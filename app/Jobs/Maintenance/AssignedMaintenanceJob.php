<?php

namespace App\Jobs\Maintenance;

use App\Filament\Resources\MaintenanceTickets\MaintenanceTicketResource;
use App\Models\Device;
use App\Models\Employee;
use App\Models\MaintenanceTicket;
use App\Models\User;
use App\Notifications\GeneralNotification;
use App\Notifications\Maintenance\AssignedMaintenance;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class AssignedMaintenanceJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private MaintenanceTicket $maintenance,
        private Employee $technician
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $title = 'Asignación de mantenimiento.';
        $body = "Te asignaron el mantenimiento de {$this->maintenance->device->model} por: '{$this->maintenance->failure_device_description}'";

        $this->technician->user->notify(new GeneralNotification(
            title: $title,
            body: $body,
        ));
    }
}
