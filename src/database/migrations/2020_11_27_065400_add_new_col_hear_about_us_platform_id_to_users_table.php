<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColHearAboutUsPlatformIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('hear_about_us_platform_id')->unsigned()->nullable()->after('is_admin');
            $table->foreign('hear_about_us_platform_id')->references('id')->on('hear_about_us_platforms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['hear_about_us_platform_id']);
            $table->dropColumn('hear_about_us_platform_id');
        });
    }
}
