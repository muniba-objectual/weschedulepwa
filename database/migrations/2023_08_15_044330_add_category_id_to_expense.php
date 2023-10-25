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
        Schema::table('expenses', function (Blueprint $table) {
            $table->integer('category_id')->nullable()->after('category');
        });

        //coping data to new column from the json data.
        foreach(\DB::table('expenses')->get()??[] as $record){
            $newCategoryId = json_decode($record->line_items)[0]->category ?? null;
            \DB::table('expenses')
                ->where('id', $record->id)
                ->update(['category_id' => $newCategoryId]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
    }
};
