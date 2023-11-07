<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Persons>
 */
class PersonsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Firstname' => fake()->firstName,
            'Lastname' => fake()->lastName,
            'Middle_Initial' => fake()->randomLetter,
            'Birthday' => fake()->date,
            'Gender' => fake()->numberBetween(1, 3),
            'Date_registered' => fake()->date,
        ];
    }
}
