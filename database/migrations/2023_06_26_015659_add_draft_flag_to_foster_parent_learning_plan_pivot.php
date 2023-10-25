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
            $table->boolean('is_draft')->default(false);
            $table->boolean('is_secondary_draft')->default(false);
        });
    }

    public function down()
    {
        Schema::table('foster_parent_forms', function (Blueprint $table) {
            $table->dropColumn('is_draft');
            $table->dropColumn('is_secondary_draft');
        });
    }
};
