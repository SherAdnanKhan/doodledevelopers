<?php
namespace App\Http\Transformers\Games;

use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Constants\ConstantTransformer;
use App\Models\GamePlayer;

class GamePlayerUserTransformer extends BaseTransformer
{
    protected $availableIncludes = [
        'status'
    ];

    public function transform($gamePlayer)
    {
        return [
            'id' => $gamePlayer->id,
            'number_of_times_played' => $gamePlayer->number_of_times_played,
            'highest_score' => $gamePlayer->highest_score,
            'shortest_duration' => sprintf('%0.2f',floor($gamePlayer->shortest_duration * 100) / 100),
        ];
    }

    public function includeStatus($gamePlayer)
    {
        $item = [
            'id' => $gamePlayer->status,
            'name' => data_get(GamePlayer::statuses(), $gamePlayer->status)
        ];

        return $this->item($item, new ConstantTransformer);
    }
}
