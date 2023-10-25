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
            $table->bigInteger('verified_by')->unsigned()->nullable();
            $table->timestamp('verified_at')->nullable();
        });
        //data patch for existing data
        \DB::statement('update expenses set verified_at = created_at, verified_by = 1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn('verified_by');
            $table->dropColumn('verified_at');
        });
    }
};
