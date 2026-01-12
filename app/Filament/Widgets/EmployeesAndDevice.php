<?php

namespace App\Filament\Widgets;

use App\Models\Device;
use App\Models\Employee as ModelEmployee;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EmployeesAndDevice extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Empleados', ModelEmployee::query()->count())
                ->icon(Heroicon::UserGroup),
            Stat::make('Dispositivos disponibles', Device::where('state', 'available')->count())
                ->description('Listos para usar')
                ->descriptionIcon(Heroicon::CheckCircle)
                ->color('success'),
            Stat::make('Dispositivos asignados', Device::where('state', 'assigned')->count())
                ->icon(Heroicon::DevicePhoneMobile)
                ->color('info'),
            Stat::make('Dispositivos en mantenimiento', Device::where('state', 'maintenance')->count())
                ->icon(Heroicon::WrenchScrewdriver)
                ->color('danger')
        ];
    }
}
