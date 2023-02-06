<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * @OA\Schema(
     *     schema="Country",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         example="brazil"
     *     ),
     *     @OA\Property(
     *         property="label",
     *         type="string",
     *         example="Brazil"
     *     )
     * )
     */

    protected $guarded = ['created_at' , 'updated_at'];
}
