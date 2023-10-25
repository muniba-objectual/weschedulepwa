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
            $table->text('type_of_family')->nullable();
            $table->text('country_of_birth')->nullable();
            $table->text('city_of_birth')->nullable();
            $table->text('relationship')->nullable();



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
            $table->dropColumn('type_of_family');
            $table->dropColumn('country_of_birth');
            $table->dropColumn('city_of_birth');
            $table->dropColumn('relationship');

        });
    }
};
