<?php

namespace App\Http\Transformers\Games;

use App\Http\Services\Games\GameWinnerEarningAdminService;
use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Constants\ConstantTransformer;
use App\Http\Transformers\Maps\MapAdminTransformer;
use App\Http\Transformers\Wallets\GameTransactionTransformer;
use App\Models\Game;

class GameAdminTransformer extends BaseTransformer
{
    protected $defaultIncludes = [
        'status'
    ];

    protected $availableIncludes = [
        'players', 'map'
    ];

    /**
     * @var GameWinnerEarningAdminService/
     */
    private $service;

    public function __construct()
    {
        $this->service = app(GameWinnerEarningAdminService::class);
    }

    public function transform(Game $game)
    {
        return [
            'id' => $game->id,
            'name' => $game->name,
            'jackpot_value' => $game->jackpot_value,
            'admin_fee_percentage' => $game->admin_fee_percentage,
            'pot_value' => (double) $game->pot_value,
            'entry_fee' => $game->entry_fee,
            'number_of_winners' => $game->number_of_winners,
            'game_ext_days' => $game->game_ext_days,
            'is_extended' => (int) $game->is_extended,
            'start_date' => $game->start_date,
            'end_date' => $game->end_date,
            'amount_of_balls_to_fire' => $game->amount_of_balls_to_fire,
            'total_attempts' => $game->total_attempts,
            'admin_earning' => $this->service->calculateAdminEarning($game),
            'days_remaining' => $game->days_remaining
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
        return $this->collection($players, new GamePlayerAdminTransformer);
    }

}

