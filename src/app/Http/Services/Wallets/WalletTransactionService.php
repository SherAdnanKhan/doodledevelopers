<?php

namespace App\Http\Services\Wallets;

use App\Models\UserWallet;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class WalletTransactionService
{
    /**
     * @param UserWallet $wallet
     * @return LengthAwarePaginator
     */
    public function getAll(UserWallet $wallet) : LengthAwarePaginator
    {
        return $wallet->walletTransactions()->orderByDesc('id')->paginate(10);
    }

}
