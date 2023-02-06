<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketMessage extends Model
{
    /**
     * @OA\Schema(
     *     schema="TicketMessage",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=12345
     *     ),
     *     @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Sed tristique velit ante, sit amet convallis ante molestie ut. Fusce risus magna, faucibus elementum arcu id, condimentum mattis quam. Mauris sit amet nisi eros. Pellentesque sit amet dignissim leo. Morbi in magna finibus, dapibus turpis vitae, faucibus odio"
     *     ),
     *     @OA\Property(
     *         property="created_at",
     *         type="string",
     *         format="date-time",
     *         example="2020-01-01T00:00:00.000000Z"
     *     ),
     *     @OA\Property(
     *         property="user",
     *         allOf={
     *             @OA\Schema(ref="#/components/schemas/User")
     *         }
     *     ),
     * )
     */

    protected $guarded = ['created_at', 'updated_at'];

    /**
     * @return BelongsTo
     */
    public function ticket() : BelongsTo
    {
        return $this->belongsTo(SupportTicket::class);
    }

    /**
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
