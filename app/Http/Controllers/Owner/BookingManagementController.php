<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BoardingHouse;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingManagementController extends Controller
{
    /**
     * Display all bookings for owner's boarding houses.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Get all boarding houses owned by this user
        $boardingHouseIds = BoardingHouse::where('user_id', $user->id)->pluck('id');

        // Filter by status if provided
        $status = $request->get('status');

        $query = Booking::whereIn('boarding_house_id', $boardingHouseIds)
            ->with(['user', 'boardingHouse', 'room', 'sharedWithUser']);

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $bookings = $query->latest()->paginate(15);

        // Get counts for tabs
        $pendingCount = Booking::whereIn('boarding_house_id', $boardingHouseIds)
            ->where('status', 'pending')
            ->count();
        $approvedCount = Booking::whereIn('boarding_house_id', $boardingHouseIds)
            ->where('status', 'approved')
            ->count();
        $totalCount = Booking::whereIn('boarding_house_id', $boardingHouseIds)->count();

        return view('owner.bookings.index', compact(
            'bookings',
            'status',
            'pendingCount',
            'approvedCount',
            'totalCount'
        ));
    }

    /**
     * Show booking details.
     */
    public function show(Booking $booking)
    {
        // Check authorization
        $boardingHouse = $booking->boardingHouse;
        if ($boardingHouse->user_id !== Auth::id()) {
            abort(403);
        }

        $booking->load(['user', 'boardingHouse', 'room', 'sharedWithUser', 'review']);

        return view('owner.bookings.show', compact('booking'));
    }

    /**
     * Approve a booking.
     */
    public function approve(Booking $booking)
    {
        // Check authorization
        $boardingHouse = $booking->boardingHouse;
        if ($boardingHouse->user_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->status !== 'pending') {
            return back()->withErrors(['error' => 'Booking tidak dalam status pending.']);
        }

        // Update booking status
        $booking->update(['status' => 'approved']);

        // Update room status if room is assigned
        if ($booking->room_id) {
            Room::where('id', $booking->room_id)->update(['status' => 'occupied']);
        }

        // TODO: Send notification email to renter

        return back()->with('success', 'Booking berhasil disetujui!');
    }

    /**
     * Reject a booking.
     */
    public function reject(Request $request, Booking $booking)
    {
        // Check authorization
        $boardingHouse = $booking->boardingHouse;
        if ($boardingHouse->user_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->status !== 'pending') {
            return back()->withErrors(['error' => 'Booking tidak dalam status pending.']);
        }

        $reason = $request->get('reason', 'Tidak ada alasan yang diberikan.');

        $booking->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
        ]);

        // TODO: Send notification email to renter

        return back()->with('success', 'Booking ditolak.');
    }

    /**
     * Mark booking as completed.
     */
    public function complete(Booking $booking)
    {
        // Check authorization
        $boardingHouse = $booking->boardingHouse;
        if ($boardingHouse->user_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->status !== 'approved') {
            return back()->withErrors(['error' => 'Booking belum disetujui.']);
        }

        $booking->update(['status' => 'completed']);

        // Update room status back to available
        if ($booking->room_id) {
            Room::where('id', $booking->room_id)->update(['status' => 'available']);
        }

        return back()->with('success', 'Booking selesai!');
    }
}
