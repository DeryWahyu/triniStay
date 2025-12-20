<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class BoardingHouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'slug',
        'price',
        'price_monthly',
        'price_3months',
        'price_6months',
        'price_yearly',
        'room_size',
        'total_rooms',
        'available_rooms',
        'rent_schemes',
        'room_facilities',
        'common_facilities',
        'images',
        'address',
        'latitude',
        'longitude',
        'description',
        'rules',
        'is_room_match_enabled',
        'room_match_price',
        'room_match_period',
        'status',
    ];

    protected $casts = [
        'rent_schemes' => 'array',
        'room_facilities' => 'array',
        'common_facilities' => 'array',
        'images' => 'array',
        'is_room_match_enabled' => 'boolean',
        'price' => 'integer',
        'price_monthly' => 'integer',
        'price_3months' => 'integer',
        'price_6months' => 'integer',
        'price_yearly' => 'integer',
        'room_match_price' => 'integer',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($boardingHouse) {
            if (empty($boardingHouse->slug)) {
                $boardingHouse->slug = Str::slug($boardingHouse->name) . '-' . Str::random(6);
            }
        });
    }

    /**
     * Get the owner of the boarding house.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Alias for owner relationship.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the rooms for this boarding house.
     */
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    /**
     * Get the bookings for this boarding house.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get the reviews for this boarding house.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get average rating.
     */
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->published()->avg('rating') ?? 0;
    }

    /**
     * Get reviews count.
     */
    public function getReviewsCountAttribute()
    {
        return $this->reviews()->published()->count();
    }

    /**
     * Get truly available rooms count (excluding rooms with pending/approved bookings).
     */
    public function getAvailableRoomsCountAttribute()
    {
        return $this->rooms()
            ->where('status', 'available')
            ->whereDoesntHave('bookings', function ($query) {
                $query->whereIn('status', ['pending', 'approved'])
                    ->where('end_date', '>=', now());
            })
            ->count();
    }

    /**
     * Get count of rooms currently booked (pending or approved).
     */
    public function getBookedRoomsCountAttribute()
    {
        return $this->rooms()
            ->whereHas('bookings', function ($query) {
                $query->whereIn('status', ['pending', 'approved'])
                    ->where('end_date', '>=', now());
            })
            ->count();
    }

    /**
     * Get formatted price.
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price_monthly ?? $this->price, 0, ',', '.');
    }

    /**
     * Get formatted monthly price.
     */
    public function getFormattedPriceMonthlyAttribute(): string
    {
        return $this->price_monthly
            ? 'Rp ' . number_format($this->price_monthly, 0, ',', '.')
            : '-';
    }

    /**
     * Get formatted 3 months price.
     */
    public function getFormattedPrice3monthsAttribute(): string
    {
        return $this->price_3months
            ? 'Rp ' . number_format($this->price_3months, 0, ',', '.')
            : '-';
    }

    /**
     * Get formatted 6 months price.
     */
    public function getFormattedPrice6monthsAttribute(): string
    {
        return $this->price_6months
            ? 'Rp ' . number_format($this->price_6months, 0, ',', '.')
            : '-';
    }

    /**
     * Get formatted yearly price.
     */
    public function getFormattedPriceYearlyAttribute(): string
    {
        return $this->price_yearly
            ? 'Rp ' . number_format($this->price_yearly, 0, ',', '.')
            : '-';
    }

    /**
     * Get type label in Indonesian.
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'putra' => 'Kos Putra',
            'putri' => 'Kos Putri',
            'campur' => 'Kos Campur',
            default => 'Kos Campur',
        };
    }

    /**
     * Get type badge color.
     */
    public function getTypeBadgeColorAttribute(): string
    {
        return match($this->type) {
            'putra' => 'bg-blue-100 text-blue-800',
            'putri' => 'bg-pink-100 text-pink-800',
            'campur' => 'bg-purple-100 text-purple-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get formatted room match price.
     */
    public function getFormattedRoomMatchPriceAttribute(): string
    {
        return $this->room_match_price
            ? 'Rp ' . number_format($this->room_match_price, 0, ',', '.')
            : '-';
    }

    /**
     * Get first image.
     */
    public function getFirstImageAttribute(): string
    {
        if ($this->images && count($this->images) > 0) {
            return asset('storage/' . $this->images[0]);
        }
        return 'https://via.placeholder.com/300x200?text=No+Image';
    }

    /**
     * Get all images with full URL.
     */
    public function getImageUrlsAttribute(): array
    {
        if (!$this->images) {
            return [];
        }

        return array_map(function($image) {
            return asset('storage/' . $image);
        }, $this->images);
    }

    /**
     * Scope for active boarding houses.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for owner's boarding houses.
     */
    public function scopeOwnedBy($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope for filtering by type.
     */
    public function scopeOfType($query, $type)
    {
        if ($type && in_array($type, ['putra', 'putri', 'campur'])) {
            return $query->where('type', $type);
        }
        return $query;
    }

    /**
     * Scope for room match enabled boarding houses.
     */
    public function scopeRoomMatchEnabled($query)
    {
        return $query->where('is_room_match_enabled', true);
    }

    /**
     * Scope for filtering by price range.
     */
    public function scopePriceRange($query, $min = null, $max = null)
    {
        if ($min) {
            $query->where('price_monthly', '>=', $min);
        }
        if ($max) {
            $query->where('price_monthly', '<=', $max);
        }
        return $query;
    }
}
