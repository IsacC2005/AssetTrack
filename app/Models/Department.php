<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function employees(): HasOne
    {
        return $this->hasOne(Employee::class);
    }

    public function devices(): HasManyThrough
    {
        return $this->hasManyThrough(Device::class, Employee::class);
    }
}
