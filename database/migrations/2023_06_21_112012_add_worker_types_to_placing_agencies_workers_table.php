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
        //enum->change not supported by '\Doctrine\DBAL\Types\Type' so using raw DB statements.
        DB::statement("ALTER TABLE placing_agencies_workers MODIFY COLUMN `type` ENUM('Finance Worker', 'Children Service Worker', 'Family Service Worker', 'Placement Worker') NOT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE placing_agencies_workers MODIFY COLUMN `type` ENUM('Finance Worker', 'Children Service Worker', 'Family Service Worker') NOT NULL");
    }
};



