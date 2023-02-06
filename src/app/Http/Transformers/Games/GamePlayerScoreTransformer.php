<?php
namespace App\Http\Transformers\Games;

use App\Http\Transformers\BaseTransformer;

class GamePlayerScoreTransformer extends BaseTransformer
{
    public function transform($playerGame)
    {
        return [
            'id' => $playerGame->pivot->id,
            'score' => $playerGame->pivot->score,
            'duration' => $playerGame->pivot->duration
        ];
    }
}
