<?php

namespace App\Http\Transformers\Wallets;

use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Constants\ConstantTransformer;
use App\Http\Transformers\Games\GameUserAdminTransformer;
use App\Http\Transformers\Users\UserTransformer;
use App\Models\GameTransaction;

class GameTransactionTransformer extends BaseTransformer
{
    protected $defaultIncludes = [
        'type', 'status'
    ];

    protected $availableIncludes = [
        'wallet', 'game', 'user'
    ];

    public function transform(GameTransaction $gameTransaction)
    {
        return [
            'id' => $gameTransaction->id,
            'amount' => $gameTransaction->amount,
            'created_at' => $gameTransaction->created_at,
            'updated_at' => $gameTransaction->updated_at,
        ];
    }

    public function includeType(GameTransaction $gameTransaction)
    {
        $item = [
            'id' => $gameTransaction->type,
            'name' => data_get(GameTransaction::types(), $gameTransaction->type)
        ];

        return $this->item($item, new ConstantTransformer);
    }

    public function includeStatus(GameTransaction $gameTransaction)
    {
        $item = [
            'id' => $gameTransaction->status,
            'name' => data_get(GameTransaction::statuses(), $gameTransaction->status)
        ];

        return $this->item($item, new ConstantTransformer);
    }

    public function includeWallet(GameTransaction $gameTransaction)
    {
        return $this->item($gameTransaction->wallet, new WalletTransformer);
    }

    public function includeGame(GameTransaction $gameTransaction)
    {
        return $this->item($gameTransaction->game, new GameUserAdminTransformer);
    }

    public function includeUser(GameTransaction $gameTransaction)
    {
        return $this->item($gameTransaction->user, new UserTransformer);
    }
}
