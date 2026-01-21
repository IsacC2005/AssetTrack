<?php

namespace App\Jobs\Maintenance;

use App\Models\Device;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class PreventiveMaintenanceJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private Device $device
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /**
         * @var Collection<User>
         */
        $users = User::role('super_admin')->get();

        $title = 'Mantenimiento preventivo.';

        foreach ($users as $user) {
            /**
             * @var User
             */
            $body = "Hola $user->name el dispositivo {$this->device->model} #{$this->device->id} ya es candidato a un mantenimiento preventivo.";

            $user->notify(new GeneralNotification(
                title: $title,
                body: $body,
            ));
        }
    }
}
