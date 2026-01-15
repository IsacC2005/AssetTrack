<?php

namespace App\Filament\Maintenance\Resources\AssignedMaintenances\Pages;

use App\Filament\Maintenance\Resources\AssignedMaintenances\AssignedMaintenanceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAssignedMaintenance extends CreateRecord
{
    protected static string $resource = AssignedMaintenanceResource::class;
}
