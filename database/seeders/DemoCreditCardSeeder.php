<?php

namespace Database\Seeders;

use App\Models\CreditCard;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DemoCreditCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //php artisan db:seed --class=DemoCreditCardSeeder

        CreditCard::create([
            'card_number' => '4713',
            'cardholder_name' => 'John Smith',
            'expiration_month' => '06',
            'expiration_year' => '2024',
            'cvv' => '123',
            'billing_zip' => '12345',
            'card_brand' => 'Visa',
            'card_type' => 'Credit',
            'user_id' => 2,
        ]);

        CreditCard::create([
            'card_number' => '2151',
            'cardholder_name' => 'Jane Doe',
            'expiration_month' => '09',
            'expiration_year' => '2023',
            'cvv' => '456',
            'billing_zip' => '67890',
            'card_brand' => 'Mastercard',
            'card_type' => 'Credit',
            'user_id' => 167,
        ]);

        CreditCard::create([
            'card_number' => '0264',
            'cardholder_name' => 'Bob Johnson',
            'expiration_month' => '12',
            'expiration_year' => '2022',
            'cvv' => '789',
            'billing_zip' => '54321',
            'card_brand' => 'Amex',
            'card_type' => 'Credit',
            'user_id' => 168,
        ]);

        CreditCard::create([
            'card_number' => '9436',
            'cardholder_name' => 'Samantha Lee',
            'expiration_month' => '03',
            'expiration_year' => '2025',
            'cvv' => '234',
            'billing_zip' => '09876',
            'card_brand' => 'Discover',
            'card_type' => 'Credit',
            'user_id' => 47,
        ]);

        CreditCard::create([
            'card_number' => '1989',
            'cardholder_name' => 'Jack Jones',
            'expiration_month' => '11',
            'expiration_year' => '2023',
            'cvv' => '567',
            'billing_zip' => '13579',
            'card_brand' => 'Visa',
            'card_type' => 'Credit',
            'user_id' => 54,
        ]);
    }
}
