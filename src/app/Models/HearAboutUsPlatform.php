<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class HearAboutUsPlatform extends Model
{
    /**
     * @OA\Schema(
     *     schema="HearAboutUsPlatform",
     *       @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *       ),
     *      @OA\Property(
     *          property="name",
     *          type="string",
     *          example="Facebook"
     *      ),
     *     @OA\Property(
     *          property="label",
     *          type="string",
     *          example="facebook"
     *      ),
     * )
     */

    /**
     * @OA\Schema(
     *     schema="HearAboutUsPlatformCount",
     *      @OA\Property(
     *          property="name",
     *          type="string",
     *          example="Facebook"
     *      ),
     *     @OA\Property(
     *          property="label",
     *          type="string",
     *          example="facebook"
     *      ),
     *     @OA\Property(
     *         property="count",
     *         type="integer",
     *         example=2
     *       ),
     * )
     */

    protected $guarded = ['created_at' , 'updated_at'];

    /**
     * @return HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'hear_about_us_platform_id');
    }
}
