<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use App\Http\Requests\Games\CreateGamePlayerAttemptScoreRequest;
use App\Http\Requests\Games\CreateGamePlayerStateRequest;
use App\Http\Requests\Games\GetGameMapRequest;
use App\Http\Requests\Games\GetGamePlayerStateRequest;
use App\Http\Services\Games\GameServerService;
use App\Http\Transformers\Games\GamePlayerAttemptScoreTransformer;
use Illuminate\Http\JsonResponse;

class GameServerController extends Controller
{

    /**
     * @var GameServerService/
     */
    private GameServerService $service;

    /**
     * @var GamePlayerAttemptScoreTransformer
     */
    private GamePlayerAttemptScoreTransformer $transformer;

    public function __construct(
        GameServerService $service,
        GamePlayerAttemptScoreTransformer $transformer
    )
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /**
     * @OA\Post(
     *     path="/api/game-server/add-score",
     *     description="Add Game Score",
     *     summary="Add Game Score",
     *     operationId="addGameScore",
     *     security={{"bearerAuth":{}}},
     *     tags={"Game Server"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="score",
     *                     type="integer",
     *                     example=20
     *                 ),
     *                 @OA\Property(
     *                     property="duration",
     *                     type="double",
     *                     example=2.9689
     *                 ),
     *                 @OA\Property(
     *                     property="game_player_token",
     *                     type="string",
     *                     example="91ec1a37-ce28-4f73-bb9c-06460f8f801d"
     *                ),
     *                 @OA\Property(
     *                     property="attempt_number",
     *                     type="integer",
     *                     example=1
     *                ),
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
     *                     example="Success"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/GamePlayerScore")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param CreateGamePlayerAttemptScoreRequest $request
     * @return JsonResponse
     * @throws \App\Exceptions\ErrorException
     */
    public function addAttemptScore(CreateGamePlayerAttemptScoreRequest $request) : JsonResponse
    {
        $gameScore = $this->service->addAttemptScore($request->validated());

        return $this->success($gameScore, $this->transformer);
    }

    /**
     * @OA\Get(
     *     path="/api/game-server/game-map",
     *     description="Get Game Map",
     *     summary="Get Game Map",
     *     operationId="getGameMap",
     *     security={{"bearerAuth":{}}},
     *     tags={"Game Server"},
     *     @OA\Parameter(
     *         @OA\Schema(type="string"),
     *         in="query",
     *         allowReserved=true,
     *         required=true,
     *         name="game_player_token",
     *         parameter="game_player_token",
     *         example="92e9517c-1363-45b8-b426-89b34470999b"
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
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/Map")
     *                  )
     *             )
     *         )
     *     )
     * )
     * @param GetGameMapRequest $request
     * @return JsonResponse
     */
    public function getGameMap(GetGameMapRequest $request): JsonResponse
    {
       $gameMap = $this->service->getGameMap($request->validated());

        return $this->success($gameMap);
    }


    /**
     * @OA\Post(
     *     path="/oauth/token",
     *     description="Get Access Token",
     *     summary="Get Access Token",
     *     operationId="getAccessToken",
     *     security={{"bearerAuth":{}}},
     *     tags={"Game Server"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="grant_type",
     *                     type="string",
     *                     example="client_credentials"
     *                 ),
     *                 @OA\Property(
     *                     property="client_id",
     *                     type="integer",
     *                     example=3
     *                 ),
     *                 @OA\Property(
     *                     property="client_secret",
     *                     type="string",
     *                     example="Eb53Q4iQgecw3VPzgSXXC1wQ5qzV9UyUxtEcjv0R"
     *                ),
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
     *                     property="token_type",
     *                     type="string",
     *                     example="Bearer"
     *                 ),
     *                  @OA\Property(
     *                     property="expires_in",
     *                     type="integer",
     *                     example=31536000
     *                 ),
     *                  @OA\Property(
     *                     property="access_token",
     *                     type="string",
     *                     example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzIiwianRpIjoiYzllYTU5YTBmNGMzNjk4MjlkYzg0YTg3OGM1YmE4MDcyNGI2NjNjODQxOWVlMWZjZjZlZWI3YTk0MWM4ODU4MGRjMDEyZDMyZTM2NGMwZjUiLCJpYXQiOjE2MDQ1NjM5NDcsIm5iZiI6MTYwNDU2Mzk0NywiZXhwIjoxNjM2MDk5OTQ3LCJzdWIiOiIiLCJzY29wZXMiOltdfQ.pcPd9txM92mXKH3EYihGG7-eq5dVEumcDFnvluEdsfeRESN5UCU7FYvhPMcqzuALXytbAajy8iOZ0v_xO-SOrGGIcm1ZRxUDILhwuHrt-ZFnAh_Ta7z-kZbNEdcbOpt50yf2UgoR4QWsonTrw7tVEOGit7-bskuqJik7eUNLkGr-oJRm4G-qDmxmKQDxV6lQZhjVMwpUnXrqO29cS_06lAziXO_8DDeW2RSbwRBkkam_24RSXmYbeZnTX6vmfNKWzG4s1B3LRsf96imsqWadrJR2UVgFof1i-Z6O_40PpHtSNPyr3tLsPE7GoUGAu4Onf_V09y0iIkzex5t-KrN0-4PgQuVESG9zNLIdz0PlPaWJdIitKTPZoIrt8NfQJJVYbbeU3XHfSb1CeSfHFMfjvSA2tKM3Inu7CMnZzqk8LxOKvtu5g3oqCc8egtFUbLJC13qKcEuvlrZIRc8O9NyUbNdp83yQx_ZEga64HGiL2VoRbKaK_1_3oGetBUpOPHiydCNqpCyruCOBtJ16Xj9V4Cub3EpFy6vXIhRHhsHoJx5tNnaohwAQNVhC8Zrt_s9LX6QtSWgiiNhSnZak1D7C0NAvLmOaFar-4Pa6IWFEagCYK8FfRxbQUOFv3YKN-fI9y4e6_i1GkDGu__G9LeSijbXss_i9VLK1KOJSHC-UYMQ"
     *                 ),
     *             )
     *         )
     *     )
     * )
     */
    public function login()
    {

    }

