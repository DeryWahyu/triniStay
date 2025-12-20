<?php

namespace App\Http\Controllers\Renter;

use App\Http\Controllers\Controller;
use App\Models\BoardingHouse;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a new review.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'boarding_house_id' => 'required|exists:boarding_houses,id',
            'booking_id' => 'nullable|exists:bookings,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ], [
            'rating.required' => 'Rating wajib diisi.',
            'rating.min' => 'Rating minimal 1.',
            'rating.max' => 'Rating maksimal 5.',
        ]);

        // Check if user already reviewed this boarding house
        $existingReview = Review::where('user_id', Auth::id())
            ->where('boarding_house_id', $validated['boarding_house_id'])
            ->first();

        if ($existingReview) {
            // Update existing review
            $existingReview->update([
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? null,
            ]);

            return back()->with('success', 'Ulasan berhasil diperbarui.');
        }

        // Create new review
        Review::create([
            'user_id' => Auth::id(),
            'boarding_house_id' => $validated['boarding_house_id'],
            'booking_id' => $validated['booking_id'] ?? null,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
            'is_published' => true,
        ]);

        return back()->with('success', 'Terima kasih atas ulasan Anda!');
    }

    /**
     * Get reviews for a boarding house.
     */
    public function index(BoardingHouse $boardingHouse)
    {
        $reviews = $boardingHouse->reviews()
            ->published()
            ->with('user')
            ->latest()
            ->paginate(10);

        return response()->json($reviews);
    }
}
