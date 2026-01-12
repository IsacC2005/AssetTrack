<?php

namespace App\Filament\Resources\MaintenanceTickets\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TechnicalRelationManager extends RelationManager
{
    protected static string $relationship = 'technician';

    protected static ?string $title = 'Técnico';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('employee')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('employee'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('employee')
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nombre')
                    ->searchable(),
                TextColumn::make('user.email')
                    ->label('Correo')
                    ->searchable(),
                TextColumn::make('workstation')
                    ->label('Puesto'),
                TextColumn::make('department.name')
                    ->label('Departamento')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //CreateAction::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
