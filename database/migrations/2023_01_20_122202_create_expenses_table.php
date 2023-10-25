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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fk_UserID');
            $table->datetime('datetime');
            $table->longText('description')->nullable();
            $table->text('attachment')->nullable();
            $table->text('category')->nullable();
            $table->decimal('subtotal',9,2)->nullable();
            $table->decimal('HST',9,2)->nullable();
            $table->decimal('total',9,2)->nullable();
            $table->json('line_items')->nullable();
            $table->longText('notes')->nullable();
            $table->text('linkTo')->nullable();
            $table->bigInteger('linkToID')->nullable();
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
        Schema::dropIfExists('expenses');
    }
};
