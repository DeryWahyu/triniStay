<?php

namespace App\Http\Controllers\Renter;

use App\Http\Controllers\Controller;
use App\Models\BoardingHouse;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Show the booking form.
     */
    public function create(Request $request, $slug)
    {
        $boardingHouse = BoardingHouse::where('slug', $slug)
            ->where('status', 'active')
            ->with(['rooms' => function($query) {
                $query->orderBy('room_number');
            }, 'user'])
            ->firstOrFail();

        // Get parameters from query string
        $duration = $request->get('duration', '1_month');
        $occupantType = $request->get('occupant', 'single'); // 'single' or 'double'
        $selectedPrice = $request->get('price'); // Price from detail page

        // Normalize duration format
        $duration = $this->normalizeDuration($duration);

        // Calculate price based on duration and occupant type
        if ($selectedPrice) {
            $price = (int) $selectedPrice;
        } else {
            $price = $this->getPriceForDurationAndOccupant($boardingHouse, $duration, $occupantType);
        }

        // Check if room match is enabled and selected
        $isRoomMatch = $occupantType === 'double' && $boardingHouse->is_room_match_enabled;

        // Get rooms with their availability status
        $rooms = $boardingHouse->rooms->map(function($room) {
            $room->is_available = $room->isAvailable();
            return $room;
        });

        return view('renter.booking.create', compact(
            'boardingHouse',
            'rooms',
            'duration',
            'price',
            'occupantType',
            'isRoomMatch'
        ));
    }

    /**
     * Normalize duration format.
     */
    private function normalizeDuration(string $duration): string
    {
        $durationMap = [
            '1 bulan' => '1_month',
            '3 bulan' => '3_months',
            '6 bulan' => '6_months',
            '12 bulan' => '1_year',
            '1_month' => '1_month',
            '3_months' => '3_months',
            '6_months' => '6_months',
            '1_year' => '1_year',
        ];

        return $durationMap[$duration] ?? '1_month';
    }

    /**
     * Store a new booking.
     */
    public function store(Request $request)
    {
        // Normalize duration format using shared method
        $normalizedDuration = $this->normalizeDuration($request->input('duration', '1_month'));
        $request->merge(['duration' => $normalizedDuration]);

        try {
            $validated = $request->validate([
                'boarding_house_id' => 'required|exists:boarding_houses,id',
                'room_id' => 'required|exists:rooms,id',
                'start_date' => 'required|date|after_or_equal:today',
                'duration' => 'required|in:1_month,3_months,6_months,1_year',
                'occupant_type' => 'nullable|in:single,double',
                'is_shared' => 'nullable|boolean',
                'shared_with_email' => 'nullable|required_if:is_shared,1|email',
                'notes' => 'nullable|string|max:500',
                'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ], [
                'room_id.required' => 'Pilih kamar yang ingin dipesan.',
                'start_date.required' => 'Tanggal mulai sewa wajib diisi.',
                'start_date.after_or_equal' => 'Tanggal mulai sewa tidak boleh di masa lalu.',
                'payment_proof.required' => 'Bukti pembayaran wajib diunggah.',
                'payment_proof.image' => 'Bukti pembayaran harus berupa gambar.',
                'payment_proof.max' => 'Ukuran bukti pembayaran maksimal 2MB.',
                'shared_with_email.required_if' => 'Email teman wajib diisi jika memilih berbagi kamar.',
                'shared_with_email.email' => 'Format email teman tidak valid.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => collect($e->errors())->flatten()->first(),
                'errors' => $e->errors(),
            ], 422);
        }

        // Get boarding house
        $boardingHouse = BoardingHouse::findOrFail($validated['boarding_house_id']);

        // Check room availability
        $room = Room::findOrFail($validated['room_id']);
        if (!$room->isAvailable()) {
            return response()->json([
                'success' => false,
                'message' => 'Kamar ini sudah tidak tersedia.',
            ], 422);
        }

        // Get occupant type
        $occupantType = $request->get('occupant_type', 'single');

        // Calculate price based on occupant type
        $pricePerPeriod = $this->getPriceForDurationAndOccupant($boardingHouse, $validated['duration'], $occupantType);
        $totalPrice = $pricePerPeriod;

        // If shared (room match with 2 persons), the price is already per person
        // For Room Match (double occupant), price is already per person from getPriceForDurationAndOccupant
        // For single occupant who wants to share, keep original calculation
        $isShared = $request->boolean('is_shared');

        // If Room Match (double), pricePerPeriod is already per person
        // total_price = per person price
        $totalPrice = $pricePerPeriod;

        // Calculate end date
        $endDate = Booking::calculateEndDate($validated['start_date'], $validated['duration']);

        // Handle shared user
        $sharedWithUserId = null;
        if ($isShared && !empty($validated['shared_with_email'])) {
            // Check if shared email is not the same as current user
            if ($validated['shared_with_email'] === Auth::user()->email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak bisa berbagi kamar dengan diri sendiri.',
                ], 422);
            }

            // Find user by email
            $sharedUser = User::where('email', $validated['shared_with_email'])->first();
            if ($sharedUser) {
                $sharedWithUserId = $sharedUser->id;
            } else {
                // User not found - return error
                return response()->json([
                    'success' => false,
                    'message' => 'Email teman tidak terdaftar di sistem. Pastikan teman Anda sudah mendaftar terlebih dahulu.',
                ], 422);
            }
        }

        // Upload payment proof
        $paymentProofPath = null;
        if ($request->hasFile('payment_proof')) {
            $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        // Create booking for the main user (initiator)
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'boarding_house_id' => $boardingHouse->id,
            'room_id' => $room->id,
            'start_date' => $validated['start_date'],
            'duration' => $validated['duration'],
            'end_date' => $endDate,
            'price_per_period' => $pricePerPeriod,
            'total_price' => $totalPrice, // Per person price for Room Match
            'payment_proof' => $paymentProofPath,
            'status' => 'pending',
            'is_shared' => $isShared,
            'shared_with_email' => $validated['shared_with_email'] ?? null,
            'shared_with_user_id' => $sharedWithUserId,
            'shared_status' => $isShared ? 'pending' : null,
            'notes' => $validated['notes'] ?? null,
        ]);

        // Note: Linked booking for invited user will be created when they ACCEPT the invitation
        // This is handled in acceptSharedBooking() method

        // Return booking ID for review modal
        return response()->json([
            'success' => true,
            'message' => 'Pemesanan berhasil! Menunggu konfirmasi pemilik kos.',
            'booking_id' => $booking->id,
            'booking_code' => $booking->booking_code,
        ]);
    }

    /**
     * Upload payment proof for existing booking.
     */
    public function uploadPaymentProof(Request $request, Booking $booking)
    {
        // Check ownership
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload payment proof
        if ($request->hasFile('payment_proof')) {
            // Delete old proof if exists
            if ($booking->payment_proof) {
                Storage::disk('public')->delete($booking->payment_proof);
            }

            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            $booking->update(['payment_proof' => $path]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Bukti pembayaran berhasil diunggah.',
        ]);
    }

    /**
     * Get price for duration (single occupant - original price).
     */
    private function getPriceForDuration(BoardingHouse $boardingHouse, string $duration): int
    {
        return match($duration) {
            '1_month' => $boardingHouse->price_monthly ?? $boardingHouse->price,
            '3_months' => $boardingHouse->price_3months ?? ($boardingHouse->price_monthly * 3),
            '6_months' => $boardingHouse->price_6months ?? ($boardingHouse->price_monthly * 6),
            '1_year' => $boardingHouse->price_yearly ?? ($boardingHouse->price_monthly * 12),
            default => $boardingHouse->price_monthly ?? $boardingHouse->price,
        };
    }

    /**
     * Get price for duration based on occupant type.
     */
    private function getPriceForDurationAndOccupant(BoardingHouse $boardingHouse, string $duration, string $occupantType): int
    {
        // For double occupant (2 orang), use room_match_price divided by 2 (per person)
        if ($occupantType === 'double' && $boardingHouse->room_match_price) {
            return intval($boardingHouse->room_match_price / 2);
        }

        // For single occupant, use regular price based on duration
        return $this->getPriceForDuration($boardingHouse, $duration);
    }

    /**
     * Accept shared booking invitation.
     */
    public function acceptSharedBooking(Booking $booking)
    {
        if ($booking->shared_with_user_id !== Auth::id()) {
            abort(403);
        }

        // Update original booking status
        $booking->update(['shared_status' => 'accepted']);

        // Create linked booking for the invited user
        // Check if linked booking already exists
        $existingLinkedBooking = Booking::where('parent_booking_id', $booking->id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$existingLinkedBooking) {
            // Calculate per-person price (room_match_price / 2)
            $perPersonPrice = intval($booking->boardingHouse->room_match_price / 2);

            Booking::create([
                'user_id' => Auth::id(),
                'boarding_house_id' => $booking->boarding_house_id,
                'room_id' => $booking->room_id,
                'start_date' => $booking->start_date,
                'end_date' => $booking->end_date,
                'duration' => $booking->duration,
                'price_per_period' => $perPersonPrice,
                'total_price' => $perPersonPrice,
                'status' => 'pending',
                'is_shared' => true,
                'shared_with_email' => $booking->user->email,
                'shared_with_user_id' => $booking->user_id, // Points back to inviter
                'shared_status' => 'accepted',
                'parent_booking_id' => $booking->id,
                'notes' => 'Room Match - Booking terhubung dari undangan #' . $booking->id,
            ]);
        }

        return back()->with('success', 'Anda telah menerima undangan berbagi kamar. Silakan upload bukti pembayaran untuk melanjutkan.');
    }

    /**
     * Reject shared booking invitation.
     */
    public function rejectSharedBooking(Booking $booking)
    {
        if ($booking->shared_with_user_id !== Auth::id()) {
            abort(403);
        }

        $booking->update([
            'shared_status' => 'rejected',
            'is_shared' => false,
            'shared_with_email' => null,
            'shared_with_user_id' => null,
        ]);

        return back()->with('success', 'Anda telah menolak undangan berbagi kamar.');
    }

    /**
     * Cancel booking.
     */
    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->status !== 'pending') {
            return back()->withErrors(['error' => 'Hanya pemesanan dengan status pending yang dapat dibatalkan.']);
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Pemesanan berhasil dibatalkan.');
    }
}
