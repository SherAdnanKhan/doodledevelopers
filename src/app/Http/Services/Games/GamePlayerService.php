<?php

namespace App\Http\Services\Games;

use App\Exceptions\ErrorException;
use App\Http\Services\BaseService;
use App\Http\Services\Wallets\WalletService;
use App\Models\Game;
use App\Models\GamePlayer;
use App\Models\GamePlayerAttemptScore;
use App\Models\User;
use App\Models\UserGameWallet;
use App\Models\UserInvitation;
use Carbon\Carbon;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GamePlayerService extends BaseService
{
    /**
     * @var WalletService
     */
    private WalletService $service;

    /**
     * @var Repository|Application|mixed
     */
    private $baseUrl;

    /**
     * @var Repository|Application|mixed
     */
    private $frontendBaseUrl;

    public function __construct (WalletService $walletService)
    {
        $this->service = $walletService;
        $this->baseUrl = config('app.url');
        $this->frontendBaseUrl = config('app.client_url');
    }


    /**
     * @param array $data
     * @return string[]
     * @throws ErrorException
     */
    public function playGame(Game $game) : array
    {
        Log::info(__METHOD__ . " -- user: " . auth()->user()->email . " -- Play game:", $game->toArray());

        $user = User::where('id', auth()->id())->first();
        $gamePlayerToken = (string)Str::orderedUuid();

        if (!$game->isLive()) {
            Log::error(__METHOD__ . " -- user: " . auth()->user()->email . " -- Game for which the user request to play is not live", $game->toArray());
            throw new ErrorException('exception.game_not_live');
        }

        $map = $game->maps()->first()->map->toArray();
        $map['data']['amount_of_balls_to_fire'] = $game->amount_of_balls_to_fire;
        $map['data']['total_attempts'] = $game->total_attempts;
        $map['data']['times_played'] = 0;

        if ($user->isPlayingGameByGameID($game->id)) {
            $isUserPlayingGame = $user->games()->where('game_id', $game->id)->wherePivot('status', GamePlayer::STATUS_PLAYING)->first();
            if ($isUserPlayingGame && $isUserPlayingGame->pivot) {
                throw new ErrorException('exception.player_already_playing_this_game');
            }
        }

        if ($game->isPaid()) {
            $this->createGameWallet($user, $game);
            $this->service->createGameTransaction($game, $user);
        }

        if (!$game->checkIfPlayerExists($user->id)) {
            $customData = [
                'user_id' => $user->id,
                'game_id' => $game->id,
                'status' => GamePlayer::STATUS_PLAYING,
                'token' => $gamePlayerToken,
                'token_generated_at' => Carbon::now()
            ];
            $game->players()->attach($user->id, $customData);

            Log::info(__METHOD__ . " -- user: " . auth()->user()->email . " -- Player payload:", $customData);
        } else {
            $game->players()->updateExistingPivot($user->id, [
                'status' => GamePlayer::STATUS_PLAYING,
                'token' => $gamePlayerToken,
                'token_generated_at' => Carbon::now()
            ]);
        }

        return [
            'game_player_token' => $gamePlayerToken,
            'map_data' => $map
        ];
    }

    /**
     * @param User $user
     * @param Game $game
     */
    private function createGameWallet(User $user, Game $game) : void
    {
        $hostUserWallet = null;
        $invitationCodeSender = UserInvitation::where('invitation_code', $user->invitation_code)->first();

        if ($invitationCodeSender) {

            $hostUserWallet = UserGameWallet::where('user_id', $invitationCodeSender->sender_user_id)->where('game_id', $game->id)->first();

            if ($hostUserWallet) {
                Log::info(__METHOD__ . " -- user: " . $hostUserWallet->user->email . " -- User got credit by invitation from user: " . $user->email . " in game: " . $game->name);

                $hostUserWallet->update([
                    'game_id' => $game->id,
                    'credit' => $hostUserWallet->credit + $game->entry_fee
                ]);
            } else {
                $hostUserWallet = UserGameWallet::create([
                    'user_id' => $invitationCodeSender->sender_user_id,
                    'game_id' => $game->id,
                    'credit' => $game->entry_fee
                ]);
            }

            $user->update([
                'invitation_code' => null
            ]);

            $hostUser = $hostUserWallet->user()->first();

            Event::dispatch('game.credit', [$hostUser, $user]);
        }
    }

    /**
     * @param Game $game
     * @return LengthAwarePaginator
     */
    public function scoreboard(Game $game) : LengthAwarePaginator
    {
        return $game->players()
            ->orderBy('highest_score', 'DESC')
            ->orderBy('shortest_duration', 'ASC')
            ->paginate(10);
    }

    /**
     * @param GamePlayer $gamePlayer
     * @return bool
     */
    public function expireGameSession(GamePlayer $gamePlayer): bool
    {
        Log::alert(__METHOD__ . " -- user: " . $gamePlayer->user->email . " -- Game session expired -- game: " . $gamePlayer->game->name);

        return $gamePlayer->update([
            'status' => GamePlayer::STATUS_NOT_PLAYING,
            'token' => null,
            'token_generated_at' => null,
            'number_of_times_played' => $gamePlayer->number_of_times_played + 1
        ]);
    }

    public function checkExpiry(array $data)
    {
        $gamePlayer = GamePlayer::where(['token' => $data['game_session_id']])->first();
        return !isset($gamePlayer);
    }

    public function invitationLink(Game $game)
    {
        $invitation = auth()->user()->invitations()->where(['game_id' => $game->id])->first();
        return isset($invitation) ? $this->frontendBaseUrl . '/register?token=' . $invitation->invitation_code : null;
    }
}
