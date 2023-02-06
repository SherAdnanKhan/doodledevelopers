<?php

namespace App\Http\Requests\Games;

use App\Models\GameTransaction;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetGameTransactionRequest extends FormRequest
{

    public function rules()
    {
        return [
            'status' => ['string', 'max:255', Rule::in(array_keys(GameTransaction::statuses()))]
        ];
    }
}
