<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateGameWinnerEarningsRenameColumnEarningPercentageToEarning extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_winner_earnings', function (Blueprint $table) {
            $table->renameColumn('earning_percentage', 'earning');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_winner_earnings', function (Blueprint $table) {
            $table->renameColumn('earning', 'earning_percentage');
        });
    }
}
