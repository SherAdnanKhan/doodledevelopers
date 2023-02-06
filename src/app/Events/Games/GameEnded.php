<?php

namespace App\Events\Games;

use App\Models\GamePlayer;
use App\Models\GameWinnerEarnings;
use App\Models\User;
use Illuminate\Queue\SerializesModels;

class GameEnded
{
    use SerializesModels;

    public $user;
    public $gameWinnerEarnings;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param  GameWinnerEarnings $gameWinnerEarnings
     * @return void
     */
    public function __construct(User $user, GameWinnerEarnings $gameWinnerEarnings)
    {
        $this->gameWinnerEarnings = $gameWinnerEarnings;
        $this->user = $user;
    }
}
