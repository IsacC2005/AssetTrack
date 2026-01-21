<?php

namespace App\Console\Commands;

use App\Jobs\Maintenance\PreventiveMaintenanceJob;
use App\Models\Device;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Console\Command;

class PreventiveMaintenance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:preventive-maintenance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $devices = Device::with('lastMaintenance')->get();

        if (!$devices) {
            return;
        }

        foreach ($devices as $device) {

            /**
             * @var Carbon
             */
            $lastMaintenanceDate = $device->lastMaintenance->updated_at ?? null;

            $intervalMaintenance = $device->maintenance_interval;

            if (!$lastMaintenanceDate) {
                return;
            }
            $nextDate = $lastMaintenanceDate->addDays($intervalMaintenance);

            if (now()->greaterThanOrEqualTo($nextDate)) {
                if (!$device->last_notified_at || $device->last_notified_at->lessThan($nextDate)) {


                    PreventiveMaintenanceJob::dispatch($device)->onQueue('maintenance');

                    // 3. Marcar como notificado
                    $device->update(['last_notified_at' => now()]);
                }
            }
        }
    }
}
