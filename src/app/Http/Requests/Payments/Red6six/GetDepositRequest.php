<?php

namespace App\Http\Requests\Payments\Red6six;

use App\Models\Deposit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetDepositRequest extends FormRequest
{
    public function rules()
    {
        return [
            'status' => ['string', 'max:255', Rule::in(array_keys(Deposit::statuses()))],
            'payment_method' => ['string', 'max:255', Rule::in(PAYMENT_METHODS)],
        ];
    }
}
