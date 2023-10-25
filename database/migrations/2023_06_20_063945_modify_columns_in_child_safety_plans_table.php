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
            $table->string('version')->change();
            $table->string('previous_version_id')->nullable()->change();
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
            $table->integer('version')->change();
            $table->integer('previous_version_id')->nullable()->change();
        });
    }
};
