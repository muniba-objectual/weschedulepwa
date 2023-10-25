<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user__types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('type', '3','1')->default(1.0); //	1=CYSW;2=Case Manager;3=Administrator
            $table->timestamps();
        });

        // Insert some stuff
        DB::table('user__types')->insert(
            array(
                'name' => 'CYSW',
                'type' => '1.0',
            ),
        );

        DB::table('user__types')->insert(
            array(
                'name' => 'Case Manager',
                'type' => '2.0',
            ),
        );

        DB::table('user__types')->insert(
            array(
                'name' => 'Administrator',
                'type' => '3.0',
            ),
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user__types');
    }
}
