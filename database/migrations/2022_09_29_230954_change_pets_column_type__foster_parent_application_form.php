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
        Schema::table('foster_parent_application_form', function (Blueprint $table) {
            $table->JSON('family_pets')->change();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('foster_parent_application_form', function (Blueprint $table) {
            $table->longText('family_pets')->change();
        });
    }
};
