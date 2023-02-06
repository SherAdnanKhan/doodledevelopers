<?php

namespace App\Http\Services\Wallets;

use App\Exceptions\ErrorException;
use App\Models\Game;
use App\Models\User;
use App\Models\GameTransaction;
use App\Models\WalletTransaction;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\UserGameWallet;
use App\Models\UserWallet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WalletService
{
    /**
     * @return LengthAwarePaginator
     */
    public function getAll() : LengthAwarePaginator
    {
        return auth()->user()->wallets()->paginate(10);
    }

    /**
     * @param Game $game
     * @param User $user
     * @return Model
     * @throws ErrorException
     */
    public function createGameTransaction(Game $game, User $user) : Model
    {
        $gameWallet = $user->gameWallets()->where(['game_id' => $game->id])->first();

        if ($gameWallet && $gameWallet->credit >= $game->entry_fee) {
            return $this->createGameWalletTransaction($gameWallet, $game, $user);
        }

        $wallet = $user->wallets()->first();

        if ($wallet->balance < $game->entry_fee) {
            Log::error(__METHOD__ . " -- user: " . $user->email . " -- User not have an enough money to play the game");
            throw new ErrorException('exception.insufficient_balance_to_play_game');
        }

        return $this->createUserWalletTransaction($wallet, $game, $user);
    }


    /**
     * @param UserGameWallet $wallet
     * @param Game $game
     * @param User $user
     * @return UserGameWallet
     * @throws ErrorException
     */
    private function createGameWalletTransaction(UserGameWallet $wallet, Game $game, User $user) : UserGameWallet
    {
        try {

            DB::beginTransaction();

            $gameTransaction = $wallet->gameTransactions()->create([
                'user_id' => $user->id,
                'game_id' => $game->id,
                'amount' => $game->entry_fee,
                'type' => GameTransaction::TYPE_PAY_VIA_FEE_CREDIT,
                'status' => GameTransaction::STATUS_APPROVED
            ]);

            Log::alert(__METHOD__ . " -- user: " . $user->email . " -- Create Game transaction:", $gameTransaction->toArray());

            $walletTransaction = $gameTransaction->walletTransactions()->create([
                'user_id' => $user->id,
                'wallet_id' => $wallet->id,
                'wallet_type' => WalletTransaction::TYPE_WALLET_GAME,
                'amount' => $game->entry_fee,
                'wallet_balance_before_tansaction' => $wallet->credit,
                'wallet_balance_after_tansaction' => $wallet->credit - $game->entry_fee,
                'type' => WalletTransaction::TYPE_DEBIT
            ]);

            Log::alert(__METHOD__ . " -- user: " . $user->email . " -- Create Wallet transaction:", $walletTransaction->toArray());

            $wallet->update([
                'credit' => $wallet->credit - $game->entry_fee
            ]);

            Log::alert(__METHOD__ . " -- User game wallet:", $wallet->toArray());

            $game->update([
                'pot_value' => $game->pot_value + $game->entry_fee
            ]);

            Log::info(__METHOD__ . " -- Game pot value updated:", $game->toArray());

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            Log::error(__METHOD__ . " -- user: " . $user->email . " -- Internal error occur in play game. All transactions rollback");
            throw new ErrorException('exception.internal_game_play_error');
        }

        return $wallet;

    }

    /**
     * @param UserWallet $wallet
     * @param Game $game
     * @param User $user
     * @return UserWallet
     * @throws ErrorException
     */
    private function createUserWalletTransaction(UserWallet $wallet, Game $game, User $user) : UserWallet
    {
        try {

            DB::beginTransaction();

            $gameTransaction = $wallet->gameTransactions()->create([
                'user_id' => $user->id,
                'game_id' => $game->id,
                'amount' => $game->entry_fee,
                'type' => GameTransaction::TYPE_PAY_VIA_WALLET,
                'status' => GameTransaction::STATUS_APPROVED
            ]);

            Log::alert(__METHOD__ . " -- user: " . $user->email . " -- Game transaction:", $gameTransaction->toArray());

            $gameTransaction->walletTransactions()->create([
                'user_id' => $user->id,
                'wallet_id' => $wallet->id,
                'wallet_type' => WalletTransaction::TYPE_WALLET_USER,
                'amount' => $game->entry_fee,
                'wallet_balance_before_tansaction' => $wallet->balance,
                'wallet_balance_after_tansaction' => $wallet->balance - $game->entry_fee,
                'type' => WalletTransaction::TYPE_DEBIT
            ]);

            $wallet->update([
                'balance' => $wallet->balance - $game->entry_fee
            ]);

            Log::alert(__METHOD__ . " -- user: " . $user->email . " -- User wallet amount deduct as game entry fee:", $wallet->toArray());

            $game->update([
                'pot_value' => $game->pot_value + $game->entry_fee
            ]);

            Log::info(__METHOD__ . " -- Game pot value updated:", $game->toArray());

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            Log::error(__METHOD__ . " -- Internal error occur in play game. All transactions rollback");
            throw new ErrorException('exception.internal_game_play_error');
        }

        return $wallet;
    }

}
