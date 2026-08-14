<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Region; // <-- Tambahkan import ini
use App\Models\Booking; // <-- Tambahkan import ini

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'region_id',
        'name',
        'license_plate',
        'type',
        'ownership',
        'rental_company',
        'fuel_consumption',
        'status',
    ];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}