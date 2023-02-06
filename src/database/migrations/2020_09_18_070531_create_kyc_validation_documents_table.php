<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKycValidationDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kyc_validation_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('kyc_validation_id')->unsigned();
            $table->string('filename');
            $table->string('link');
            $table->string('type');
            $table->timestamps();

            $table->foreign('kyc_validation_id')->references('id')->on('kyc_validations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kyc_validation_documents');
    }
}
