<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use App\Http\Services\Games\GamePlayerScoreService;
use App\Http\Transformers\Games\GamePlayerScoreTransformer;
use App\Models\Game;
use Illuminate\Http\JsonResponse;


class GamePlayerScoreController extends Controller
{
    /**
     * @var GamePlayerScoreService/
     */
    private GamePlayerScoreService $service;

    /**
     * @var GamePlayerScoreTransformer
     */
    private GamePlayerScoreTransformer $transformer;

    public function __construct(
        GamePlayerScoreService $service,
        GamePlayerScoreTransformer $transformer
    )
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /**
     * @OA\Get(
     *     path="/api/users/games/{game}/scores",
     *     description="Get Game Scores",
     *     summary="Get Game Scores",
     *     operationId="getGameScores",
     *     security={{"bearerAuth":{}}},
     *     tags={"Game/Score"},
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
     *                     @OA\Items(ref="#/components/schemas/GamePlayerScore")
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
        $scores = $this->service->getAll($game);

        return $this->success($scores, $this->transformer);
    }
}
