<?php

namespace App\Http\Controllers\Payments\Red6six;

use App\Exceptions\ErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payments\Red6six\CreateDepositRequest;
use App\Http\Requests\Payments\Red6six\GetDepositRequest;
use App\Http\Services\Payments\Red6six\DepositService;
use App\Http\Transformers\Payments\Red6six\DepositTransformer;
use App\Models\Deposit;
use Illuminate\Http\JsonResponse;

class DepositController extends Controller
{
    /**
     * @var DepositService/
     */
    private DepositService $service;

    /**
     * @var DepositTransformer
     */
    private DepositTransformer $transformer;

    public function __construct(
        DepositService $service,
        DepositTransformer $transformer
    )
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /**
     * @OA\Get(
     *     path="/api/users/deposits",
     *     description="Get Deposits",
     *     summary="Get Deposits",
     *     operationId="getDeposits",
     *     security={{"bearerAuth":{}}},
     *     tags={"Deposit"},
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         style="form",
     *         explode=false,
     *         description="Get deposits from one of these statuses",
     *         @OA\Schema(
     *             type="string",
     *             enum={"approved", "rejected"},
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="payment method",
     *         in="query",
     *         style="form",
     *         explode=false,
     *         description="Get deposits from one of these payment methods",
     *         @OA\Schema(
     *             type="string",
     *             enum={"1"},
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
     *                     @OA\Items(ref="#/components/schemas/Deposit")
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
     * @param GetDepositRequest $request
     * @return JsonResponse
     */
    public function index(GetDepositRequest $request) : JsonResponse
    {
        $deposits = $this->service->getAll($request->validated());

        return $this->success($deposits, $this->transformer);
    }

    /**
     * @OA\Post(
     *     path="/api/users/deposits",
     *     description="Create Deposit",
     *     summary="Create Deposit",
     *     operationId="createDeposit",
     *     security={{"bearerAuth":{}}},
     *     tags={"Deposit"},
     *     @OA\RequestBody(
     *          description="Currency : 'GBP'",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="currency",
     *                     type="string",
     *                     example="GBP"
     *                 ),
     *                 @OA\Property(
     *                     property="amount",
     *                     type="integer",
     *                     example="100000"
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
     *                     example="Success"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     @OA\Property(
     *                         property="buildNumber",
     *                         type="string",
     *                         example="e8a11f5184272c5264c83aa39af0ccdef32db99b@2021-04-19 16:00:50 +0000"
     *                     ),
     *                     @OA\Property(
     *                         property="id",
     *                         type="string",
     *                         example="6B399304CE7577F872EE8D69093A08FA.uat01-vm-tx02"
     *                     ),
     *                     @OA\Property(
     *                         property="ndc",
     *                         type="string",
     *                         example="6B399304CE7577F872EE8D69093A08FA.uat01-vm-tx02"
     *                     ),
     *                     @OA\Property(
     *                         property="result",
     *                         @OA\Property(
     *                             property="code",
     *                             type="string",
     *                             example="000.200.100"
     *                         ),
     *                         @OA\Property(
     *                             property="description",
     *                             type="string",
     *                             example="successfully created checkout"
     *                         ),
     *                     ),
     *                     @OA\Property(
     *                         property="timestamp",
     *                         type="string",
     *                         example="2021-04-21 18:39:56+000"
     *                     ),
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param CreateDepositRequest $request
     * @return JsonResponse
     * @throws ErrorException
     */
    public function store(CreateDepositRequest $request) : JsonResponse
    {
        $prepareCheckout = $this->service->store($request->validated());

        return $this->success($prepareCheckout);
    }

    /**
     * @OA\Get(
     *     path="/api/users/deposits/{deposit}",
     *     description="Get Deposit",
     *     summary="Get Deposit",
     *     operationId="getDeposit",
     *     security={{"bearerAuth":{}}},
     *     tags={"Deposit"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="deposit",
     *         parameter="deposit",
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
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/Deposit")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param Deposit $deposit
     * @return JsonResponse
     */
    public function show(Deposit $deposit) : JsonResponse
    {
        return $this->success($deposit, $this->transformer);
    }
}
