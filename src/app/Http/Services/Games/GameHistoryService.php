<?php

namespace App\Http\Services\Games;

use App\Http\Services\BaseService;
use App\Models\Game;
use Illuminate\Pagination\LengthAwarePaginator;

class GameHistoryService extends BaseService
{
    /**
     * @return LengthAwarePaginator
     */
    public function getAll() : LengthAwarePaginator
    {
        $user = auth()->user();
        $games = $user->games()->whereIn('games.status', [Game::STATUS_FINISHED, Game::STATUS_ENDED_BY_ADMIN])->get();
        return $this->paginate($games);
    }
}
