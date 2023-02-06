<?php

namespace App\Custom\Observers\SupportTicket;

use App\Custom\Observers\BaseObserver;
use App\Models\TicketMessage;
use App\Models\User;
use App\Notifications\SupportTicket\TicketMessageNotification;

class TicketMessages extends BaseObserver
{
    public static $listen = ['ticket.message'];

    public function handle(User $user, TicketMessage $ticketMessage)
    {
        $user->notify(new TicketMessageNotification($ticketMessage));
    }
}
