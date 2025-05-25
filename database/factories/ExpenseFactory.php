<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'amount' => $this->faker->numberBetween(10000, 500000),
            'description' => $this->faker->sentence(),
            'month' => now()->format('m'),
            'year' => now()->format('Y'),
        ];
    }
}