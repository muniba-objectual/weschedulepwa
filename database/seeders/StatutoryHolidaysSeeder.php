<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatutoryHolidaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file_path = resource_path('sql/statutory_holidays(2022-2025).sql');
        \DB::unprepared(
            file_get_contents($file_path)
        );
    }
}
