<?php

namespace App\Http\Controllers\TicketSupport;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketSupport\CreateMessageRequest;
use App\Http\Services\TicketSupport\TicketService;
use App\Http\Transformers\TicketSupport\TicketMessageTransformer;
use Illuminate\Http\JsonResponse;

class TicketMessageController extends Controller
{
    /**
     * @var TicketService
     */
    private TicketService $service;

    /**
     * @var TicketMessageTransformer
     */
    private TicketMessageTransformer $transformer;

    public function __construct(
        TicketService $service,
        TicketMessageTransformer $transformer
    ) {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /**
     * @OA\Post(
     *     path="/api/users/ticket-message",
     *     description="Create Message",
     *     summary="Create Message",
     *     operationId="createMessage",
     *     security={{"bearerAuth":{}}},
     *     tags={"Ticket Message"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="ticket_id",
     *                     type="integer",
     *                     example="1"
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Sed tristique velit ante, sit amet convallis ante molestie ut. Fusce risus magna, faucibus elementum arcu id, condimentum mattis quam. Mauris sit amet nisi eros. Pellentesque sit amet dignissim leo. In in orci sed nulla tempus rutrum. Vivamus vel dignissim odio. Morbi in magna finibus, dapibus turpis vitae, faucibus odio"
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
     *                         @OA\Schema(ref="#/components/schemas/TicketMessage")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param CreateMessageRequest $request
     * @return JsonResponse
     */
    public function message(CreateMessageRequest $request) : JsonResponse
    {
        $ticketMessage = $this->service->message($request->validated());

        return $this->success($ticketMessage, $this->transformer);
    }

}
