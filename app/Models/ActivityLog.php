<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'role',
        'action',
        'description',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Get the user that performed the action.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get formatted action badge color.
     */
    public function getActionColorAttribute(): string
    {
        return match(strtoupper($this->action)) {
            'LOGIN' => 'bg-green-100 text-green-700',
            'LOGOUT' => 'bg-gray-100 text-gray-700',
            'CREATE', 'TAMBAH' => 'bg-blue-100 text-blue-700',
            'UPDATE', 'EDIT' => 'bg-yellow-100 text-yellow-700',
            'DELETE', 'HAPUS' => 'bg-red-100 text-red-700',
            'BOOKING' => 'bg-purple-100 text-purple-700',
            'APPROVE' => 'bg-green-100 text-green-700',
            'REJECT' => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }
}
