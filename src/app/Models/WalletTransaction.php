<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    /**
     * @OA\Schema(
     *     schema="WalletTransaction",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="amount",
     *         type="double",
     *         example=3000
     *     ),
     *     @OA\Property(
     *         property="wallet_balance_before_tansaction",
     *         type="double",
     *         example=5000
     *     ),
     *     @OA\Property(
     *         property="wallet_balance_after_tansaction",
     *         type="double",
     *         example=8000
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
     *         example="2020-10-21T09:33:59.000000Z"
     *     ),
     *     @OA\Property(
     *         property="wallet",
     *         allOf={
     *          @OA\Schema(ref="#/components/schemas/UserWallet")
     *        }
     *     ),
     *     @OA\Property(
     *         property="type",
     *         @OA\Property(
     *             property="id",
     *             type="string",
     *             example="Debit"
     *         ),
     *         @OA\Property(
     *             property="name",
     *             type="string",
     *             example="debit"
     *         )
     *     ),
     *      @OA\Property(
     *         property="transaction",
     *         allOf={
     *          @OA\Schema(ref="#/components/schemas/GameTransaction"),
     *        }
     *     ),
     * )
     */

    protected $guarded = ['created_at' , 'updated_at'];

    const TYPE_DEBIT = 'debit';
    const TYPE_CREDIT = 'credit';

    const TYPE_TRANSACTION_USER = 'App\Models\UserTransaction';
    const TYPE_TRANSACTION_GAME = 'App\Models\GameTransaction';

    const TYPE_WALLET_USER = 'App\Models\UserWallet';
    const TYPE_WALLET_GAME = 'App\Models\UserGameWallet';


    public function wallet()
    {
        return $this->morphTo();
    }

    public function transaction()
    {
        return $this->morphTo();
    }

    public static function types()
    {
        return [
            static::TYPE_DEBIT => "Debit",
            static::TYPE_CREDIT => "Credit"
        ];
    }

}
