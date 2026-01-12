<?php

namespace App\Filament\Resources\MaintenanceTickets\Pages;

use App\Filament\Resources\MaintenanceTickets\MaintenanceTicketResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMaintenanceTicket extends CreateRecord
{
    protected static string $resource = MaintenanceTicketResource::class;
}
