<?php

namespace App\Filament\Maintenance\Resources\AssignedMaintenances\Tables;

use App\Jobs\Maintenance\DoneMaintenanceJob;
use App\Jobs\Maintenance\CostMaintenanceJob;
use App\Models\MaintenanceTicket;
use App\Models\User;
use App\Notifications\CostMaintenance;
use App\Notifications\GeneralNotification;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AssignedMaintenancesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('device.model')
                    ->label('Modelo del dispositivo'),
                TextColumn::make('device.serial')
                    ->label('Serial'),
                TextColumn::make('parts_cost')
                    ->default('N/A')
                    ->label('Costo de reparación')
                    ->money()
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('Costo')
                    ->modalHeading('Establecer costo de reparación.')
                    ->form([
                        TextInput::make('price')
                            ->label('Costo de reparación')
                            ->integer()
                            ->required()
                    ])
                    ->action(
                        function (MaintenanceTicket $ticket, array $data) {
                            $price = $data['price'];
                            $ticket->parts_cost = $price;

                            $ticket->save();

                            Notification::make()
                                ->title('Costo de mantenimiento definido.')
                                ->body('Debes esperar que aprueben el mantenimiento.')
                                ->success()
                                ->send();

                            CostMaintenanceJob::dispatch($ticket)->onQueue('maintenance');
                        }
                    )
                    ->visible(
                        fn(MaintenanceTicket $ticket): bool => $ticket->parts_cost ? false : true
                    ),
                Action::make('Listo')
                    ->action(
                        function (MaintenanceTicket $ticket) {
                            $ticket->state = 'done';

                            // $ticket->save();

                            Notification::make()
                                ->title('Mantenimiento marcado como realizado.')
                                ->send();

                            DoneMaintenanceJob::dispatch($ticket)->onQueue('maintenance');
                        }
                    )
                    ->visible(fn(MaintenanceTicket $ticket): bool => $ticket->parts_cost ? true : false)

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
