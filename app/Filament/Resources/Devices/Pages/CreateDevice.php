<?php

namespace App\Filament\Resources\Devices\Pages;

use App\Filament\Resources\Devices\DeviceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDevice extends CreateRecord
{
    protected static string $resource = DeviceResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['state'] = 'available';

        if ($data['employee_id'] !== null) {
            $data['state'] = 'assigned';
        }

        return $data;
    }
}
