<?php

namespace App\Repositories\PaymentGateways;

use Illuminate\Http\Request;

interface PaymentRepositoryInterface
{
    /**
     * Perform a server-to-server POST request to prepare the checkout with the required data
     * @return mixed
     */
    public function prepareCheckout(array $data);

    /**
     * Independent transaction that results in a refund.
     * @param array $data
     * @return mixed
     */
    public function withdraw(array $data);

    /**
     * Get the transaction status using the payment id
     * @param string $resultCode
     * @return mixed
     */
    public function getPaymentStatus(string $resultCode);

    /**
     * Decript Webhook payload
     * @param array $data
     * @return mixed
     */
    public function decryptWebhookPayload(array $data);
}
