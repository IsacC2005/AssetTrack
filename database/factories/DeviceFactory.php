<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class DeviceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'serial' => $this->faker->unique()->uuid(),
            'model' => $this->faker->word(),
            'detail' => $this->faker->sentence(),
            'cost' => $this->faker->randomFloat(2, 100, 2000),
            'state' => $this->faker->randomElement(['assigned', 'maintenance', 'discarded']),
            'maintenance_interval' => $this->faker->numberBetween(200, 5000)
        ];
    }
}
