<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityPhotos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_photos', function (Blueprint $table) {
            $table->id();


            $table->longText('photo')->nullable();

            $table->unsignedBigInteger('fk_ChildID')->nullable();
            $table->foreign('fk_ChildID')->references('id')->on('children');

            $table->unsignedBigInteger('fk_UserID')->nullable();
            $table->foreign('fk_UserID')->references('id')->on('users');

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
        Schema::dropIfExists('activity_photos');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
