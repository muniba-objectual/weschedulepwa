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
        Schema::create('expense_payouts', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 12);
            $table->string('currency');
            $table->enum('status', ['pending', 'paid', 'payment failed']);
            $table->unsignedBigInteger('paid_by_user_id');
            $table->unsignedBigInteger('paid_to_user_id');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            // Add foreign key constraints
//            $table->foreign('paid_by_user_id')->references('id')->on('users')->onDelete('cascade');
//            $table->foreign('paid_to_user_id')->references('id')->on('users')->onDelete('cascade');
//            $table->foreign('expense_id')->references('id')->on('expenses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expense_payouts');
    }
};
