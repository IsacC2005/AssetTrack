<?php

namespace App\Filament\Resources\AssignedDevices\Pages;

use App\Filament\Resources\AssignedDevices\AssignedDeviceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAssignedDevices extends ListRecords
{
    protected static string $resource = AssignedDeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //CreateAction::make(),
        ];
    }
}
