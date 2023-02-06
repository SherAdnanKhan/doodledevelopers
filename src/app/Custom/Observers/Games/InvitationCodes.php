<?php

namespace App\Custom\Observers\Games;

use App\Custom\Observers\BaseObserver;
use App\Models\Game;
use App\Models\User;
use App\Notifications\Users\InvitationCode;

class InvitationCodes extends BaseObserver
{
    public static $listen = ['user.invitation'];

    public function handle(User $user, Game $game, string $invitationCode)
    {
        $user->notify(new InvitationCode($game, $invitationCode));
    }
}
