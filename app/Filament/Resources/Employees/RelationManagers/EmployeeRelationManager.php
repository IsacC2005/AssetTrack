<?php

namespace App\Filament\Resources\Employees\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EmployeeRelationManager extends RelationManager
{
    protected static string $relationship = 'devices';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('serial')
                    ->label('Serial')
                    ->required(),
                TextInput::make('model')
                    ->label('Modelo')
                    ->required(),
                Textarea::make('detail')
                    ->label('Detalles')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('cost')
                    ->label('Costo')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
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

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('model')
                    ->label('Modelo')
                    ->searchable(),
                TextColumn::make('serial')
                    ->label('Serial')
                    ->searchable(),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()->mutateDataUsing(function (array $data): array {
                    $data['state'] = 'assigned';
                    return $data;
                }),
                AssociateAction::make()
                    ->preloadRecordSelect()
                    ->recordTitleAttribute('model')
                    ->recordSelectSearchColumns(['model', 'serial'])
                    ->recordSelectOptionsQuery(function (Builder $query) {
                        return $query->whereNull('employee_id');
                    })
            ])
            ->recordActions([
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
