<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFosterParentApplicationForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('foster_parent_application_form');

        Schema::create('foster_parent_application_form', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("fk_UserID")->nullable();
            $table->text('primary_caregiver_fullname')->nullable();
            $table->text('partner_fullname')->nullable();
            $table->text('mailing_address')->nullable();
            $table->text('city')->nullable();
            $table->text('province')->nullable();
            $table->text('postal_code')->nullable();
            $table->text('telephone')->nullable();
            $table->text('email')->nullable();
            $table->json('family_members')->nullable();
            $table->longText('family_pets')->nullable();


            $table->longText('describe_home')->nullable();
            $table->longText('describe_backyard')->nullable();
            $table->longText('basement_apartment')->nullable();
            $table->longText('describe_schools')->nullable();


            $table->longText('describe_physical_personality_applicants')->nullable();
            $table->longText('describe_parents')->nullable();

            $table->longText('personal_history_applicants')->nullable();

            $table->longText('describe_partner')->nullable();
            $table->longText('personal_history_primary_caregiver')->nullable();
            $table->longText('personal_history_partner')->nullable();

            $table->longText('primary_caregiver_education')->nullable();
            $table->longText('primary_caregiver_employment')->nullable();

            $table->longText('partner_education')->nullable();
            $table->longText('partner_employment')->nullable();

            $table->longText('partner_describe_relationship')->nullable();
            $table->longText('partner_length_of_relationship')->nullable();

            $table->longText('describe_previous_marriage')->nullable();
            $table->longText('describe_previous_partner_contact')->nullable();

            $table->longText('describe_discipline')->nullable();
            $table->longText('describe_communication')->nullable();

            $table->longText('describe_problem_solving')->nullable();
            $table->longText('problem_solving_example')->nullable();

            $table->longText('pattern_daily_living')->nullable();

            $table->longText('describe_experience_cultures')->nullable();

            $table->longText('open_willing_other_backgrounds')->nullable();

            $table->longText('primary_religious_affiliation')->nullable();
            $table->longText('primary_spiritual_practices')->nullable();


            $table->longText('partner_religious_affiliation')->nullable();
            $table->longText('partner_spiritual_practices')->nullable();

            $table->longText('special_skills')->nullable();
            $table->longText('describe_pursuing_fostering')->nullable();

            $table->longText('primary_income_source')->nullable();
            $table->longText('primary_debt_management')->nullable();
            $table->longText('primary_bill_management')->nullable();

            $table->longText('partner_income_source')->nullable();
            $table->longText('partner_debt_management')->nullable();
            $table->longText('partner_bill_management')->nullable();

            $table->text('fulltime_parttime')->nullable();
            $table->longText('list_strengths')->nullable();
            $table->longText('record_check_CAS')->nullable();
            $table->longText('record_check_VSP')->nullable();


            $table->boolean('has_drivers_license')->nullable();
            $table->date('date');





            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('foster_parent_application_form');
    }
}
