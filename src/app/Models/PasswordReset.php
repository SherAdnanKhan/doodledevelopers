<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    /**
     * The attributes that are guarded and others are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'created_at'
    ];

    public function setUpdatedAt($value)
    {
        return NULL;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}
