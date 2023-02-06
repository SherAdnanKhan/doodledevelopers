<?php

namespace App\Http\Requests\TicketSupport;

use Illuminate\Foundation\Http\FormRequest;

class CreateMessageRequest extends FormRequest
{
    public function rules()
    {
        return [
            'ticket_id' => 'required|string|exists:support_tickets,id',
            'message' => 'required|string',
        ];
    }
}
