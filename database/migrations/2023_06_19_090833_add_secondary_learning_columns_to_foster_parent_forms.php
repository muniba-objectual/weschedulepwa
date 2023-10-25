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
        Schema::table('foster_parent_forms', function (Blueprint $table) {
            $table->boolean('has_secondary_learning_form')->default(false);
            $table->unsignedBigInteger('secondary_form_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('foster_parent_forms', function (Blueprint $table) {
            $table->dropColumn('has_secondary_learning_form');
            $table->dropColumn('secondary_form_id');
        });
    }
};
