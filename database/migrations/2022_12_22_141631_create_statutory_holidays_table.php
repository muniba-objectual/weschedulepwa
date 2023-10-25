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
        Schema::create('statutory_holidays', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->text('nameEn');
            $table->text('nameFr');
            $table->integer('federal');
            $table->date('observedDate');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statutory_holidays');
    }
};
