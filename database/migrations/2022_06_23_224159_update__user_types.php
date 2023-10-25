<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user__types', function (Blueprint $table) {

           // $table->dropForeign(['users_user_type_foreign']);
            $table->decimal('type',3,1)->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user__types', function (Blueprint $table) {
            //
        });
    }
}
