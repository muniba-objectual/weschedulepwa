<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HomeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => "Sample Home - " . $this->faker->randomNumber,
            'address' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'province' => $this->faker->state,
            'postal' => $this->faker->postcode,
            'notes' => $this->faker->text,
        ];
    }
}
