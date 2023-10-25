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
        Schema::create('IR_locks', function (Blueprint $table) {
            $table->id();
            $table->string("field")->nullable();
            $table->bigInteger("fk_UserID")->nullable();

        });
        }




    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('IR_locks');
    }
};
