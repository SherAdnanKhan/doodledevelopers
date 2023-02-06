<?php

namespace App\Custom\Observers\Games;

use App\Custom\Observers\BaseObserver;
use App\Models\GamePlayer;
use App\Models\GameWinnerEarnings;
use App\Models\User;
use App\Notifications\Games\GameWinnerNotification;

class GameWinners extends BaseObserver
{
    public static $listen = ['game.ended'];

    public function handle(User $user, GameWinnerEarnings $gameWinnerEarnings)
    {
        $user->notify(new GameWinnerNotification($gameWinnerEarnings));
    }
}
