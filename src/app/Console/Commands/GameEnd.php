<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Models\GamePlayer;
use App\Models\GameTransaction;
use App\Models\GameWinnerEarnings;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use App\Http\Services\Games\GameWinnerEarningAdminService;
use Illuminate\Support\Facades\Log;


class GameEnd extends Command
{
    /**
     * The name and signature of the console command.
     *
     */
    protected $signature = 'game:end';

    /**
     * The console command description.
     *
     */
    protected $description = 'End game and update winners';

    /**
     * @var GameWinnerEarningAdminService
     */
    private GameWinnerEarningAdminService $service;

    public function __construct(GameWinnerEarningAdminService $service)
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

        $games = Game::where(['status' => 'live'])->get();
        foreach ($games as $game) {
            if (($game->is_deadline_reached) && (($game->pot_value >= $game->jackpot_value) ||
                ($game->is_extended && $game->pot_value >= $game->jackpot_value) ||
                ($game->is_extended && $game->extensions_count == MAX_GAME_EXTENSION_LIMIT))
            ) {
                $this->finishGame($game);
                $this->updateWinners($game);
            }
        }
    }

    /**
     * @param Game $game
     */
    private function finishGame(Game $game) : void
    {
        $game->status = Game::STATUS_FINISHED;
        $game->save();

        $game->players()->newPivotStatement()->update([
            'status' => GamePlayer::STATUS_NOT_PLAYING,
            'token' => null,
            'token_generated_at' => null
        ]);

        Log::info(__METHOD__ . " -- Game finished by Job:", $game->toArray());
    }

    /**
     * @param Game $game
     */
    private function updateWinners(Game $game) : void
    {
        $players = $game->players()
            ->orderBy('highest_score', 'DESC')
            ->orderBy('shortest_duration', 'ASC')
            ->get();
        Log::info(__METHOD__ . " -- Players:", $players->toArray());

        $this->service->calculateUserEarning($game);
        $winners = $this->service->getWinners();
        $adminEarning = $this->service->getAdminPotValue();

        Log::info(__METHOD__ . " -- Winners:", [$winners, $adminEarning]);

        
        try {
            DB::beginTransaction();

            foreach($winners as $index => $prize) {
                $player = $players[$index-1];

                if ($prize == 0) {
                    break;
                }

                $earning = $game->earnings()->create([
                    'user_id' => $player->id,
                    'earning' => $prize,
                    'status' => GameWinnerEarnings::STATUS_NEW
                ]);

                Log::alert(__METHOD__ . " -- Game Earning of player:", $earning->toArray());

                $playerWallet = $player->wallets()->first();

                $gameTransaction = $game->gameTransactions()->create([
                    'user_id' => $player->id,
                    'wallet_id' => $playerWallet->id,
                    'wallet_type' => GameTransaction::TYPE_WALLET_USER,
                    'amount' => $prize,
                    'type' => GameTransaction::TYPE_EARN,
                    'status' => GameTransaction::STATUS_APPROVED,
                ]);

                Log::alert(__METHOD__ . " -- Player game transaction:", $gameTransaction->toArray());

                Event::dispatch('game.ended', [$player, $earning]);
            }

            $admin = User::where('is_admin', 1)->first();
            $adminWallet = $admin->wallets()->first();

            $adminWallet->update([
                'balance' => ($adminWallet->balance + $adminEarning)
            ]);
            Log::alert(__METHOD__ . " -- Admin wallet:", $adminWallet->toArray());

            $gameTransaction = $game->gameTransactions()->create([
                'user_id' =>  $adminWallet->user_id,
                'wallet_id' => $adminWallet->id,
                'wallet_type' => GameTransaction::TYPE_WALLET_USER,
                'amount' => $adminEarning,
                'type' => GameTransaction::TYPE_EARN,
                'status' => GameTransaction::STATUS_APPROVED,
            ]);
            Log::alert(__METHOD__ . " -- Admin game transaction:", $gameTransaction->toArray());

            $gameTransaction->walletTransactions()->create([
                'user_id' => $adminWallet->user_id,
                'wallet_id' => $adminWallet->id,
                'wallet_type' => WalletTransaction::TYPE_WALLET_USER,
                'amount' => $adminEarning,
                'wallet_balance_before_tansaction' => $adminWallet->balance,
                'wallet_balance_after_tansaction' => $adminWallet->balance + $adminEarning,
                'type' => WalletTransaction::TYPE_CREDIT
            ]);

            DB::commit();

        } catch (\Exception $exception) {
            Log::error(__METHOD__ . " -- Internal error occur in game end. All transactions is rollback");
            DB::rollback();
        }
        

    }
}
