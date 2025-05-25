<?php

namespace Database\Factories;

use App\Models\Resident;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resident>
 */
class ResidentFactory extends Factory
{
    protected $model = Resident::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => $this->faker->name(),
            'id_card_photo' => null, // kamu bisa ganti dengan URL dummy kalau mau
            'resident_status' => $this->faker->randomElement(['permanent', 'contract']),
            'phone_number' => $this->faker->phoneNumber(),
            'marital_status' => $this->faker->randomElement(['married', 'single']),
        ];
    }
}