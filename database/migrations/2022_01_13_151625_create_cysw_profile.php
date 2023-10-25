<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCyswProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CYSW_Profile', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('cellular')->nullable();
            $table->string('monday')->nullable();
            $table->string('tuesday')->nullable();
            $table->string('wednesday')->nullable();
            $table->string('thursday')->nullable();
            $table->string('friday')->nullable();
            $table->string('saturday')->nullable();
            $table->string('sunday')->nullable();


            $table->string('resume_attachment')->nullable();

            $table->string('reference_1_name')->nullable();
            $table->string('reference_1_phone')->nullable();
            $table->string('reference_1_email')->nullable();
            $table->string('reference_1_attachment')->nullable();

            $table->string('reference_2_name')->nullable();
            $table->string('reference_2_phone')->nullable();
            $table->string('reference_2_email')->nullable();
            $table->string('reference_2_attachment')->nullable();

            $table->string('reference_3_name')->nullable();
            $table->string('reference_3_phone')->nullable();
            $table->string('reference_3_email')->nullable();
            $table->string('reference_3_attachment')->nullable();

            $table->string('diploma_certificate_1_attachment')->nullable();
            $table->string('diploma_certificate_2_attachment')->nullable();
            $table->string('diploma_certificate_3_attachment')->nullable();
            $table->string('diploma_certificate_4_attachment')->nullable();
            $table->string('diploma_certificate_5_attachment')->nullable();

            $table->string('criminal_reference_1_attachment')->nullable();
            $table->string('criminal_reference_2_attachment')->nullable();

            $table->string('carpe_diem_confidentiality_attachment')->nullable();
            $table->string('carpe_diem_release_information_attachment')->nullable();
            $table->string('child_welfare_check_attachment')->nullable();

            $table->string('drivers_license_front_attachment')->nullable();
            $table->string('drivers_license_back_attachment')->nullable();

            $table->string('auto_insurance_front_attachment')->nullable();
            $table->string('auto_insurance_back_attachment')->nullable();
            $table->string('auto_year')->nullable();
            $table->string('auto_make')->nullable();
            $table->string('auto_model')->nullable();
            $table->string('auto_liability')->nullable();

            $table->longText('notes')->nullable();
            $table->string('admin_salary')->nullable();

            $table->unsignedBigInteger('fk_UserID')->nullable();
            $table->foreign('fk_UserID')->references('id')->on('users');
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
        Schema::dropIfExists('CYSW_Profile');
    }
}
