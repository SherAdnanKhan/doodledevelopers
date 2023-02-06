<?php

namespace App\Http\Requests\Games;

use Illuminate\Foundation\Http\FormRequest;

class GetGameMapRequest extends FormRequest
{
    public function rules()
    {
        return [
            'game_player_token' => 'required|string|max:255|exists:game_players,token',
        ];
    }
}
