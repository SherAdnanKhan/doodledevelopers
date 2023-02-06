<?php

use App\Models\Game;
use Illuminate\Database\Seeder;

class AttachOldGamesToMapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $games = Game::all();
        foreach ($games as $game){
            $game->update([
                'amount_of_balls_to_fire' => 5,
                'total_attempts' => 3
            ]);
            if ($game->maps()->count() === 0) {
                $game->maps()->create([
                    'map_id' => 1
                ]);
            }
        }
    }

}
