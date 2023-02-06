<?php

namespace App\Http\Controllers\KycValidations;

use App\Http\Controllers\Controller;
use App\Http\Requests\KycValidations\UpdateKycValidationRequest;
use App\Http\Services\KycValidations\KycValidationService;
use App\Http\Transformers\KycValidations\KycValidationTransformer;
use App\Models\KycValidation;
use Illuminate\Http\JsonResponse;

class KycValidationAdminController extends Controller
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
     *     path="/api/admin/kyc-validations",
     *     description="Get KYC Validations",
     *     summary="Get KYC Validations",
     *     operationId="getKycValidations",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/KYC"},
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
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        $validations = $this->service->getAll();

        return $this->success($validations, $this->transformer);
    }

    /**
     * @OA\Get(
     *     path="/api/admin/kyc-validations/{kycValidation}",
     *     description="Get KYC Validation",
     *     summary="Get KYC Validation",
     *     operationId="getKycValidation",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/KYC"},
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

    /**
     * @OA\Put(
     *     path="/api/admin/kyc-validations/{kycValidation}",
     *     description="Update KYC Validation",
     *     summary="Update KYC Validation",
     *     operationId="updateKycValidation",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/KYC"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
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
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="status",
     *                     type="string",
     *                     example="rejected"
     *                 ),
     *                 @OA\Property(
     *                     property="review_notes",
     *                     type="string",
     *                     example="Document is blurry."
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Kyc validation updated successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Kyc validation updated successfully"
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
     * @param UpdateKycValidationRequest $request
     * @param KycValidation $kycValidation
     * @return JsonResponse
     */
    public function update(UpdateKycValidationRequest $request, KycValidation $kycValidation) : JsonResponse
    {
        $kycValidation = $this->service->update($kycValidation, $request->validated());

        return $this->success($kycValidation, $this->transformer, trans('messages.kyc_validation_update_success'));
    }

    /**
     * @OA\Delete(
     *     path="/api/admin/kyc-validations/{kycValidation}",
     *     description="Delete KYC Validation",
     *     summary="Delete KYC Validation",
     *     operationId="deleteKycValidation",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/KYC"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="kycValidation",
     *         parameter="kycValidation",
     *         example=1
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Kyc validation deleted successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Kyc validation deleted successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     example="[]"
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param KycValidation $kycValidation
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(KycValidation $kycValidation) : JsonResponse
    {
        $this->service->delete($kycValidation);

        return $this->success([], null, trans('messages.kyc_validation_delete_success'));
    }
}
