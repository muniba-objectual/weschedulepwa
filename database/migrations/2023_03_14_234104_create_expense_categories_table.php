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
        Schema::create('expense_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        \DB::table('expense_categories')->insert([
            [ 'id' => "5800", 'name' => "Cell Phone Expense (5800)"],
            [ 'id' => "5226", 'name' => "Clothing (5226)"],
            [ 'id' => "5662", 'name' => "Flowers/Gift Cards (5662)"],
            [ 'id' => "5772", 'name' => "Food - Sales & Ent. (5772)"],
            [ 'id' => "5771", 'name' => "Food FP & Children (5771)"],
            [ 'id' => "5770", 'name' => "Food Staff Mtg's (5770)"],
//            [ 'id' => "5226", 'name' => "Formula (5226)"], //TODO::michello, what to do over here? its a duplicate record!
            [ 'id' => "5780", 'name' => "Internet (5780)"],
            [ 'id' => "5260", 'name' => "Medical (5260)"],
            [ 'id' => "5720", 'name' => "Mileage (5720)"],
            [ 'id' => "5258", 'name' => "Misc. Child Expense (5258)"],
            [ 'id' => "5700", 'name' => "Office Supplies (5700)"],
            [ 'id' => "5801", 'name' => "Parking & 407 (5801)"],
            [ 'id' => "5645", 'name' => "Postage/Courier (5645)"],
            [ 'id' => "5764", 'name' => "Recreation (5764)"],
            [ 'id' => "5230", 'name' => "School Expense (5230)"],
            [ 'id' => "5625", 'name' => "Training (5625)"],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expense_categories');
    }
};
