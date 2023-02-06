<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GamePlayerScore extends Model
{
    /**
     * @OA\Schema(
     *     schema="GamePlayerScore",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="score",
     *         type="integer",
     *         example=4
     *     ),
     *     @OA\Property(
     *         property="duration",
     *         type="double",
     *         example=2.56325
     *     ),
     *     @OA\Property(
     *          property="invitationLink",
     *          type="string",
     *          example="https://red6six/api/auth/register"
     *     )
     * )
     */

    protected $guarded = ['created_at', 'updated_at'];
}
