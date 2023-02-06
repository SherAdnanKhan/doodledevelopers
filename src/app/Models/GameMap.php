<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameMap extends Model
{
    protected $guarded = ['created_at' , 'updated_at'];

    /**
     * @return BelongsTo
     */
    public function map() : BelongsTo
    {
        return $this->belongsTo(Map::class, 'map_id', 'id');
    }
}
