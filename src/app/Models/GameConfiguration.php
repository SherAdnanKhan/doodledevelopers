<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameConfiguration extends Model
{
    /**
     * @OA\Schema(
     *     schema="GameConfiguration",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="currency_conversion_duration",
     *         type="integer",
     *         example=30
     *     ),
     *     @OA\Property(
     *         property="min_deposit_amount",
     *         type="integer",
     *         example=5000
     *     ),
     *     @OA\Property(
     *         property="max_deposit_amount",
     *         type="integer",
     *         example=5000000
     *     ),
     *     @OA\Property(
     *         property="min_withdrawal_amount",
     *         type="integer",
     *         example=5000
     *     ),
     *     @OA\Property(
     *         property="max_withdrawal_amount",
     *         type="integer",
     *         example=5000000
     *     ),
     *     @OA\Property(
     *         property="amount_of_balls_to_fire",
     *         type="integer",
     *         example=5
     *     ),
     *     @OA\Property(
     *         property="total_attempts",
     *         type="integer",
     *         example=3
     *     ),
     *     @OA\Property(
     *         property="maintenance_mode",
     *         type="integer",
     *         example=0
     *     ),
     *     @OA\Property(
     *         property="created_at",
     *         type="string",
     *         format="date-time",
     *         example="2020-11-21T09:33:59.000000Z"
     *     ),
     *     @OA\Property(
     *         property="updated_at",
     *         type="string",
     *         format="date-time",
     *         example="22020-11-21T09:33:59.000000Z"
     *     ),
     * )
     */

    protected $guarded = ['created_at', 'updated_at'];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
