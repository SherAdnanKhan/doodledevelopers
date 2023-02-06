<?php

namespace App\Repositories\PaymentGateways\Zing;

use App\Models\Currency;
use App\Repositories\HttpHandler;
use App\Repositories\PaymentGateways\PaymentRepositoryInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class ZingRepository extends HttpHandler implements PaymentRepositoryInterface
{
    public function __construct()
    {
        parent::__construct();
        $this->config = config('services.zing');
    }

    /**
     * Perform a server-to-server POST request to prepare the checkout with the required data
     * @return mixed
     */
    public function prepareCheckout(array $data)
    {
        $user = auth()->user();
        $data = array_merge($data, [
            'entityId' => $this->config['entityId'],
            'amount' => $data['amount'],
            'currency' => Currency::TYPE_GBP,
            'paymentType' => ZING_PAYMENT_TYPE_DEBIT,
            'customParameters' => [
                'SHOPPER_customerId' => auth()->id()
            ],
            'billing.city' => $user->city,
            'billing.country' => $user->country->name,
            'billing.street1' => $user->address,
            'billing.postcode' => $user->postcode,
            'customer.email' => $user->email,
            'customer.givenName' => $user->first_name . ' '. $user->last_name,
            'customer.surname' => $user->first_name,
            'merchantTransactionId' => Str::orderedUuid()->toString()
        ]);
        return $this->call('checkouts', 'POST', $data);
    }

    /**
     * Independent transaction that results in a refund.
     * @param array $data
     * @return mixed
     */
    public function withdraw(array $data)
    {
        $payload = [
            'entityId' => $this->config['entityId'],
            'amount' => $data['amount'],
            'currency' => Currency::TYPE_GBP,
            'paymentBrand' => $data['payment_brand'],
            'paymentType' => ZING_PAYMENT_TYPE_CREDIT,
            'card.number' => $data['payment_card_number'],
            'card.expiryMonth' => $data['payment_expiry_month'],
            'card.expiryYear' => $data['payment_expiry_year'],
            'card.holder' => $data['payment_card_holder'],
            'customParameters' => [
                'SHOPPER_customerId' => auth()->id()
            ]
        ];
        return $this->call('payments', 'POST', $payload);
    }

    /**
     * Get the transaction status using the payment id
     * @param string $resultCode
     * @return string
     */
    public function getPaymentStatus(string $resultCode): string
    {
        if (preg_match(ZING_RC_SUCCESSFULLY_PROCESSED, $resultCode)) {
            return STATUS_APPROVED;
        } else if (preg_match(ZING_RC_MANUAL_REVIEW_SUCCESSFULLY_PROCESSED, $resultCode) ||
            preg_match(ZING_RC_PENDING, $resultCode)) {
            return STATUS_PENDING;
        } else {
            return STATUS_REJECTED;
        }
    }

    function validateConfig()
    {
        if (!isset($this->config)) {
            return $this->failure('', trans('exception.invalid_config'), Response::HTTP_BAD_REQUEST);
        }

        if (!isset($this->config['baseUrl']) || empty($this->config['baseUrl'])) {
            return $this->failure('', trans('exception.invalid_base_url'), Response::HTTP_BAD_REQUEST);
        }

        if (!isset($this->config['accessToken']) || empty($this->config['accessToken'])) {
            return $this->failure('', trans('exception.invalid_api_key'), Response::HTTP_BAD_REQUEST);
        }

        return true;
    }

    /**
     * Decript Webhook payload
     * @param array $data
     * @return mixed
     */
    public function decryptWebhookPayload(array $data)
    {
        $key = $this->config['decryptionKey'];
        $iv = $data['iv'];
        $authTag = $data['authTag'];
        $encryptedBody = $data['encryptedBody'];

        $key = hex2bin($key);
        $iv = hex2bin($iv);
        $authTag = hex2bin($authTag);
        $cipherText = hex2bin($encryptedBody);

        return json_decode(openssl_decrypt($cipherText, "aes-256-gcm", $key, OPENSSL_RAW_DATA, $iv, $authTag), true);
    }
}
