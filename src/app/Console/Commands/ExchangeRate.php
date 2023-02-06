<?php

namespace App\Console\Commands;

use App\Models\CurrencyConversation;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Services\Payments\ExchangeRateService;

class ExchangeRate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange:rate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the exchange rate and update into the db';

    /**
     * @var ExchangeRateService
     */
    private ExchangeRateService $service;

    public function __construct(ExchangeRateService $service)
    {
        parent::__construct();
        $this->service = $service;
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->exchangeFromEurToGbp();
        $this->exchangeFromUsdToGbp();
    }

    /**
     * @throws GuzzleException
     */
    private function exchangeFromEurToGbp() : void
    {
        $content = $this->service->exchangeRate('EUR', 'GBP');

        Log::info(__METHOD__ . " -- Exchange rate service response from eur to gbp:", $content);

        try {
            DB::beginTransaction();

            CurrencyConversation::create([
                'from_currency' => 2,
                'to_currency' => 1,
                'per_unit_rate' => $content['rates']['GBP']
            ]);

            DB::commit();
        } catch (\Exception $exception) {
            Log::error(__METHOD__ . " -- Internal error occur in currency exchange from eur to gbp");
            DB::rollback();
        }
    }

    /**
     * @throws GuzzleException
     */
    private function exchangeFromUsdToGbp() : void
    {
        $content = $this->service->exchangeRate('USD', 'GBP');

        Log::info(__METHOD__ . " -- Exchange rate service response from usd to gbp:", $content);

        try {
            DB::beginTransaction();

            CurrencyConversation::create([
                'from_currency' => 3,
                'to_currency' => 1,
                'per_unit_rate' => $content['rates']['GBP']
            ]);

            DB::commit();
        } catch (\Exception $exception) {
            Log::error(__METHOD__ . " -- Internal error occur in currency exchange from usd to gbp");
            DB::rollback();
        }
    }
}
