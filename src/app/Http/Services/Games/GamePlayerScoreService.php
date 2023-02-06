<?php

namespace App\Http\Services\Games;

use App\Http\Services\BaseService;
use App\Models\Game;
use Illuminate\Pagination\LengthAwarePaginator;

class GamePlayerScoreService extends BaseService
{
    /**
     * @param Game $game
     * @return LengthAwarePaginator
     */
    public function getAll(Game $game) : LengthAwarePaginator
    {
        return auth()->user()->scores()->where('game_id', $game->id)->paginate(10);
    }
}
