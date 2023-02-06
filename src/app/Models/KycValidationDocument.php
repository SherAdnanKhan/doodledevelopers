<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KycValidationDocument extends Model
{
    /**
     * @OA\Schema(
     *     schema="KycValidationDocument",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="filename",
     *         type="string",
     *         example="abc.png"
     *     ),
     *     @OA\Property(
     *         property="link",
     *         type="string",
     *         example="http://domain.com/storage/5f75db467852f.pdf"
     *     ),
     *     @OA\Property(
     *         property="type",
     *         @OA\Property(
     *             property="id",
     *             type="string",
     *             example="id"
     *         ),
     *         @OA\Property(
     *             property="name",
     *             type="string",
     *             example="Id"
     *         )
     *     )
     * )
     */

    protected $guarded = ['created_at', 'updated_at'];

    const TYPE_DRIVING_LICENSE = "drivinglicense";
    const TYPE_PASSPORT = "passport";
    const TYPE_UTILITY_BILL = "utilitybill";

    public static function types()
    {
        return [
            static::TYPE_DRIVING_LICENSE => "Driving License",
            static::TYPE_PASSPORT => "Passport",
            static::TYPE_UTILITY_BILL => "Utility Bill",
        ];
    }

    public function validation()
    {
        return $this->belongsTo(KycValidation::class, 'kyc_validation_id', 'id');
    }

}
