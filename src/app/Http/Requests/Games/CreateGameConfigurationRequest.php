<?php

namespace App\Http\Requests\Games;

use Illuminate\Foundation\Http\FormRequest;

class CreateGameConfigurationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'currency_conversion_duration' => 'required|integer|gt:0',
            'min_deposit_amount' => 'required|integer|gt:0',
            'max_deposit_amount' => 'required|integer|gt:0',
            'min_withdrawal_amount' => 'required|integer|gt:0',
            'max_withdrawal_amount' => 'required|integer|gt:0',
            'amount_of_balls_to_fire' => 'required|integer|gt:0',
            'total_attempts' => 'required|integer|gt:0'
        ];
    }
}
