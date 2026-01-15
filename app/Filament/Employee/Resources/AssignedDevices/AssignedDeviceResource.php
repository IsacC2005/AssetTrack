<?php

namespace App\Filament\Employee\Resources\AssignedDevices;

use App\Filament\Employee\Resources\AssignedDevices\Pages\CreateAssignedDevice;
use App\Filament\Employee\Resources\AssignedDevices\Pages\EditAssignedDevice;
use App\Filament\Employee\Resources\AssignedDevices\Pages\ListAssignedDevices;
use App\Filament\Employee\Resources\AssignedDevices\Schemas\AssignedDeviceForm;
use App\Filament\Employee\Resources\AssignedDevices\Tables\AssignedDevicesTable;
use App\Models\Device;
use App\Models\Employee;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class AssignedDeviceResource extends Resource
{
    protected static ?string $model = Device::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDevicePhoneMobile;

    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::DevicePhoneMobile;

    protected static ?string $label = 'Dispositivo asignado';

    protected static ?string $pluralLabel = 'Dispositivos asignados';

    protected static string|UnitEnum|null $navigationGroup = 'Gestión de Inventario';

    public static function form(Schema $schema): Schema
    {
        return AssignedDeviceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AssignedDevicesTable::configure($table);
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

        // dd($employee->user_id ? 0 : 'no existe el ');
        //dd($user_id);
        return parent::getEloquentQuery()
            ->where('employee_id', $employee_id);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAssignedDevices::route('/'),
            'create' => CreateAssignedDevice::route('/create'),
            'edit' => EditAssignedDevice::route('/{record}/edit'),
        ];
    }
}
