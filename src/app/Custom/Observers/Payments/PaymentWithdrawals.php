<?php

namespace App\Custom\Observers\Payments;

use App\Custom\Observers\BaseObserver;
use App\Models\User;
use App\Models\Withdrawal;
use App\Notifications\Payments\PaymentWithdrawalNotification;

class PaymentWithdrawals extends BaseObserver
{
    public static $listen = ['payment.withdrawal'];

    public function handle(User $user, Withdrawal $withdrawal)
    {
        $user->notify(new PaymentWithdrawalNotification($withdrawal));
    }
}
