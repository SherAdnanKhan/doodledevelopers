<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGameIdColToUserInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_invitations', function (Blueprint $table) {
            $table->dropForeign(['game_player_id']);
            $table->dropColumn('game_player_id');

            $table->bigInteger('game_id')->unsigned()->nullable()->after('sender_user_id');
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_invitations', function (Blueprint $table) {
            $table->bigInteger('game_player_id')->unsigned()->nullable()->after('sender_user_id');
            $table->foreign('game_player_id')->references('id')->on('game_players')->onDelete('cascade');

            $table->dropForeign(['game_id']);
            $table->dropColumn('game_id');
        });
    }
}
