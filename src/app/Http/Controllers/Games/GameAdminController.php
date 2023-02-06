<?php

namespace App\Http\Controllers\Games;

use App\Exceptions\ErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Games\CreateGameRequest;
use App\Http\Requests\Games\UpdateGameRequest;
use App\Http\Requests\Games\GetGameRequest;
use App\Http\Services\Games\GameAdminService;
use App\Http\Transformers\Games\GameUserAdminTransformer;
use App\Models\Game;
use Illuminate\Http\JsonResponse;

class GameAdminController extends Controller
{
    /**
     * @var GameAdminService/
     */
    private GameAdminService $service;

    /**
     * @var GameUserAdminTransformer
     */
    private GameUserAdminTransformer $transformer;

    public function __construct(
        GameAdminService $service,
        GameUserAdminTransformer $transformer
    )
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /**
     * @OA\Get(
     *     path="/api/admin/games",
     *     description="Get Games",
     *     summary="Get Games",
     *     operationId="getGames",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/Game"},
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
     *                     @OA\Items(ref="#/components/schemas/GameAdmin")
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
     *                          example="{}"
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
     * @OA\Post(
     *     path="/api/admin/games",
     *     description="Create Game",
     *     summary="Create Game",
     *     operationId="createGame",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/Game"},
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
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="Bowling"
     *                 ),
     *                 @OA\Property(
     *                     property="jackpot_value",
     *                     type="double",
     *                     example=20000
     *                 ),
     *                 @OA\Property(
     *                     property="admin_fee_percentage",
     *                     type="double",
     *                     example=30
     *                 ),
     *                 @OA\Property(
     *                     property="entry_fee",
     *                     type="double",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="game_ext_days",
     *                     type="integer",
     *                     example=3
     *                 ),
     *                 @OA\Property(
     *                     property="start_date",
     *                     type="date",
     *                     example="2020-01-01"
     *                 ),
     *                 @OA\Property(
     *                     property="end_date",
     *                     type="date",
     *                     example="2020-01-09"
     *                 ),
     *                 @OA\Property(
     *                     property="amount_of_balls_to_fire",
     *                     type="integer",
     *                     example=5
     *                 ),
     *                 @OA\Property(
     *                     property="total_attempts",
     *                     type="integer",
     *                     example=3
     *                 ),
     *                 @OA\Property(
     *                     property="map_id",
     *                     type="integer",
     *                     example=1
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Game created successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Game created successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/GameAdmin")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param CreateGameRequest $request
     * @return JsonResponse
     */
    public function store(CreateGameRequest $request) : JsonResponse
    {
        $game = $this->service->store($request->validated());

        return $this->success($game, $this->transformer, trans('messages.game_create_success'));
    }

    /**
     * @OA\Get(
     *     path="/api/admin/games/{game}",
     *     description="Get Game",
     *     summary="Get Game",
     *     operationId="getGame",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/Game"},
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
     *                         @OA\Schema(ref="#/components/schemas/GameAdmin")
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
     * @OA\Put(
     *     path="/api/admin/games/{game}",
     *     description="Update Game",
     *     summary="Update Game",
     *     operationId="updateGame",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/Game"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="game",
     *         parameter="game",
     *         example=1
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="Bowling"
     *                 ),
     *                 @OA\Property(
     *                     property="jackpot_value",
     *                     type="double",
     *                     example=20000
     *                 ),
     *                 @OA\Property(
     *                     property="admin_fee_percentage",
     *                     type="double",
     *                     example=30
     *                 ),
     *                 @OA\Property(
     *                     property="pot_value",
     *                     type="double",
     *                     example=3000
     *                 ),
     *                 @OA\Property(
     *                     property="entry_fee",
     *                     type="double",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="number_of_winners",
     *                     type="double",
     *                     example=40
     *                 ),
     *                 @OA\Property(
     *                     property="game_ext_days",
     *                     type="integer",
     *                     example=3
     *                 ),
     *                 @OA\Property(
     *                     property="is_extended",
     *                     type="boolean",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="start_date",
     *                     type="date",
     *                     example="2020-01-01"
     *                 ),
     *                 @OA\Property(
     *                     property="end_date",
     *                     type="date",
     *                     example="2020-01-09"
     *                 ),
     *                 @OA\Property(
     *                     property="amount_of_balls_to_fire",
     *                     type="integer",
     *                     example=5
     *                 ),
     *                 @OA\Property(
     *                     property="total_attempts",
     *                     type="integer",
     *                     example=3
     *                 ),
     *                 @OA\Property(
     *                     property="status",
     *                     type="string",
     *                     example="live"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Game updated successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Game updated successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/GameAdmin")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param UpdateGameRequest $request
     * @param Game $game
     * @return JsonResponse
     */
    public function update(UpdateGameRequest $request, Game $game) : JsonResponse
    {
        $game = $this->service->update($game, $request->validated());

        return $this->success($game, $this->transformer, trans('messages.game_update_success'));
    }

    /**
     * @OA\Delete(
     *     path="/api/admin/games/{game}",
     *     description="Delete Game",
     *     summary="Delete Game",
     *     operationId="deleteGame",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/Game"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="game",
     *         parameter="game",
     *         example=1
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Game deleted successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Game deleted successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     example="[]"
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param Game $game
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Game $game) : JsonResponse
    {
        $this->service->delete($game);

        return $this->success([], null, trans('messages.game_delete_success'));
    }

    /**
     * @OA\Post(
     *     path="/api/admin/stop-games",
     *     description="Stop Game",
     *     summary="Stop Game",
     *     operationId="stopGame",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/Game"},
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
     *         description="Game stopped successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="All live games stops successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/GameAdmin")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @return JsonResponse
     * @throws ErrorException
     */
    public function stopGame() : JsonResponse
    {
        $stoppedGames = $this->service->stopGame();

        return $this->success($stoppedGames, $this->transformer, trans('messages.stop_games'));
    }

}
