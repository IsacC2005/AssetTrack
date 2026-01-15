<?php

namespace App\Filament\Maintenance\Resources\AssignedMaintenances;

use App\Filament\Maintenance\Resources\AssignedMaintenances\Pages\CreateAssignedMaintenance;
use App\Filament\Maintenance\Resources\AssignedMaintenances\Pages\EditAssignedMaintenance;
use App\Filament\Maintenance\Resources\AssignedMaintenances\Pages\ListAssignedMaintenances;
use App\Filament\Maintenance\Resources\AssignedMaintenances\Pages\ViewAssignedMaintenance;
use App\Filament\Maintenance\Resources\AssignedMaintenances\Schemas\AssignedMaintenanceForm;
use App\Filament\Maintenance\Resources\AssignedMaintenances\Schemas\AssignedMaintenanceInfolist;
use App\Filament\Maintenance\Resources\AssignedMaintenances\Tables\AssignedMaintenancesTable;
use App\Models\MaintenanceTicket;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class AssignedMaintenanceResource extends Resource
{
    protected static ?string $model = MaintenanceTicket::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return AssignedMaintenanceForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AssignedMaintenanceInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AssignedMaintenancesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): Builder
    {

        $employee_id = Auth::user()->employee?->id ?? 0;


        return parent::getEloquentQuery()
            ->where('technician_id', $employee_id);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAssignedMaintenances::route('/'),
            'create' => CreateAssignedMaintenance::route('/create'),
            'view' => ViewAssignedMaintenance::route('/{record}'),
            'edit' => EditAssignedMaintenance::route('/{record}/edit'),
        ];
    }
}
