<?php

namespace App\Http\Requests\KycValidations;

use App\Models\KycValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKycValidationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'status'     => ['required', 'string', 'max:255', Rule::in(array_keys(KycValidation::statuses()))],
            'review_notes'     => 'required|string|max:255'
        ];
    }
}
