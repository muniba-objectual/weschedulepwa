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
        Schema::create('oncall', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fk_UserID');
            $table->bigInteger('fk_HomeID');
            $table->bigInteger('fk_ChildID');
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
        Schema::dropIfExists('oncall');
    }
};
