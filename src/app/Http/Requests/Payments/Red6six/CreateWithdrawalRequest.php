<?php

namespace App\Http\Requests\Payments\Red6six;

use App\Models\Currency;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateWithdrawalRequest extends FormRequest
{
    public function rules()
    {
        return [
            'amount' => 'required|integer',
            'currency' => ['required', 'string', 'max:255', Rule::in(array_keys(Currency::types()))],
            'payment_brand' => ['required', 'string', 'max:255', Rule::in(['VISA', 'MASTER', 'AMEX'])],
            'payment_card_number' => 'required|numeric',
            'payment_expiry_month' => 'required|numeric',
            'payment_expiry_year' => 'required|numeric',
            'payment_card_holder' => 'required|string',
        ];
    }
}
