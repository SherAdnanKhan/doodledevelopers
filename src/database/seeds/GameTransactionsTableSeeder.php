<?php

use App\Models\GameTransaction;
use Illuminate\Database\Seeder;

class GameTransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        GameTransaction::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $gameTransactions[] = [
            'user_id' => 2,
            'wallet_id' => 2,
            'wallet_type' => 'App\Models\UserWallet',
            'game_id' => 1,
            'amount' => 2000,
            'type' => GameTransaction::TYPE_PAY_VIA_WALLET,
            'status' => GameTransaction::STATUS_APPROVED,
        ];

        $gameTransactions[] = [
            'user_id' => 3,
            'wallet_id' => 3,
            'wallet_type' => 'App\Models\UserWallet',
            'game_id' => 1,
            'amount' => 2000,
            'type' => GameTransaction::TYPE_PAY_VIA_WALLET,
            'status' => GameTransaction::STATUS_APPROVED,
        ];

        $gameTransactions[] = [
            'user_id' => 4,
            'wallet_id' => 4,
            'wallet_type' => 'App\Models\UserWallet',
            'game_id' => 1,
            'amount' => 2000,
            'type' => GameTransaction::TYPE_PAY_VIA_WALLET,
            'status' => GameTransaction::STATUS_APPROVED,
        ];

        foreach ($gameTransactions as $gameTransaction) {
            GameTransaction::create($gameTransaction);
        }
    }
}