    /**
     * @OA\Post(
     *     path="/api/game-server/game-player-state",
     *     description="Store Game Player State",
     *     summary="Store Game Player State",
     *     operationId="StoreGamePlayerState",
     *     security={{"bearerAuth":{}}},
     *     tags={"Game Server"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="token",
     *                     type="string",
     *                     example="92e9517c-1363-45b8-b426-89b34470999b"
     *                 ),
     *                 @OA\Property(
     *                     property="state",
     *                     @OA\Property(
     *                         property="ball_radius",
     *                         type="double",
     *                         example=0.2
     *                     ),
     *                 @OA\Property(
     *                     property="ball_color",
     *                     type="string",
     *                     example="#00ffff"
     *                 ),
     *                 @OA\Property(
     *                     property="wall_color",
     *                     type="string",
     *                     example="#ff0000"
     *                 ),
     *                 @OA\Property(
     *                     property="block_width",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="block_height",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="board_width",
     *                     type="integer",
     *                     example=9
     *                 ),
     *                 @OA\Property(
     *                     property="board_height",
     *                     type="string",
     *                     example=29
     *                 ),
     *                 @OA\Property(
     *                     property="blocks",
     *                     type="array",
     *                     @OA\Items(
     *                         @OA\Property(
     *                             property="id",
     *                             type="integer",
     *                             example=91
     *                         ),
     *                         @OA\Property(
     *                             property="x",
     *                             type="double",
     *                             example=4.5
     *                         ),
     *                         @OA\Property(
     *                             property="y",
     *                             type="double",
     *                             example=26.5
     *                         ),
     *                         @OA\Property(
     *                             property="color_image",
     *                             type="string",
     *                             example="yellow"
     *                         ),
     *                         @OA\Property(
     *                             property="total_hp",
     *                             type="integer",
     *                             example=30
     *                         ),
     *                         @OA\Property(
     *                             property="points_per_hit",
     *                             type="integer",
     *                             example=10
     *                         ),
     *                         @OA\Property(
     *                             property="points_per_destruction",
     *                             type="integer",
     *                             example=25
     *                         ),
     *                     ),
     *                 ),
     *                 @OA\Property(
     *                     property="last_generated_id",
     *                     type="integer",
     *                     example=139
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
     *                     property="times_played",
     *                     type="integer",
     *                     example=0
     *                 ),
     *             ),
     *         ))
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
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/GamePlayerState")
     *                  )
     *             )
     *         )
     *     )
     * )
     */
    public function addGamePlayerState(CreateGamePlayerStateRequest $request): JsonResponse
    {
        $state = $this->service->addOrUpdateGamePlayerState($request->validated());

        return $this->success($state);
    }

    /**
     * @OA\Get(
     *     path="/api/game-server/game-player-state",
     *     description="Get Game Player State",
     *     summary="Get Game Player State",
     *     operationId="GetGamePlayerState",
     *     security={{"bearerAuth":{}}},
     *     tags={"Game Server"},
     *     @OA\Parameter(
     *         @OA\Schema(type="string"),
     *         in="query",
     *         allowReserved=true,
     *         required=true,
     *         name="token",
     *         parameter="token",
     *         example="92e9517c-1363-45b8-b426-89b34470999b"
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
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/GamePlayerState")
     *                  )
     *             )
     *         )
     *     )
     * )
     */
    public function getGamePlayerState(GetGamePlayerStateRequest $request)
    {
        $state = $this->service->getGamePlayerState($request->validated());

        return $this->success($state);
    }
}
