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
        Schema::table('document_shares', function (Blueprint $table) {
            $table->string('token', 128);
            $table->string('email', 191)->nullable();
        });
    }

    public function down()
    {
        Schema::table('document_shares', function (Blueprint $table) {
            $table->dropColumn('token');
            $table->dropColumn('email');
        });
    }
};
