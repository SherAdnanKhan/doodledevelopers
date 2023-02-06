<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class KycValidation extends Model
{
    /**
     * @OA\Schema(
     *     schema="KycValidation",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=12345
     *     ),
     *     @OA\Property(
     *         property="review_notes",
     *         type="string",
     *         example="Document is blur."
     *     ),
     *     @OA\Property(
     *         property="reviewed_at",
     *         type="string",
     *         example="2020-01-01T00:00:00.000000Z"
     *     ),
     *     @OA\Property(
     *         property="user",
     *         allOf={
     *             @OA\Schema(ref="#/components/schemas/User")
     *         }
     *     ),
     *     @OA\Property(
     *         property="status",
     *         @OA\Property(
     *             property="id",
     *             type="string",
     *             example="new"
     *         ),
     *         @OA\Property(
     *             property="name",
     *             type="string",
     *             example="New"
     *         )
     *     ),
     *     @OA\Property(
     *         property="reviewer",
     *         allOf={
     *             @OA\Schema(ref="#/components/schemas/User")
     *         }
     *     ),
     *     @OA\Property(
     *         property="document",
     *         allOf={
     *             @OA\Schema(ref="#/components/schemas/KycValidationDocument")
     *         }
     *     ),
     * )
     */

    protected $guarded = ['created_at', 'updated_at'];

    const STATUS_NEW = "new";
    const STATUS_RESUBMIT = "resubmit";
    const STATUS_APPROVED = "approved";
    const STATUS_REJECTED = "rejected";

    /**
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function reviewer() : BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function document() : HasOne
    {
        return $this->hasOne(KycValidationDocument::class, 'kyc_validation_id');
    }

    /**
     * @return string[]
     */
    public static function statuses()
    {
        return [
            static::STATUS_NEW => "New",
            static::STATUS_RESUBMIT => "Resubmit",
            static::STATUS_APPROVED => "Approved",
            static::STATUS_REJECTED => "Rejected"
        ];
    }

    /**
     * @return bool
     */
    public function isApproved() : bool
    {
        return $this->status == KycValidation::STATUS_APPROVED;
    }
}
