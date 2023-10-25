<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('children', function (Blueprint $table) {
            $table->bigInteger('CaseManager_fk_UserID')->nullable(); // Case Manage - Assigned Case Manager
            $table->bigInteger('CAS_fk_UserID')->nullable();  // Case Manage - Assigned CAS
            $table->bigInteger('FosterHome_fk_UserID')->nullable();  // Case Manage - Assigned Foster Home



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('children', function (Blueprint $table) {
            $table->dropColumn('CaseManager_fk_UserID');
            $table->dropColumn('CAS_fk_UserID');
            $table->dropColumn('FosterHome_fk_UserID');

        });
    }
};
