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
        Schema::table('edited_incident_entries', function (Blueprint $table) {
            $table->text('override_name_of_child')->nullable();
            $table->date('override_date_of_birth')->nullable();
            $table->date('override_date_of_placement')->nullable();
            $table->text('override_foster_home')->nullable();
            $table->text('override_placing_agency')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('edited_incident_entries', function (Blueprint $table) {
                $table->dropIfExists('override_name_of_child');
                $table->dropIfExists('override_date_of_birth');
                $table->dropIfExists('override_date_of_placement');
                $table->dropIfExists('override_foster_home');
                $table->dropIfExists('override_placing_agency');

        });
    }
};
