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
        Schema::create('oncall_CYSW', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fk_UserID');
            $table->bigInteger('fk_CYSWID');
            $table->longText('notes');
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
        Schema::dropIfExists('oncall_CYSW');
    }
};
