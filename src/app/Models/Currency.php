<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    /**
     * @OA\Schema(
     *     schema="Currency",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         example="GBP"
     *     ),
     *     @OA\Property(
     *         property="label",
     *         type="string",
     *         example="gbp"
     *     ),
     * )
     */
    protected $guarded = ['created_at' , 'updated_at'];

    //Todo Remove USD and EUR types and remove getConvertedAmount accordingly

    const TYPE_GBP = "GBP";
    const TYPE_USD = "USD";
    const TYPE_EUR = "EUR";

    public static function types()
    {
        return [
            static::TYPE_GBP => "GBP",
            static::TYPE_USD => "USD",
            static::TYPE_EUR => "EUR"
        ];
    }
}
