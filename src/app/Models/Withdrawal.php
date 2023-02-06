<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Withdrawal extends Model
{
    protected $guarded = ['created_at' , 'updated_at'];

    const STATUS_APPROVED = "approved";
    const STATUS_REJECTED = "rejected";

    /**
     * @return MorphMany
     */
    public function userTransactions() : MorphMany
    {
        return $this->morphMany(UserTransaction::class, 'transactional');
    }

    /**
     * @return MorphTo
     */
    public function transaction() : MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return string[]
     */
    public static function statuses()
    {
        return [
            static::STATUS_APPROVED => "Approved",
            static::STATUS_REJECTED => "Rejected"
        ];
    }
}
