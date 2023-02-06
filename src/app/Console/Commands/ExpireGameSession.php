<?php

namespace App\Console\Commands;

use App\Http\Services\Games\GamePlayerService;
use App\Models\GamePlayer;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ExpireGameSession extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:expire-session';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire 30 minutes older game sessions';

    /**
     * @var GamePlayerService
     */
    private GamePlayerService $service;

    /**
     * Create a new command instance.
     *
     * @param GamePlayerService $service
     */
    public function __construct(GamePlayerService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::info(__METHOD__ . " -- Expiring game player sessions:");
        $gamePlayers = GamePlayer::where(['status' => GamePlayer::STATUS_PLAYING])->get();
        foreach ($gamePlayers as $gamePlayer) {
            if ($gamePlayer->token_generated_at->diffInMinutes(Carbon::now()) >= 30) {
                $this->service->expireGameSession($gamePlayer);
            }
        }
    }
}
