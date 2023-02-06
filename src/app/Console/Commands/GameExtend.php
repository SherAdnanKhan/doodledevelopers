<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Notifications\Games\GameExtensionNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class GameExtend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:extend';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Extend the game if deadline reached and pot value is less than jackpot';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $games = Game::where(['status' => 'live'])->get();

        Log::info(__METHOD__ . " -- Game extend games:", $games->toArray());

        try {
            DB::beginTransaction();

            foreach ($games as $game) {

                $this->info($game->is_deadline_reached);
                $this->info($game->extensions_count);
                $this->info($game->pot_value);
                $this->info($game->jackpot_value);
                
                if ($game->is_deadline_reached &&
                    $game->extensions_count < MAX_GAME_EXTENSION_LIMIT &&
                    $game->pot_value < $game->jackpot_value
                ) {
                    $extensionStartDate = $game->end_date->toDateString();
                    $extensionEndDate = $game->end_date->addDays($game->game_ext_days)->toDateString();

                    $game->extensions()->create([
                        "extension_days" => $game->game_ext_days,
                        "start_date" => $extensionStartDate,
                        "end_date" => $extensionEndDate
                    ]);

                    $game->update([
                        "is_extended" => 1,
                        "end_date" => $extensionEndDate
                    ]);

                    Log::info(__METHOD__ . " -- Game is extended! game:", $game->toArray());

                    Event::dispatch('game.extended', [$game, $extensionEndDate]);
                }
            }

            DB::commit();

        } catch (\Exception $e) {
            Log::error(__METHOD__ . " -- Internal error occur in extending game. All transactions is rollback");
            DB::rollback();
        }
    }

}
