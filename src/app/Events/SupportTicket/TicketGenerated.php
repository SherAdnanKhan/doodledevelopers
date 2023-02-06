<?php

namespace App\Events\SupportTicket;

use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Queue\SerializesModels;

class TicketGenerated
{
    use SerializesModels;

    public $user;
    public $ticket;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param SupportTicket $ticket
     */
    public function __construct(User $user, SupportTicket $ticket)
    {
        $this->user = $user;
        $this->ticket = $ticket;
    }
}
