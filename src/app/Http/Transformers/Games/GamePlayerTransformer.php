<?php
namespace App\Http\Transformers\Games;

use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Constants\ConstantTransformer;
use App\Http\Transformers\Users\UserTransformer;
use App\Models\GamePlayer;

class GamePlayerTransformer extends BaseTransformer
{
    protected $defaultIncludes = [
        'user'
    ];

    protected $availableIncludes = [
        'status'
    ];

    public function transform($gamePlayer)
    {
        return [
            'id' => $gamePlayer->pivot->id,
            'number_of_times_played' => $gamePlayer->pivot->number_of_times_played,
            'highest_score' => $gamePlayer->pivot->highest_score,
            'shortest_duration' => sprintf('%0.2f',floor($gamePlayer->pivot->shortest_duration * 100) / 100),
        ];
    }

    public function includeStatus($gamePlayer)
    {
        $item = [
            'id' => $gamePlayer->pivot->status,
            'name' => data_get(GamePlayer::statuses(), $gamePlayer->pivot->status)
        ];

        return $this->item($item, new ConstantTransformer);
    }

    public function includeUser($gamePlayer)
    {
        return $this->item($gamePlayer, new UserTransformer);
    }
}
