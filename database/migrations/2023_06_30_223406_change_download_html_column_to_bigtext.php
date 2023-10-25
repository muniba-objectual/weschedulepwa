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
            $table->longText('download_html')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('document_shares', function (Blueprint $table) {
            $table->string('download_html')->nullable()->change();
        });
    }
};
