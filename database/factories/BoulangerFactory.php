<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Boulanger>
 */
class BoulangerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'created_by' => $this->faker->numberBetween(1, 10),
            'mowzoune_id' => $this->faker->numberBetween(1, 5),
            'etat' => ['active', 'noActive'][rand(0, 1)],
            'description' => $this->faker->paragraph(2)
        ];
    }
}
