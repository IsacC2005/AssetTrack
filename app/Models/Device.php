<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Device extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'employee_id',
        'serial',
        'model',
        'detail',
        'cost',
        'state',
        'maintenance_interval',
        'last_notified_at'
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function maintenanceTickets(): HasMany
    {
        return $this->hasMany(MaintenanceTicket::class, 'device_id');
    }

    public function lastMaintenance(): HasOne
    {
        return $this->hasOne(MaintenanceTicket::class)->latestOfMany();
    }

    protected function casts(): array
    {
        return [
            'last_notified_at' => 'datetime',
            'maintenance_interval' => 'integer', // Aprovecha para asegurar que el intervalo sea un número
        ];
    }
}
