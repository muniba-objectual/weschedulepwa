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
        Schema::table('child_safety_plans', function (Blueprint $table) {
            $table->boolean('is_a_new_plan')->default(true);
            $table->string('version')->default('1.0')->change();
            $table->boolean('ready_for_review')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('child_safety_plans', function (Blueprint $table) {
            $table->dropColumn(['ready_for_review','is_a_new_plan']);
            $table->string('version')->change();
        });
    }
};
