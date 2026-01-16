<?php

namespace App\Filament\Resources\MaintenanceTickets;

use App\Filament\Resources\MaintenanceTickets\Pages\CreateMaintenanceTicket;
use App\Filament\Resources\MaintenanceTickets\Pages\EditMaintenanceTicket;
use App\Filament\Resources\MaintenanceTickets\Pages\ListMaintenanceTickets;
use App\Filament\Resources\MaintenanceTickets\RelationManagers\DeviceRelationManager;
use App\Filament\Resources\MaintenanceTickets\RelationManagers\TechnicalRelationManager;
use App\Filament\Resources\MaintenanceTickets\Schemas\MaintenanceTicketForm;
use App\Filament\Resources\MaintenanceTickets\Tables\MaintenanceTicketsTable;
use App\Models\MaintenanceTicket;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class MaintenanceTicketResource extends Resource
{
    protected static ?string $model = MaintenanceTicket::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::WrenchScrewdriver;

    protected static ?string $navigationLabel = 'Mantenimiento';

    protected static ?string $label = 'Mantenimiento';

    protected static ?string $pluralLabel = 'Mantenimientos';

    protected static string|UnitEnum|null $navigationGroup = 'Operaciones';

    public static function form(Schema $schema): Schema
    {
        return MaintenanceTicketForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MaintenanceTicketsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            // DeviceRelationManager::class,
            // TechnicalRelationManager::class
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereNot('state', 'done');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMaintenanceTickets::route('/'),
            'create' => CreateMaintenanceTicket::route('/create'),
            'edit' => EditMaintenanceTicket::route('/{record}/edit'),
        ];
    }
}
