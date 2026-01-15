<?php

namespace App\Filament\Resources\Employees\Pages;

use App\Filament\Resources\Employees\EmployeeResource;
use App\Models\Department;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        /**
         * @var User
         */
        $user = User::create([
            'name' => $data['user_name'],
            'email' => $data['user_email'],
            'password' => bcrypt($data['user_password'])
        ]);

        $data['user_id'] = $user->id;

        $departmentId = $data['department_id'];

        /**
         * @var Department
         */
        $department = Department::find($departmentId);



        switch ($department->name) {
            case 'Mantenimiento':
                $user->assignRole('Mantenimiento');
                break;

            default:
                $user->assignRole('Empleado');
                break;
        }

        unset($data['user_name'], $data['user_email'], $data['user_password']);

        return $data;
    }
}
