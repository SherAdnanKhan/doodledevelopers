<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class UserWallet extends Model
{
    /**
     * @OA\Schema(
     *     schema="UserWallet",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="balance",
     *         type="integer",
     *         example=45895
     *     ),
     *     @OA\Property(
     *         property="currency",
     *         allOf={
     *          @OA\Schema(ref="#/components/schemas/Currency")
     *        }
     *     ),
     * )
     */

    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return MorphMany
     */
    public function walletTransactions() : MorphMany
    {
        return $this->morphMany(WalletTransaction::class, 'wallet');
    }

    /**

     * @return MorphMany
     */
    public function gameTransactions() : MorphMany
    {
        return $this->morphMany(GameTransaction::class, 'wallet');
    }
}
