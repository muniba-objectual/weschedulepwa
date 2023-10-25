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
            $table->tinyInteger('form_stage')->default(0);
        });
    }

    public function down()
    {
        Schema::table('child_safety_plans', function (Blueprint $table) {
            $table->dropColumn('form_stage');
        });
    }
};
