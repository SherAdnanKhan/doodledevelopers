<?php

namespace App\Custom\Observers\Games;

use App\Custom\Observers\BaseObserver;
use App\Models\User;
use App\Notifications\Games\GameUserWalletNotification;

class GameUserWallet extends BaseObserver
{
    public static $listen = ['game.credit'];

    public function handle(User $hostUser, User $invitedUser)
    {
        $hostUser->notify(new GameUserWalletNotification($invitedUser));
    }
}
