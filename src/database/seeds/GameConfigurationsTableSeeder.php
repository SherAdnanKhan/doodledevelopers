<?php

use App\Models\GameConfiguration;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameConfigurationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!GameConfiguration::exists()) {
            DB::table('game_configurations')->insert([
                [
                    'id' => 1,
                    'currency_conversion_duration' => 30,
                    'min_deposit_amount' => 5,
                    'max_deposit_amount' => 5000000,
                    'min_withdrawal_amount' => 5,
                    'max_withdrawal_amount' => 5000000,
                    'amount_of_balls_to_fire' => 5,
                    'total_attempts' => 3,
                    'maintenance_mode' => 0,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
            ]);
        }
    }
}
