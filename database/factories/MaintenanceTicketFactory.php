<?php

namespace Database\Factories;

use App\Models\Device;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MaintenanceTicket>
 */
class MaintenanceTicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'device_id' => Device::factory(),
            'technician_id' => Employee::factory(),
            'failure_device_description' => $this->faker->text(),
            'state' => $this->faker->randomElement(['pending', 'discarded', 'rejected', 'done']),

            'failure' => $this->faker->text(),
            'parts_cost' => $this->faker->randomFloat(2, 100, 10000),
            'idle_time' => $this->faker->numberBetween(1, 10),
        ];
    }
}
