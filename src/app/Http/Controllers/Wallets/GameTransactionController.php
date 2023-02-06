<?php

namespace App\Http\Controllers\Wallets;

use App\Http\Controllers\Controller;
use App\Http\Requests\Games\GetGameTransactionRequest;
use App\Http\Services\Wallets\GameTransactionService;
use App\Http\Transformers\Wallets\GameTransactionTransformer;
use App\Models\GameTransaction;
use App\Models\UserWallet;
use Illuminate\Http\JsonResponse;

class GameTransactionController extends Controller
{
    /**
     * @var GameTransactionService/
     */
    private GameTransactionService $service;

    /**
     * @var GameTransactionTransformer
     */
    private GameTransactionTransformer $transformer;

    public function __construct(
        GameTransactionService $service,
        GameTransactionTransformer $transformer
    )
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /**
     * @OA\Get(
     *     path="/api/users/wallets/{wallet}/game-transactions",
     *     description="Get Wallet Game Transactions",
     *     summary="Get Wallet Game Transactions",
     *     operationId="getWalletGameTransactions",
     *     security={{"bearerAuth":{}}},
     *     tags={"Game Transaction"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="wallet",
     *         parameter="wallet",
     *         example=1
     *     ),
     *      @OA\Parameter(
     *         name="status",
     *         in="query",
     *         style="form",
     *         explode=false,
     *         description="Get game transactions from one of these statuses",
     *         @OA\Schema(
     *             type="string",
     *             enum={"pending", "approved", "rejected"}
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="include",
     *         in="query",
     *         style="form",
     *         explode=false,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items( type="enum", enum={"game", "wallet"} ),
     *             example={"game"}
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
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     * @param GetGameTransactionRequest $request
     * @param UserWallet $wallet
     * @return JsonResponse
     */
    public function index(GetGameTransactionRequest $request, UserWallet $wallet) : JsonResponse
    {
        $gameTransactions = $this->service->getAll($wallet, $request->validated());

        return $this->success($gameTransactions, $this->transformer);
    }

    /**
     * @OA\Get(
     *     path="/api/users/wallets/{wallet}/game-transactions/{game_transaction}",
     *     description="Get Wallet Game Transaction",
     *     summary="Get Wallet Game Transaction",
     *     operationId="getWalletGameTransaction",
     *     security={{"bearerAuth":{}}},
     *     tags={"Game Transaction"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="wallet",
     *         parameter="wallet",
     *         example=1
     *     ),
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="game_transaction",
     *         parameter="game_transaction",
     *         example=1
     *     ),
     *     @OA\Parameter(
     *         name="include",
     *         in="query",
     *         style="form",
     *         explode=false,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items( type="enum", enum={"game", "wallet"} ),
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
     *             )
     *         )
     *     )
     * )
     * @param UserWallet $wallet
     * @param GameTransaction $gameTransaction
     * @return JsonResponse
     */
    public function show(UserWallet $wallet, GameTransaction $gameTransaction) : JsonResponse
    {
        return $this->success($gameTransaction, $this->transformer);
    }
}
