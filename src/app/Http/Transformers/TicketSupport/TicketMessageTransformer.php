<?php

namespace App\Http\Transformers\TicketSupport;

use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Users\UserTransformer;
use App\Models\TicketMessage;

class TicketMessageTransformer extends BaseTransformer
{
    protected $defaultIncludes = [
        'user',
    ];

    public function transform(TicketMessage $ticketMessage)
    {

        return [
            'id' => $ticketMessage->id,
            'message' => $ticketMessage->message,
            'created_at' => $ticketMessage->created_at
        ];
    }

    public function includeUser(TicketMessage $ticketMessage)
    {
        if ($ticketMessage->user) {
            return $this->item($ticketMessage->user, new UserTransformer);
        }
    }
}
