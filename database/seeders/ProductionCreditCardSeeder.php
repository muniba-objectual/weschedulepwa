<?php

namespace Database\Seeders;

use App\Models\CreditCard;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductionCreditCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //php artisan db:seed --class=ProductionCreditCardSeeder --env=production

        CreditCard::create([
            'user_id' => 2,
            'card_number' => '4713',
        ]);

        CreditCard::create([
            'user_id' => 167,
            'card_number' => '2151',
        ]);

        CreditCard::create([
            'user_id' => 168,
            'card_number' => '0264',
        ]);

        CreditCard::create([
            'user_id' => 47,
            'card_number' => '9436',
        ]);

        CreditCard::create([
            'user_id' => 54,
            'card_number' => '1989',
        ]);
    }
}
