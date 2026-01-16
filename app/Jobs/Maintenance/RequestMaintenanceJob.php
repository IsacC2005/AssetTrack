<?php

namespace App\Jobs\Maintenance;

use App\Filament\Resources\MaintenanceTickets\MaintenanceTicketResource;
use App\Models\Device;
use App\Models\MaintenanceTicket;
use App\Models\User;
use App\Notifications\GeneralNotification;
use App\Notifications\Maintenance\RequestMaintenance;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Str;

class RequestMaintenanceJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private MaintenanceTicket $maintenance,
        private String $failure
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

        $title = 'Solicitud de mantenimiento.';
        $failure = Str::limit($this->failure, 250);

        foreach ($users as $user) {
            /**
             * @var User
             */
            $url = MaintenanceTicketResource::getUrl('edit', ['record' => $this->maintenance->id]);
            $body = "{$this->maintenance->device->employee->user->name} solicito mantenimiento al equipo {$this->maintenance->device->model} por: '$failure'";

            $user->notify(new GeneralNotification(
                title: $title,
                body: $body,
                url: $url
            ));
        }
    }
}
