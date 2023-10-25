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
        Schema::create('CarpeDiem_Notes', function (Blueprint $table) {

            $table->id();
            $table->bigInteger('fk_UserID');
            $table->bigInteger('fk_ChildID');
            $table->longText('entry_notes');

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
        Schema::dropIfExists('CarpeDiem_Notes');

    }
};
