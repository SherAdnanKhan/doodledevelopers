<?php

namespace App\Http\Services\Payments\Red6six;

use App\Models\Deposit;
use Illuminate\Pagination\LengthAwarePaginator;

class DepositAdminService
{
    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function getAll(array $data) : LengthAwarePaginator
    {
        $deposit = new Deposit();

        if (isset($data['status'])) {
            $deposit = $deposit->ofStatus($data['status']);
        }

        if (isset($data['payment_method'])) {
            $deposit->ofPaymentMethod($data['payment_method']);
        }

        return $deposit->paginate(10);
    }
}
