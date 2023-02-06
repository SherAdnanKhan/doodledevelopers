<?php
namespace App\Http\Transformers\Games;

use App\Http\Services\Games\GameServerService;
use App\Http\Transformers\BaseTransformer;
use App\Models\Game;

class GamePlayerAttemptScoreTransformer extends BaseTransformer
{
    /**
     * @var GameServerService
     */
    private $service;

    public function __construct()
    {
        $this->service = app(GameServerService::class);
    }

    protected $defaultIncludes = [
        'game'
    ];

    public function transform(Game $game)
    {
        return [
            'id' => $game->pivot->id,
            'score' => $game->pivot->score,
            'duration' => $game->pivot->duration,
            'next_attempt_number' => ($game->pivot->attempt_number < $game->total_attempts) ? $game->pivot->attempt_number + 1 : null,
            'invitationLink' => $this->service->invitationLink($game)
        ];
    }

    public function includeGame(Game $game)
    {
        return $this->item($game, new GameUserAdminTransformer);
    }
}
