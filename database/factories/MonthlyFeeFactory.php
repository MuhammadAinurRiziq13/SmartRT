<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MonthlyFee>
 */
class MonthlyFeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'house_id' => \App\Models\House::factory(),
            'resident_id' => \App\Models\Resident::factory(),
            'month' => $this->faker->monthName(),
            'year' => now()->year,
            'security_fee' => 100000,
            'cleaning_fee' => 15000,
            'status' => $this->faker->randomElement(['lunas', 'belum']),
        ];
    }
}