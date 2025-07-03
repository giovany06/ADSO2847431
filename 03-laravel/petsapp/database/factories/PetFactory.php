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
            'name'        => fake()->domainWord(),
            'kind'        => fake()->randomElement(['Dog', 'Cat', 'Fish', 'Mouse', 'Bird']),
            'weight'      => fake()->numberBetween(1, 80),
            'age'         => fake()->randomNumber(2, true),
            'breed'       => fake()->colorName(),
            'location'    => fake()->city(),
            'description' => fake()->sentence(10),
            'status'      => true, 
            'created_at'  => now(),
            'updated_at'  => now(),
        ];
    }
}
