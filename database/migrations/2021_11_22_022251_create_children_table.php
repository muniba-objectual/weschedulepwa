<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildrenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('children', function (Blueprint $table) {
            $table->id();
            $table->string('initials')->nullable();
            $table->date('DOB')->nullable();
            $table->longText('notes')->nullable();
            $table->unsignedBigInteger('fk_HomeID')->nullable();

            $table->foreign('fk_HomeID')->references('id')->on('homes');

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
        Schema::dropIfExists('children');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');    }
}
