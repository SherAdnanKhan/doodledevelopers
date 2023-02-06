<?php

namespace App\Http\Controllers\Wallets;

use App\Http\Controllers\Controller;
use App\Http\Services\Wallets\WalletService;
use App\Http\Transformers\Wallets\WalletTransformer;
use App\Models\UserWallet;
use Illuminate\Http\JsonResponse;

class WalletController extends Controller
{
    /**
     * @var WalletService/
     */
    private WalletService $service;

    /**
     * @var WalletTransformer
     */
    private WalletTransformer $transformer;

    public function __construct(
        WalletService $service,
        WalletTransformer $transformer
    )
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /**
     * @OA\Get(
     *     path="/api/users/wallets",
     *     description="Get All Wallets",
     *     summary="Get All Wallets",
     *     operationId="getAllWallets",
     *     security={{"bearerAuth":{}}},
     *     tags={"Wallet"},
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
     *                     @OA\Items(ref="#/components/schemas/UserWallet")
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
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        $wallets = $this->service->getAll();

        return $this->success($wallets, $this->transformer);
    }

    /**
     * @OA\Get(
     *     path="/api/users/wallets/{wallet}",
     *     description="Get Wallet",
     *     summary="Get Wallet",
     *     operationId="getWallet",
     *     security={{"bearerAuth":{}}},
     *     tags={"Wallet"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="wallet",
     *         parameter="wallet",
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
     *                     @OA\Items(ref="#/components/schemas/UserWallet")
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param UserWallet $wallet
     * @return JsonResponse
     */
    public function show(UserWallet $wallet) : JsonResponse
    {
        return $this->success($wallet, $this->transformer);
    }
}
