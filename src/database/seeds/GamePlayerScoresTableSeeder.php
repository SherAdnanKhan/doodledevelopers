<?php

use App\Models\GamePlayerScore;
use Illuminate\Database\Seeder;

class GamePlayerScoresTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        GamePlayerScore::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        $gamePlayerScores[] = [
            'user_id' => 2,
            'game_id' => 1,
            'score' => 10,
            'duration' => 2.678
        ];

        $gamePlayerScores[] = [
            'user_id' => 3,
            'game_id' => 1,
            'score' => 8,
            'duration' => 2.00
        ];

        $gamePlayerScores[] = [
            'user_id' => 4,
            'game_id' => 1,
            'score' => 11,
            'duration' => 6.98
        ];

        foreach ($gamePlayerScores as $gamePlayerScore) {
            GamePlayerScore::create($gamePlayerScore);
        }
    }
}
