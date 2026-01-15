<?php

namespace App\Filament\Maintenance\Resources\AssignedMaintenances\Tables;

use App\Jobs\MaintenanceJob;
use App\Models\MaintenanceTicket;
use App\Models\User;
use App\Notifications\CostMaintenance;
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


                            // $users = User::role('super_admin')->get();


                            // foreach ($users as $user) {
                            //     /**
                            //      * @var User
                            //      */
                            //     $user->notify(new CostMaintenance($ticket));
                            // }
                            // dd($users);

                            MaintenanceJob::dispatch($ticket)->onQueue('maintenance');
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
