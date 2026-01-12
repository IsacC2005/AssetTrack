<?php

namespace App\Filament\Resources\MaintenanceTickets\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DeviceRelationManager extends RelationManager
{
    protected static string $relationship = 'device';

    protected static ?string $title = 'Dispositivo';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('serial')
                    ->required(),
                TextInput::make('model')
                    ->required(),
                Textarea::make('detail')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('cost')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Select::make('state')
                    ->options([
                        'assigned' => 'Assigned',
                        'available' => 'Available',
                        'maintenance' => 'Maintenance',
                        'discarded' => 'Discarded',
                    ])
                    ->required(),
                TextInput::make('maintenance_interval')
                    ->required()
                    ->numeric(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('employee')
            ->columns([
                TextColumn::make('serial')
                    ->searchable(),
                TextColumn::make('model')
                    ->searchable(),
                TextColumn::make('cost')
                    ->money()
                    ->sortable(),
                TextColumn::make('state')
                    ->badge(),
                TextColumn::make('maintenance_interval')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
