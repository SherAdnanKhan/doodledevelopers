<?php

namespace App\Http\Transformers\Payments\Red6six;

use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Constants\ConstantTransformer;
use App\Models\Withdrawal;
use App\Models\PaymentMethod;

class WithdrawalTransformer extends BaseTransformer
{
    protected $defaultIncludes = [
        'paymentMethod', 'status'
    ];

    public function transform(Withdrawal $withdrawal)
    {
        return [
            'id' => $withdrawal->id,
            'amount' => $withdrawal->amount,
            'converted_amount' => (int) $withdrawal->converted_amount,
            'fee_deducted_amount' => $withdrawal->additional_charges,
            'fee_deducted_converted_amount' => (double) $withdrawal->additional_charges_converted_amount,
            'additional_charges' => $withdrawal->additional_charges,
            'additional_charges_converted_amount' => (double) $withdrawal->additional_charges_converted_amount,
            'completed_at' => $withdrawal->completed_at,
            'created_at' => $withdrawal->created_at,
            'updated_at' => $withdrawal->updated_at,
        ];
    }

    public function includePaymentMethod(Withdrawal $withdrawal)
    {
        $paymentMethod = PaymentMethod::find($withdrawal->payment_method_id);
        return $this->item($paymentMethod, new ConstantTransformer);
    }

    public function includeStatus(Withdrawal $withdrawal)
    {
        $item = [
            'id' => $withdrawal->withdrawal_status,
            'name' => data_get(Withdrawal::statuses(), $withdrawal->withdrawal_status)
        ];

        return $this->item($item, new ConstantTransformer);
    }
}
