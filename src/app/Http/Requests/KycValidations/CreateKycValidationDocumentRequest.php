<?php

namespace App\Http\Requests\KycValidations;

use App\Models\KycValidationDocument;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateKycValidationDocumentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'type' => ['required', 'string','max:255', Rule::in(array_keys(KycValidationDocument::types()))],
            'file' => 'required|base64kyc'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'base64kyc' => 'The file must be a type of pdf, png, jpg, jpeg',
        ];
    }
}
