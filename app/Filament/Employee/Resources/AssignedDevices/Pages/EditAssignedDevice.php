<?php

namespace App\Filament\Employee\Resources\AssignedDevices\Pages;

use App\Filament\Resources\AssignedDevices\AssignedDeviceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAssignedDevice extends EditRecord
{
    protected static string $resource = AssignedDeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //DeleteAction::make(),
        ];
    }
}
