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
        Schema::table('children', function (Blueprint $table) {
            $table->bigInteger('pre_admissions_form_id')->nullable();
            $table->bigInteger('preliminary_assessment_form_id')->nullable();
            $table->bigInteger('agreement_and_authorization_form_id')->nullable();
            $table->bigInteger('authorization_for_supervised_activities_form_id')->nullable();
            $table->bigInteger('approval_to_administer_all_medication_form_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('children', function (Blueprint $table) {
            $table->dropColumn('pre_admissions_form_id');
            $table->dropColumn('preliminary_assessment_form_id');
            $table->dropColumn('agreement_and_authorization_form_id');
            $table->dropColumn('authorization_for_supervised_activities_form_id');
            $table->dropColumn('approval_to_administer_all_medication_form_id');
        });
    }
};
