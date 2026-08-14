<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\BookingApproval;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'admin_id',
        'vehicle_id',
        'driver_id',
        'start_date',
        'end_date',
        'purpose',
        'status',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(BookingApproval::class)->orderBy('level', 'asc');
    }
}