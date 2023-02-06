<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameWinnerEarnings extends Model
{
    /**
     * @OA\Schema(
     *     schema="GameWinnerEarning",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="earning",
     *         type="double",
     *         example=50000
     *     ),
     *     @OA\Property(
     *         property="created_at",
     *         type="string",
     *         format="date-time",
     *         example="2020-10-21T09:33:59.000000Z"
     *     ),
     *     @OA\Property(
     *         property="updated_at",
     *         type="string",
     *         format="date-time",
     *         example="22020-10-21T09:33:59.000000Z"
     *     ),
     *     @OA\Property(
     *         property="status",
     *         @OA\Property(
     *             property="id",
     *             type="string",
     *             example="approved"
     *         ),
     *         @OA\Property(
     *             property="name",
     *             type="string",
     *             example="Approved"
     *         )
     *     ),
     *     @OA\Property(
     *         property="game",
     *         allOf={
     *          @OA\Schema(ref="#/components/schemas/GameAdmin"),
     *        }
     *     ),
     * )
     */
    protected $guarded = ['created_at' , 'updated_at'];

    const STATUS_NEW = "new";
    const STATUS_PENDING = "pending";
    const STATUS_APPROVED = "approved";
    const STATUS_REJECTED = "rejected";

    /**
     * @return string[]
     */
    public static function statuses() : array
    {
        return [
            static::STATUS_NEW => "New",
            static::STATUS_PENDING => "Pending",
            static::STATUS_APPROVED => "Approved",
            static::STATUS_REJECTED => "Rejected"
        ];
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

}
