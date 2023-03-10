<?php

namespace App\Http\Requests\Games;

use Illuminate\Foundation\Http\FormRequest;

class CreateGamePlayerAttemptScoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'game_player_token' => 'required|string|max:255|exists:game_players,token',
            'attempt_number' => 'required|numeric|gt:0',
            'score' => 'required|numeric|gt:0',
            'duration' => 'required|numeric|gt:0'
        ];
    }
}
