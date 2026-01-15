<?php

namespace App\Filament\Maintenance\Resources\AssignedMaintenances\Pages;

use App\Filament\Maintenance\Resources\AssignedMaintenances\AssignedMaintenanceResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAssignedMaintenance extends EditRecord
{
    protected static string $resource = AssignedMaintenanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
