<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GamePlayerState extends Model
{
    /**
     * @OA\Schema(
     *     schema="GamePlayerState",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="token",
     *         type="string",
     *         example="91ec1a37-ce28-4f73-bb9c-06460f8f801d"
     *     ),
     *     @OA\Property(
     *         property="state",
     *         @OA\Property(
     *             property="ball_radius",
     *             type="double",
     *             example=0.2
     *         ),
     *         @OA\Property(
     *             property="ball_color",
     *             type="string",
     *             example="#00ffff"
     *         ),
     *         @OA\Property(
     *             property="wall_color",
     *             type="string",
     *             example="#ff0000"
     *         ),
     *         @OA\Property(
     *             property="block_width",
     *             type="integer",
     *             example=1
     *         ),
     *         @OA\Property(
     *             property="block_height",
     *             type="integer",
     *             example=1
     *         ),
     *         @OA\Property(
     *             property="board_width",
     *             type="integer",
     *             example=9
     *         ),
     *         @OA\Property(
     *             property="board_height",
     *             type="string",
     *             example=29
     *         ),
     *         @OA\Property(
     *              property="blocks",
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(
     *                      property="id",
     *                      type="integer",
     *                      example=91
     *                  ),
     *                  @OA\Property(
     *                      property="x",
     *                      type="double",
     *                      example=4.5
     *                  ),
     *                  @OA\Property(
     *                      property="y",
     *                      type="double",
     *                      example=26.5
     *                  ),
     *                  @OA\Property(
     *                      property="color_image",
     *                      type="string",
     *                      example="yellow"
     *                  ),
     *                  @OA\Property(
     *                      property="total_hp",
     *                      type="integer",
     *                      example=30
     *                  ),
     *                  @OA\Property(
     *                      property="points_per_hit",
     *                      type="integer",
     *                      example=10
     *                  ),
     *                  @OA\Property(
     *                      property="points_per_destruction",
     *                      type="integer",
     *                      example=25
     *                  ),
     *              ),
     *         ),
     *         @OA\Property(
     *             property="last_generated_id",
     *             type="integer",
     *             example=139
     *         ),
     *         @OA\Property(
     *             property="amount_of_balls_to_fire",
     *             type="integer",
     *             example=5
     *         ),
     *         @OA\Property(
     *             property="total_attempts",
     *             type="integer",
     *             example=3
     *         ),
     *         @OA\Property(
     *             property="times_played",
     *             type="integer",
     *             example=0
     *         ),
     *     ),
     * )
     */

    protected $guarded = ['created_at' , 'updated_at'];

    protected $casts = [
        'state' => 'array'
    ];
}
