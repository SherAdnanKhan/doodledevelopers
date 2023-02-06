<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Deposit extends Model
{
    /**
     * @OA\Schema(
     *     schema="Deposit",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="payment_transaction_id",
     *         type="string",
     *         example="4439B6611064A5DAE0AF8953C1D6A09F.uat01-vm-tx01"
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
     *         property="additional_charges",
     *         type="double",
     *         example=0
     *     ),
     *     @OA\Property(
     *         property="additional_charges_converted_amount",
     *         type="double",
     *         example=0
     *     ),
     *     @OA\Property(
     *         property="completed_at",
     *         type="string",
     *         format="date-time",
     *         example="2020-10-21T09:33:59.619340Z"
     *     ),
     *     @OA\Property(
     *         property="created_at",
     *         type="string",
     *         format="date-time",
     *         example="2020-01-01T00:00:00.000000Z"
     *     ),
     *     @OA\Property(
     *         property="updated_at",
     *         type="string",
     *         format="date-time",
     *         example="2020-01-01T00:00:00.000000Z"
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

    protected $dates = [
        'completed_at',
    ];

    const STATUS_APPROVED = "approved";
    const STATUS_PENDING = "pending";
    const STATUS_REJECTED = "rejected";

    /**
     * @param $query
     * @param $status
     * @return mixed
     */
    public function scopeOfStatus($query, string $status)
    {
        return $query->where('deposit_status', $status);
    }

    /**
     * @param $query
     * @param $paymentMethodId
     * @return mixed
     */
    public function scopeOfPaymentMethod($query, int $paymentMethodId)
    {
        return $query->where('payment_method_id', $paymentMethodId);
    }

    /**
     * @return MorphMany
     */
    public function userTransactions() : MorphMany
    {
        return $this->morphMany(UserTransaction::class, 'transactional');
    }

    /**
     * @return string[]
     */
    public static function statuses()
    {
        return [
            static::STATUS_APPROVED => "Approved",
            static::STATUS_PENDING => "Pending",
            static::STATUS_REJECTED => "Rejected",
        ];
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
