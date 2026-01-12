<?php

namespace App\Filament\Resources\Devices\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DevicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('photo_device')
                    ->label('Foto'),
                TextColumn::make('serial')
                    ->label('Serial')
                    ->searchable(),
                TextColumn::make('model')
                    ->label('Modelo')
                    ->searchable(),
                TextColumn::make('cost')
                    ->label('Precio')
                    ->money()
                    ->sortable(),
                TextColumn::make('state')
                    ->label('Estado')
                    ->badge(),
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
                Filter::make('Disponibles')
                    ->query(fn(Builder $query): Builder => $query->orWhere('state', 'available')),
                Filter::make('Asignados')
                    ->query(fn(Builder $query): Builder => $query->orWhere('state', 'assigned')),
                Filter::make('Mantenimiento')
                    ->query(fn(Builder $query): Builder => $query->orWhere('state', 'maintenance')),
                Filter::make('Descartados')
                    ->query(fn(Builder $query): Builder => $query->orWhere('state', 'discarded'))
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
