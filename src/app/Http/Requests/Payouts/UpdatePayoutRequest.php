<?php

namespace App\Http\Requests\Payouts;

use App\Models\GameTransaction;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePayoutRequest extends FormRequest
{

    public function rules()
    {
        return [
            'status' => ['required', 'string', 'max:255', Rule::in(array_keys(GameTransaction::statuses()))]
        ];
    }
}
