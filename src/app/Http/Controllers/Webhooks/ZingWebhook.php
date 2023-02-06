<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Http\Services\Payments\Red6six\DepositService;
use App\Repositories\PaymentGateways\PaymentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ZingWebhook extends Controller
{
    /**
     * @var PaymentRepositoryInterface/
     */
    private PaymentRepositoryInterface $repository;

    /**
     * @var DepositService/
     */
    private DepositService $depositService;

    public function __construct(PaymentRepositoryInterface $repository, DepositService $depositService)
    {
        $this->repository = $repository;
        $this->depositService = $depositService;
    }

    /**
     * @throws \App\Exceptions\ErrorException
     */
    public function store(Request $request)
    {
        Log::info(__METHOD__ . " -- Zing webhook call Headers:", $request->header());
        Log::info(__METHOD__ . " -- Zing webhook call payload:", $request->all());

        $payload = [
            'iv' => $request->header('x-initialization-vector'),
            'authTag' => $request->header('x-authentication-tag'),
            'encryptedBody' => $request->encryptedBody,
        ];

        $decryptedPayload = $this->repository->decryptWebhookPayload($payload);

        if ($decryptedPayload['type'] === 'test') {
            return "success";
        }

        $data = [
            'payment_transaction_id' => $decryptedPayload['payload']['id'],
            'payment_status' => $this->repository->getPaymentStatus($decryptedPayload['payload']['result']['code']),
            'user_id' => $decryptedPayload['payload']['customParameters']['SHOPPER_customerId']
        ];

        if ($decryptedPayload['payload']['paymentType'] == ZING_PAYMENT_TYPE_DEBIT) {
            Log::info(__METHOD__ . " -- Processing Deposit Request:", $data);
            if ($data['payment_status'] !== STATUS_REJECTED) {
                $data['amount'] = (integer) $decryptedPayload['payload']['amount'];
            } else {
                $data['amount'] = (integer) $decryptedPayload['payload']['presentationAmount'];
            }
            $this->depositService->processDeposit($data);
        }
    }
}
