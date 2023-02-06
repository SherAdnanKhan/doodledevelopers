<?php
namespace App\Http\Transformers\Games;

use App\Http\Transformers\BaseTransformer;
use App\Models\Game;

class GamePublicTransformer extends BaseTransformer
{
    public function transform(Game $game)
    {
        return [
            'id' => $game->id,
            'name' => $game->name,
            'entry_fee' => $game->entry_fee,
            'jackpot_value' => $game->jackpot_value,
            'start_date' => $game->start_date,
            'end_date' => $game->end_date,
            'days_remaining' => $game->days_remaining
        ];
    }
}
