<?php

use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Game::where('name', 'bubbles')->exists()) {
            $game = [
                "name" => "bubbles",
                "jackpot_value" => 2500,
                "admin_fee_percentage" => 30,
                "pot_value" => 6000,
                "entry_fee" => 2000,
                "number_of_winners" => 10,
                "game_ext_days" => "4",
                'amount_of_balls_to_fire' => 5,
                'total_attempts' => 3,
                "status" => "live",
                "start_date" => Carbon::now()->format('Y-m-d'),
                "end_date" => Carbon::now()->format('Y-m-d'),
            ];

            $gameObj = Game::create($game);
            if ($gameObj->maps()->count() === 0) {
                $gameObj->maps()->create([
                    'map_id' => 1
                ]);
            }
        }
    }
}
