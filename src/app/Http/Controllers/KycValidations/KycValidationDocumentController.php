<?php

namespace App\Http\Controllers\KycValidations;

use App\Exceptions\ErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\KycValidations\CreateKycValidationDocumentRequest;
use App\Http\Services\KycValidations\KycValidationDocumentService;
use App\Http\Transformers\KycValidations\KycValidationDocumentTransformer;
use App\Models\KycValidation;
use App\Models\KycValidationDocument;
use Exception;
use Illuminate\Http\JsonResponse;

class KycValidationDocumentController extends Controller
{
    /**
     * @var KycValidationDocumentService/
     */
    private $service;

    /**
     * @var KycValidationDocumentTransformer
     */
    private $transformer;

    public function __construct(
        KycValidationDocumentService $service,
        KycValidationDocumentTransformer $transformer
    )
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /**
     * @OA\Post(
     *     path="/api/users/kyc-validations/{kycValidation}/documents",
     *     description="Create KYC Validation Document",
     *     summary="Create KYC Validation Document",
     *     operationId="createKycValidationDocument",
     *     security={{"bearerAuth":{}}},
     *     tags={"KYC Document"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="kycValidation",
     *         parameter="kycValidation",
     *         example=1
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="abc.pdf"
     *                 ),
     *                 @OA\Property(
     *                     property="type",
     *                     type="string",
     *                     example="id"
     *                 ),
     *                 @OA\Property(
     *                     property="file",
     *                     type="string",
     *                     format="base64pdf",
     *                     example="data:application/pdf;base64,JVBERi0xLjcNCiW1tbW1DQoxIDAgb2JqDQo8PC9UeXBlL..."
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Kyc validation document added successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Kyc validation document added successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/KycValidationDocument")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param CreateKycValidationDocumentRequest $request
     * @param KycValidation $kycValidation
     * @return JsonResponse
     * @throws ErrorException
     */
    public function store(CreateKycValidationDocumentRequest $request, KycValidation $kycValidation) : JsonResponse
    {
        $validation = $this->service->store($kycValidation, $request->validated());

        return $this->success($validation, $this->transformer, trans('messages.kyc_validation_document_create_success'));
    }

    /**
     * @OA\Get(
     *     path="/api/users/kyc-validations/{kycValidation}/documents/{document}",
     *     description="Get KYC Validation Document",
     *     summary="Get KYC Validation Document",
     *     operationId="getKycValidationDocument",
     *     security={{"bearerAuth":{}}},
     *     tags={"KYC Document"},
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
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="document",
     *         parameter="document",
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
     *                         @OA\Schema(ref="#/components/schemas/KycValidationDocument")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param $kycValidation
     * @param KycValidationDocument $document
     * @return JsonResponse
     */
    public function show($kycValidation, KycValidationDocument $document) : JsonResponse
    {
        return $this->success($document, $this->transformer);
    }

    /**
     * @OA\Put(
     *     path="/api/users/kyc-validations/{kycValidation}/documents/{document}",
     *     description="Update KYC Validation Document",
     *     summary="Update KYC Validation Document",
     *     operationId="updateKycValidationDocument",
     *     security={{"bearerAuth":{}}},
     *     tags={"KYC Document"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         name="kycValidation",
     *         parameter="kycValidation",
     *         example=1
     *     ),
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         name="document",
     *         parameter="document",
     *         example=1
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="abc.pdf"
     *                 ),
     *                 @OA\Property(
     *                     property="type",
     *                     type="string",
     *                     example="id"
     *                 ),
     *                 @OA\Property(
     *                     property="file",
     *                     type="string",
     *                     format="base64pdf",
     *                     example="data:application/pdf;base64,JVBERi0xLjcNCiW1tbW1DQoxIDAgb2JqDQo8PC9UeXBlL..."
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Kyc validation document updated successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Kyc validation document updated successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/KycValidationDocument")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param CreateKycValidationDocumentRequest $request
     * @param KycValidation $kycValidation
     * @param KycValidationDocument $document
     * @return JsonResponse
     * @throws ErrorException
     */
    public function update(CreateKycValidationDocumentRequest $request, KycValidation $kycValidation, KycValidationDocument $document) : JsonResponse
    {
        $validation = $this->service->update($kycValidation, $document, $request->validated());

        return $this->success($validation, $this->transformer, trans('messages.kyc_validation_document_update_success'));
    }

    /**
     * @OA\Delete(
     *     path="/api/users/kyc-validations/{kycValidation}/documents/{document}",
     *     description="Delete KYC Validation Document",
     *     summary="Delete KYC Validation Document",
     *     operationId="deleteKycValidationDocument",
     *     security={{"bearerAuth":{}}},
     *     tags={"KYC Document"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         name="kycValidation",
     *         parameter="kycValidation",
     *         example=1
     *     ),
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         name="document",
     *         parameter="document",
     *         example=1
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Kyc validation document deleted successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Kyc validation document deleted successfully"
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     example="[]"
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param $kycValidation
     * @param KycValidationDocument $document
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy($kycValidation, KycValidationDocument $document) : JsonResponse
    {
        $this->service->delete($document);

        return $this->success([], null, trans('messages.kyc_validation_document_delete_success'));
    }
}
