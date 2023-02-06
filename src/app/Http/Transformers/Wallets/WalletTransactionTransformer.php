<?php

namespace App\Http\Transformers\Wallets;

use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Constants\ConstantTransformer;
use App\Http\Transformers\Payments\Red6six\UserTransactionTransformer;
use App\Models\WalletTransaction;

class WalletTransactionTransformer extends BaseTransformer
{
    protected $defaultIncludes = [
        'wallet', 'type'
    ];

    protected $availableIncludes = [
        'transaction'
    ];

    public function transform(WalletTransaction $walletTransaction)
    {
        return [
            'id' => $walletTransaction->id,
            'amount' => $walletTransaction->amount,
            'wallet_balance_before_tansaction' => (int) $walletTransaction->wallet_balance_before_tansaction,
            'wallet_balance_after_tansaction' => (int) $walletTransaction->wallet_balance_after_tansaction,
            'transaction_type' => $walletTransaction->transaction_type,
            'transaction_id' => $walletTransaction->transaction_id,
            'created_at' => $walletTransaction->created_at,
            'updated_at' => $walletTransaction->updated_at,
        ];
    }

    public function includeWallet(WalletTransaction $walletTransaction)
    {
        return $this->item($walletTransaction->wallet, new WalletTransformer);
    }

    public function includeType(WalletTransaction $walletTransaction)
    {
        $item = [
            'id' => $walletTransaction->type,
            'name' => data_get(WalletTransaction::types(), $walletTransaction->type)
        ];

        return $this->item($item, new ConstantTransformer);
    }

    public function includeTransaction(WalletTransaction $walletTransaction)
    {
        if ($walletTransaction->transaction_type === WalletTransaction::TYPE_TRANSACTION_USER) {
            return $this->item($walletTransaction->transaction, new UserTransactionTransformer);
        }

        if ($walletTransaction->transaction) {
            return $this->item($walletTransaction->transaction, new GameTransactionTransformer);
        }
    }
}
