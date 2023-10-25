<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEditedIncidentEntries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edited_incident_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("fk_IncidentEntryID")->nullable();
            $table->unsignedBigInteger("fk_UserID")->nullable();
            $table->unsignedBigInteger('fk_ChildID')->nullable();

            $table->string('legal_guardian_name')->nullable();
            $table->string('incident_type')->nullable();
            $table->string('serious_occurence')->nullable();
            $table->string('level1_serious_occurence')->nullable();
            $table->date('date_of_incident')->nullable();
            $table->string('time_duration')->nullable();
            $table->date('datetime_report_received')->nullable();
            $table->longText('location_of_incident')->nullable();
            $table->longText('antecedent_leading_to_incident')->nullable();
            $table->longText('description_of_incident')->nullable();
            $table->longText('action_taken')->nullable();
            $table->string('who_was_notified')->nullable();
            $table->longText('physical_injuries')->nullable();
            $table->longText('property_damage')->nullable();
            $table->longText('comments')->nullable();



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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('edited_incident_entries');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
