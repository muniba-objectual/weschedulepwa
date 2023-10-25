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
        Schema::table('placing_agencies', function (Blueprint $table) {
            $table->dropColumn('finance_worker_name');
            $table->dropColumn('finance_worker_phone');
            $table->dropColumn('finance_worker_invoicing_email_address');

            $table->dropColumn('children_service_worker_name');
            $table->dropColumn('children_service_worker_phone');
            $table->dropColumn('children_service_worker_email_address');

            $table->dropColumn('family_service_worker_name');
            $table->dropColumn('family_service_worker_phone');
            $table->dropColumn('family_service_worker_email_address');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
};
