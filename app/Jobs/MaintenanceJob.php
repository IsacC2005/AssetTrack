<?php

namespace App\Jobs;

use App\Models\MaintenanceTicket;
use App\Models\User;
use App\Notifications\CostMaintenance;
use App\Notifications\MaintenancePriceCost;
use App\Notifications\Test;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class MaintenanceJob implements ShouldQueue
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

        foreach ($users as $user) {
            /**
             * @var User
             */
            $user->notify(new CostMaintenance($this->maintenance));
        }
    }
}
