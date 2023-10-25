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
        Schema::create('quickbooks_tokens', function (Blueprint $table) {
            $table->id();
            $table->longText('access_token');
            $table->string('realm_id');
            $table->longText('other_details');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quickbooks_tokens');
    }
};
