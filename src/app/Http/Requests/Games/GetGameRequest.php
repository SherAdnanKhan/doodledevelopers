<?php

namespace App\Http\Requests\Games;

use App\Models\Game;
use App\Models\GamePlayer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetGameRequest extends FormRequest
{

    public function rules()
    {
        return [
            'status' => 'gamestatus',
            'player_status' => ['string', 'max:255', Rule::in(array_merge(['all'], array_keys(GamePlayer::statuses())))]
        ];
    }
}
