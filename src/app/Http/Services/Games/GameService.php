<?php

namespace App\Http\Services\Games;

use App\Http\Services\BaseService;
use App\Models\Game;
use Illuminate\Pagination\LengthAwarePaginator;

class GameService extends BaseService
{
    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function getAll(array $data) : LengthAwarePaginator
    {
        $user = auth()->user();
        $games = Game::query();

        if (isset($data['player_status'])) {
            if ($data['player_status'] == 'all') {
                $games = $user->games();
            } else {
                $games = $user->games()->wherePivot('status', $data['player_status']);
            }
        }

        if (isset($data['status'])) {
            $statuses = explode(',', $data['status']);
            $games->where(function($query) use ($statuses) {
                foreach ($statuses as $status) {
                    $query->orWhere('games.status', $status);
                }
            });
        }

        return $this->paginate($games->get());
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getLiveGames() : LengthAwarePaginator
    {
        $games = Game::where(['status' => Game::STATUS_LIVE])->get();

        return $this->paginate($games);
    }

    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function getGamesWinners(array $data) : LengthAwarePaginator
    {
        $games = Game::query();

        if (isset($data['status'])) {
            $statuses = explode(',', $data['status']);
            $games->where(function($query) use ($statuses) {
                foreach ($statuses as $status) {
                    $query->orWhere('games.status', $status);
                }
            });
        }

        return $this->paginate($games->get());
    }
}
