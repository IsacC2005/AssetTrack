<?php

namespace App\Filament\Widgets;

use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class Maintenances extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        /**
         * @var User
         */
        $user = Auth::user();

        /**
         * @var Employee
         */
        $employee = $user->employee;


        $data = [
            Stat::make('Dispositivos asignados', $employee->devices->count())
                ->icon(Heroicon::DeviceTablet)
        ];

        if ($user->hasRole('Mantenimiento')) {
            $maintenanceAssigned = $employee->maintenanceTickets->where('state', 'pending')->count();

            $maintenanceDone = $employee->maintenanceTickets->where('state', 'done')->count();

            $data[] = Stat::make('Mantenimientos asignados', $maintenanceAssigned);

            $data[] = Stat::make('Mantenimientos completados', $maintenanceDone);
        }

        return $data;
    }
}
