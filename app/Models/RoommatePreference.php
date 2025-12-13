<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoommatePreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        // Sleep habits
        'sleep_lamp_off',
        'sleep_late',
        'sleep_noise_tolerant',
        'sleep_snore',
        // Cleanliness
        'clean_daily',
        'clean_tolerance',
        'clean_self_wash',
        'clean_shared_duty',
        // Study/Work
        'study_late',
        'study_quiet_needed',
        'study_music',
        // Social
        'guest_welcome',
        'introvert',
        'smoking',
        'pet_friendly',
        // Bio
        'description',
        'contact_preference',
        'is_active',
    ];

    protected $casts = [
        'sleep_lamp_off' => 'boolean',
        'sleep_late' => 'boolean',
        'sleep_noise_tolerant' => 'boolean',
        'sleep_snore' => 'boolean',
        'clean_daily' => 'boolean',
        'clean_tolerance' => 'boolean',
        'clean_self_wash' => 'boolean',
        'clean_shared_duty' => 'boolean',
        'study_late' => 'boolean',
        'study_quiet_needed' => 'boolean',
        'study_music' => 'boolean',
        'guest_welcome' => 'boolean',
        'introvert' => 'boolean',
        'smoking' => 'boolean',
        'pet_friendly' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user that owns the preference.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all preference fields that are used for matching.
     */
    public static function getMatchableFields(): array
    {
        return [
            'sleep_lamp_off',
            'sleep_late',
            'sleep_noise_tolerant',
            'sleep_snore',
            'clean_daily',
            'clean_tolerance',
            'clean_self_wash',
            'clean_shared_duty',
            'study_late',
            'study_quiet_needed',
            'study_music',
            'guest_welcome',
            'introvert',
            'smoking',
            'pet_friendly',
        ];
    }

    /**
     * Calculate match percentage with another preference.
     */
    public function calculateMatchPercentage(RoommatePreference $other): int
    {
        $fields = self::getMatchableFields();
        $matches = 0;
        $total = count($fields);

        foreach ($fields as $field) {
            // Special handling for smoking - both should have same preference
            if ($field === 'smoking') {
                if ($this->$field === $other->$field) {
                    $matches++;
                }
            }
            // For sleep_noise_tolerant - if one snores, the other should be tolerant
            elseif ($field === 'sleep_noise_tolerant') {
                // If neither snores, or if snorer is paired with tolerant, it's a match
                if (!$this->sleep_snore && !$other->sleep_snore) {
                    $matches++;
                } elseif ($this->sleep_snore && $other->sleep_noise_tolerant) {
                    $matches++;
                } elseif ($other->sleep_snore && $this->sleep_noise_tolerant) {
                    $matches++;
                }
            }
            // For most fields, similar preferences mean better compatibility
            else {
                if ($this->$field === $other->$field) {
                    $matches++;
                }
            }
        }

        return (int) round(($matches / $total) * 100);
    }

    /**
     * Get match percentage as formatted string.
     */
    public function getMatchBadgeColor(int $percentage): string
    {
        if ($percentage >= 80) {
            return 'bg-green-500';
        } elseif ($percentage >= 60) {
            return 'bg-yellow-500';
        } elseif ($percentage >= 40) {
            return 'bg-orange-500';
        }
        return 'bg-red-500';
    }
}
