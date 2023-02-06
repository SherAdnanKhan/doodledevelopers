<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupportTicket extends Model
{
    /**
     * @OA\Schema(
     *     schema="TicketSupport",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=12345
     *     ),
     *     @OA\Property(
     *         property="title",
     *         type="string",
     *         example="game issue"
     *     ),
     *     @OA\Property(
     *         property="description",
     *         type="string",
     *         example="Sed tristique velit ante, sit amet convallis ante molestie ut. Fusce risus magna, faucibus elementum arcu id, condimentum mattis quam. Mauris sit amet nisi eros. Pellentesque sit amet dignissim leo"
     *     ),
     *     @OA\Property(
     *         property="status",
     *         @OA\Property(
     *             property="id",
     *             type="string",
     *             example="pending"
     *         ),
     *         @OA\Property(
     *             property="name",
     *             type="string",
     *             example="Pending"
     *         )
     *     ),
     *     @OA\Property(
     *         property="messages",
     *         allOf={
     *             @OA\Schema(ref="#/components/schemas/TicketMessage")
     *         }
     *     ),
     * )
     */

    protected $guarded = ['created_at', 'updated_at'];

    public $incrementing = false;

    protected $keyType = 'string';

    const STATUS_NEW = 'new';
    const STATUS_IN_PROGRESS = 'inprogress';
    const STATUS_IN_REVISION = 'inrevision';
    const STATUS_RESOLVED = 'resolved';
    const STATUS_CLOSED = 'closed';

     /**
     * @return string[]
     */
    public static function statuses() : array
    {
        return [
            static::STATUS_NEW => "New",
            static::STATUS_IN_PROGRESS => "In Progress",
            static::STATUS_IN_REVISION => "Open",
            static::STATUS_RESOLVED => "Resolved",
            static::STATUS_CLOSED => 'Closed'
        ];
    }

    /**
     * @param $query
     * @param string $status
     * @return mixed
     */
    public function scopeOfStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * @return HasMany
     */
    public function messages() : HasMany
    {
        return $this->hasMany(TicketMessage::class, 'ticket_id');
    }

    /**
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
