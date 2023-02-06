<?php

namespace App\Http\Transformers\Payments\Red6six;

use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Constants\ConstantTransformer;
use App\Models\PaymentMethod;
use App\Models\UserTransaction;

class UserTransactionTransformer extends BaseTransformer
{
    protected $defaultIncludes = [
        'paymentMethod', 'status'
    ];

    protected $availableIncludes = [
        'transactional'
    ];

    public function transform(UserTransaction $userTransaction)
    {
        return [
            'id' => $userTransaction->id,
            'amount' => $userTransaction->amount,
            'converted_amount' => (int) $userTransaction->converted_amount,
            'fee_deducted_amount' => $userTransaction->fee_deducted_amount,
            'fee_deducted_converted_amount' => $userTransaction->fee_deducted_converted_amount,
            'transactional_type' => $userTransaction->transactional_type,
            'transactional_id' => $userTransaction->transactional_id,
            'created_at' => $userTransaction->created_at,
            'updated_at' => $userTransaction->updated_at,
        ];
    }

    public function includePaymentMethod(UserTransaction $userTransaction)
    {
        $paymentMethod = PaymentMethod::find($userTransaction->payment_method_id);
        return $this->item($paymentMethod, new ConstantTransformer);
    }

    public function includeStatus(UserTransaction $userTransaction)
    {
        $item = [
            'id' => $userTransaction->status,
            'name' => data_get(UserTransaction::statuses(), $userTransaction->status)
        ];

        return $this->item($item, new ConstantTransformer);
    }

    public function includeTransactional(UserTransaction $userTransaction)
    {
        if ($userTransaction->transactional_type === UserTransaction::TYPE_TRANSACTION_DEPOSIT) {
            return $this->item($userTransaction->transactional, new DepositTransformer);
        }

        return $this->item($userTransaction->transactional, new WithdrawalTransformer);
    }
}
