<?php

use App\Models\Game;
use App\Models\GameTransaction;
use App\Models\GameWinnerEarnings;
use App\Models\UserWallet;
use App\Models\WalletTransaction;
use Illuminate\Database\Seeder;

class GameEndSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Game::where('id', 1)->update(['status' => 'finished']);

        $gameWinnerEarnings[] = [
            'game_id' => 1,
            'user_id' => 2,
            'earning' => 2500,
            'status' => GameWinnerEarnings::STATUS_NEW,
        ];

        $gameWinnerEarnings[] = [
            'game_id' => 1,
            'user_id' => 3,
            'earning' => 1071,
            'status' => GameWinnerEarnings::STATUS_NEW,
        ];

        $gameWinnerEarnings[] = [
            'game_id' => 1,
            'user_id' => 4,
            'earning' => 459,
            'status' => GameWinnerEarnings::STATUS_NEW,
        ];

        foreach ($gameWinnerEarnings as $gameWinnerEarning) {
            GameWinnerEarnings::create($gameWinnerEarning);
        }

        $gameTransactions[] = [
            'user_id' => 4,
            'wallet_id' => 2,
            'wallet_type' => 'App\Models\UserWallet',
            'game_id' => 1,
            'amount' => 2500,
            'type' => 'earn',
            'status' => 'approved',
        ];

        $gameTransactions[] = [
            'user_id' => 2,
            'wallet_id' => 2,
            'wallet_type' => 'App\Models\UserWallet',
            'game_id' => 1,
            'amount' => 1071,
            'type' => 'earn',
            'status' => 'approved',
        ];

        $gameTransactions[] = [
            'user_id' => 3,
            'wallet_id' => 3,
            'wallet_type' => 'App\Models\UserWallet',
            'game_id' => 1,
            'amount' => 459,
            'type' => 'earn',
            'status' => 'approved',
        ];

        $gameTransactions[] = [
            'user_id' => 1,
            'wallet_id' => 3,
            'wallet_type' => 'App\Models\UserWallet',
            'game_id' => 1,
            'amount' => 1800,
            'type' => 'earn',
            'status' => 'approved',
        ];

        foreach ($gameTransactions as $gameTransaction) {
            GameTransaction::create($gameTransaction);
        }

        WalletTransaction::create([
            'user_id' => 1,
            'wallet_id' => 1,
            'wallet_type' => 'App\Models\UserWallet',
            'amount' => 1800,
            'wallet_balance_before_tansaction' => 0,
            'wallet_balance_after_tansaction' => 1800,
            'type' => WalletTransaction::TYPE_CREDIT,
            'transaction_type' => 'App\Models\GameTransaction',
            'transaction_id' => 7
        ]);

        UserWallet::where('id', 1)->update(['balance' => 1800]);

    }
}
