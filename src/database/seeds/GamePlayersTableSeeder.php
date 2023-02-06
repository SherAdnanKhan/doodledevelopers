<?php

use App\Models\GamePlayer;
use Illuminate\Database\Seeder;

class GamePlayersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        GamePlayer::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $gamePlayers[] = [
            'user_id' => 2,
            'game_id' => 1,
            'number_of_times_played' => 1,
            'highest_score' => 10,
            'shortest_duration' => 2.678,
            'status' => GamePlayer::STATUS_NOT_PLAYING,
        ];

        $gamePlayers[] = [
            'user_id' => 3,
            'game_id' => 1,
            'number_of_times_played' => 1,
            'highest_score' => 8,
            'shortest_duration' => 2.00,
            'status' => GamePlayer::STATUS_NOT_PLAYING,
        ];

        $gamePlayers[] = [
            'user_id' => 4,
            'game_id' => 1,
            'number_of_times_played' => 1,
            'highest_score' => 11,
            'shortest_duration' => 6.98,
            'status' => GamePlayer::STATUS_NOT_PLAYING,
        ];

        foreach ($gamePlayers as $gamePlayer) {
            GamePlayer::create($gamePlayer);
        }
    }
}
