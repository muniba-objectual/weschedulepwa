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
            $table->text('direct_deposit_ID')->nullable();
            $table->text('finance_worker_name')->nullable();
            $table->text('finance_worker_phone')->nullable();
            $table->text('finance_worker_invoicing_email_address')->nullable();

            $table->text('children_service_worker_name')->nullable();
            $table->text('children_service_worker_phone')->nullable();
            $table->text('children_service_worker_email_address')->nullable();

            $table->text('family_service_worker_name')->nullable();
            $table->text('family_service_worker_phone')->nullable();
            $table->text('family_service_worker_email_address')->nullable();

            $table->double('per_diem_rate')->nullable();
            $table->double('ISA_PFA_rate')->nullable();
            $table->double('outside_respite_rate')->nullable();
            $table->double('holding_rate')->nullable();
            $table->double('mileage_rate')->nullable();
            $table->text('mileage_terms')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('placing_agencies', function (Blueprint $table) {
            $table->dropColumn('direct_deposit_ID');
            $table->dropColumn('finance_worker_name');
            $table->dropColumn('finance_worker_phone');
            $table->dropColumn('finance_worker_invoicing_email_address');

            $table->dropColumn('children_service_worker_name');
            $table->dropColumn('children_service_worker_phone');
            $table->dropColumn('children_service_worker_email_address');

            $table->dropColumn('family_worker_name');
            $table->dropColumn('family_worker_phone');
            $table->dropColumn('family_worker_email_address');


            $table->dropColumn('per_diem_rate');
            $table->dropColumn('ISA_PFA_rate');
            $table->dropColumn('outside_respite_rate');
            $table->dropColumn('holding_rate');
            $table->dropColumn('mileage_rate');
            $table->dropColumn('mileage_terms');



        });
    }
};
