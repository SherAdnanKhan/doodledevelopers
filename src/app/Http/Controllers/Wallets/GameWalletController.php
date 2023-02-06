<?php

namespace App\Http\Controllers\Wallets;

use App\Http\Controllers\Controller;
use App\Http\Services\Wallets\GameWalletService;
use App\Http\Transformers\Wallets\GameWalletTransformer;
use App\Models\UserGameWallet;
use Illuminate\Http\JsonResponse;

class GameWalletController extends Controller
{
    /**
     * @var GameWalletService
     */
    private GameWalletService $service;

    /**
     * @var GameWalletTransformer
     */
    private GameWalletTransformer $transformer;

    public function __construct(
        GameWalletService $service,
        GameWalletTransformer $transformer
    )
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /**
     * @OA\Get(
     *     path="/api/users/game-wallets",
     *     description="Get All Game Wallets",
     *     summary="Get All Game Wallets",
     *     operationId="getAllGameWallets",
     *     security={{"bearerAuth":{}}},
     *     tags={"User Game Wallet"},
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
     *                     @OA\Items(ref="#/components/schemas/UserGameWallet")
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
        $gameWallets = $this->service->getAll();

        return $this->success($gameWallets, $this->transformer);
    }

    /**
     * @OA\Get(
     *     path="/api/users/game-wallets/{game_wallet}",
     *     description="Get Game Wallet",
     *     summary="Get Game Wallet",
     *     operationId="getGameWallet",
     *     security={{"bearerAuth":{}}},
     *     tags={"User Game Wallet"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="game_wallet",
     *         parameter="game_wallet",
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
     *                     @OA\Items(ref="#/components/schemas/UserGameWallet")
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param UserGameWallet $gameWallet
     * @return JsonResponse
     */
    public function show(UserGameWallet $gameWallet): JsonResponse
    {
        return $this->success($gameWallet, $this->transformer);
    }

}
