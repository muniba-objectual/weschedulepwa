<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->string('title'); //used for calendar title
            $table->datetime('start');
            $table->datetime('end');
            $table->string('status')->default('Pending'); //Pending; Started; Ended - Incomplete; Ended - Pending Verification; Complete
            $table->unsignedBigInteger('fk_UserID');

            $table->timestamps();

           // $table->unsignedBigInteger('fk_ShiftID')->nullable();
            $table->dateTime('actual_shift_start')->nullable();
            $table->dateTime('actual_shift_end')->nullable();
            $table->unsignedBigInteger('fk_ShiftFormID')->nullable();
            $table->foreign('fk_ShiftformID')->references('id')->on('shift_forms')->onDelete('cascade')->onUpdate('cascade');
           // $table->unsignedBigInteger('fk_MedicationFormID')->nullable();
           // $table->foreign('fk_MedicationFormID')->references('id')->on('medication_forms');

            $table->unsignedBigInteger('fk_ChildID')->nullable();
            $table->foreign('fk_ChildID')->references('id')->on('children');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('shifts');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
