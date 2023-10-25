<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ShiftLayoutTemplate extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'day_of_week' => $this->faker->date->weekday,
            'start_time' => $this->faker->date,
            'fk_HomeID' => $this->faker->unique->numberBetween(1,5),
            'notes' => $this->faker->text(15),
        ];
    }
}
