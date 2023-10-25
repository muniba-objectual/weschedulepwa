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
        Schema::create('expenses_verifiers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('verifier_user_id');
            $table->bigInteger('expense_user_id');
            $table->bigInteger('assigned_by_user_id');
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
        Schema::dropIfExists('expenses_verifiers');
    }
};
