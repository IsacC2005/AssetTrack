<?php

namespace App\Filament\Resources\Employees\Pages;

use App\Filament\Resources\Employees\EmployeeResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = User::create([
            'name' => $data['user_name'],
            'email' => $data['user_email'],
            'password' => bcrypt($data['user_password'])
        ]);

        $data['user_id'] = $user->id;

        unset($data['user_name'], $data['user_email'], $data['user_password']);

        return $data;
    }
}
