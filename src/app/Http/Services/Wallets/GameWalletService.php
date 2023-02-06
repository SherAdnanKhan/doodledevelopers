<?php

namespace App\Http\Services\Wallets;

use App\Http\Services\BaseService;
use Illuminate\Pagination\LengthAwarePaginator;

class GameWalletService extends BaseService
{
    /**
     * @return LengthAwarePaginator
     */
    public function getAll() : LengthAwarePaginator
    {
        return auth()->user()->gameWallets()->paginate(10);
    }

}
