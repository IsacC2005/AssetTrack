<?php

namespace App\Filament\Widgets;

use App\Models\Department;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;

class DevicesByDepartment extends ChartWidget
{
    protected ?string $heading = 'Dispositivos por Departamento';

    protected function getData(): array
    {

        $departments = Department::withCount('devices')->get();

        return [
            'datasets' => [
                [
                    'label' => 'Dispositivos por departamento',
                    'data' => $departments->pluck('devices_count'),
                ],
            ],
            'labels' =>  $departments->pluck('name'),

        ];
    }

    protected function getOptions(): array|RawJs|null
    {
        return [
            'scales' => [
                'y' =>  [
                    'ticks' => [
                        'precision' => 0,
                    ]
                ]
            ]
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
