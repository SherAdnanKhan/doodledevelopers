<?php

namespace App\Http\Services\Games;

use App\Exceptions\ErrorException;
use App\Http\Services\BaseService;
use App\Models\Game;
use App\Models\GameConfiguration;
use App\Models\GamePlayer;
use App\Models\GameTransaction;
use App\Models\WalletTransaction;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GameAdminService extends BaseService
{
    /**
     * @var GameConfiguration
     */
    private GameConfiguration $config;

    public function __construct()
    {
        $this->config = GameConfiguration::first();
    }

    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function getAll(array $data) : LengthAwarePaginator
    {
        if ($data) {
           return Game::where('status', $data['status'])->paginate(10);
        }

        return Game::paginate(10);

    }

    /**
     * @param array $data
     * @return Game
     */
    public function store(array $data) : Game
    {
        $customData = [];

        if (!isset($data['amount_of_balls_to_fire'])) {
            $customData['amount_of_balls_to_fire'] = $this->config->amount_of_balls_to_fire;
        }

        if (!isset($data['total_attempts'])) {
            $customData['total_attempts'] = $this->config->total_attempts;
        }

        $customData['number_of_winners'] = (0 == $data['entry_fee']) ? 0 : 30;
        $customData['status'] = Game::STATUS_NOT_STARTED;

        Log::info(__METHOD__ . " -- Admin create a new game:", array_merge($data, $customData));

        $game = Game::create(array_merge($data, $customData));

        $game->maps()->create([
            'map_id' => $data['map_id']
        ]);

        return $game;
    }

    /**
     * @param Game $game
     * @param array $data
     * @return Game
     */
    public function update(Game $game, array $data) : Game
    {
        Log::info(__METHOD__ . " -- Admin updated the game:", $data);

        $game->update($data);
        return $game;
    }

    /**
     * @param Game $game
     * @return bool
     * @throws ErrorException
     */
    public function delete(Game $game) : bool
    {
        Log::alert(__METHOD__ . " -- Admin delete the game:", $game->toArray());
        if ($game->status === Game::STATUS_LIVE) {
            Log::error(__METHOD__ . " -- live games cannot be deleted by admin", $game->toArray());
            throw new ErrorException('exception.live_game_delete_error');
        }
        return $game->delete();
    }

    /**
     * @return Collection
     * @throws ErrorException
     */
    public function stopGame(): Collection
    {
        Log::alert(__METHOD__ . " -- Admin attempt to stop games");

        $games = Game::where(['status' => 'live'])->get();

        if (!isset($games)) {
            Log::error(__METHOD__ . ' -- No live game exists');
            throw new ErrorException('exception.live_game_not_exists');
        }

        Log::info(__METHOD__ . " -- Games to be stopped immediately:", $games->toArray());

        try {
            foreach ($games as $game) {
                $game->update([
                    'status' => Game::STATUS_ENDED_BY_ADMIN,
                ]);

                $gameTransactions = $game->gameTransactions()->get();

                foreach ($gameTransactions as $gameTransaction) {

                    $playerWallet = $gameTransaction->wallet()->first();

                    $gameTransaction = $playerWallet->gameTransactions()->create([
                        'user_id' => $playerWallet->user_id,
                        'game_id' => $game->id,
                        'amount' => $gameTransaction->amount,
                        'type' => GameTransaction::TYPE_REFUND,
                        'status' => GameTransaction::STATUS_APPROVED
                    ]);
                    Log::alert(__METHOD__ . " -- Refund Game Transaction:", $gameTransaction->toArray());

                    $gameTransaction->walletTransactions()->create([
                        'user_id' => $playerWallet->user_id,
                        'wallet_id' => $playerWallet->id,
                        'wallet_type' => WalletTransaction::TYPE_WALLET_USER,
                        'amount' => $game->entry_fee,
                        'wallet_balance_before_tansaction' => $playerWallet->balance,
                        'wallet_balance_after_tansaction' => $playerWallet->balance + $gameTransaction->amount,
                        'type' => WalletTransaction::TYPE_CREDIT
                    ]);

                    $playerWallet->update([
                        'balance' => $playerWallet->balance + $gameTransaction->amount
                    ]);
                    Log::alert(__METHOD__ . " -- Player wallet updated:", $playerWallet->toArray());
                }

                $gamePlayers = $game->players()->get();

                foreach($gamePlayers as $gamePlayer) {

                    $gamePlayer->pivot->update([
                        'status' => GamePlayer::STATUS_NOT_PLAYING,
                        'token' => null
                    ]);
                }
            }
        } catch (\Exception $exception) {
            DB::rollback();
            Log::error(__METHOD__ . " -- Internal error occur in stopping game. All transactions are rollback");
            throw new ErrorException('exception.stop_game_error');
        }

        return $games;
    }
}
