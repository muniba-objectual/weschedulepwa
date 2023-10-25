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
        Schema::create('module_chat', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fk_UserID');
            $table->text('model');
            $table->bigInteger('fk_ModelID');
            $table->longText('note');





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
        Schema::dropIfExists('module_chat');
    }
};
