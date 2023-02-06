<?php

use App\Models\WalletTransaction;
use Illuminate\Database\Seeder;

class WalletTransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        WalletTransaction::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $walletTransactions[] = [
            'user_id' => 2,
            'wallet_id' => 2,
            'wallet_type' => 'App\Models\UserWallet',
            'amount' => 2000,
            'wallet_balance_before_tansaction' => 2000,
            'wallet_balance_after_tansaction' => 4000,
            'type' => WalletTransaction::TYPE_DEBIT,
            'transaction_type' => 'App\Models\GameTransaction',
            'transaction_id' => 1
        ];

        $walletTransactions[] = [
            'user_id' => 3,
            'wallet_id' => 3,
            'wallet_type' => 'App\Models\UserWallet',
            'amount' => 2000,
            'wallet_balance_before_tansaction' => 2000,
            'wallet_balance_after_tansaction' => 4000,
            'type' => WalletTransaction::TYPE_DEBIT,
            'transaction_type' => 'App\Models\GameTransaction',
            'transaction_id' => 2
        ];

        $walletTransactions[] = [
            'user_id' => 4,
            'wallet_id' => 4,
            'wallet_type' => 'App\Models\UserWallet',
            'amount' => 2000,
            'wallet_balance_before_tansaction' => 2000,
            'wallet_balance_after_tansaction' => 4000,
            'type' => WalletTransaction::TYPE_DEBIT,
            'transaction_type' => 'App\Models\GameTransaction',
            'transaction_id' => 3
        ];


        foreach ($walletTransactions as $walletTransaction) {
            WalletTransaction::create($walletTransaction);
        }

    }
}
