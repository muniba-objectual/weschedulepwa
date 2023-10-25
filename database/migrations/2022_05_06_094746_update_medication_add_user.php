<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMedicationAddUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medication_entries', function (Blueprint $table) {
            $table->bigInteger('fk_UserID')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medication_entries', function (Blueprint $table) {
            $table->dropColumn('fk_UserID');
        });
    }
}
