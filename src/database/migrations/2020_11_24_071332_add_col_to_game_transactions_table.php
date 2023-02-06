<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColToGameTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_transactions', function (Blueprint $table) {
            $table->dropForeign(['wallet_id']);
            $table->dropColumn('wallet_id');
        });

        Schema::table('game_transactions', function (Blueprint $table) {
            $table->unsignedInteger("wallet_id")->after('game_id');
            $table->string("wallet_type")->after('wallet_id');
            $table->index(["wallet_id", "wallet_type"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_transactions', function (Blueprint $table) {
           $table->dropIndex('game_transactions_wallet_id_wallet_type_index');
        });
    }
}
