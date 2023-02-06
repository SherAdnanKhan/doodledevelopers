<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    /**
     * @OA\Schema(
     *     schema="GameAdmin",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         example="Bowling"
     *     ),
     *     @OA\Property(
     *         property="jackpot_value",
     *         type="double",
     *         example=50000
     *     ),
     *     @OA\Property(
     *         property="admin_fee_percentage",
     *         type="double",
     *         example=30
     *     ),
     *     @OA\Property(
     *         property="pot_value",
     *         type="double",
     *         example=20000
     *     ),
     *     @OA\Property(
     *         property="entry_fee",
     *         type="double",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="number_of_winners",
     *         type="integer",
     *         example=30
     *     ),
     *     @OA\Property(
     *         property="game_ext_days",
     *         type="integer",
     *         example=3
     *     ),
     *     @OA\Property(
     *         property="is_extended",
     *         type="boolean",
     *         example=0
     *     ),
     *     @OA\Property(
     *         property="start_date",
     *         type="string",
     *         example="2020-01-01T00:00:00.000000Z"
     *     ),
     *     @OA\Property(
     *         property="end_date",
     *         type="string",
     *         example="2020-01-01T00:00:00.000000Z"
     *     ),
     *     @OA\Property(
     *         property="days_remaining",
     *         type="integer",
     *         example=8
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
     *         property="status",
     *         @OA\Property(
     *             property="id",
     *             type="string",
     *             example="notstarted"
     *         ),
     *         @OA\Property(
     *             property="name",
     *             type="string",
     *             example="Not Started"
     *         )
     *     ),
     *     @OA\Property(
     *         property="players",
     *         allOf={
     *          @OA\Schema(ref="#/components/schemas/GamePlayerAdmin")
     *        }
     *     ),
     *     @OA\Property(
     *         property="map",
     *         allOf={
     *          @OA\Schema(ref="#/components/schemas/MapAdmin")
     *        }
     *     )
     * )
     */

    /**
     * @OA\Schema(
     *     schema="Game",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         example="Bowling"
     *     ),
     *     @OA\Property(
     *         property="entry_fee",
     *         type="double",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="jackpot_value",
     *         type="double",
     *         example=50000
     *     ),
     *     @OA\Property(
     *         property="is_extended",
     *         type="boolean",
     *         example=0
     *     ),
     *     @OA\Property(
     *         property="start_date",
     *         type="string",
     *         example="2020-01-01T00:00:00.000000Z"
     *     ),
     *     @OA\Property(
     *         property="end_date",
     *         type="string",
     *         example="2020-01-01T00:00:00.000000Z"
     *     ),
     *     @OA\Property(
     *         property="days_remaining",
     *         type="integer",
     *         example=8
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
     *         property="status",
     *         @OA\Property(
     *             property="id",
     *             type="string",
     *             example="notstarted"
     *         ),
     *         @OA\Property(
     *             property="name",
     *             type="string",
     *             example="Not Started"
     *         )
     *     ),
     *     @OA\Property(
     *         property="players",
     *         allOf={
     *          @OA\Schema(ref="#/components/schemas/GamePlayerAdmin")
     *        }
     *     ),
     *     @OA\Property(
     *         property="map",
     *         allOf={
     *          @OA\Schema(ref="#/components/schemas/MapAdmin")
     *        }
     *     )
     * )
     * )
     */

    /**
     * @OA\Schema(
     *     schema="GameHistory",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         example="Bowling"
     *     ),
     *     @OA\Property(
     *         property="entry_fee",
     *         type="double",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="jackpot_value",
     *         type="double",
     *         example=50000
     *     ),
     *     @OA\Property(
     *         property="is_extended",
     *         type="boolean",
     *         example=0
     *     ),
     *     @OA\Property(
     *         property="start_date",
     *         type="string",
     *         example="2020-01-01T00:00:00.000000Z"
     *     ),
     *     @OA\Property(
     *         property="end_date",
     *         type="string",
     *         example="2020-01-01T00:00:00.000000Z"
     *     ),
     *     @OA\Property(
     *         property="total_attempts",
     *         type="integer",
     *         example=3
     *     ),
     *     @OA\Property(
     *         property="position_finished",
     *         type="integer",
     *         example=8
     *     ),
     *     @OA\Property(
     *         property="prize_won",
     *         type="double",
     *         example=1071
     *     ),
     *     @OA\Property(
     *         property="status",
     *         @OA\Property(
     *             property="id",
     *             type="string",
     *             example="finished"
     *         ),
     *         @OA\Property(
     *             property="name",
     *             type="string",
     *             example="Finished"
     *         )
     *     ),
     * )
     * )
     */

    /**
     * @OA\Schema(
     *     schema="GamePublic",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         example="Bowling"
     *     ),
     *     @OA\Property(
     *         property="entry_fee",
     *         type="double",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="jackpot_value",
     *         type="double",
     *         example=50000
     *     ),
     *     @OA\Property(
     *         property="start_date",
     *         type="string",
     *         example="2020-01-01T00:00:00.000000Z"
     *     ),
     *     @OA\Property(
     *         property="end_date",
     *         type="string",
     *         example="2020-01-01T00:00:00.000000Z"
     *     ),
     *     @OA\Property(
     *         property="days_remaining",
     *         type="integer",
     *         example=8
     *     ),
     * )
     */

    protected $guarded = ['created_at' , 'updated_at'];

    protected $dates = ['start_date', 'end_date'];

    const STATUS_NOT_STARTED = "notstarted";
    const STATUS_LIVE = "live";
    const STATUS_FINISHED = "finished";
    const STATUS_ENDED_BY_ADMIN = "endedbyadmin";

    /**
     * @return HasMany
     */
    public function extensions() : HasMany
    {
        return $this->hasMany(GameExtension::class, 'game_id');
    }

    /**
     * @return BelongsToMany
     */
    public function players() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'game_players', 'game_id', 'user_id')
            ->withPivot('id', 'number_of_times_played', 'highest_score', 'shortest_duration', 'status', 'token')
            ->withTimestamps();
    }

    /**
     * @return HasMany
     */
    public function earnings() : HasMany
    {
        return $this->hasMany(GameWinnerEarnings::class, 'game_id');
    }

    /**
     * @return HasMany
     */
    public function maps() : HasMany
    {
        return $this->hasMany(GameMap::class, 'game_id');
    }

    /**
     * @return BelongsToMany
     */
    public function payouts() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'game_transactions', 'game_id', 'user_id')
            ->withPivot('id', 'wallet_id', 'amount', 'type', 'status')
            ->withTimestamps();
    }

    /**
     * @return mixed
     */
    public function getIsDeadlineReachedAttribute()
    {
        return $this->end_date->lte(today());
    }

    /**
     * @return int
     */
    public function getExtensionsCountAttribute() : int
    {
        return $this->extensions()->count();
    }

    /**
     * @return int
     */
    public function getNumberOfPlayersAttribute() : int
    {
        return $this->players()->count();
    }

    /**
     * @return bool
     */
    public function isLive() : bool
    {
        return $this->status == static::STATUS_LIVE;
    }

    /**
     * @return bool
     */
    public function isPaid() : bool
    {
        return ($this->entry_fee === 0) ? false : true;
    }

    /**
     * @param $userId
     * @return bool
     */
    public function checkIfPlayerExists($userId) : bool
    {
        return $this->players()->where('user_id', $userId)->count() > 0;
    }

    /**
     * @return string[]
     */
    public static function statuses() : array
    {
        return [
            static::STATUS_NOT_STARTED => "Not Started",
            static::STATUS_LIVE => "Live",
            static::STATUS_FINISHED => "Finished",
            static::STATUS_ENDED_BY_ADMIN => "Ended By Admin"
        ];
    }

    /**
     * @return HasMany
     */
    public function gameTransactions() : HasMany
    {
        return $this->hasMany(GameTransaction::class, 'game_id');
    }

    /**
     * @return mixed
     */
    public function getDaysRemainingAttribute()
    {
        $endDate = $this->end_date;

        return $endDate->diffInDays(Carbon::today());
    }
}
