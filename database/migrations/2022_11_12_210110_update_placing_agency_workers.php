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
        Schema::dropIfExists('placing_agencies_case_workers');

        Schema::create('placing_agencies_workers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fk_PlacingAgencyID');
            $table->enum('type',['Finance Worker', 'Children Service Worker', 'Family Service Worker'])->nullable;
            $table->text('name')->nullable;
            $table->text('email')->nullable;
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
        Schema::dropIfExists('placing_agencies_case_workers');

    }
};
