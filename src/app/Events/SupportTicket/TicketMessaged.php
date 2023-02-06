<?php

namespace App\Events\SupportTicket;

use App\Models\TicketMessage;
use App\Models\User;
use Illuminate\Queue\SerializesModels;

class TicketMessaged
{
    use SerializesModels;

    public $user;
    public $ticket;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param TicketMessage $ticket
     */
    public function __construct(User $user, TicketMessage $ticket)
    {
        $this->user = $user;
        $this->ticket = $ticket;
    }
}
