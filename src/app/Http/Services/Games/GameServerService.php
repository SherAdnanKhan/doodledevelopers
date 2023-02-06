<?php
namespace App\Http\Services\Games;

use App\Exceptions\ErrorException;
use App\GamePlayerState;
use App\Models\GamePlayerAttemptScore;
use App\Http\Services\BaseService;
use App\Models\Game;
use App\Models\GamePlayer;
use App\Models\GamePlayerScore;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GameServerService extends BaseService
{
    /**
     * @var Repository|Application|mixed
     */
    private $baseUrl;

    public function __construct ()
    {
        $this->baseUrl = config('app.client_url');
    }

    /**
     * @param array $data
     * @return GamePlayerScore
     */
    public function addOrUpdateScore(array $data) : GamePlayerScore
    {
        $gamePlayer = GamePlayer::where('token', $data['game_player_token'])->first();
        $player = $gamePlayer->user()->first();
        $gamePlayerScore = GamePlayerScore::where([
            'game_id' => $gamePlayer->game_id,
            'user_id' => $gamePlayer->user_id,
            'play_id' => $gamePlayer->number_of_times_played
        ])->first();

        if (!isset($gamePlayerScore)) {
            $player->scores()->attach($gamePlayer->game_id, [
                'play_id' => $gamePlayer->number_of_times_played,
                'score' => $data['score'],
                'duration' => $data['duration']
            ]);
            $gamePlayerScore = GamePlayerScore::where([
                'game_id' => $gamePlayer->game_id,
                'user_id' => $gamePlayer->user_id,
                'play_id' => $gamePlayer->number_of_times_played
            ])->first();
        }

        if ($data['score'] > $gamePlayer->highest_score || ($data['score'] === $gamePlayer->highest_score && $data['duration'] < $gamePlayer->shortest_duration)) {
            $gamePlayer->highest_score = $data['score'];
            $gamePlayer->shortest_duration = $data['duration'];
            $gamePlayer->save();
            $gamePlayerScore->score = $data['score'];
            $gamePlayerScore->duration = $data['duration'];
            $gamePlayerScore->save();
        }

        if ($data['attempt_number'] == $gamePlayer->game->total_attempts) {
            $gamePlayer->status = GamePlayer::STATUS_NOT_PLAYING;
            $gamePlayer->number_of_times_played += 1;
            $gamePlayer->token = null;
            $gamePlayer->token_generated_at = null;
            $gamePlayer->save();

            if ($gamePlayer->number_of_times_played == 5) {
                Log::info(__METHOD__ . " -- user: " . $player->email . " -- Five times game played, Invitation link generated in game: " . $gamePlayer->game->name);
                $invitationCode = (string)Str::orderedUuid();
                $player->invitations()->create([
                    'game_id' => $gamePlayer->game_id,
                    'invitation_code' => $invitationCode
                ]);

                Event::dispatch('user.invitation', [$player, $gamePlayer->game, $invitationCode]);            }
        }

        return $gamePlayerScore;
    }

    /**
     * @param Game $game
     * @return string|null
     */
    public function invitationLink(Game $game) : ?string
    {
        $player = $game->players()
            ->where('user_id', $game->pivot->user_id)
            ->first();
        $invitation = $player->invitations()->where(['game_id' => $game->id])->first();
        return isset($invitation) ? $this->baseUrl . '/register?token=' . $invitation->invitation_code : null;
    }

    public function addAttemptScore(array $data)
    {
        Log::info(__METHOD__ . " -- Server request to add user attempt score in game:", $data);

        $gamePlayer = GamePlayer::where('token', $data['game_player_token'])->first();

        $game = $gamePlayer->game()->first();

        if ($data['attempt_number'] > $game->total_attempts) {
            Log::error(__METHOD__ . " -- Game for which the server request to add wrong attempt number");
            throw new ErrorException('exception.attempt_number_greater_than_limit_error', ['totalAttempts' => $game->total_attempts]);
        }

        if (!$game->isLive()) {
            Log::error(__METHOD__ . " -- Game for which the server request to add attempt score when game is not live");
            throw new ErrorException('exception.game_not_live');
        }

        if ($gamePlayer->status !== GamePlayer::STATUS_PLAYING) {
            Log::error(__METHOD__ . " -- Server request to add user attempt score without playing game");
            throw new ErrorException('exception.inserting_score_before_playing_game');
        }

        $maxAttempNo = GamePlayerAttemptScore::where([
            'play_id' => $gamePlayer->number_of_times_played,
            'user_id' => $gamePlayer->user_id,
            'game_id' => $gamePlayer->game_id
        ])->max('attempt_number');

        if ($data['attempt_number'] !== $maxAttempNo + 1) {
            Log::error(__METHOD__ . " -- Server request to add user attempt score invalid order");
            throw new ErrorException('exception.inserting_attemp_score_invalid_order', ['attemptNo' => $maxAttempNo + 1]);
        }

        $player = $gamePlayer->user()->first();
        $playerAttemptScoreSame = GamePlayerAttemptScore::where([
            'play_id' => $gamePlayer->number_of_times_played,
            'attempt_number' => $data['attempt_number'],
            'user_id' => $gamePlayer->user_id,
            'game_id' => $gamePlayer->game_id
        ])->first();

        if ($playerAttemptScoreSame) {
            Log::error(__METHOD__ . " -- Server request to add user attempt score with same attempt number");
            throw new ErrorException('exception.inserting_score_with_same_attempt_number');
        }

        $this->addOrUpdateScore($data);

        $player->attemptScores()->attach($gamePlayer->game_id, [
            'play_id' => $gamePlayer->number_of_times_played,
            'attempt_number' => $data['attempt_number'],
            'score' => $data['score'],
            'duration' => $data['duration']
        ]);

        $gamePlayer = $player->attemptScores()->latest('game_player_attempt_scores.id')->first();

        Log::info(__METHOD__ . " -- Server request to add user attempt score success: ", $data);

        return $gamePlayer;
    }

    public function getGameMap(array $data)
    {
        $gamePlayer = GamePlayer::where('token', $data['game_player_token'])->first();

        $game = $gamePlayer->game()->first();
        $map = $game->maps()->first()->map->toArray();

        $map['data']['amount_of_balls_to_fire'] = $game->amount_of_balls_to_fire;
        $map['data']['total_attempts'] = $game->total_attempts;
        $map['data']['times_played'] = GamePlayerAttemptScore::where([
            'user_id' => $gamePlayer->user->id,
            'game_id' => $game->id,
            'play_id' => $gamePlayer->number_of_times_played
        ])->count();

        return $map;
    }

    public function addOrUpdateGamePlayerState(array $data)
    {
        return GamePlayerState::updateOrCreate(
            [
                'token' => $data['token']
            ],
            [
                'state' => $data['state']
            ]
        );
    }

    /**
     * @param array $data
     * @return array
     */
    public function getGamePlayerState(array $data)
    {
        return GamePlayerState::where(['token' => $data['token']])->latest()->first();
    }
}
