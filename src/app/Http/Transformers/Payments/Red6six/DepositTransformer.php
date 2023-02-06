<?php

namespace App\Http\Transformers\Payments\Red6six;

use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Constants\ConstantTransformer;
use App\Http\Transformers\Users\UserTransformer;
use App\Models\Deposit;
use App\Models\PaymentMethod;

class DepositTransformer extends BaseTransformer
{
    protected $defaultIncludes = [
        'paymentMethod', 'status'
    ];

    protected $availableIncludes = [
        'user'
    ];

    public function transform(Deposit $deposit)
    {
        return [
            'id' => $deposit->id,
            'payment_transaction_id' => $deposit->payment_transaction_id,
            'amount' => $deposit->amount,
            'converted_amount' => (int) $deposit->converted_amount,
            'additional_charges' => $deposit->additional_charges,
            'additional_charges_converted_amount' => $deposit->additional_charges_converted_amount,
            'completed_at' => $deposit->completed_at,
            'created_at' => $deposit->created_at,
            'updated_at' => $deposit->updated_at,
        ];
    }

    public function includePaymentMethod(Deposit $deposit)
    {
        $paymentMethod = PaymentMethod::find($deposit->payment_method_id);
        return $this->item($paymentMethod, new ConstantTransformer);
    }

    public function includeStatus(Deposit $deposit)
    {
        $item = [
            'id' => $deposit->deposit_status,
            'name' => data_get(Deposit::statuses(), $deposit->deposit_status)
        ];

        return $this->item($item, new ConstantTransformer);
    }

    public function includeUser(Deposit $deposit)
    {
        if ($deposit->user) {
            return $this->item($deposit->user, new UserTransformer);
        }
    }
}
