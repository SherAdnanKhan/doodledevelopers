<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    /**
     * @OA\Schema(
     *     schema="PaymentMethod",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         example="DebitCard"
     *     ),
     *     @OA\Property(
     *         property="label",
     *         type="string",
     *         example="debitcard"
     *     )
     * )
     */

    protected $guarded = ['created_at' , 'updated_at'];

}
