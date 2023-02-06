<?php

namespace App\Http\Transformers\Wallets;

use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Constants\CurrencyTransformer;
use App\Http\Transformers\Games\GameUserAdminTransformer;
use App\Models\Currency;
use App\Models\Game;
use App\Models\UserGameWallet;

class GameWalletTransformer extends BaseTransformer
{
    protected $defaultIncludes = [
        'game'
    ];

    public function transform(UserGameWallet $wallet)
    {
        return [
            'id' => $wallet->id,
            'credit' => (int) $wallet->credit
        ];
    }

    public function includeGame(UserGameWallet $wallet)
    {
        //ToDo after branch merges
        $game = Game::find($wallet->game_id);
        return $this->item($game, new GameUserAdminTransformer);
    }
}
