<?php

namespace App\Http\Controllers\Payments\Red6six;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payments\Red6six\GetDepositRequest;
use App\Http\Services\Payments\Red6six\DepositAdminService;
use App\Http\Transformers\Payments\Red6six\DepositTransformer;
use Illuminate\Http\JsonResponse;

class DepositAdminController extends Controller
{

    /**
     * @var DepositAdminService
     */
    private DepositAdminService $service;

    /**
     * @var DepositTransformer
     */
    private DepositTransformer $transformer;

    public function __construct(
        DepositAdminService $service,
        DepositTransformer $transformer
    )
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /**
     * @OA\Get(
     *     path="/api/admin/deposits",
     *     description="Get Deposits",
     *     summary="Get Deposits",
     *     operationId="getDeposits",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/Deposit"},
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

}
