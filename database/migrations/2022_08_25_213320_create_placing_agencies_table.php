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
        Schema::create('placing_agencies', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable;
            $table->text('address')->nullable;
            $table->text('city')->nullable;
            $table->text('province')->nullable;
            $table->text('postal')->nullable;
            $table->text('telephone')->nullable;
            $table->longText('notes')->nullable;


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
        Schema::dropIfExists('placing_agencies');
    }
};
