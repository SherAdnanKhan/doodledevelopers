<?php

namespace App\Http\Controllers\Games;

use App\Exceptions\ErrorException;
use App\Http\Controllers\Controller;
use App\Http\Services\Games\GamePlayerAdminService;
use App\Http\Transformers\Games\GamePlayerAdminTransformer;
use App\Models\Game;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class GamePlayerAdminController extends Controller
{
    /**
     * @var GamePlayerAdminService/
     */
    private GamePlayerAdminService $service;

    /**
     * @var GamePlayerAdminTransformer
     */
    private GamePlayerAdminTransformer $transformer;

    public function __construct(
        GamePlayerAdminService $service,
        GamePlayerAdminTransformer $transformer
    )
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /**
     * @OA\Get(
     *     path="/api/admin/games/{game}/players",
     *     description="Get Game Players",
     *     summary="Get Game Players",
     *     operationId="getGamePlayers",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/Game/Player"},
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
     *                     @OA\Items(ref="#/components/schemas/GamePlayerAdmin")
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
     *                         example = {}
     *                     )
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param Game $game
     * @return JsonResponse
     */
    public function index(Game $game) : JsonResponse
    {
        $players = $this->service->getAll($game);

        return $this->success($players, $this->transformer);
    }

    /**
     * @OA\Get(
     *     path="/api/admin/games/{game}/players/{player}",
     *     description="Get Game Player",
     *     summary="Get Game Player",
     *     operationId="getGamePlayer",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/Game/Player"},
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
     *                         @OA\Schema(ref="#/components/schemas/GamePlayerAdmin")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param Game $game
     * @param User $player
     * @return JsonResponse
     */
    public function show(Game $game, User $player) : JsonResponse
    {
        $player = $this->service->getPlayer($game, $player);

        return $this->success($player, $this->transformer);
    }

    /**
     * @OA\Delete(
     *     path="/api/admin/games/{game}/players/{player}",
     *     description="Delete Game Player",
     *     summary="Delete Game Player",
     *     operationId="deleteGamePlayer",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/Game/Player"},
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
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="player",
     *         parameter="player",
     *         example=1
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Player deleted successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Player deleted successfully"
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
     * @param User $player
     * @return JsonResponse
     * @throws ErrorException
     */
    public function destroy(Game $game, User $player) : JsonResponse
    {
        $this->service->destroy($game, $player);

        return $this->success([], null, trans('messages.game_player_delete_success'));
    }

}
