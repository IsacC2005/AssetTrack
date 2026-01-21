<?php

use App\Jobs\Maintenance\PreventiveMaintenanceJob;
use App\Models\Device;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('test', function () {
    $devices = Device::with('lastMaintenance')->get();
    foreach ($devices as $device) {

        /**
         * @var Carbon
         */
        $lastMaintenanceDate = $device->lastMaintenance->updated_at ?? null;

        $intervalMaintenance = $device->maintenance_interval ? 1 : 1;

        if (!$lastMaintenanceDate) {
            return;
        }
        $nextDate = $lastMaintenanceDate->addDays($intervalMaintenance);

        if (now()->greaterThanOrEqualTo($nextDate)) {

            $last_notified_at = $device->last_notified_at;

            // dd($last_notified_at);

            // dd($device->last_notified_at->lessThan($nextDate));
            if (!$device->last_notified_at || $device->last_notified_at->lessThan($nextDate)) {


                PreventiveMaintenanceJob::dispatch($device)->onQueue('maintenance');

                // 3. Marcar como notificado
                $device->update(['last_notified_at' => now()]);
            }
        }
    }
    dd($devices);
    return 'Test corriendo';
});
