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
        Schema::table('expense_payouts', function (Blueprint $table) {
            $table->string('currency')->nullable()->change();
            $table->dropColumn('status');
            $table->unsignedBigInteger('paid_by_user_id')->nullable()->change();
        });
        Schema::table('expense_payouts', function (Blueprint $table) {
            $table->enum('status', ['pending', 'paid', 'payment failed'])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expense_payouts', function (Blueprint $table) {
            $table->string('currency')->change();
            $table->dropColumn('status');
            $table->unsignedBigInteger('paid_by_user_id')->change();
        });
        Schema::table('expense_payouts', function (Blueprint $table) {
            $table->enum('status', ['pending', 'paid', 'payment failed']);
        });
    }
};
