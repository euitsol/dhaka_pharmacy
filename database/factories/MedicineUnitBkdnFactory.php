<?php

namespace Database\Factories;

use App\Models\Medicine;
use App\Models\MedicineUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicineUnitBkdn>
 */
class MedicineUnitBkdnFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'unit_id' => $this->faker->numberBetween(1, 12),
        ];
    }
}