<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shift_forms', function (Blueprint $table) {
            $table->id();

            $table->dateTime('datetime')->nullable();
            $table->longText('mood_upon_arrival')->nullable();
            $table->longText('interaction_with_staff')->nullable();
            $table->longText('general_observations')->nullable();
            $table->longText('dietary_notes')->nullable();


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
        Schema::dropIfExists('shift_forms');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
