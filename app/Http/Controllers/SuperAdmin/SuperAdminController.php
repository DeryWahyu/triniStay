<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\BoardingHouse;
use App\Models\Booking;
use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    /**
     * Display the SuperAdmin dashboard.
     */
    public function dashboard()
    {
        // Stats
        $totalRenters = User::where('role', 'renter')->count();
        $totalOwners = User::where('role', 'owner')->count();
        $totalBoardingHouses = BoardingHouse::count();

        // Average Rating from reviews
        $averageRating = Review::where('is_published', true)->avg('rating') ?? 0;
        $totalReviews = Review::where('is_published', true)->count();

        // Monthly visitor/booking data for chart (last 6 months)
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthName = $date->translatedFormat('M');
            
            // Count bookings per month as "visitors/activity"
            $bookingCount = Booking::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            
            // Count new users per month
            $userCount = User::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $monthlyData[] = [
                'month' => $monthName,
                'bookings' => $bookingCount,
                'users' => $userCount,
            ];
        }

        // Online users (last seen within 5 minutes)
        $onlineUsers = User::where('last_seen_at', '>=', Carbon::now()->subMinutes(5))
            ->where('role', '!=', 'superadmin')
            ->orderBy('last_seen_at', 'desc')
            ->take(10)
            ->get();

        // Recent activity logs
        $recentActivities = ActivityLog::with('user')
            ->latest('created_at')
            ->take(5)
            ->get();

        return view('superadmin.dashboard', compact(
            'totalRenters',
            'totalOwners',
            'totalBoardingHouses',
            'averageRating',
            'totalReviews',
            'monthlyData',
            'onlineUsers',
            'recentActivities'
        ));
    }

    /**
     * Display all users.
     */
    public function users(Request $request)
    {
        $query = User::where('role', '!=', 'superadmin');

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('superadmin.users.index', compact('users'));
    }

    /**
     * Delete a user.
     */
    public function destroyUser(User $user)
    {
        if ($user->role === 'superadmin') {
            return back()->withErrors(['error' => 'Tidak dapat menghapus SuperAdmin.']);
        }

        $userName = $user->name;
        $user->delete();

        LogActivity::record('DELETE', "Menghapus pengguna: {$userName}");

        return back()->with('success', "Pengguna {$userName} berhasil dihapus.");
    }

    /**
     * Toggle block/unblock user.
     */
    public function toggleBlockUser(User $user)
    {
        if ($user->role === 'superadmin') {
            return back()->withErrors(['error' => 'Tidak dapat memblokir SuperAdmin.']);
        }

        $user->update(['is_blocked' => !$user->is_blocked]);

        $action = $user->is_blocked ? 'BLOCK' : 'UNBLOCK';
        $message = $user->is_blocked ? 'diblokir' : 'dibuka blokirnya';

        LogActivity::record($action, "Pengguna {$user->name} {$message}");

        return back()->with('success', "Pengguna {$user->name} berhasil {$message}.");
    }

    /**
     * Display all boarding houses.
     */
    public function boardingHouses(Request $request)
    {
        $query = BoardingHouse::with(['owner', 'rooms']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('owner', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $boardingHouses = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('superadmin.kost.index', compact('boardingHouses'));
    }

    /**
     * Display activity logs.
     */
    public function activityLogs(Request $request)
    {
        $query = ActivityLog::with('user');

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $activities = $query->latest('created_at')->paginate(20);

        // Get unique actions for filter dropdown
        $actions = ActivityLog::distinct()->pluck('action');

        return view('superadmin.activity.index', compact('activities', 'actions'));
    }
}
