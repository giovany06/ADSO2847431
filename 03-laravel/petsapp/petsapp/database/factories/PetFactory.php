<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'name' =>fake()->word,
           'kind' => fake()->randomElement(['Dog', 'Cat', 'Bird', 'Fish']),
            'weight' =>fake()->randomNumber(2,true),
            'age' =>fake()->randomNumber(2,true),
            'breed' => fake()->colorName(),
            'location' =>fake()->city(),
            'description'=>fake()->sentence(10),
            'created_at' => now()

        ];
    }
}
