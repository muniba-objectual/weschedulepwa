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
        Schema::create('bank_deposits_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fk_BankDepositID');
            $table->bigInteger('fk_UserID');
            $table->json('details');
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
        Schema::dropIfExists('bank_deposits_details');
    }
};
