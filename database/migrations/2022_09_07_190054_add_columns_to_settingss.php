<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToSettingss extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('intro');
            $table->string('contact_us_text');
            $table->string('mobile_app_text');
            $table->string('mobile_app_android_link');
            $table->string('mobile_app_ios_link');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('intro');
            $table->dropColumn('contact_us');
            $table->dropColumn('mobile_app_text');
            $table->dropColumn('mobile_app_android_link');
            $table->dropColumn('mobile_app_ios_link');
        });
    }
}
