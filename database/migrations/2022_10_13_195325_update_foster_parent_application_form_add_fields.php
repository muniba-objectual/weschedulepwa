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
            $table->json('additional_telephone_numbers')->nullable();
            $table->longText('secondary_describe_previous_marriage')->nullable();
            $table->longText('secondary_describe_previous_partner_contact')->nullable();




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
            $table->dropColumn('additional_telephone_numbers');


        });
    }
};
