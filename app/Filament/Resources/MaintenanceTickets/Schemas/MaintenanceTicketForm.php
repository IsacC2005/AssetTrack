<?php

namespace App\Filament\Resources\MaintenanceTickets\Schemas;

use App\Models\Device;
use App\Models\Employee;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class MaintenanceTicketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('device_id')
                    ->label('Dispositivo')
                    ->relationship('device', 'id')
                    ->getOptionLabelFromRecordUsing(fn(Device $record) => "{$record->id}: {$record->model}, {$record->serial}")
                    ->searchable(['model', 'serial'])
                    ->preload()
                    ->required(),
                Select::make('technician_id')
                    ->label('Técnico')
                    ->relationship(
                        name: 'technician',
                        titleAttribute: 'id',
                        modifyQueryUsing: fn(Builder $query) => $query
                            ->whereHas('department', fn($q) => $q->where('name', 'Mantenimiento'))
                            ->join('users', 'employees.user_id', 'users.id')
                            ->select('employees.*')
                    )
                    ->getOptionLabelFromRecordUsing(fn(Employee $record) => "{$record->user->name}, $record->workstation")
                    ->searchable(['users.name', 'workstation'])
                    ->preload()
                    ->required(),
                Textarea::make('failure')
                    ->label('Descripción de la falla')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('parts_cost')
                    ->label('Costo de reparación')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('idle_time')
                    ->label('Tiempo de inactividad')
                    ->required()
                    ->numeric(),
                SpatieMediaLibraryFileUpload::make('photo_device_maintenance')
                    ->image()
                    ->multiple()
                    ->maxFiles(2)
                    ->label('Foto del dispositivo')
                    ->validationMessages([
                        'max_files' => 'Solo puedes subir un máximo de dos imágenes.',
                    ])
            ]);
    }
}
