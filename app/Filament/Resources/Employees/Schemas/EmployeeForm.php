<?php

namespace App\Filament\Resources\Employees\Schemas;

use App\Models\Department;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Usuario')
                    ->visibleOn('create')
                    ->schema([
                        TextInput::make('user_name')
                            ->label('Nombre')
                            ->required(),
                        TextInput::make('user_email')
                            ->label('Correo')
                            ->email()
                            ->unique('users', 'email')
                            ->validationMessages([
                                'unique' => 'Este email ya esta registrado en otra cuenta.'
                            ])
                            ->required(),
                        TextInput::make('user_password')
                            ->label('Contraseña')
                            ->password()
                            ->confirmed()
                            ->visibleOn('create')
                            ->required(),
                        TextInput::make('user_password_confirmation')
                            ->label('Repite la contraseña')
                            ->password()
                            ->visibleOn('create')
                            ->required(),
                    ]),
                Section::make('Trabajo')
                    ->schema([
                        Select::make('department_id')
                            ->options(Department::query()->pluck('name', 'id'))
                            ->label('Departamento')
                            ->searchable()
                            ->required(),
                        TextInput::make('workstation')
                            ->label('Puesto')
                            ->required(),
                    ])
            ]);
    }
}
