<?php

namespace App\Http\Controllers\KycValidations;

use App\Exceptions\ErrorException;
use App\Http\Controllers\Controller;
use App\Http\Services\KycValidations\KycValidationService;
use App\Http\Transformers\KycValidations\KycValidationTransformer;
use App\Models\KycValidation;
use Illuminate\Http\JsonResponse;

class KycValidationController extends Controller
{
    /**
     * @var KycValidationService/
     */
    private KycValidationService $service;

    /**
     * @var KycValidationTransformer
     */
    private KycValidationTransformer $transformer;

    public function __construct(
        KycValidationService $service,
        KycValidationTransformer $transformer
    )
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /**
     * @OA\Get(
     *     path="/api/users/kyc-validations",
     *     description="Get KYC Validations",
     *     summary="Get KYC Validations",
     *     operationId="getKycValidations",
     *     security={{"bearerAuth":{}}},
     *     tags={"KYC"},
     *     @OA\Parameter(
     *         name="include",
     *         in="query",
     *         required=false,
     *         style="form",
     *         explode=false,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items( type="enum", enum={"reviewer", "document"} ),
     *             example={"reviewer"}
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
     *                     @OA\Items(ref="#/components/schemas/KycValidation")
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
     *                         @OA\Property(
     *                             property="previous",
     *                             type="string",
     *                             example="http://domain.com/api/users/kyc-validations?page=1"
     *                         ),
     *                         @OA\Property(
     *                             property="next",
     *                             type="string",
     *                             example="http://domain.com/api/users/kyc-validations?page=3"
     *                         )
     *                     )
     *                 ),
     *             )
     *         )
     *     )
     * )
     *
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        $validations = $this->service->getUserKycValidations();

        return $this->success($validations, $this->transformer);
    }

    /**
     * @OA\Post(
     *     path="/api/users/kyc-validations",
     *     description="Create KYC Validation",
     *     summary="Create KYC Validation",
     *     operationId="createKycValidation",
     *     security={{"bearerAuth":{}}},
     *     tags={"KYC"},
     *     @OA\Response(
     *         response="200",
     *         description="Kyc validation created successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Kyc validation created successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/KycValidation")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @return JsonResponse
     * @throws ErrorException
     */
    public function store() : JsonResponse
    {
        $validation = $this->service->store();

        return $this->success($validation, $this->transformer, trans('messages.kyc_validation_create_success'));
    }

    /**
     * @OA\Get(
     *     path="/api/users/kyc-validations/{kycValidation}",
     *     description="Get KYC Validation",
     *     summary="Get KYC Validation",
     *     operationId="getKycValidation",
     *     security={{"bearerAuth":{}}},
     *     tags={"KYC"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *          required=true,
     *         name="kycValidation",
     *         parameter="kycValidation",
     *         example=1
     *     ),
     *     @OA\Parameter(
     *         name="include",
     *         in="query",
     *         required=false,
     *         style="form",
     *         explode=false,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items( type="enum", enum={"reviewer", "document"} ),
     *             example={"reviewer"}
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
     *                         @OA\Schema(ref="#/components/schemas/KycValidation")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param KycValidation $kycValidation
     * @return JsonResponse
     */
    public function show(KycValidation $kycValidation) : JsonResponse
    {
        return $this->success($kycValidation, $this->transformer);
    }

}
