<?php

namespace App\Custom\Observers\SupportTicket;

use App\Custom\Observers\BaseObserver;;
use App\Models\SupportTicket;
use App\Models\User;
use App\Notifications\SupportTicket\TicketGeneratedNotification;

class TicketGenerate extends BaseObserver
{
    public static $listen = ['ticket.generated'];

    public function handle(User $user, SupportTicket $ticket)
    {
        $user->notify(new TicketGeneratedNotification($ticket));
    }
}
