<?php

namespace App\Http\Requests\Games;

use Illuminate\Foundation\Http\FormRequest;

class CheckExpiryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'game_session_id' => 'required|string',
        ];
    }
}
