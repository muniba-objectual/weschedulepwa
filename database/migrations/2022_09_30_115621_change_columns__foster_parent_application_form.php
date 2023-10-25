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
            $table->longText('describe_parents_secondary')->nullable();
            $table->longText('personal_history_secondary')->nullable();
            $table->longText('secondary_caregiver_education')->nullable();
            $table->longText('secondary_caregiver_employment')->nullable();
            $table->longText('secondary_religious_affiliation')->nullable();
            $table->longText('secondary_spiritual_practices')->nullable();
            $table->longText('secondary_income_source')->nullable();
            $table->longText('secondary_debt_management')->nullable();
            $table->longText('secondary_bill_management')->nullable();


            $table->dropColumn('personal_history_partner');
            $table->dropColumn('partner_religious_affiliation');
            $table->dropColumn('partner_spiritual_practices');
            $table->dropColumn('partner_income_source');
            $table->dropColumn('partner_debt_management');
            $table->dropColumn('partner_bill_management');



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
