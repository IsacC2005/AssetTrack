<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class ShieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $superAdminRole = Role::firstOrCreate([
            'name' => config('filament-shield.super_admin.name'),
            'guard_name' => 'web'
        ]);

        $maintenanceRole = Role::firstOrCreate([
            'name' => 'Mantenimiento',
            'guard_name' => 'web'
        ]);

        $employeeRole = Role::firstOrCreate([
            'name' => 'Empleado',
            'guard_name' => 'web'
        ]);
    }
}
