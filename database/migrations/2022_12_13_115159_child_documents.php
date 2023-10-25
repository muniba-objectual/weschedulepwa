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
        Schema::create('child_documents', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fk_ChildID');
            $table->text('type')->nullable();
            $table->text('description')->nullable();
            $table->date('date')->nullable();
            $table->date('renewal_date')->nullable();
            $table->boolean('recurring')->default(false);
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
        Schema::dropIfExists('cm_child_profile');

    }
};
