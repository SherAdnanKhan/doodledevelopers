<?php
namespace App\Http\Transformers\Games;

use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Constants\ConstantTransformer;
use App\Http\Transformers\Users\UserTransformer;
use App\Http\Transformers\Games\GamePlayerUserTransformer;
use App\Models\GameWinnerEarnings;
use App\Models\GamePlayer;

class GameWinnerEarningTransformer extends BaseTransformer
{
    protected $defaultIncludes = [
        'status', 'game'
    ];

    protected $availableIncludes = [
        'user', 'game_player'
    ];

    public function transform($gameWinnerEarning)
    {
        return [
            'id' => $gameWinnerEarning->id,
            'earning' => $gameWinnerEarning->earning,
            'created_at' => $gameWinnerEarning->created_at,
            'updated_at' => $gameWinnerEarning->updated_at,
            'status'  => $gameWinnerEarning->status,
        ];
    }

    public function includeStatus(GameWinnerEarnings $gameWinnerEarnings)
    {
        $item = [
            'id' => $gameWinnerEarnings->status,
            'name' => data_get($gameWinnerEarnings::statuses(), $gameWinnerEarnings->status)
        ];

        return $this->item($item, new ConstantTransformer);
    }

    public function includeGame(GameWinnerEarnings $gameWinnerEarnings)
    {
        return $this->item($gameWinnerEarnings->game, new GameUserAdminTransformer);
    }

    public function includeUser(GameWinnerEarnings $gameWinnerEarnings)
    {
        return $this->item($gameWinnerEarnings->user, new UserTransformer);
    }

    public function includeGamePlayer(GameWinnerEarnings $gameWinnerEarnings)
    {
        return $this->item(GamePlayer::where(['user_id' => $gameWinnerEarnings->user_id, 'game_id' => $gameWinnerEarnings->game_id])->first(), new GamePlayerUserTransformer);
    }

}
