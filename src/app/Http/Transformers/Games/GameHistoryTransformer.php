<?php
namespace App\Http\Transformers\Games;

use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Constants\ConstantTransformer;
use App\Http\Transformers\Maps\MapAdminTransformer;
use App\Models\Game;

class GameHistoryTransformer extends BaseTransformer
{
    protected $defaultIncludes = [
        'status'
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
            'total_attempts' => $game->pivot->number_of_times_played,
            'position_finished' => $this->getPositionFinished($game),
            'prize_won' => $this->getPrizeWon($game),
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

    public function getPrizeWon(Game $game)
    {
        $prize = 0;

        $earning = $game->players()->where(['users.id' => auth()->id()])->first()
            ->earnings()->where(['games.id' => $game->id])->first();

        if ($earning) {
            $prize = $earning->pivot->earning;
        }

        return $prize;
    }

    public function getPositionFinished(Game $game)
    {
        $position = 0;

        $players = $game->players()
            ->orderBy('highest_score', 'DESC')
            ->orderBy('shortest_duration', 'ASC')->get();

        foreach ($players as $player) {
            $position++;
            if ($player->id == auth()->id()) break;
        }

        return $position;
    }
}
