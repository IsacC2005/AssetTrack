<?php

namespace App\Filament\Resources\Devices\Schemas;

use App\Models\Employee;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class DeviceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('serial')
                    ->label('Serial')
                    ->unique()
                    ->maxLength(255)
                    ->validationMessages([
                        'unique' => 'El serial ya existe.',
                    ])
                    ->required(),
                TextInput::make('model')
                    ->label('Modelo')
                    ->maxLength(255)
                    ->required(),
                Textarea::make('detail')
                    ->label('Detalles')
                    ->maxLength(1200)
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('cost')
                    ->label('Costo')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Select::make('employee_id')
                    ->label('Asignar al empleado')
                    ->searchable(['users.name', 'workstation'])
                    ->preload()
                    ->relationship(
                        name: 'employee',
                        titleAttribute: 'employees.id',
                        modifyQueryUsing: fn(Builder $query) => $query
                            // ->whereNot('users.name', 'eze')
                            ->join('users', 'employees.user_id', 'users.id')
                            ->select('employees.*')
                    )
                    ->getOptionLabelFromRecordUsing(fn(Employee $record) => "{$record->user->name} | $record->workstation"),
                TextInput::make('maintenance_interval')
                    ->label('Cada cuanto se debe hacer mantenimiento')
                    ->numeric()
                    ->prefix('Dias')
                    ->required(),
                SpatieMediaLibraryFileUpload::make('photo_device')
                    ->disk('public')
                    ->label('Foto del dispositivo')

            ]);
    }
}
