<?php

namespace App\Http\Services\Games;

use App\Exceptions\ErrorException;
use App\Http\Services\BaseService;
use App\Models\Game;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class GamePlayerAdminService extends BaseService
{
    /**
     * @param Game $game
     * @return LengthAwarePaginator
     */
    public function getAll(Game $game) : LengthAwarePaginator
    {
        return $game->players()->paginate(10);
    }

    /**
     * @param Game $game
     * @param User $player
     * @return User
     */
    public function getPlayer(Game $game, User $player) : User
    {
        return $game->players()->where('user_id', $player->id)->first();
    }

    /**
     * @param Game $game
     * @param User $player
     * @return int
     * @throws ErrorException
     */
    public function destroy(Game $game, User $player) : int
    {
        Log::alert(__METHOD__ . " -- Admin delete the player:", $player->toArray());

        if ($player->isPlayingGame()) {
            Log::error(__METHOD__ . " -- Player cannot be deleted if he is playing the game");
            throw new  ErrorException('exception.game_player_delete_error');
        }

        return $game->players()->detach($player->id);
    }
}
