<?php

namespace App\Custom\Observers\Games;

use App\Custom\Observers\BaseObserver;
use App\Models\Game;
use App\Notifications\Games\GameExtensionNotification;

class GameExtensions extends BaseObserver
{
    public static $listen = ['game.extended'];

    public function handle(Game $game, string $extensionEndDate)
    {
        foreach ($game->players as $player) {
            $player->notify(new GameExtensionNotification($game->name, $extensionEndDate));
        }
    }
}
