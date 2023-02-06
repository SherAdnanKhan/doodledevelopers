<?php

namespace App\Http\Controllers\Payouts;

use App\Exceptions\ErrorException;
use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Http\Services\Payouts\PayoutService;
use App\Http\Transformers\Wallets\GameTransactionTransformer;
use App\Http\Requests\Payouts\GetPayoutRequest;
use Illuminate\Http\JsonResponse;

class PayoutController extends Controller
{
    /**
     * @var PayoutService
     */
    private PayoutService $service;

    /**
     * @var GameTransactionTransformer
     */
    private GameTransactionTransformer $transformer;

    public function __construct(
        PayoutService $service,
        GameTransactionTransformer $transformer
    ) {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /**
     * @OA\Get(
     *     path="/api/users/games/{game}/payouts",
     *     description="Get Game Payouts",
     *     summary="Get Game Payouts",
     *     operationId="getGamePayouts",
     *     security={{"bearerAuth":{}}},
     *     tags={"Game Payout"},
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
     *         name="status",
     *         in="query",
     *         style="form",
     *         explode=false,
     *         description="Get payouts from one of these statuses",
     *         @OA\Schema(
     *             type="string",
     *             enum={"approved", "pending", "rejected"},
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="include",
     *         in="query",
     *         style="form",
     *         explode=false,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items( type="enum", enum={"wallet", "game"} ),
     *             example={"wallet"}
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
     *                     @OA\Items(ref="#/components/schemas/GameTransaction")
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
     * @param GetPayoutRequest $request
     * @param Game $game
     * @return JsonResponse
     */
    public function index(GetPayoutRequest $request, Game $game) : JsonResponse
    {
      $payouts = $this->service->getAll($game, $request->validated());

      return $this->success($payouts, $this->transformer);
    }

    /**
     * @OA\Post(
     *     path="/api/users/games/{game}/payouts",
     *     description="Create Payout",
     *     summary="Create Payout",
     *     operationId="createPayout",
     *     security={{"bearerAuth":{}}},
     *     tags={"Game Payout"},
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
     *             @OA\Items( type="enum", enum={"wallet", "game"} ),
     *             example={"wallet"}
     *         ),
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
     *                     example="Payout request sent successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/GameTransaction")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param Game $game
     * @return JsonResponse
     * @throws ErrorException
     */
    public function store(Game $game) : JsonResponse
    {
       $payout = $this->service->store($game);

       return $this->success($payout, $this->transformer, trans('messages.payout_create_success'));
    }

}
