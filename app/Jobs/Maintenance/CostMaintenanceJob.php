<?php

namespace App\Jobs\Maintenance;

use App\Models\MaintenanceTicket;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CostMaintenanceJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private MaintenanceTicket $maintenance) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /**
         * @var Collection<User>
         */
        $users = User::role('super_admin')->get();

        $title = 'Aprobación de mantenimiento pendiente.';

        foreach ($users as $user) {
            /**
             * @var User
             */
            $body = "Hola $user->name, el costo del mantenimiento del equipo {$this->maintenance->device->model} es de {$this->maintenance->parts_cost}$. Ahora debes aprobar o desaprobar el mantenimiento.";

            $user->notify(new GeneralNotification(
                title: $title,
                body: $body
            ));
        }
    }
}
