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
        Schema::table('expense_categories', function (Blueprint $table) {
            $table->integer('qb_sync_token');
            $table->boolean('is_active')->default(true);
            $table->renameColumn('qb_account_name', 'qb_account_type');
        });

        \DB::table('expense_categories')->truncate();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expense_categories', function (Blueprint $table) {
            $table->dropColumn(['qb_sync_token', 'is_active']);
            $table->renameColumn('qb_account_type', 'qb_account_name');
        });
    }
};
