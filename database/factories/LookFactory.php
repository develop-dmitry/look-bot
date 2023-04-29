<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Look>
 */
class LookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $lowerTemperature = fake()->numberBetween(-50, +50);

        return [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'photo' => fake()->filePath(),
            'lower_temperature_range' => $lowerTemperature,
            'upper_temperature_range' => fake()->numberBetween($lowerTemperature, +50)
        ];
    }
}
