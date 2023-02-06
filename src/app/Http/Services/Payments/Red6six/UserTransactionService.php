<?php

namespace App\Http\Services\Payments\Red6six;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class UserTransactionService
{
    /**
     * @return LengthAwarePaginator
     */
    public function getAll() : LengthAwarePaginator
    {
        return auth()->user()->userTransactions()->paginate(10);
    }

    /**
     * @param User $user
     * @param array $data
     * @return Model
     */
    public function createUserTransaction(User $user, array $data) : Model
    {
        return $user->userTransactions()->create($data);
    }
}
