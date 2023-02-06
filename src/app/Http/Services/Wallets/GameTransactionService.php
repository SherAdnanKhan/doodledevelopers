<?php

namespace App\Http\Services\Wallets;

use App\Models\UserWallet;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GameTransactionService
{
    /**
     * @param UserWallet $wallet
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function getAll(UserWallet $wallet, array $data) : LengthAwarePaginator
    {
        $gameTransaction = auth()->user()
            ->gameTransactions()
            ->where('wallet_id', $wallet->id);

        if ($data) {
            $gameTransaction->where('status', $data['status']);
        }

        return $gameTransaction->paginate(10);

    }

}
