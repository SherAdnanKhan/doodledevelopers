<?php

namespace App\Http\Controllers\TicketSupport;

use App\Exceptions\ErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\TicketSupport\CreateTicketRequest;
use App\Http\Requests\TicketSupport\GetTicketRequest;
use App\Http\Requests\TicketSupport\UpdateTicketRequest;
use App\Http\Services\TicketSupport\TicketService;
use App\Http\Transformers\TicketSupport\TicketTransformer;
use App\Models\SupportTicket;
use Illuminate\Http\JsonResponse;

class TicketController extends Controller
{
    /**
     * @var TicketService
     */
    private TicketService $service;

    /**
     * @var TicketTransformer
     */
    private TicketTransformer $transformer;

    public function __construct(
        TicketService $service,
        TicketTransformer $transformer
    ) {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /**
     * @OA\Get(
     *     path="/api/users/tickets",
     *     description="Get Tickets",
     *     summary="Get Tickets",
     *     operationId="getTickets",
     *     security={{"bearerAuth":{}}},
     *     tags={"Support Ticket"},
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         style="form",
     *         explode=false,
     *         description="Get tickets from one of these statuses",
     *         @OA\Schema(
     *             type="string",
     *             enum={"new", "inprogress", "inrevision", "resolved", "closed"},
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Success"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/TicketSupport")
     *                 ),
     *                 @OA\Property(
     *                     property="pagination",
     *                     @OA\Property(
     *                         property="total",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="count",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="per_page",
     *                         type="integer",
     *                         example=10
     *                     ),
     *                     @OA\Property(
     *                         property="current_page",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="total_pages",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="links",
     *                         type="string",
     *                          example="{}"
     *                     )
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param GetTicketRequest $request
     * @return JsonResponse
     */
    public function index(GetTicketRequest $request) : JsonResponse
    {
       $tickets = $this->service->getAll($request->validated());

       return $this->success($tickets, $this->transformer);
    }

    /**
     * @OA\Post(
     *     path="/api/users/tickets",
     *     description="Create Ticket",
     *     summary="Create Ticket",
     *     operationId="createTicket",
     *     security={{"bearerAuth":{}}},
     *     tags={"Support Ticket"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="title",
     *                     type="string",
     *                     example="payout issue"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     example="Sed tristique velit ante, sit amet convallis ante molestie ut. Fusce risus magna, faucibus elementum arcu id, condimentum mattis quam. Mauris sit amet nisi eros. Pellentesque sit amet dignissim leo"
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Ticket is created successfully. Support team will contact you shortly",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Ticket is created successfully. Support team will contact you shortly"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/TicketSupport")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param CreateTicketRequest $request
     * @return JsonResponse
     */
    public function store(CreateTicketRequest $request) : JsonResponse
    {
        $ticket = $this->service->store($request->validated());

        return $this->success($ticket, $this->transformer, trans('messages.ticket_create_success'));
    }

    /**
     * @OA\Put (
     *     path="/api/users/tickets/{ticket}",
     *     description="Update Ticket",
     *     summary="Update Ticket",
     *     operationId="updateTicket",
     *     security={{"bearerAuth":{}}},
     *     tags={"Support Ticket"},
     *     @OA\Parameter(
     *         @OA\Schema(type="string"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="ticket",
     *         parameter="ticket",
     *         example="bed676e9-402e-42f4-a220-17f4793f0097"
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         style="form",
     *         explode=false,
     *         description="Update ticket from one of these statuses",
     *         @OA\Schema(
     *             type="string",
     *             enum={"inrevision", "closed"},
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Ticket is updated successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Ticket is updated successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/TicketSupport")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param UpdateTicketRequest $request
     * @param SupportTicket $ticket
     * @return JsonResponse
     * @throws ErrorException
     */
    public function update(UpdateTicketRequest $request, SupportTicket $ticket) : JsonResponse
    {
       $this->service->update($ticket, $request->validated());

       return $this->success($ticket, $this->transformer, trans('messages.ticket_update_success'));
    }

    /**
     * @OA\Get(
     *     path="/api/users/tickets/{ticket}",
     *     description="Get Ticket",
     *     summary="Get Ticket",
     *     operationId="getTicket",
     *     security={{"bearerAuth":{}}},
     *     tags={"Support Ticket"},
     *     @OA\Parameter(
     *         @OA\Schema(type="string"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="ticket",
     *         parameter="ticket",
     *         example="bed676e9-402e-42f4-a220-17f4793f0097"
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Success"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/TicketSupport")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param SupportTicket $ticket
     * @return JsonResponse
     */
    public function show(SupportTicket $ticket) : JsonResponse
    {
        return $this->success($ticket, $this->transformer);
    }

    /**
     * @OA\Delete(
     *     path="/api/users/tickets/{ticket}",
     *     description="Delete Ticket",
     *     summary="Delete Ticket",
     *     operationId="deleteTicket",
     *     security={{"bearerAuth":{}}},
     *     tags={"Support Ticket"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="ticket",
     *         parameter="ticket",
     *         example="bed676e9-402e-42f4-a220-17f4793f0097"
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Ticket deleted successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Ticket deleted successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     example="[]"
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param SupportTicket $ticket
     * @return JsonResponse
     * @throws ErrorException
     */
    public function destroy(SupportTicket $ticket) : JsonResponse
    {
        $this->service->destroy($ticket);

        return $this->success(null, $this->transformer, trans('messages.ticket_delete_success'));
    }
}
