<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayerGameHighestScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_game_highest_scores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('game_player_id')->unsigned();
            $table->integer('score');
            $table->double('duration');
            $table->timestamps();

            $table->foreign('game_player_id')->references('id')->on('game_players')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('player_game_highest_scores');
    }
}
