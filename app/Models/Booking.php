<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'user_id',
        'boarding_house_id',
        'room_id',
        'start_date',
        'duration',
        'end_date',
        'price_per_period',
        'total_price',
        'payment_proof',
        'status',
        'rejection_reason',
        'is_shared',
        'shared_with_email',
        'shared_with_user_id',
        'shared_status',
        'parent_booking_id',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'price_per_period' => 'integer',
        'total_price' => 'integer',
        'is_shared' => 'boolean',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->booking_code)) {
                $booking->booking_code = 'TRN-' . strtoupper(Str::random(8));
            }
        });
    }

    /**
     * Get the user who made the booking.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the boarding house for this booking.
     */
    public function boardingHouse(): BelongsTo
    {
        return $this->belongsTo(BoardingHouse::class);
    }

    /**
     * Get the room for this booking.
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get the shared user (room match partner).
     */
    public function sharedWithUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'shared_with_user_id');
    }

    /**
     * Get the review for this booking.
     */
    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    /**
     * Get the parent booking (for linked/invited bookings).
     */
    public function parentBooking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'parent_booking_id');
    }

    /**
     * Get the linked booking (for original booking to see invited user's booking).
     */
    public function linkedBooking(): HasOne
    {
        return $this->hasOne(Booking::class, 'parent_booking_id');
    }

    /**
     * Get formatted total price.
     */
    public function getFormattedTotalPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    /**
     * Get formatted price per period.
     */
    public function getFormattedPricePerPeriodAttribute(): string
    {
        return 'Rp ' . number_format($this->price_per_period, 0, ',', '.');
    }

    /**
     * Get duration label.
     */
    public function getDurationLabelAttribute(): string
    {
        return match($this->duration) {
            '1_month' => '1 Bulan',
            '3_months' => '3 Bulan',
            '6_months' => '6 Bulan',
            '1_year' => '1 Tahun',
            default => $this->duration,
        };
    }

    /**
     * Get status badge color.
     */
    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            'cancelled' => 'bg-gray-100 text-gray-800',
            'completed' => 'bg-blue-100 text-blue-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get status label in Indonesian.
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu Konfirmasi',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'cancelled' => 'Dibatalkan',
            'completed' => 'Selesai',
            default => 'Unknown',
        };
    }

    /**
     * Get shared status label.
     */
    public function getSharedStatusLabelAttribute(): ?string
    {
        if (!$this->is_shared) {
            return null;
        }

        return match($this->shared_status) {
            'pending' => 'Menunggu Konfirmasi Teman',
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak',
            default => null,
        };
    }

    /**
     * Calculate end date based on start date and duration.
     */
    public static function calculateEndDate($startDate, $duration): \Carbon\Carbon
    {
        $start = \Carbon\Carbon::parse($startDate);

        return match($duration) {
            '1_month' => $start->addMonth(),
            '3_months' => $start->addMonths(3),
            '6_months' => $start->addMonths(6),
            '1_year' => $start->addYear(),
            default => $start->addMonth(),
        };
    }

    /**
     * Scope for user's bookings (as booker or shared partner).
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId)
            ->orWhere('shared_with_user_id', $userId);
    }

    /**
     * Check if booking is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'approved' && $this->end_date >= now();
    }
}
