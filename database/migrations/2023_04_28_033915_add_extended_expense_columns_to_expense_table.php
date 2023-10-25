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
        Schema::table('expenses', function (Blueprint $table) {
            $table->enum('payment_type', ['coppany-credit-card', 'unspecified'])->after('datetime')->default('unspecified')->index();
            $table->unsignedBigInteger('credit_card_id')->after('payment_type')->nullable();
            $table->string('last_four_digits')->after('credit_card_id')->nullable();
            $table->unsignedBigInteger('expense_payout_id')->after('last_four_digits')->nullable();
            $table->boolean('is_tampered')->after('expense_payout_id')->default(false)->comment('0=>no,1=>yes');
            $table->boolean('is_override_totals')->after('is_tampered')->default(false)->comment('0=>no,1=>yes');

            $table->index(['payment_type', 'last_four_digits']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn(['payment_type', 'credit_card_id', 'last_four_digits', 'expense_payout_id', 'is_tampered', 'is_override_totals']);
        });
    }
};
