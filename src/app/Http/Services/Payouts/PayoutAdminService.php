<?php

namespace App\Http\Services\Payouts;

use App\Exceptions\ErrorException;
use App\Http\Services\BaseService;
use App\Models\Game;
use App\Models\GameTransaction;
use App\Models\WalletTransaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PayoutAdminService extends BaseService
{
    /**
     * @param Game $game
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function getAll(Game $game, array $data) : LengthAwarePaginator
    {
        $payouts = $game->gameTransactions()
            ->where('type', GameTransaction::TYPE_PAYOUT)
            ->where('game_id', $game->id);

        if ($data) {
            $payouts->where('status', $data['status']);
        }

        return $payouts->paginate(10);
    }

    /**
     * @param Game $game
     * @param GameTransaction $gameTransaction
     * @param array $data
     * @return GameTransaction
     * @throws ErrorException
     */
    public function update(Game $game, GameTransaction $gameTransaction, array $data) : GameTransaction
    {
        if ($gameTransaction->status != GameTransaction::STATUS_PENDING) {
            Log::error(__METHOD__ . " -- Payout request is already approved");
            throw new ErrorException('exception.payout_update_error');
        }

        $userWallet = $gameTransaction->wallet;
        $userEarning = $game->earnings()->where('user_id', $userWallet->user_id)->first();

        try {

            DB::beginTransaction();

            $gameTransaction->update([
                'status' => $data['status']
            ]);
            Log::alert(__METHOD__ . " -- Game Transaction:", $gameTransaction->toArray());

            $userEarning->update([
                'status' => $data['status']
            ]);
            Log::alert(__METHOD__ . " -- User Earnings:", $userEarning->toArray());

            $gameTransaction->walletTransactions()->create([
                'user_id' => $userWallet->user_id,
                'wallet_id' => $userWallet->id,
                'wallet_type' => WalletTransaction::TYPE_WALLET_USER,
                'amount' => $gameTransaction->amount,
                'wallet_balance_before_tansaction' => $userWallet->balance,
                'wallet_balance_after_tansaction' => $data['status'] == GameTransaction::STATUS_REJECTED ? $userWallet->balance : $userWallet->balance + $gameTransaction->amount,
                'type' => WalletTransaction::TYPE_CREDIT
            ]);

            if ($data['status'] != GameTransaction::STATUS_REJECTED) {
                $userWallet->update([
                    'balance' => $userWallet->balance + $gameTransaction->amount
                ]);
            }

            Log::alert(__METHOD__ . " -- User wallet:", $userWallet->toArray());

            DB::commit();

        } catch (\Exception $exception) {
            DB::rollback();
            Log::error(__METHOD__ . " -- Internal error occur in admin approve payout. All transactions rollback");
            throw new ErrorException('exception.internal_payout_error');
        }

        return $gameTransaction;
    }
}
