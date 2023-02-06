<?php

namespace App\Http\Requests\Games;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGameConfigurationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'currency_conversion_duration' => 'integer|gt:0',
            'min_deposit_amount' => 'integer|gt:0',
            'max_deposit_amount' => 'integer|gt:0',
            'min_withdrawal_amount' => 'integer|gt:0',
            'max_withdrawal_amount' => 'integer|gt:0',
            'amount_of_balls_to_fire' => 'integer|gt:0',
            'total_attempts' => 'integer|gt:0'
        ];
    }
}

