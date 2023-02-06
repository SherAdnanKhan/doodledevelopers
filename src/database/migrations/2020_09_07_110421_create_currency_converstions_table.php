<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyConverstionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_conversations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('from_currency')->unsigned();
            $table->bigInteger('to_currency')->unsigned();
            $table->double('per_unit_rate');
            $table->timestamps();

            $table->foreign('from_currency')->references('id')->on('currencies')->onDelete('cascade');
            $table->foreign('to_currency')->references('id')->on('currencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currency_conversations');
    }
}
