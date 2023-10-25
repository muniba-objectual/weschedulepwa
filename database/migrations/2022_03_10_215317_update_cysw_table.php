<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCyswTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('CYSW_Profile', function (Blueprint $table) {
            $table->renameColumn('name', 'legal_name');
            $table->string('title')->nullable();
            $table->string('preferred_name')->nullable();
            $table->string('SIN')->nullable();
            $table->string('vaccination_status')->nullable();
            $table->string('banking_attachment')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('CYSW_Profile', function (Blueprint $table) {
            $table->dropColumn('legal_name');
            $table->dropColumn('title');
            $table->dropColumn('preferred_name');
            $table->dropColumn('SIN');
            $table->dropColumn('vaccination_status');
            $table->dropColumn('banking_attachment');

        });
    }
}
