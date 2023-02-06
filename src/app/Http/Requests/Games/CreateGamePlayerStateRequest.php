<?php

namespace App\Http\Requests\Games;

use Illuminate\Foundation\Http\FormRequest;

class CreateGamePlayerStateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'token' => 'required|string|max:255|exists:game_players,token',
            'state' => 'required'
        ];
    }
}
