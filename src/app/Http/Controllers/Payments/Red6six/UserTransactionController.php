<?php

namespace App\Http\Controllers\Payments\Red6six;

use App\Http\Controllers\Controller;
use App\Http\Services\Payments\Red6six\UserTransactionService;
use App\Http\Transformers\Payments\Red6six\UserTransactionTransformer;
use App\Models\UserTransaction;
use Illuminate\Http\JsonResponse;

class UserTransactionController extends Controller
{
    /**
     * @var UserTransactionService/
     */
    private UserTransactionService $service;

    /**
     * @var UserTransactionTransformer
     */
    private UserTransactionTransformer $transformer;

    public function __construct(
        UserTransactionService $service,
        UserTransactionTransformer $transformer
    )
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }
    /**
     * @OA\Get(
     *     path="/api/users/user-transactions",
     *     description="Get Users Transactions",
     *     summary="Get Users Transactions",
     *     operationId="getUsersTransactions",
     *     security={{"bearerAuth":{}}},
     *     tags={"User Transactions"},
     *     @OA\Parameter(
     *         name="include",
     *         in="query",
     *         required=false,
     *         style="form",
     *         explode=false,
     *         @OA\Schema(
     *             type="string",
     *             enum={"transactional"},
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
     *                     @OA\Items(ref="#/components/schemas/UserTransaction")
     *                 ),
     *                 @OA\Property(
     *                     property="pagination",
     *                     @OA\Property(
     *                         property="total",
     *                         type="integer",
     *                         example=2
     *                     ),
     *                     @OA\Property(
     *                         property="count",
     *                         type="integer",
     *                         example=2
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
     *     path="/api/users/user-transactions/{user_transaction}",
     *     description="Get User Transactions",
     *     summary="Get User Transactions",
     *     operationId="getUserTransactions",
     *     security={{"bearerAuth":{}}},
     *     tags={"User Transactions"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="user_transaction",
     *         parameter="user_transaction",
     *         example=1
     *     ),
     *     @OA\Parameter(
     *         name="include",
     *         in="query",
     *         required=false,
     *         style="form",
     *         explode=false,
     *         @OA\Schema(
     *             type="string",
     *             enum={"transactional"},
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
     *                         @OA\Schema(ref="#/components/schemas/UserTransaction")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param UserTransaction $userTransaction
     * @return JsonResponse
     */
    public function show(UserTransaction $userTransaction) : JsonResponse
    {
        return $this->success($userTransaction, $this->transformer);
    }
}
