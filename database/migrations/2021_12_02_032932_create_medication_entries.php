<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicationEntries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medication_entries', function (Blueprint $table) {


            $table->id();
            $table->string('medication_type')->nullable();
            $table->string('dosage')->nullable();
            $table->dateTime('date_time')->nullable();
            $table->string('compliance')->nullable();
            $table->boolean('taken_with_food')->nullable();
            $table->boolean('PRN')->nullable();
            $table->string('photo')->nullable();
            $table->unsignedBigInteger('fk_ChildID')->nullable();

            $table->foreign('fk_ChildID')->references('id')->on('children');
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('medication_entries');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
