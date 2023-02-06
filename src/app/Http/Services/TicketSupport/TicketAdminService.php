<?php


namespace App\Http\Services\TicketSupport;

use App\Http\Services\BaseService;
use App\Models\SupportTicket;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class TicketAdminService extends BaseService
{
    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function getAll(array $data) : LengthAwarePaginator
    {
        $tickets = SupportTicket::with('messages');

        if(isset($data['status'])) {
            $tickets = $tickets->ofStatus($data['status']);
        }

        return $tickets->paginate(10);
    }

    /**
     * @param SupportTicket $ticket
     * @param array $data
     * @return bool
     */
    public function update(SupportTicket $ticket, array $data) : bool
    {
        Log::info(__METHOD__ . " -- Admin update the status of ticket: " . $ticket->id, $data);

        if (isset($data['message'])) {
            $ticket->messages()->create([
                'user_id' => auth()->id(),
                'message' => $data['message']
            ]);
        }

        if ($ticket->status == SupportTicket::STATUS_IN_PROGRESS && isset($data['status'])) {
            return $ticket->update([
                'status' => $data['status']
            ]);
        }

        return $ticket->update([
            'status' => SupportTicket::STATUS_IN_PROGRESS,
        ]);

    }
}
