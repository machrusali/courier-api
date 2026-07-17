<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CourierFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'phone_number' => $this->faker->unique()->phoneNumber(),
            'vehicle_type' => $this->faker->randomElement(['Motorcycle', 'Car', 'Van']),
            'level' => $this->faker->numberBetween(1, 5),
            'is_active' => true,
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}