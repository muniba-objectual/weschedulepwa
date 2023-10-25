<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ChildFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'initials' => $this->faker->name[0] . " " . $this->faker->name[0],
            'dob' => $this->faker->date,
            'fk_HomeID' => $this->faker->unique->numberBetween(1,5),
            'notes' => $this->faker->text(15),
        ];
    }
}
