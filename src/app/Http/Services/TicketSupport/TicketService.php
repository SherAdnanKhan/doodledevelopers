<?php


namespace App\Http\Services\TicketSupport;

use App\Exceptions\ErrorException;
use App\Http\Services\BaseService;
use App\Models\SupportTicket;
use App\Models\TicketMessage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TicketService extends BaseService
{
    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function getAll(array $data) : LengthAwarePaginator
    {
         $tickets = auth()->user()->tickets()->with('messages');

         if(isset($data['status'])) {
             $tickets = $tickets->ofStatus($data['status']);
         }

         return $tickets->paginate(10);
    }

    /**
     * @param array $data
     * @return SupportTicket
     */
    public function store(array $data) : SupportTicket
    {
        $ticket = auth()->user()->tickets()->create([
            'id' =>  str::uuid()->toString(),
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => SupportTicket::STATUS_NEW
        ]);

        Log::info(__METHOD__ . " -- user: " . auth()->user()->email . " -- User create support ticket: ", $ticket->toArray());

        Event::dispatch('ticket.generated', [auth()->user(), $ticket]);

        return $ticket;
    }

    /**
     * @param SupportTicket $ticket
     * @param array $data
     * @return bool
     */
    public function update(SupportTicket $ticket, array $data) : bool
    {
        Log::info(__METHOD__ . " -- user: " . auth()->user()->email . " -- User update the status of ticket: " . $ticket->id . " -- ", $data);

        if ($ticket->status == SupportTicket::STATUS_CLOSED) {
            Log::error(__METHOD__ . " -- user: " . auth()->user()->email . " -- User is changing the status of closed ticket", $ticket->toArray());
            throw new ErrorException('exception.ticket_status_error');
        }

        return $ticket->update([
            'status' => $data['status']
        ]);
    }

    /**
     * @param SupportTicket $ticket
     * @throws ErrorException
     */
    public function destroy(SupportTicket $ticket) : void
    {
        Log::info(__METHOD__ . " -- user: " . auth()->user()->email . " -- User delete ticket: ", $ticket->toArray());

        $ticket->delete();
    }

    /**
     * @param array $data
     * @return TicketMessage
     */
    public function message(array $data) : TicketMessage
    {
        $ticketMessage = TicketMessage::create([
            'ticket_id' => $data['ticket_id'],
            'user_id' => auth()->id(),
            'message' => $data['message']
        ]);

        Log::info(__METHOD__ . " -- user: " . auth()->user()->email . " -- Create Ticket message: ", $ticketMessage->toArray());

        Event::dispatch('ticket.message', [auth()->user(), $ticketMessage]);

        return $ticketMessage;
    }
}
