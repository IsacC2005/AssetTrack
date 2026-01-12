<?php

namespace App\Filament\Resources\MaintenanceTickets\Tables;

use App\Models\Employee;
use App\Models\MaintenanceTicket;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MaintenanceTicketsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('device.model')
                    ->label('Dispositivo')
                    ->searchable(),
                TextColumn::make('technician.user.name')
                    ->label('Técnico')
                    ->searchable(),
                TextColumn::make('parts_cost')
                    ->label('Costo del mantenimiento')
                    ->money()
                    ->sortable(),
                TextColumn::make('idle_time')
                    ->label('Tiempo inactivo')
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
            ->recordActions([
                // EditAction::make(),
                Action::make('assigned technical')
                    ->modalHeading('Asignar tecnico')
                    ->form([
                        Select::make('technician_id')
                            ->relationship(
                                name: 'technician',
                                titleAttribute: 'id',
                                modifyQueryUsing: function (Builder $query) {
                                    $query->whereHas('department', function ($q) {
                                        $q->where('name', 'Mantenimiento');
                                    });
                                }
                            )
                            ->getOptionLabelFromRecordUsing(fn(Employee $record) => "{$record->user->name} | $record->workstation")
                    ])
                    ->action(
                        function (MaintenanceTicket $ticket, array $data): void {

                            $ticket->update([
                                'technician_id' => $data['technician_id']
                            ]);
                        }
                    )
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
