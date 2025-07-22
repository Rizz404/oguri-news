<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'age' => fake()->numberBetween(18, 70),
            'bio' => fake()->realText(200),
            'phone_number' => fake()->unique()->phoneNumber(),
        ];
    }
}
