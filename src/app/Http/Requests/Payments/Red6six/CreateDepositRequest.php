<?php

namespace App\Http\Requests\Payments\Red6six;

use App\Models\Currency;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateDepositRequest extends FormRequest
{
    public function rules()
    {
        return [
            'amount' => 'required|integer',
            'currency' => ['required', 'string', 'max:255', Rule::in(array_keys(Currency::types()))],
        ];
    }
}
