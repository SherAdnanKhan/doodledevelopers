<?php

namespace App\Http\Requests\Games;

use App\Models\Game;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGameRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'string|max:255|unique:games,name,'. $this->game->id,
            'jackpot_value' => 'numeric|gt:0',
            'admin_fee_percentage' => 'numeric|gt:0',
            'entry_fee' => 'numeric|gt:0',
            'game_ext_days' => 'integer|gt:0',
            'number_of_winners' => 'required_with:entry_fee|integer|gt:0',
            'status' => ['string', 'max:255', Rule::in(array_keys(Game::statuses()))],
            'pot_value' => 'numeric|gte:0',
            'is_extended' => 'boolean',
            'start_date' => 'date|after_or_equal:today',
            'end_date' => 'date|after_or_equal:start_date',
            'amount_of_balls_to_fire' => 'integer|gt:0',
            'total_attempts' => 'integer|gt:0',
            'map_id' => 'numeric|gt:0'
        ];
    }
}
