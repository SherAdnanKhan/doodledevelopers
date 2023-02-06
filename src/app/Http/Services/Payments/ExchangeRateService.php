<?php

namespace App\Http\Services\Payments;

use App\Models\Currency;
use App\Models\CurrencyConversation;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class ExchangeRateService
{
    /** @var Client */
    private $client;

    /**
     * @var mixed
     */
    private $accessKey;

    /** @var string */
    private string $baseUrl;

    public function __construct($client = null)
    {
        $this->client = $client ?? app(Client::class);
        $this->accessKey = config('services.fixer.accessKey');
        $this->baseUrl = "http://data.fixer.io/api/latest?access_key={$this->accessKey}" ;
    }

    /**
     * @param string $base
     * @param string $symbols
     * @return array
     * @throws GuzzleException
     */
    public function exchangeRate(string $base, string $symbols) : array
    {
        $url = $this->baseUrl . "&base={$base}&symbols={$symbols}";

        try {
            $response = $this->client->request('POST', $url);

            return json_decode($response->getBody(), true);

        }catch (\Exception $exception) {
            Log::warning(__METHOD__ . " -- Error requesting service data. Response Status: " . $response->getStatusCode(), json_decode($response->getBody(), true));
        }
    }


    /**
     * @param int $amount
     * @param string $fromCurrency
     * @param string $toCurrency
     * @return int
     * @throws GuzzleException
     */
    public function getExchangeAmount(int $amount, string $fromCurrency, string $toCurrency) : int
    {
        if ($fromCurrency == Currency::TYPE_EUR || $fromCurrency == Currency::TYPE_USD) {

            $fromCurrency = ($fromCurrency == Currency::TYPE_EUR) ? 2 : 3 ;

            $currency = CurrencyConversation::where('from_currency', $fromCurrency)->latest('created_at')->first();

            return (int) ceil($amount * $currency->per_unit_rate);
        }

        $content = $this->exchangeRate($fromCurrency, $toCurrency);

        return (int) ceil($amount * $content['rates'][$toCurrency]);
    }
}
