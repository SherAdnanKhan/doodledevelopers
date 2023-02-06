<?php

namespace App\Http\Controllers\TicketSupport;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketSupport\AdminUpdateTicketRequest;
use App\Http\Requests\TicketSupport\GetTicketRequest;
use App\Http\Services\TicketSupport\TicketAdminService;
use App\Http\Transformers\TicketSupport\TicketTransformer;
use App\Models\SupportTicket;
use Illuminate\Http\JsonResponse;

class TicketAdminController extends Controller
{
    /**
     * @var TicketAdminService
     */
    private TicketAdminService $service;

    /**
     * @var TicketTransformer
     */
    private TicketTransformer $transformer;

    public function __construct(
        TicketAdminService $service,
        TicketTransformer $transformer
    ) {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /**
     * @OA\Get(
     *     path="/api/admin/tickets",
     *     description="Get Tickets",
     *     summary="Get Tickets",
     *     operationId="getTickets",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/Support Ticket"},
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
     *
     * @param GetTicketRequest $request
     * @return JsonResponse
     */
    public function index(GetTicketRequest $request) : JsonResponse
    {
        $tickets = $this->service->getAll($request->validated());

        return $this->success($tickets, $this->transformer);
    }

    /**
     * @OA\Put (
     *     path="/api/admin/tickets/{ticket}",
     *     description="Update Ticket",
     *     summary="Update Ticket",
     *     operationId="updateTicket",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/Support Ticket"},
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
     *         description="update ticket from one of these statuses",
     *         @OA\Schema(
     *             type="string",
     *             enum={"inprogress", "resolved"},
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="If you only want to update status of ticket don't send message in body params",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Fusce ultricies maximus ipsum. Donec auctor aliquet ligula, ut dapibus mauris. Sed eget venenatis odio. Nam lobortis elit ac massa efficitur lacinia vitae ac turpis. Fusce a sem sem. Nam scelerisque eu ligula non lacinia. Integer gravida leo quis sagittis sollicitudin. Fusce non gravida leo. Mauris laoreet magna id felis luctus, sed luctus tortor ultrices. Curabitur eu gravida nulla. Quisque aliquet imperdiet magna, non consequat lorem auctor vel."
     *                 ),
     *             )
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
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/TicketSupport")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     *
     * @param AdminUpdateTicketRequest $request
     * @param SupportTicket $ticket
     * @return JsonResponse
     */
    public function update(AdminUpdateTicketRequest $request, SupportTicket $ticket) : JsonResponse
    {
        $this->service->update($ticket, $request->validated());

        return $this->success($ticket, $this->transformer, trans('messages.ticket_update_success'));
    }

    /**
     * @OA\Get(
     *     path="/api/admin/tickets/{ticket}",
     *     description="Get Ticket",
     *     summary="Get Ticket",
     *     operationId="getTicket",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/Support Ticket"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="ticket",
     *         parameter="ticket",
     *         example=1
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
}
