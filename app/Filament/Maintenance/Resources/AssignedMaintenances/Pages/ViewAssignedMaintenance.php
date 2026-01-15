<?php

namespace App\Filament\Maintenance\Resources\AssignedMaintenances\Pages;

use App\Filament\Maintenance\Resources\AssignedMaintenances\AssignedMaintenanceResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAssignedMaintenance extends ViewRecord
{
    protected static string $resource = AssignedMaintenanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
