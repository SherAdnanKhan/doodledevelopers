<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class UserTransaction extends Model
{
    /**
     * @OA\Schema(
     *     schema="UserTransaction",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="amount",
     *         type="double",
     *         example=50000
     *     ),
     *     @OA\Property(
     *         property="converted_amount",
     *         type="double",
     *         example=50000
     *     ),
     *     @OA\Property(
     *         property="fee_deducted_amount",
     *         type="double",
     *         example=0
     *     ),
     *     @OA\Property(
     *         property="fee_deducted_converted_amount",
     *         type="double",
     *         example=0
     *     ),
     *     @OA\Property(
     *         property="transactional_type",
     *         type="string",
     *         example="App\Models\Deposit"
     *     ),
     *     @OA\Property(
     *         property="transactional_id",
     *         type="double",
     *         example=6
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
     *         property="paymentMethod",
     *         @OA\Property(
     *             property="id",
     *             type="integer",
     *             example="1"
     *         ),
     *         @OA\Property(
     *             property="name",
     *             type="string",
     *             example="DebitCard"
     *         )
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
     * )
     */

    protected $guarded = ['created_at' , 'updated_at'];

    const STATUS_APPROVED = "approved";
    const STATUS_PENDING = "pending";
    const STATUS_REJECTED = "rejected";

    const TYPE_TRANSACTION_DEPOSIT = 'App\Models\Deposit';
    const TYPE_TRANSACTION_WITHDRAWAL = 'App\Models\Withdrawal';

    /**
     * @return MorphTo
     */
    public function transactional() : MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return MorphMany
     */
    public function walletTransactions() : MorphMany
    {
        return $this->morphMany(WalletTransaction::class, 'transaction');
    }

    /**
     * @return string[]
     */
    public static function statuses()
    {
        return [
            static::STATUS_APPROVED => "Approved",
            static::STATUS_PENDING  => "Pending",
            static::STATUS_REJECTED => "Rejected"
        ];
    }
}
