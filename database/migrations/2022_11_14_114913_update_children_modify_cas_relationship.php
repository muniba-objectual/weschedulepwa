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
        Schema::table('children', function(Blueprint $table) {
            $table->renameColumn('CAS_fk_UserID', 'fk_CASAgencyID');
            $table->bigInteger('fk_CASAgencyWorkerID')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('children', function(Blueprint $table) {
            $table->renameColumn('fk_CASAgencyID', 'CAS_fk_UserID');
            $table->dropColumn('fk_CASAgencyWorkerID');
        });    }
};
