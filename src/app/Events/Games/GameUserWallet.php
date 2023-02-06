<?php

namespace App\Events\Games;

use App\Models\User;
use App\Models\UserGameWallet;
use Illuminate\Queue\SerializesModels;

class GameUserWallet
{
    use SerializesModels;

    public $hostUser;
    public $invitedUser;

    /**
     * Create a new event instance.
     *
     * @param User $hostUser
     * @param User $invitedUser
     */
    public function __construct(User $hostUser, User $invitedUser)
    {
        $this->hostUser = $hostUser;
        $this->invitedUser = $invitedUser;
    }
}
