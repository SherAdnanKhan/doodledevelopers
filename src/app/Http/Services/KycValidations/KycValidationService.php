<?php

namespace App\Http\Services\KycValidations;

use App\Exceptions\ErrorException;
use App\Http\Services\BaseService;
use App\Models\KycValidation;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class KycValidationService extends BaseService
{
    /**
     * @return LengthAwarePaginator
     */
    public function getAll() : LengthAwarePaginator
    {
        return KycValidation::paginate(10);
    }

    public function getUserKycValidations()
    {
        return auth()->user()->kycValidation()->get();
    }

    /**
     * @return KycValidation
     * @throws ErrorException
     */
    public function store() : KycValidation
    {
        Log::info(__METHOD__ . " -- user: " . auth()->user()->email . " -- User request to create kyc validation");

        if (auth()->user()->kycValidation()->count() > 0) {
            Log::error(__METHOD__ . " -- user: " . auth()->user()->email . " -- kyc validation already exists");
            throw new ErrorException('exception.kyc_validation_exists', [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return KycValidation::create([
            'user_id' => auth()->id(),
            'status'  => KycValidation::STATUS_NEW
        ]);
    }

    /**
     * @param KycValidation $validation
     * @param array $data
     * @return KycValidation
     */
    public function update(KycValidation $validation, array $data) : KycValidation
    {
        Log::info(__METHOD__ . " -- Admin approve the kyc validation:", $data);

        $validation->update(array_merge($data, ['reviewed_at' => now(), 'reviewed_by_id' => auth()->id()]));

        if ($data['status'] == KycValidation::STATUS_APPROVED) {
            $validation->user()->update([
                'is_kyc_verified' => 1
            ]);
        }

        if ($data['status'] == KycValidation::STATUS_REJECTED) {
            $validation->user()->update([
                'is_kyc_verified' => 0
            ]);
        }

        return $validation;
    }

    /**
     * @param KycValidation $validation
     * @return bool
     * @throws ErrorException
     */
    public function delete(KycValidation $validation) : bool
    {
        Log::alert(__METHOD__ . " -- Admin delete the validation: ", $validation->toArray());

        if ($validation->status === KycValidation::STATUS_APPROVED) {
            Log::alert(__METHOD__ . " -- Admin cannot delete the kyc validation if it's already approved");
            throw new ErrorException('exception.approved_kyc_delete_error');
        }
        unlink(storage_path("app/public/{$validation->document->link}"));
        return $validation->delete();
    }
}
