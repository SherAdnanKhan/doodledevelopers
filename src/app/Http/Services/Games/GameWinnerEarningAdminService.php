<?php

namespace App\Http\Services\Games;

use App\Http\Services\BaseService;
use App\Models\Game;
use App\Models\GameTransaction;

class GameWinnerEarningAdminService extends BaseService
{
    private $game;
    private $adminFeePercent = 0;
    private $adminPotValue = 0;
    private $numberOfPlayers = 0;
    private $numberOfWinners = 0;
    private $winners = [];
    private $jackpotTarget = 0;
    private $endPotValue = 0;
    private $remainingPot = 0;
    private $topFivePot = 0;

    private function setup(Game $game) {

        $this->game = $game;
        $this->adminFeePercent = $game->game_fee_percentage;
        $this->adminPotValue = 0;
        $this->numberOfPlayers = $game->number_of_players;
        $this->numberOfWinners = $game->number_of_winners;
        $this->winners = [];
        $this->jackpotTarget = $game->jackpot_value;
        $this->endPotValue = $this->remainingPot = $game->pot_value;
        $this->topFivePot = 0;

        // Jackpot Target + 50%
        $this->multiPayMinimum = ((50/100) * $this->jackpotTarget) + $this->jackpotTarget;

        // Setup admin pot value here as applies to all outcomes below
        $this->adminPotValue = ($this->adminFeePercent/100) * $this->endPotValue;
        $this->remainingPot -= $this->adminPotValue;

        $i = 1;
        while ($i <= $this->numberOfPlayers) {
            $this->winners[$i] = 0;
            $i++;
        }

    }

    public function getWinners() {
        return $this->winners;
    }

    public function getAdminPotValue() {
        return $this->adminPotValue;
    }

    public function getRemainingPot() {
        return $this->remainingPot;
    }

    /**
     * @param Game $game
     */
    public function calculateUserEarning(Game $game)
    {
        $this->setup($game);
        $this->calculateEarning();
    }

    /**
     * @param Game $game
     */
    public function calculateAdminEarning(Game $game)
    {
        if($game->status == Game::STATUS_FINISHED) {
            return $game->gameTransactions()
                ->where('type', GameTransaction::TYPE_EARN)
                ->where('user_id', auth()->id())
                ->value('amount');
        }

        $this->setup($game);
        $this->calculateEarning();
    }

    public function calculateEarning()
    {
        if ($this->endPotValue <= $this->jackpotTarget) {
            $this->singlePay();
        } elseif ($this->endPotValue <= $this->multiPayMinimum) {
            $this->triplePay();
        } elseif ($this->endPotValue > $this->multiPayMinimum) {

            $megaPayMinimum = (20/100) * $this->remainingPot;

            if ($megaPayMinimum >= $this->jackpotTarget) {
                $this->winners[1] = floor((25/100) * $this->remainingPot);
            } else {
                $this->winners[1] = floor($this->jackpotTarget);
            }

            $this->remainingPot -= $this->winners[1];

            $this->topFivePot = (50/100) * $this->remainingPot;
    
            $this->calculateTopFiveWinners();
            $this->splitRemaining();

        }

        // Sweep up remaining pot (left overs and division remainders) into adminPot
        $this->adminPotValue += $this->remainingPot;
    }

    private function singlePay()
    {
        $this->winners[1] = floor($this->remainingPot);
        $this->remainingPot -= $this->winners[1];
    }

    private function triplePay()
    {
        if ($this->remainingPot >= $this->jackpotTarget) {

            $this->winners[1] = $this->jackpotTarget;
            $this->remainingPot -= $this->jackpotTarget;

            if ($this->remainingPot >= 2) {

                if ( $this->numberOfPlayers >= 3 ) {

                    $runnerUpWinnings = floor($this->remainingPot / 2);
                    $this->winners[2] = $this->winners[3] = $runnerUpWinnings;
                    $this->remainingPot -= ($runnerUpWinnings * 2);

                } elseif ( $this->numberOfPlayers == 2 ) {

                    $this->winners[2] = floor($this->remainingPot);
                    $this->remainingPot -= $this->winners[2];

                }

            } 

        } else {
            $this->winners[1] = floor($this->remainingPot);
            $this->remainingPot -= $this->winners[1];
        }
    }


    private function calculateTopFiveWinners()
    {
        $payoutStructureRules = [
            1 => [],
            2 => [100],
            3 => [70, 30],
            4 => [50, 30, 20],
            5 => [40, 30, 18, 12]
        ];

        $payoutStructure = $this->numberOfPlayers < 5 ? $this->numberOfPlayers : 5;

        $i = 2;
        foreach ($payoutStructureRules[$payoutStructure] as $p) {
            $amount = ($p / 100) * $this->topFivePot;
            $this->winners[$i] = floor($amount);
            $this->remainingPot -= $this->winners[$i];
            $i++;
        }
    }

    private function splitRemaining()
    {
        $remainingWinners = $this->numberOfWinners;

        if ( $this->numberOfPlayers < $this->numberOfWinners )
            $remainingWinners = $this->numberOfPlayers;
        
        $remainingWinners = abs($remainingWinners - 5);

        $winningAmount = 0;
        
        if ( $remainingWinners >= 1 )
            $winningAmount = floor($this->remainingPot / $remainingWinners);

        if ( $winningAmount < 1 )
            return;

        for ( $i = 6; $i <= $remainingWinners; $i++ ) {
            $winners[$i] = $winningAmount;
            $this->remainingPot -= $winners[$i];
        }
    }
}
