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
            $table->string('secondary_foster_parent_full_name')->after('user_id');
            $table->date('secondary_foster_parent_date_of_birth')->after('secondary_foster_parent_full_name');
            $table->string('secondary_foster_parent_email')->after('secondary_foster_parent_date_of_birth');
            $table->string('secondary_foster_parent_telephone')->after('secondary_foster_parent_email');
            $table->string('secondary_foster_parent_relationship_to_primary')->after('secondary_foster_parent_telephone');
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
            $table->dropColumn('secondary_foster_parent_full_name');
            $table->dropColumn('secondary_foster_parent_date_of_birth');
            $table->dropColumn('secondary_foster_parent_email');
            $table->dropColumn('secondary_foster_parent_telephone');
            $table->dropColumn('secondary_foster_parent_relationship_to_primary');
        });
    }
};
