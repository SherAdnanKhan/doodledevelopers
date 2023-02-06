<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class UserGameWallet extends Model
{
    /**
     * @OA\Schema(
     *     schema="UserGameWallet",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="credit",
     *         type="integer",
     *         example=500
     *     ),
     *     @OA\Property(
     *         property="game",
     *         allOf={
     *          @OA\Schema(ref="#/components/schemas/Game")
     *        }
     *     ),
     * )
     */

    protected $guarded = ['created_at', 'updated_at'];

    /**
     * @return MorphMany
     */
    public function gameTransactions() : MorphMany
    {
        return $this->morphMany(GameTransaction::class, 'wallet');
    }

    /**
     * @return MorphMany
     */
    public function walletTransactions() : MorphMany
    {
        return $this->morphMany(WalletTransaction::class, 'wallet');
    }

    /**
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
