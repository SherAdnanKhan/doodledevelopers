<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAmountOfBallsToFireToGameConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_configurations', function (Blueprint $table) {
            $table->integer('amount_of_balls_to_fire')->after('max_withdrawal_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_configurations', function (Blueprint $table) {
            $table->dropColumn('amount_of_balls_to_fire');
        });
    }
}
