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
        Schema::create('credit_cards', function (Blueprint $table) {
            $table->id();
            $table->string('card_number');
            $table->string('cardholder_name');
            $table->string('expiration_month');
            $table->string('expiration_year');
            $table->string('cvv');
            $table->string('billing_zip');
            $table->string('card_brand');
            $table->string('card_type');$table->unsignedBigInteger('user_id'); // Add the user_id foreign key
            $table->timestamps();


            // Mark some fields as not nullable
//            $table->string('card_number')->nullable(false)->change();
            $table->string('cardholder_name')->nullable(false)->change();
            $table->string('expiration_month')->nullable(false)->change();
            $table->string('expiration_year')->nullable(false)->change();
            $table->string('cvv')->nullable(false)->change();
            $table->string('billing_zip')->nullable(false)->change();
            $table->string('card_brand')->nullable(false)->change();
            $table->string('card_type')->nullable(false)->change();


            // Add the foreign key constraint
//            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credit_cards');
    }
};
