<?php

namespace App\Filament\Employee\Resources\AssignedDevices\Tables;

use App\Jobs\Maintenance\RequestMaintenanceJob;
use App\Models\Device;
use App\Models\MaintenanceTicket;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AssignedDevicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('photo_device'),
                TextColumn::make('serial'),
                TextColumn::make('model'),
                TextColumn::make('last_ticket_maintenance')
                    ->label('Estado mantenimiento')
                    ->getStateUsing(
                        function (Device $device): string {
                            /**
                             * @var MaintenanceTicket
                             */
                            $lastTicket = $device->maintenanceTickets()->latest()->first();

                            $status = '';

                            if (!$lastTicket) {
                                return 'Sin ticket';
                            }

                            switch ($lastTicket->state) {
                                case 'pending':
                                    $status = 'Pendiente';
                                    break;
                                case 'discarded':
                                    $status = 'Desechado';
                                    break;
                                case 'rejected':
                                    $status = 'Rechazado';
                                    break;
                                case 'done':
                                    /**
                                     * @var Carbon
                                     */
                                    $date = $lastTicket->updated_at;

                                    $status = $date->diffForHumans();
                                    break;
                                default:
                                    $status = 'Sin ticket';
                                    break;
                            }

                            return $status;
                        }
                    )
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Pendiente' => 'warning',
                        'Sin ticket' => 'secondary',
                        'Rechazado' => 'gray',
                        'Desechado' => 'danger',
                        default => 'success',
                    })
            ])
            ->recordUrl(null)
            ->recordActions([
                //EditAction::make(),
                Action::make('createTicket')
                    ->label('Mantenimiento')
                    ->icon(Heroicon::WrenchScrewdriver)
                    ->color('warning')
                    ->visible(
                        fn(Device $record) =>
                        !$record->maintenanceTickets()->where('state', 'pending')->exists()
                    )
                    ->modalDescription('Registra el problema del equipo')
                    ->modalSubmitActionLabel('Crear Ticket de mantenimiento')
                    ->form([
                        Textarea::make('description')
                            ->label('Descripción del problema')
                            ->required()
                    ])
                    ->action(function (Device $device, array $data): void {
                        /**
                         * @var MaintenanceTicket
                         */
                        $maintenance = MaintenanceTicket::create([
                            'device_id' => $device->id,
                            'failure_device_description' => $data['description'],
                            'state' => 'pending'
                        ]);

                        Notification::make()
                            ->title('Solicitud de mantenimiento creada.')
                            ->success()
                            ->send();

                        RequestMaintenanceJob::dispatch($maintenance, $data['description'])->onQueue('maintenance');

                        // dd($record);
                    })
            ]);
    }
}
