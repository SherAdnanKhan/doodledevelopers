<?php

namespace App\Events\Games;

use App\Models\Game;
use Illuminate\Queue\SerializesModels;

class GameExtended
{
    use SerializesModels;

    public $game;
    public $extensionEndDate;

    /**
     * Create a new event instance.
     *
     * @param  Game $game
     * @param  string $extensionEndDate
     * @return void
     */
    public function __construct(Game $game, string $extensionEndDate)
    {
        $this->game = $game;
        $this->extensionEndDate = $extensionEndDate;
    }
}
