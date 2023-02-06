<?php

namespace App\Http\Services\Payments\Red6six;

use App\Exceptions\ErrorException;
use App\Http\Services\Payments\ExchangeRateService;
use App\Models\Currency;
use App\Models\GameConfiguration;
use App\Models\User;
use App\Models\UserTransaction;
use App\Models\UserWallet;
use App\Models\WalletTransaction;
use App\Models\Withdrawal;
use App\Repositories\PaymentGateways\PaymentRepositoryInterface;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class WithdrawalService
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
     * @return LengthAwarePaginator
     */
    public function getAll() : LengthAwarePaginator
    {
        return auth()->user()->withdrawals()->orderByDesc('id')->paginate(10);
    }

    /**
     * @param array $data
     * @return Withdrawal
     * @throws ErrorException
     */
    public function store(array $data) : Withdrawal
    {
        Log::info("User withdrawal:", $data);

        $amount = $data['amount'];
        $currency = $data['currency'];
        $convertedAmount = $amount;

        $user = auth()->user();
        $wallet = $user->wallets()->firstOrFail();

        $minAmount = $this->config->min_withdrawal_amount;
        $maxAmount = $this->config->max_withdrawal_amount;
        $maxWithdrawLimitWithoutKyc = MAX_WITHDRAW_LIMIT_WITHOUT_KYC;

        if ($currency !== Currency::TYPE_GBP) {
            $convertedAmount = $this->getConvertedAmount($amount, $currency, Currency::TYPE_GBP);
            $minAmount = $this->getConvertedAmount($minAmount, Currency::TYPE_GBP, $currency);
            $maxAmount = $this->getConvertedAmount($maxAmount, Currency::TYPE_GBP, $currency);
            $maxWithdrawLimitWithoutKyc = $this->getConvertedAmount($maxWithdrawLimitWithoutKyc, Currency::TYPE_GBP, $currency);
        }

        if ($convertedAmount > MAX_WITHDRAW_LIMIT_WITHOUT_KYC && !$user->is_kyc_verified) {
            Log::error("User kyc is not approved");
            throw new ErrorException('exception.amount_limit_exceed_without_kyc_process', [
                "maxWithdrawLimitWithoutKyc" => floor($maxWithdrawLimitWithoutKyc),
                "currency" => $currency
            ]);
        }

        if ($convertedAmount < $this->config->min_withdrawal_amount || $convertedAmount > $this->config->max_withdrawal_amount) {
            Log::error("User withdrawal amount is out of range from:", array("min_amount" => $minAmount, "max_amount" => $maxAmount));
            throw new ErrorException('exception.amount_limit_below_or_exceed_error', ['min' => ceil($minAmount), 'max' => floor($maxAmount)]);
        }

        if ($wallet->balance < $convertedAmount) {
            Log::error("User wallet has insufficient balance");
            throw new ErrorException('exception.insufficient_wallet_balance_for_withdrawal');
        }

        $response = $this->repository->withdraw($data);

        $creditData = [
            'payment_transaction_id' => $response['id'],
            'payment_status' => $this->repository->getPaymentStatus($response['result']['code']),
            'amount' => $amount,
        ];

        Log::info("Processing Credit Request:", $creditData);

        return $this->createTransaction($creditData);
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
     * @param $data
     * @return Model
     * @throws ErrorException
     */
    private function createTransaction($data) : Withdrawal
    {
        $withdrawal = null;
        $user = auth()->user();
        $wallet = $user->wallets()->firstOrFail();
        try {
            DB::beginTransaction();

            $withdrawal = $user->withdrawals()->create([
                'payment_method_id' => PAYMENT_METHODS['DEBIT_CARD'],
                'payment_transaction_id' => $data['payment_transaction_id'],
                'amount' => $data['amount'],
                'converted_amount' => $data['amount'],
                'fee_deducted_amount' => 0,
                'fee_deducted_converted_amount' => 0,
                'additional_charges' => 0,
                'additional_charges_converted_amount' => 0,
                'withdrawal_status' => $data['payment_status'],
                'completed_at' => Carbon::now()
            ]);

            Log::alert("Withdrawal:", $withdrawal->toArray());

            //Todo User transaction and wallet transaction will be done by payment gateway webhook later
            $userTransaction = $withdrawal->userTransactions()->create([
                'payment_method_id' => PAYMENT_METHODS['DEBIT_CARD'],
                'payment_transaction_id' => $data['payment_transaction_id'],
                'user_id' => $user->id,
                'amount' => $data['amount'],
                'converted_amount' => $data['amount'],
                'fee_deducted_amount' => 0,
                'fee_deducted_converted_amount' => 0,
                'status' => $data['payment_status']
            ]);

            Log::alert("User withdrawal transaction:", $userTransaction->toArray());

            $userTransaction->walletTransactions()->create([
                'user_id' => $user->id,
                'wallet_id' => $wallet->id,
                'payment_transaction_id' => $data['payment_transaction_id'],
                'wallet_type' => WalletTransaction::TYPE_WALLET_USER,
                'amount' => $data['amount'],
                'wallet_balance_before_tansaction' => $wallet->balance,
                'wallet_balance_after_tansaction' => $wallet->balance - $data['amount'],
                'type' => WalletTransaction::TYPE_DEBIT
            ]);

            $wallet->update([
                'balance' => $wallet->balance - $data['amount']
            ]);

            Log::alert("User Wallet:", $wallet->toArray());

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Internal error occur in withdrawal. All transactions rollback");
            throw new ErrorException('exception.internal_withdrawal_error');
        }

        Event::dispatch('payment.withdrawal', [$user, $withdrawal]);

        return $withdrawal;
    }
}
