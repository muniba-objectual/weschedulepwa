<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateShiftTableAddValidationField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shifts', function (Blueprint $table) {
            $table->boolean('validated')->nullable()->default(false);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shifts', function (Blueprint $table) {
            $table->dropColumn('validated');
        });
    }
}
