<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use App\Http\Requests\Games\GetGameRequest;
use App\Http\Services\Games\GameService;
use App\Http\Transformers\Games\GamePublicTransformer;
use App\Http\Transformers\Games\GameUserAdminTransformer;
use App\Models\Game;
use Illuminate\Http\JsonResponse;

class GameController extends Controller
{
    /**
     * @var GameService/
     */
    private GameService $service;

    /**
     * @var GameUserAdminTransformer
     */
    private GameUserAdminTransformer $transformer;

    /**
     * @var GamePublicTransformer
     */
    private GamePublicTransformer $GamePublicTransformer;

    public function __construct(
        GameService $service,
        GameUserAdminTransformer $transformer,
        GamePublicTransformer $GamePublicTransformer
    )
    {
        $this->service = $service;
        $this->transformer = $transformer;
        $this->GamePublicTransformer = $GamePublicTransformer;
    }

    /**
     * @OA\Get(
     *     path="/api/users/games",
     *     description="Get Games",
     *     summary="Get Games",
     *     operationId="getGames",
     *     security={{"bearerAuth":{}}},
     *     tags={"Game"},
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         style="form",
     *         explode=false,
     *         description="Get Games from any of these statuses",
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items( type="enum", enum={"notstarted", "live", "finished", "endedbyadmin"} ),
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="player_status",
     *         in="query",
     *         style="form",
     *         explode=false,
     *         description="Get User Games from one of these statuses",
     *         @OA\Schema(
     *             type="string",
     *             enum={"all", "playing", "notplaying"},
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="include",
     *         in="query",
     *         style="form",
     *         explode=false,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items( type="enum", enum={"players", "map"} ),
     *             example={"players"}
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Success"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/Game")
     *                 ),
     *                 @OA\Property(
     *                     property="pagination",
     *                     @OA\Property(
     *                         property="total",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="count",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="per_page",
     *                         type="integer",
     *                         example=10
     *                     ),
     *                     @OA\Property(
     *                         property="current_page",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="total_pages",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="links",
     *                         type="string",
     *                         example="{}"
     *                     )
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param GetGameRequest $request
     * @return JsonResponse
     */
    public function index(GetGameRequest $request) : JsonResponse
    {
        $games = $this->service->getAll($request->validated());

        return $this->success($games, $this->transformer);
    }

    /**
     * @OA\Get(
     *     path="/api/users/games/{game}",
     *     description="Get Game",
     *     summary="Get Game",
     *     operationId="getGame",
     *     security={{"bearerAuth":{}}},
     *     tags={"Game"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="game",
     *         parameter="game",
     *         example=1
     *     ),
     *     @OA\Parameter(
     *         name="include",
     *         in="query",
     *         style="form",
     *         explode=false,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items( type="enum", enum={"players", "map"} ),
     *             example={"players"}
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Success"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/Game")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param Game $game
     * @return JsonResponse
     */
    public function show(Game $game) : JsonResponse
    {
        return $this->success($game, $this->transformer);
    }

    /**
     * @OA\Get(
     *     path="/api/games",
     *     description="Get Live Games",
     *     summary="Get Live Games",
     *     operationId="getLiveGames",
     *     tags={"Game"},
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Success"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/GamePublic")
     *                 ),
     *                 @OA\Property(
     *                     property="pagination",
     *                     @OA\Property(
     *                         property="total",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="count",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="per_page",
     *                         type="integer",
     *                         example=10
     *                     ),
     *                     @OA\Property(
     *                         property="current_page",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="total_pages",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="links",
     *                         type="string",
     *                         example="{}"
     *                     )
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @return JsonResponse
     */
    public function getLiveGames()
    {
        $games = $this->service->getLiveGames();

        return $this->success($games, $this->GamePublicTransformer);
    }

    /**
     * @OA\Get(
     *     path="/api/users/games-winners",
     *     description="Get Games Winners",
     *     summary="Get Games Winners",
     *     operationId="getGamesWinners",
     *     security={{"bearerAuth":{}}},
     *     tags={"Game"},
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         style="form",
     *         explode=false,
     *         description="Get Games Winners from any of these statuses",
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items( type="enum", enum={"notstarted", "live", "finished", "endedbyadmin"} ),
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="include",
     *         in="query",
     *         style="form",
     *         explode=false,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items( type="enum", enum={"players", "map"} ),
     *             example={"players"}
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Success"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/Game")
     *                 ),
     *                 @OA\Property(
     *                     property="pagination",
     *                     @OA\Property(
     *                         property="total",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="count",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="per_page",
     *                         type="integer",
     *                         example=10
     *                     ),
     *                     @OA\Property(
     *                         property="current_page",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="total_pages",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="links",
     *                         type="string",
     *                         example="{}"
     *                     )
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param GetGameRequest $request
     * @return JsonResponse
     */
    public function getGamesWinners(GetGameRequest $request) : JsonResponse
    {
        $games = $this->service->getGamesWinners($request->validated());

        return $this->success($games, $this->transformer);
    }

}
