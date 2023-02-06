<?php

namespace App\Http\Requests\TicketSupport;

use App\Models\SupportTicket;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetTicketRequest extends FormRequest
{
    public function rules()
    {
        return [
            'status' => ['string', 'max:255', Rule::in(array_keys(SupportTicket::statuses()))]
        ];
    }
}
