<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GamePlayer extends Model
{
    /**
     * @OA\Schema(
     *     schema="GamePlayer",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="number_of_times_played",
     *         type="integer",
     *         example=4
     *     ),
     *     @OA\Property(
     *         property="highest_score",
     *         type="integer",
     *         example=20
     *     ),
     *     @OA\Property(
     *         property="shortest_duration",
     *         type="double",
     *         example=5.666
     *     ),
     *     @OA\Property(
     *         property="status",
     *         @OA\Property(
     *             property="id",
     *             type="string",
     *             example="notplaying"
     *         ),
     *         @OA\Property(
     *             property="name",
     *             type="string",
     *             example="Not Playing"
     *         )
     *     ),
     *     @OA\Property(
     *         property="user",
     *         allOf={
     *             @OA\Schema(ref="#/components/schemas/User")
     *         }
     *     )
     * )
     */

    /**
     * @OA\Schema(
     *     schema="GamePlayerAdmin",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="number_of_times_played",
     *         type="integer",
     *         example=4
     *     ),
     *     @OA\Property(
     *         property="highest_score",
     *         type="integer",
     *         example=20
     *     ),
     *     @OA\Property(
     *         property="shortest_duration",
     *         type="double",
     *         example=5.666
     *     ),
     *     @OA\Property(
     *         property="status",
     *         @OA\Property(
     *             property="id",
     *             type="string",
     *             example="notplaying"
     *         ),
     *         @OA\Property(
     *             property="name",
     *             type="string",
     *             example="Not Playing"
     *         )
     *     ),
     *     @OA\Property(
     *         property="user",
     *         allOf={
     *             @OA\Schema(ref="#/components/schemas/User")
     *         }
     *     ),
     *     @OA\Property(
     *         property="earning",
     *         allOf={
     *             @OA\Schema(ref="#/components/schemas/GameWinnerEarning")
     *         }
     *     )
     * )
     */

    protected $guarded = ['created_at', 'updated_at'];
    protected $dates = ['token_generated_at'];

    const STATUS_PLAYING = "playing";
    const STATUS_NOT_PLAYING = "notplaying";

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
            static::STATUS_PLAYING => "Playing",
            static::STATUS_NOT_PLAYING => "Not Playing"
        ];
    }

    /**
     * @return BelongsTo
     */
    public function game() : BelongsTo
    {
        return $this->belongsTo(Game::class, 'game_id', 'id');
    }
}
