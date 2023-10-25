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
        Schema::create('medication_profile', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fk_ChildID');
            $table->bigInteger('fk_UserID'); //Who created the entry
            $table->string('type')->default(null);
            $table->string('dosage')->default(null);
            $table->unique(['type', 'dosage']);

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
        Schema::dropIfExists('medication_profile');
    }
};
