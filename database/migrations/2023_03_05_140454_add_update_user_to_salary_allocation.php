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
        Schema::table('users_children_history', function (Blueprint $table) {
            $table->integer('updated_by')->unsigned()->after('user_id');
        });
        Schema::table('users_children', function (Blueprint $table) {
            $table->integer('updated_by')->unsigned()->after('users_id');
        });

        //temporary data fix to avoid null point exceptions.
        \DB::table('users_children_history')->update(['updated_by'=>1]);
        \DB::table('users_children')->update(['updated_by'=>1]);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_children_history', function (Blueprint $table) {
            $table->dropColumn('updated_by');
        });
        Schema::table('users_children', function (Blueprint $table) {
            $table->dropColumn('updated_by');
        });
    }
};
