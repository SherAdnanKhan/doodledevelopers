<?php

namespace App\Http\Services\Games;

use App\Http\Services\BaseService;
use App\Models\GameTransaction;
use Illuminate\Pagination\LengthAwarePaginator;

class GameEarningAdminService extends BaseService
{
    /**
     * @return LengthAwarePaginator
     */
    public function getAll() : LengthAwarePaginator
    {
        return GameTransaction::where('type', GameTransaction::TYPE_EARN)->paginate(15);
    }

    public function getEarning()
    {
        return auth()->user()->gameTransactions()->where('type', GameTransaction::TYPE_EARN)->get();
    }
}
