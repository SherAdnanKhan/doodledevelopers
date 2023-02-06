<?php

namespace App\Http\Services\KycValidations;

use App\Exceptions\ErrorException;
use App\Http\Services\BaseService;
use App\Http\Services\Uploads\FileUploadService;
use App\Models\KycValidation;
use App\Models\KycValidationDocument;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class KycValidationDocumentService extends BaseService
{
    /**
     * @var FileUploadService/
     */
    private FileUploadService $service;

    public function __construct(FileUploadService $service)
    {
        $this->service = $service;
    }

    /**
     * @param KycValidation $validation
     * @param array $data
     * @return Model
     * @throws ErrorException
     */
    public function store(KycValidation $validation, array $data) : Model
    {
        Log::info(__METHOD__ . " -- user: " . auth()->user()->email . " -- User attached the kyc validation document:", $data);

        if ($validation->document()->count() > 0) {
            Log::error(__METHOD__ . " -- user: " . auth()->user()->email . " -- User kyc validation document already exists");
            throw new ErrorException('exception.kyc_validation_document_exists', [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $filePath = $this->service->uploadFile($data['file'], [
            'quality' => 50
        ], "users/kycvalidations/" . hash('sha256', $validation->id) . "/");

        return $validation->document()->create([
            "filename" => $data["name"],
            "link" => $filePath,
            "type" => $data["type"]
        ]);
    }

    /**
     * @param KycValidation $validation
     * @param KycValidationDocument $document
     * @param array $data
     * @return Model
     * @throws ErrorException
     */
    public function update(KycValidation $validation, KycValidationDocument $document, array $data) : Model
    {
        Log::info(__METHOD__ . " -- user: " . auth()->user()->email . " -- User updated the attached kyc validation document:", $data);
        if ($validation->isApproved()) {
            Log::error(__METHOD__ . " -- user: " . auth()->user()->email . " -- User kyc validation document is already approved");
            throw new ErrorException('exception.kyc_validation_document_update_fail', [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        unlink(storage_path("app/public/{$validation->document->link}"));

        $filePath = $this->service->uploadFile($data['file'], [
            'quality' => 50
        ], "users/kycvalidations/" . hash('sha256', $validation->id) . "/");

        $document->update([
            "filename" => $data["name"],
            "link" => $filePath,
            "type" => $data["type"]
        ]);

        $validation->update([
            "status" => KycValidation::STATUS_RESUBMIT,
            "reviewed_by_id" => null,
            "review_notes" => null,
            "reviewed_at" => null
        ]);

        return $validation->document->refresh();
    }

    /**
     * @param KycValidationDocument $document
     * @return bool
     * @throws \Exception
     */
    public function delete(KycValidationDocument $document) : bool
    {
        Log::info(__METHOD__ . " -- user: " . auth()->user()->email . " -- User deleted the attached kyc validation document:", $document->toArray());

        unlink(storage_path("/app/public/{$document->link}"));

        return $document->delete();
    }
}
