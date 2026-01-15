<?php

namespace App\Filament\Maintenance\Resources\AssignedMaintenances\Pages;

use App\Filament\Maintenance\Resources\AssignedMaintenances\AssignedMaintenanceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAssignedMaintenances extends ListRecords
{
    protected static string $resource = AssignedMaintenanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
