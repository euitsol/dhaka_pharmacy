<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medicine>
 */
class MedicineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word() . ' ' . $this->faker->numberBetween(1, 100),
            'slug' => $this->faker->unique()->slug(),
            'pro_cat_id' => $this->faker->numberBetween(1, 8),
            'pro_sub_cat_id' => $this->faker->numberBetween(1, 40),
            'generic_id' => $this->faker->numberBetween(1, 6),
            'company_id' => $this->faker->numberBetween(1, 6),
            'strength_id' => $this->faker->numberBetween(1, 20),
            'price' => $this->faker->randomFloat(2, 0.5, 100),
            'description' => $this->faker->paragraphs(3, true),
            'prescription_required' => $this->faker->boolean(),
            'max_quantity' => $this->faker->numberBetween(1, 100),
            'kyc_required' => $this->faker->boolean(),
            'status' => $this->faker->boolean(90), // 90% chance of being true (active)
            'is_best_selling' => $this->faker->boolean(50), // 50% chance
            'is_featured' => $this->faker->boolean(70), // 50% chance
            'image' => $this->faker->imageUrl(640, 480, 'Medicine Faker', true, 'Image', true),
        ];
    }
}