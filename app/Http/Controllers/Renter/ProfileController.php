<?php

namespace App\Http\Controllers\Renter;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show the renter profile page
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        
        // Get booking statistics
        $totalBookings = $user->bookings()->count();
        $activeBookings = $user->bookings()->whereIn('status', ['approved', 'pending'])->count();
        $completedBookings = $user->bookings()->where('status', 'completed')->count();
        
        return view('renter.profile.index', compact('user', 'totalBookings', 'activeBookings', 'completedBookings'));
    }

    /**
     * Update renter profile
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'gender' => 'nullable|in:Male,Female',
            'date_of_birth' => 'nullable|date|before:today',
        ]);

        /** @var User $user */
        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
        ]);

        return redirect()->route('renter.profile.index')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        /** @var User $user */
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('renter.profile.index')
            ->with('success', 'Password berhasil diubah!');
    }
}

