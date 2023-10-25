<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateISAContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ISA_Contracts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fk_UserID');
            $table->bigInteger('fk_ChildID');
            $table->longText('contract_attachment');
            $table->boolean('active')->default(false);
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
        Schema::dropIfExists('ISA_Contracts');
    }
}
