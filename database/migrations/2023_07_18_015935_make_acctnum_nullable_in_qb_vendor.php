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
        Schema::table('qb_vendors', function (Blueprint $table) {
            $table->string('AcctNum', 100)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('qb_vendors', function (Blueprint $table) {
            $table->string('AcctNum', 100)->nullable(false)->change();
        });
    }
};
