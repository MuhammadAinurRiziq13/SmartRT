<?php

namespace Database\Factories;

use App\Models\House;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\House>
 */
class HouseFactory extends Factory
{
    protected $model = House::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            'house_number' => 'A' . $this->faker->unique()->numberBetween(1, 20),
            'occupancy_status' => $this->faker->randomElement(['occupied', 'vacant']),
        ];
    }
}