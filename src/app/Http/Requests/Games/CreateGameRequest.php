<?php

namespace App\Http\Requests\Games;

use Illuminate\Foundation\Http\FormRequest;

class CreateGameRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:games,name',
            'jackpot_value' => 'required|numeric|gt:0',
            'admin_fee_percentage' => 'required|numeric|gt:0',
            'entry_fee' => 'required|numeric|gt:0',
            'game_ext_days' => 'required|integer|gte:0',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'amount_of_balls_to_fire' => 'integer|gt:0',
            'total_attempts' => 'integer|gt:0',
            'map_id' => 'required|numeric|gt:0'
        ];
    }
}
