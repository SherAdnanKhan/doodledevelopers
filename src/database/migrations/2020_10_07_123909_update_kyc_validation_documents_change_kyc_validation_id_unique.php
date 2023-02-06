<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateKycValidationDocumentsChangeKycValidationIdUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kyc_validation_documents', function (Blueprint $table) {
            $table->unique('kyc_validation_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('kyc_validation_documents', function (Blueprint $table) {
            $table->dropUnique('kyc_validation_documents_kyc_validation_id_unique');
        });
        Schema::enableForeignKeyConstraints();
    }
}
