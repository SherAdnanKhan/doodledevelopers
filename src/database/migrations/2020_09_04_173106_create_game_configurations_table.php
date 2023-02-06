<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_configurations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('currency_conversion_duration');
            $table->double('min_deposit_amount');
            $table->double('max_deposit_amount');
            $table->double('min_withdrawal_amount');
            $table->double('max_withdrawal_amount');
            $table->boolean('maintenance_mode')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_configurations');
    }
}
