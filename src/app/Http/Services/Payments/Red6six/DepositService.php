<?php

namespace App\Http\Services\Payments\Red6six;

use App\Exceptions\ErrorException;
use App\Http\Services\BaseService;
use App\Http\Services\Payments\ExchangeRateService;
use App\Models\Currency;
use App\Models\Deposit;
use App\Models\GameConfiguration;
use App\Models\User;
use App\Models\UserTransaction;
use App\Models\WalletTransaction;
use App\Repositories\PaymentGateways\PaymentRepositoryInterface;
use App\Repositories\PaymentGateways\Zing\ZingRepositoryInterface;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DepositService extends BaseService
{
    /**
     * @var GameConfiguration
     */
    private GameConfiguration $config;

    /**
     * @var ExchangeRateService/
     */
    private ExchangeRateService $service;

    /**
     * @var PaymentRepositoryInterface/
     */
    private PaymentRepositoryInterface $repository;

    public function __construct(PaymentRepositoryInterface $repository)
    {
        $this->config = GameConfiguration::first();
        $this->service = app(ExchangeRateService::class);
        $this->repository = $repository;
    }

    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function getAll(array $data) : LengthAwarePaginator
    {
        $deposit = auth()->user()->deposits();

        if (isset($data['status'])) {
            $deposit = $deposit->ofStatus($data['status']);
        }

        if (isset($data['payment_method'])) {
            $deposit->ofPaymentMethod($data['payment_method']);
        }

        return $deposit->orderByDesc('id')->paginate(10);
    }

    /**
     * @param array $data
     * @return array
     * @throws GuzzleException|ErrorException
     */
    public function store(array $data) : array
    {
        Log::info(__METHOD__ . " -- User deposit:", $data);

        $amount = $data['amount'];
        $currency = $data['currency'];
        $convertedAmount = $amount;

        $minAmount = $this->config->min_deposit_amount;
        $maxAmount = $this->config->max_deposit_amount;

        if ($currency !== Currency::TYPE_GBP) {
            $convertedAmount = $this->getConvertedAmount($amount, $currency, Currency::TYPE_GBP);
            $minAmount = $this->getConvertedAmount($minAmount, Currency::TYPE_GBP, $currency);
            $maxAmount = $this->getConvertedAmount($maxAmount, Currency::TYPE_GBP, $currency);
        }

        if ($convertedAmount < $this->config->min_deposit_amount || $convertedAmount > $this->config->max_deposit_amount) {
            Log::error(__METHOD__ . " -- User deposit amount is out of range from:", array("min_amount" => $minAmount, "max_amount" => $maxAmount));
            throw new ErrorException('exception.amount_limit_below_or_exceed_error', ['min' => $this->thousandsCurrencyFormat(ceil($minAmount)), 'max' => $this->thousandsCurrencyFormat(floor($maxAmount))]);
        }

        return $this->repository->prepareCheckout($data);
    }

    /**
     * @throws ErrorException
     */
    public function processDeposit(array $data) : Deposit {
        return $this->createTransaction($data);
    }

    /**
     * @param int $amount
     * @param string $fromCurrency
     * @param string $toCurrency
     * @return int
     * @throws GuzzleException
     */
    private function getConvertedAmount(int $amount, string $fromCurrency, string $toCurrency) : int
    {
        return $this->service->getExchangeAmount($amount, $fromCurrency, $toCurrency);
    }

    /**
     * @param array $data
     * @return Deposit
     * @throws ErrorException
     */
    private function createTransaction(array $data) : Deposit
    {
        $user = User::where('id', $data['user_id'])->first();

        try {
            DB::beginTransaction();

            $deposit = $user->deposits()->create([
                'payment_method_id' => PAYMENT_METHODS['DEBIT_CARD'],
                'payment_transaction_id' => $data['payment_transaction_id'],
                'amount' => $data['amount'],
                'converted_amount' => $data['amount'],
                'additional_charges' => 0,
                'additional_charges_converted_amount' => 0,
                'deposit_status' => $data['payment_status'],
                'completed_at' => Carbon::now()
            ]);
            Log::info(__METHOD__ . " -- user: " . $user->email . " -- User Deposit:", $deposit->toArray());

            $userTransaction = $deposit->userTransactions()->create([
                'payment_method_id' => PAYMENT_METHODS['DEBIT_CARD'],
                'payment_transaction_id' => $data['payment_transaction_id'],
                'user_id' => $user->id,
                'amount' => $data['amount'],
                'converted_amount' => $data['amount'],
                'fee_deducted_amount' => 0,
                'fee_deducted_converted_amount' => 0,
                'status' => $data['payment_status']
            ]);
            Log::info(__METHOD__ . " -- user: " . $user->email . " -- Deposit User Transaction:", $userTransaction->toArray());

            $wallet = $user->wallets()->firstOrFail();

            $userTransaction->walletTransactions()->create([
                'user_id' => $user->id,
                'wallet_id' => $wallet->id,
                'wallet_type' => WalletTransaction::TYPE_WALLET_USER,
                'amount' => $data['amount'],
                'wallet_balance_before_tansaction' => $wallet->balance,
                'wallet_balance_after_tansaction' => $wallet->balance + $data['amount'],
                'type' => WalletTransaction::TYPE_CREDIT,
                'payment_transaction_id' => $data['payment_transaction_id'],
            ]);

            $wallet->update([
                'balance' => $wallet->balance + $data['amount']
            ]);

            Log::info(__METHOD__ . " -- user: " . $user->email . " -- Deposit User wallet credited with amount: " . $data['amount'] . " wallet: ", $wallet->toArray());

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            Log::error(__METHOD__ . " -- user: " . $user->email . " -- Internal error occur in deposit. All transactions rollback");
            throw new ErrorException('exception.internal_deposit_error');
        }

        return $deposit;
    }
}
