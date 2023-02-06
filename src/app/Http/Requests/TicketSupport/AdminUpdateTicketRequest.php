<?php

namespace App\Http\Requests\TicketSupport;

use App\Models\SupportTicket;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminUpdateTicketRequest extends FormRequest
{
    public function rules()
    {
        return [
            'message' => 'string',
            'status' => ['string', 'max:255', Rule::in(array_keys(SupportTicket::statuses()))]
        ];
    }
}
