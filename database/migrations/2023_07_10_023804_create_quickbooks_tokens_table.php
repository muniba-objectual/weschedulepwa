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
        Schema::table('quickbooks_tokens', function (Blueprint $table) {
            $table->dropColumn(['access_token', 'realm_id']);
            $table->longText('serialized_access_token')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quickbooks_tokens', function (Blueprint $table) {
            $table->longText('access_token')->after('id');
            $table->string('realm_id')->after('access_token');
            $table->dropColumn('serialized_access_token');
        });
    }
};
