<?php

namespace App\Http\Controllers\Renter;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display user's orders/bookings.
     */
    public function index()
    {
        $userId = Auth::id();

        // Get bookings where user is the main booker (created the booking)
        // Include Room Match bookings where this user initiated the invitation
        $myBookings = Booking::where('user_id', $userId)
            ->whereNull('parent_booking_id') // Exclude linked bookings created for invited users
            ->with(['boardingHouse', 'room', 'sharedWithUser'])
            ->latest()
            ->get();

        // Get bookings where user is invited (shared partner)
        // These are bookings where:
        // 1. User is listed as shared_with_user_id on the ORIGINAL booking (parent), OR
        // 2. User has a linked booking created for them (has parent_booking_id)
        $sharedBookings = Booking::where(function($query) use ($userId) {
                // User is invited on the original booking
                $query->where('shared_with_user_id', $userId)
                      ->whereNull('parent_booking_id');
            })
            ->orWhere(function($query) use ($userId) {
                // User has a linked booking (their own booking created when invited)
                $query->where('user_id', $userId)
                      ->whereNotNull('parent_booking_id');
            })
            ->with(['boardingHouse', 'room', 'user', 'sharedWithUser'])
            ->latest()
            ->get();

        // Pending shared invitations for the current user (where they need to accept/reject)
        $pendingInvitations = Booking::where('shared_with_user_id', $userId)
            ->whereNull('parent_booking_id') // Only original bookings, not linked ones
            ->where('shared_status', 'pending')
            ->with(['boardingHouse', 'room', 'user'])
            ->get();

        return view('renter.orders.index', compact('myBookings', 'sharedBookings', 'pendingInvitations'));
    }

    /**
     * Show single order details.
     */
    public function show(Booking $booking)
    {
        $userId = Auth::id();

        // Check if user is authorized to view this booking
        if ($booking->user_id !== $userId && $booking->shared_with_user_id !== $userId) {
            abort(403);
        }

        $booking->load(['boardingHouse.owner', 'room', 'user', 'sharedWithUser', 'review']);

        return view('renter.orders.show', compact('booking'));
    }

    /**
     * Download booking receipt as PDF.
     */
    public function downloadReceipt(Booking $booking)
    {
        $userId = Auth::id();

        // Check if user is authorized
        if ($booking->user_id !== $userId && $booking->shared_with_user_id !== $userId) {
            abort(403);
        }

        // Only allow download for approved/completed bookings
        if (!in_array($booking->status, ['approved', 'completed'])) {
            return back()->withErrors(['error' => 'Bukti transaksi hanya tersedia untuk pemesanan yang disetujui.']);
        }

        $booking->load(['boardingHouse.owner', 'room', 'user', 'sharedWithUser']);

        $pdf = Pdf::loadView('pdf.booking-receipt', compact('booking'));

        return $pdf->download('bukti-transaksi-' . $booking->booking_code . '.pdf');
    }
}
