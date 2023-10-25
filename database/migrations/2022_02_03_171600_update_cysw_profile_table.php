<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCYSWProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('CYSW_Profile', function (Blueprint $table) {

            $table->string('photo_id_2_front_attachment')->nullable();
            $table->string('photo_id_2_back_attachment')->nullable();
            $table->string('covid19_proof_of_vaccination')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('transit')->nullable(); //must be 5 digits
            $table->string('institution')->nullable(); //must be 3 digits
            $table->string('account_number')->nullable(); //must be 7 digits

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('CYSW_Profile', function(Blueprint $table) {
            $table->dropColumn('photo_id_2_front_attachment');
            $table->dropColumn('photo_id_2_back_attachment');
            $table->dropColumn('covid19_proof_of_vaccination');
            $table->dropColumn('bank_name');
            $table->dropColumn('transit');
            $table->dropColumn('institution');
            $table->dropColumn('account_number');
        });
    }
}
