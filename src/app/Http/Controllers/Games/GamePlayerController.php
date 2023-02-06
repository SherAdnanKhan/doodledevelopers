<?php

namespace App\Http\Controllers\Games;

use App\Exceptions\ErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Games\CheckExpiryRequest;
use App\Http\Services\Games\GamePlayerService;
use App\Http\Transformers\Games\GamePlayerTransformer;
use App\Models\Game;
use Illuminate\Http\JsonResponse;

class GamePlayerController extends Controller
{
    /**
     * @var GamePlayerService/
     */
    private GamePlayerService $service;

    /**
     * @var GamePlayerTransformer
     */
    private GamePlayerTransformer $transformer;

    public function __construct(
        GamePlayerService $service,
        GamePlayerTransformer $transformer
    )
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /**
     * @OA\Get (
     *     path="/api/users/games/{game}/scoreboard",
     *     description="Scoreboard",
     *     summary="Scoreboard",
     *     operationId="scoreboard",
     *     security={{"bearerAuth":{}}},
     *     tags={"Game/Scoreboard"},
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
     *             type="string",
     *             enum={"status"},
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
     *                         @OA\Schema(ref="#/components/schemas/GamePlayer")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param Game $game
     * @return JsonResponse
     */
    public function scoreboard(Game $game) : JsonResponse
    {
        $gamePlayer = $this->service->scoreboard($game);

        return $this->success($gamePlayer, $this->transformer);
    }

    /**
     * @OA\POST (
     *     path="/api/users/games/{game}/play",
     *     description="Play Game",
     *     summary="Play Game",
     *     operationId="playGame",
     *     security={{"bearerAuth":{}}},
     *     tags={"Game/Play Game"},
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
     *                     example="success"
     *                 ),
     *                  @OA\Property (
     *                     property = "data",
     *                     type= "array",
     *                     @OA\Items(
     *                           @OA\Property(
     *                               property="game_session_id",
     *                               type="string",
     *                               example="91ec1a37-ce28-4f73-bb9c-06460f8f801d"
     *                           ),
     *                           @OA\Property(
     *                              property="map_data",
     *                              allOf={
     *                                  @OA\Schema(ref="#/components/schemas/Map")
     *                              }
     *                          ),
     *                      )
     *                  )
     *             )
     *         )
     *     )
     * )
     * @param Game $game
     * @return JsonResponse
     * @throws ErrorException
     */
    public function playGame(Game $game) : JsonResponse
    {
        $gamePlayerData = $this->service->playGame($game);

        return $this->success($gamePlayerData);
    }

    /**
     * @OA\GET (
     *     path="/api/users/games/{game}/check-expiry",
     *     description="Check Game Player Expiry",
     *     summary="Check Game Player Expiry",
     *     operationId="checkGamePlayerExpiry",
     *     security={{"bearerAuth":{}}},
     *     tags={"Game/Check Game Player Expiry"},
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
     *                     property="game_session_id",
     *                     type="string",
     *                     example="92c33585-8f2d-4f93-b3c6-b5fe44245bbd"
     *                 ),
     *             )
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
     *                     example="success"
     *                 ),
     *                 @OA\Property (
     *                     property = "data",
     *                     @OA\Property(
     *                          property="expired",
     *                          type="boolean",
     *                          example=false
     *                     ),
     *                 )
     *             )
     *         )
     *     )
     * )
     * @param CheckExpiryRequest $request
     * @return JsonResponse
     */
    public function checkExpiry(CheckExpiryRequest $request) : JsonResponse
    {
        $expired = $this->service->checkExpiry($request->validated());

        return $this->success(['expired' => $expired]);
    }

    /**
     * @OA\GET (
     *     path="/api/users/games/{game}/invitation-link",
     *     description="Get Invitation Link",
     *     summary="Get Invitation Link",
     *     operationId="getInvitationLink",
     *     security={{"bearerAuth":{}}},
     *     tags={"Game/Get Invitation Link"},
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
     *                     example="success"
     *                 ),
     *                 @OA\Property (
     *                     property = "data",
     *                     @OA\Property(
     *                          property="invitation_link",
     *                          type="string",
     *                          example="https://test.red6six.com/register?token=930bf4bd-cdfa-47f3-a853-cdd15db7bfc0"
     *                     ),
     *                 )
     *             )
     *         )
     *     )
     * )
     * @param Game $game
     * @return JsonResponse
     */
    public function invitationLink(Game $game) : JsonResponse
    {
        $invitationLink = $this->service->invitationLink($game);

        return $this->success(['invitation_link' => $invitationLink]);
    }
}
