<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class LogActivity
{
    /**
     * Record an activity log.
     *
     * @param string $action
     * @param string|null $description
     * @return ActivityLog
     */
    public static function record(string $action, ?string $description = null): ActivityLog
    {
        $user = Auth::user();

        return ActivityLog::create([
            'user_id' => $user?->id,
            'role' => $user?->role ?? 'guest',
            'action' => strtoupper($action),
            'description' => $description,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'created_at' => now(),
        ]);
    }

    /**
     * Record login activity.
     */
    public static function login(): ActivityLog
    {
        return self::record('LOGIN', 'User berhasil login ke sistem');
    }

    /**
     * Record logout activity.
     */
    public static function logout(): ActivityLog
    {
        return self::record('LOGOUT', 'User keluar dari sistem');
    }
}
