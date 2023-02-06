<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use App\Http\Services\Games\GameHistoryService;
use App\Http\Transformers\Games\GameHistoryTransformer;
use Illuminate\Http\JsonResponse;

class GameHistoryController extends Controller
{
    /**
     * @var GameHistoryService/
     */
    private GameHistoryService $service;

    /**
     * @var GameHistoryTransformer
     */
    private GameHistoryTransformer $transformer;

    public function __construct(
        GameHistoryService $service,
        GameHistoryTransformer $transformer
    )
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /**
     * @OA\Get(
     *     path="/api/users/games/history",
     *     description="Get Games History",
     *     summary="Get Games History",
     *     operationId="getGamesHistory",
     *     security={{"bearerAuth":{}}},
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
     *                     @OA\Items(ref="#/components/schemas/GameHistory")
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
    public function index() : JsonResponse
    {
        $games = $this->service->getAll();

        return $this->success($games, $this->transformer);
    }
}
