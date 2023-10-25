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
            $table->integer('version')->default(1);
            $table->bigInteger('previous_version_id')->nullable();
            $table->boolean('ready_for_safety_plan')->default(false);
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
            $table->dropColumn('version');
            $table->dropColumn('previous_version_id');
            $table->dropColumn('ready_for_safety_plan');
        });
    }
};
