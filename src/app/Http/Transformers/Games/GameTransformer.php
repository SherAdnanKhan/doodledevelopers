<?php
namespace App\Http\Transformers\Games;

use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Constants\ConstantTransformer;
use App\Http\Transformers\Maps\MapAdminTransformer;
use App\Models\Game;

class GameTransformer extends BaseTransformer
{
    protected $defaultIncludes = [
        'status'
    ];

    protected $availableIncludes = [
        'players', 'map'
    ];

    public function transform(Game $game)
    {
        return [
            'id' => $game->id,
            'name' => $game->name,
            'entry_fee' => $game->entry_fee,
            'jackpot_value' => $game->jackpot_value,
            'is_extended' => (int) $game->is_extended,
            'start_date' => $game->start_date,
            'end_date' => $game->end_date,
            'days_remaining' => $game->days_remaining,
            'amount_of_balls_to_fire' => $game->amount_of_balls_to_fire,
            'total_attempts' => $game->total_attempts
        ];
    }

    public function includeStatus(Game $game)
    {
        $item = [
            'id' => $game->status,
            'name' => data_get(Game::statuses(), $game->status)
        ];

        return $this->item($item, new ConstantTransformer);
    }

    public function includeMap(Game $game)
    {
        return $this->item($game->maps()->first()->map, new MapAdminTransformer);
    }

    public function includePlayers(Game $game)
    {
        $players = $game->players()
            ->orderBy('highest_score', 'DESC')
            ->orderBy('shortest_duration', 'ASC')
            ->get();

        if ($players->count() > 0) {
            return $this->collection($players, new GamePlayerAdminTransformer);
        }
    }
}
