<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone_number',
        'age',
        'gender',
        'bank_name',
        'bank_account_number',
        'bank_account_name',
        'is_blocked',
        'last_seen_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_blocked' => 'boolean',
            'last_seen_at' => 'datetime',
        ];
    }

    /**
     * Check if user is superadmin.
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    /**
     * Check if user is owner.
     */
    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }

    /**
     * Check if user is renter.
     */
    public function isRenter(): bool
    {
        return $this->role === 'renter';
    }

    /**
     * Get the roommate preference for this user.
     */
    public function roommatePreference()
    {
        return $this->hasOne(RoommatePreference::class);
    }

    /**
     * Check if user has roommate preference.
     */
    public function hasRoommatePreference(): bool
    {
        return $this->roommatePreference()->exists();
    }

    /**
     * Get user initials for avatar.
     */
    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->name);
        $initials = '';
        foreach (array_slice($words, 0, 2) as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }
        return $initials;
    }

    /**
     * Check if user is currently online (active within last 5 minutes).
     */
    public function isOnline(): bool
    {
        if (!$this->last_seen_at) {
            return false;
        }
        return $this->last_seen_at->diffInMinutes(now()) < 5;
    }

    /**
     * Get the activity logs for this user.
     */
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * Get the boarding houses owned by this user.
     */
    public function boardingHouses()
    {
        return $this->hasMany(BoardingHouse::class, 'owner_id');
    }
}
