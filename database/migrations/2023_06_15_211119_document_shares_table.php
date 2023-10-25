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
        Schema::create('document_shares', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('model_id')->nullable();
            $table->boolean('downloaded_at')->nullable();
            $table->dateTime('last_access_at')->nullable();
            $table->dateTime('link_expire_at')->nullable()->comment('if null, then it never expires');
            $table->string('password')->nullable()->comment('if null, then no password is set');
            $table->string('download_html')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_shares');
    }
};
