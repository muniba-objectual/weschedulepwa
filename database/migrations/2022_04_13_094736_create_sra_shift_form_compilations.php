<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSraShiftFormCompilations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SRA_shift_form_compilations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fk_UserID')->nullable();
            $table->bigInteger('fk_ChildID')->nullable();
            $table->string('month')->nullable();
            $table->date('date_of_approved_SRA')->nullable();
            $table->longText('entry_body')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('SRA_shift_form_compilations', function (Blueprint $table) {
            Schema::dropIfExists('SRA_shift_form_compilations');

        });
    }
}
