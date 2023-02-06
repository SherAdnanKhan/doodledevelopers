<?php

namespace App\Http\Controllers\Wallets;

use App\Http\Controllers\Controller;
use App\Http\Services\Wallets\WalletTransactionService;
use App\Http\Transformers\Wallets\WalletTransactionTransformer;
use App\Models\UserWallet;
use App\Models\WalletTransaction;
use Illuminate\Http\JsonResponse;

class WalletTransactionController extends Controller
{
    /**
     * @var WalletTransactionService/
     */
    private WalletTransactionService $service;

    /**
     * @var WalletTransactionTransformer
     */
    private WalletTransactionTransformer $transformer;

    public function __construct(
        WalletTransactionService $service,
        WalletTransactionTransformer $transformer
    )
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /**
     * @OA\Get(
     *     path="/api/users/wallets/{wallet}/transactions",
     *     description="Get Wallet Transactions",
     *     summary="Get Wallet Transactions",
     *     operationId="getWalletTransactions",
     *     security={{"bearerAuth":{}}},
     *     tags={"Wallet Transactions"},
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
     *         name="include",
     *         in="query",
     *         style="form",
     *         explode=false,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items( type="enum", enum={"transaction"} ),
     *             example={"transaction"}
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
     *                     @OA\Items(ref="#/components/schemas/WalletTransaction")
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
     * @param UserWallet $wallet
     * @return JsonResponse
     */
    public function index(UserWallet $wallet) : JsonResponse
    {
        $walletTransactions = $this->service->getAll($wallet);

        return $this->success($walletTransactions, $this->transformer);
    }

    /**
     * @OA\Get(
     *     path="/api/users/wallets/{wallet}/transactions/{transaction}",
     *     description="Get Wallet Transaction",
     *     summary="Get Wallet Transaction",
     *     operationId="getWalletTransaction",
     *     security={{"bearerAuth":{}}},
     *     tags={"Wallet Transactions"},
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
     *         name="transaction",
     *         parameter="transaction",
     *         example=1
     *     ),
     *     @OA\Parameter(
     *         name="include",
     *         in="query",
     *         style="form",
     *         explode=false,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items( type="enum", enum={"transaction"} ),
     *             example={"transaction"}
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
     *                     @OA\Items(ref="#/components/schemas/WalletTransaction")
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param UserWallet $wallet
     * @param WalletTransaction $transaction
     * @return JsonResponse
     */
    public function show(UserWallet $wallet, WalletTransaction $transaction) : JsonResponse
    {
        return $this->success($transaction, $this->transformer);
    }
}
