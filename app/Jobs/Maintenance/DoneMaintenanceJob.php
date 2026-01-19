<?php

namespace App\Jobs\Maintenance;

use App\Models\MaintenanceTicket;
use App\Notifications\GeneralNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class DoneMaintenanceJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private MaintenanceTicket $maintenance
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $employee = $this->maintenance->device->employee;

        $employee->user->notify(new GeneralNotification(
            title: 'Mantenimiento realizado',
            body: "Hola {$employee->user->name}, el mantenimiento del dispositivo {$this->maintenance->device->model}, ya fue realizado."
        ));
    }
}
