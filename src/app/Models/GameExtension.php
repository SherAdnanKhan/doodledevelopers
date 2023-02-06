<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameExtension extends Model
{
    protected $guarded = ['created_at' , 'updated_at'];

    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id', 'id');
    }
}
