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
        Schema::create('mentor_homes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        \DB::table('mentor_homes')->insert([
            ['id' => '14', 'name' => 'Madelaine'          ],
            ['id' => '24', 'name' => 'McCulla'            ],
            ['id' => '26', 'name' => 'McCulla'            ],
            ['id' => '90', 'name' => 'Post Rd Upstairs'   ],
            ['id' => '91', 'name' => 'Post Rd Downstairs' ],//id was changed
            ['id' => '59', 'name' => 'Welbeck Upstairs'   ],
            ['id' => '60', 'name' => 'Welbeck Downstairs' ],//id was changed
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mentor_homes');
    }
};
