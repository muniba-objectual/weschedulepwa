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
        Schema::create('child_safety_plan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fk_ChildID');

            //Emergency Contacts
            $table->text('Foster_Parent_Name')->nullable();
            $table->text('Foster_Parent_Address')->nullable();
            $table->text('Foster_Parent_Phone')->nullable();
            $table->text('Case_Manager')->nullable();

            //Identifying Information
            $table->text('Name')->nullable();
            $table->text('DOB')->nullable();
            $table->text('DOA')->nullable();
            $table->text('Status')->nullable();
            $table->text('CSW')->nullable();
            $table->text('Branch')->nullable();

            //Medical Information
            $table->text('Health_Card')->nullable();
            $table->text('Physician')->nullable();
            $table->longText('Allergies')->nullable();
            $table->longText('Food_Restrictions')->nullable();
            $table->longText('Medical_Condition')->nullable();
            $table->longText('Medication')->nullable();
            $table->longText('PRNs')->nullable();
            $table->longText('Diagnosed_With')->nullable();

            $table->longText('Risk_of_Injury_Behaviour')->nullable();
            $table->longText('Description_of_Specific_Behaviours')->nullable();
            $table->longText('Triggers')->nullable();
            $table->longText('Indicators')->nullable();
            $table->longText('Non-Physical_Responses')->nullable();
            $table->longText('Physical_Responses')->nullable();
            $table->longText('Additional_Information')->nullable();


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
        Schema::dropIfExists('child_safety_plan');

    }
};
