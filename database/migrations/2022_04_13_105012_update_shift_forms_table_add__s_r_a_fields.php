<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateShiftFormsTableAddSRAFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shift_forms', function (Blueprint $table) {
            $table->boolean('SRA_enabled')->nullable()->default(0);
            $table->dateTime('SRA_datetime')->nullable();
            $table->longText('SRA_activities')->nullable();
            $table->string('SRA_total_hours_worked')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shift_forms', function (Blueprint $table) {
            $table->dropColumn('SRA_enabled');
            $table->dropColumn('SRA_datetime');
            $table->dropColumn('SRA_activities');
            $table->dropColumn('SRA_total_hours_worked');

        });
    }
}
