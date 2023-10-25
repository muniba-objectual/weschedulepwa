<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSRAReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SRA_Reports', function (Blueprint $table) {
            $table->id();
            $table->text('report_title')->nullable();
            $table->bigInteger("fk_ChildID")->nullable();
            $table->bigInteger("fk_UserID")->nullable();
            $table->longText("report_html")->nullable();
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
        Schema::dropIfExists('SRA_Reports');
    }
}
