<?php


namespace App\Http\Services\Payouts;

use App\Exceptions\ErrorException;
use App\Http\Services\BaseService;
use App\Models\Game;
use App\Models\GameTransaction;
use App\Models\GameWinnerEarnings;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PayoutService extends BaseService
{
    /**
     * @param Game $game
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function getAll(Game $game, array $data) : LengthAwarePaginator
    {
        $payouts = auth()->user()
            ->gameTransactions()
            ->where('type', GameTransaction::TYPE_PAYOUT)
            ->where('game_id', $game->id);

        if ($data) {
            $payouts->where('status', $data['status']);
        }

        return $payouts->paginate(10);
    }

    /**
     * @param Game $game
     * @return GameTransaction
     * @throws ErrorException
     */
    public function store(Game $game) : GameTransaction
    {
        if ($game->status == Game::STATUS_LIVE) {
            Log::error(__METHOD__ . " -- Game is not finished and user request for payout");
            throw new ErrorException('exception.payout_request_error');
        }

        $userGame = auth()->user()->earnings()->where('game_id', $game->id)->first();

        if (!isset($userGame)) {
            Log::error(__METHOD__ . " -- User played game but didn't earn any reward");
            throw new ErrorException('exception.payout_request_without_game');
        }

        $userGameEarnings = $userGame->pivot;

        if ($userGameEarnings->status == GameWinnerEarnings::STATUS_PENDING) {
            Log::error(__METHOD__ . " -- User already sent request for payout");
            throw new ErrorException('exception.payout_request_sent');
        }

        if ($userGameEarnings->status == GameWinnerEarnings::STATUS_APPROVED) {
            Log::error(__METHOD__ . " -- Payout is already approved");
            throw new ErrorException('exception.payout_request_already_approved');
        }

        $wallet = auth()->user()->wallets()->first();

        try {

            DB::beginTransaction();

            $gameTransaction = $game->gameTransactions()->create([
                'user_id' => auth()->id(),
                'wallet_id' => $wallet->id,
                'wallet_type' => GameTransaction::TYPE_WALLET_USER,
                'amount' => $userGameEarnings->earning,
                'type' => GameTransaction::TYPE_PAYOUT,
                'status' => GameTransaction::STATUS_PENDING
            ]);
            Log::alert(__METHOD__ . " -- Payout Game Transaction:", $gameTransaction->toArray());

            $userGameEarnings->update([
                'status' => GameWinnerEarnings::STATUS_PENDING
            ]);

            DB::commit();

        } catch (\Exception $exception) {
            DB::rollback();
            Log::error(__METHOD__ . " -- Internal error occur in user payout. All transactions rollback");
            throw new ErrorException('exception.internal_payout_error');
        }

        return $gameTransaction;
    }
}
