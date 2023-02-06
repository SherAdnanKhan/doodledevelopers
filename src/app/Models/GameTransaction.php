<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class GameTransaction extends Model
{
    /**
     * @OA\Schema(
     *     schema="GameTransaction",
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
     *         property="type",
     *         @OA\Property(
     *             property="id",
     *             type="string",
     *             example="walletpay"
     *         ),
     *         @OA\Property(
     *             property="name",
     *             type="string",
     *             example="Fee Pay Via Wallet"
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
     *     @OA\Property(
     *         property="wallet",
     *         allOf={
     *          @OA\Schema(ref="#/components/schemas/UserWallet"),
     *        }
     *     ),
     *     @OA\Property(
     *         property="game",
     *         allOf={
     *          @OA\Schema(ref="#/components/schemas/Game"),
     *        }
     *     ),
     * )
     */

    protected $guarded = ['created_at', 'updated_at'];

    const STATUS_PENDING = "pending";
    const STATUS_APPROVED = "approved";
    const STATUS_REJECTED = "rejected";

    const TYPE_PAY_VIA_WALLET = "walletpay";
    const TYPE_PAY_VIA_FEE_CREDIT = "creditpay";
    const TYPE_REFUND = "refund";
    const TYPE_EARN = "earn";
    const TYPE_PAYOUT = "payout";

    const TYPE_WALLET_USER = 'App\Models\UserWallet';
    const TYPE_WALLET_GAME = 'App\Models\UserGameWallet';

    /**
     * @return MorphMany
     */
    public function walletTransactions() : MorphMany
    {
        return $this->morphMany(WalletTransaction::class, 'transaction');
    }

    /**
     * @return BelongsTo
     */
    public function wallet() : BelongsTo
    {
        return $this->morphTo();
    }

    /**
     * @return BelongsTo
     */
    public function game() : BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return string[]
     */
    public static function statuses() : array
    {
        return [
            static::STATUS_APPROVED => "Approved",
            static::STATUS_REJECTED => "Rejected",
            static::STATUS_PENDING => "Pending"
        ];
    }

    /**
     * @return string[]
     */
    public static function types() : array
    {
        return [
            static::TYPE_PAY_VIA_WALLET => "Fee Pay Via Wallet",
            static::TYPE_PAY_VIA_FEE_CREDIT => "Fee Pay Via Credit",
            static::TYPE_REFUND => "Refund",
            static::TYPE_EARN => "Earn",
            static::TYPE_PAYOUT => "Payout"
        ];
    }
}
