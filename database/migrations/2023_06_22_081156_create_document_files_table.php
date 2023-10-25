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
        Schema::create('document_files', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->json('file_meta_info')->nullable();
            $table->string('directory_path');
            $table->string('file_category');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('document_files');
    }
};
