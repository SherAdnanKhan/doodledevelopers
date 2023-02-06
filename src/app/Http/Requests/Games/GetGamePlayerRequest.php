<?php

namespace App\Http\Requests\Games;

use App\Models\GamePlayer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetGamePlayerRequest extends FormRequest
{

    public function rules()
    {
        return [
            'status' => ['string', 'max:255', Rule::in(array_keys(GamePlayer::statuses()))]
        ];
    }
}
