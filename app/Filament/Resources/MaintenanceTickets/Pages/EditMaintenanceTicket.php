<?php

namespace App\Filament\Resources\MaintenanceTickets\Pages;

use App\Filament\Resources\MaintenanceTickets\MaintenanceTicketResource;
use App\Jobs\Maintenance\AssignedMaintenanceJob;
use App\Models\MaintenanceTicket;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditMaintenanceTicket extends EditRecord
{
    protected static string $resource = MaintenanceTicketResource::class;

    protected static ?string $title = 'Asignar técnico';

    protected function getSaveFormActionLabel(): string
    {
        return 'Confirmar Asignación';
    }

    public function getBreadcrumb(): string
    {
        return 'Asignar';
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Mantenimiento Asignado');
    }

    protected function afterSave(): void
    {
        /**
         * @var MaintenanceTicket
         */
        $maintenance = $this->record;

        $technician = $maintenance->technician;

        AssignedMaintenanceJob::dispatch($maintenance, $technician)->onQueue('maintenance');
    }
}
