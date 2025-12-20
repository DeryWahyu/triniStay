<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'boarding_house_id',
        'room_number',
        'floor',
        'status',
        'notes',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    /**
     * Get the boarding house that owns the room.
     */
    public function boardingHouse(): BelongsTo
    {
        return $this->belongsTo(BoardingHouse::class);
    }

    /**
     * Get all bookings for this room.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get active booking for this room.
     */
    public function activeBooking()
    {
        return $this->hasOne(Booking::class)
            ->where('status', 'approved')
            ->where('end_date', '>=', now());
    }

    /**
     * Get current active booking (alias for activeBooking).
     */
    public function currentBooking()
    {
        return $this->activeBooking();
    }

    /**
     * Check if room is available for booking.
     */
    public function isAvailable(): bool
    {
        if ($this->status !== 'available') {
            return false;
        }

        return !$this->bookings()
            ->whereIn('status', ['pending', 'approved'])
            ->where('end_date', '>=', now())
            ->exists();
    }

    /**
     * Get status badge color.
     */
    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status) {
            'available' => 'bg-green-100 text-green-800',
            'occupied' => 'bg-red-100 text-red-800',
            'maintenance' => 'bg-yellow-100 text-yellow-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get status label in Indonesian.
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'available' => 'Tersedia',
            'occupied' => 'Terisi',
            'maintenance' => 'Perbaikan',
            default => 'Unknown',
        };
    }
}
