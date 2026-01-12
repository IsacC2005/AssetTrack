<?php

namespace Tests\Feature;

use App\Models\Device;
use App\Models\Employee;
use App\Models\MaintenanceTicket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class MaintenanceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_maintenance_ticket_belongs_to_a_device_and_a_technician()
    {
        // 1. Creamos un ticket usando el factory
        $ticket = MaintenanceTicket::factory()->create();

        // 2. Verificamos que el ticket tenga un objeto Device relacionado
        $this->assertInstanceOf(Device::class, $ticket->device);

        // 3. Verificamos que el ticket tenga un técnico (Employee)
        $this->assertInstanceOf(Employee::class, $ticket->technician);

        // 4. Verificamos que los IDs coincidan
        $this->assertEquals($ticket->device_id, $ticket->device->id);
    }

    #[Test]
    public function a_device_can_have_many_maintenance_tickets()
    {
        /**
         * @var Device
         */
        $device = Device::factory()->create();

        // Creamos 3 tickets para este dispositivo específico
        MaintenanceTicket::factory()->count(3)->create([
            'device_id' => $device->id
        ]);

        $this->assertCount(3, $device->maintenanceTickets);
    }

    #[Test]
    public function a_employee_can_have_many_maintenance_tickets()
    {
        $employee = Employee::factory()->create();

        MaintenanceTicket::factory()->count(3)->create([
            'technician_id' => $employee->id
        ]);

        $this->assertCount(3, $employee->maintenanceTickets);
    }
}
