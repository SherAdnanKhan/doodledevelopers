<?php

namespace App\Http\Transformers\TicketSupport;

use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Constants\ConstantTransformer;
use App\Http\Transformers\Users\UserTransformer;
use App\Models\SupportTicket;

class TicketTransformer extends BaseTransformer
{
    protected $defaultIncludes = [
        'status', 'user'
    ];

    protected $availableIncludes = [
        'messages'
    ];

    public function transform(SupportTicket $ticket)
    {
        return [
            'id' => $ticket->id,
            'title' => $ticket->title,
            'description' => $ticket->description,
        ];
    }

    public function includeStatus(SupportTicket $ticket)
    {
        $item = [
            'id' => $ticket->status,
            'name' => data_get($ticket::statuses(), $ticket->status)
        ];

        return $this->item($item, new ConstantTransformer);
    }

    public function includeMessages(SupportTicket $ticket)
    {
        if ($ticket->messages()->count() > 0) {
            return $this->collection($ticket->messages, new TicketMessageTransformer);
        }
    }

    public function includeUser(SupportTicket $ticket)
    {
        if ($ticket->user) {
            return $this->item($ticket->user, new UserTransformer);
        }
    }
}
