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
        Schema::create('cm_child_profile', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fk_ChildID');
            $table->text('legal_name')->nullable();
            $table->text('preferred_name')->nullable();
            $table->text('pronoun')->nullable();
            $table->text('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('health_card_number')->nullable();
            $table->text('green_shield_number')->nullable();
            $table->date('date_admitted_carpediem')->nullable();
            $table->date('date_admitted_fosterhome')->nullable();
            $table->date('date_readmitted_carpediem')->nullable();
            $table->text('legal_status')->nullable();
            $table->date('discharge_date')->nullable();
            $table->boolean('is_sibling_group')->nullable()->default(false);
            $table->json('school_info')->nullable();
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
        Schema::dropIfExists('cm_child_profile');

    }
};
