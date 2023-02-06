<?php

namespace App\Http\Requests\TicketSupport;

use App\Models\SupportTicket;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTicketRequest extends FormRequest
{
    public function rules()
    {
        $excludeStatuses = ['new', "inprogress", "resolved"];

        return [
            'status' => ['string', 'max:255', Rule::in(array_keys(array_except(SupportTicket::statuses(), $excludeStatuses)))]
        ];
    }
}
