<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOncallUserPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oncall_user', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedBigInteger('oncall_id')->index();
//            $table->foreign('oncall_id')->references('id')->on('oncall')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->index();
//            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
//            $table->primary(['oncall_id', 'user_id']);
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
        Schema::dropIfExists('oncall_user');
    }
}
