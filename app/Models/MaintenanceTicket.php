<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class MaintenanceTicket extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'maintenance_ticket';

    protected $fillable = [
        'device_id',
        'technician_id',
        'failure_device_description',
        'state',
        'date_maintenance',
        'failure',
        'parts_cost',
        'idle_time',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class, 'device_id');
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'technician_id');
    }
}
