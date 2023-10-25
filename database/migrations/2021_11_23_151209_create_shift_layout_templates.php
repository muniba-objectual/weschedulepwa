<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftLayoutTemplates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shift__layout__templates', function (Blueprint $table) {
            $table->id();
            $table->string('day_of_week')->nullable();
            $table->unique(['day_of_week', 'fk_UserID', 'start_time', 'end_time'])->constrained()->index('uniqueShift');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            $table->unsignedBigInteger('fk_UserID')->nullable();
            $table->unsignedBigInteger('fk_ChildID')->nullable();

            $table->foreign('fk_UserID')->references('id')->on('users');
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
        Schema::dropIfExists('shift__layout__templates');
    }
}
