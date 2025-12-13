<?php

namespace App\Http\Controllers\Renter;

use App\Http\Controllers\Controller;
use App\Models\BoardingHouse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display the search page with filtered results.
     */
    public function index(Request $request)
    {
        $query = BoardingHouse::where('status', 'active');

        // Keyword Search - Filter by name or address
        $query->when($request->filled('keyword'), function ($q) use ($request) {
            $keyword = $request->keyword;
            $q->where(function ($query) use ($keyword) {
                $query->where('name', 'like', "%{$keyword}%")
                      ->orWhere('address', 'like', "%{$keyword}%");
            });
        });

        // Price Range Filter
        $query->when($request->filled('min_price'), function ($q) use ($request) {
            $q->where('price_monthly', '>=', $request->min_price);
        });

        $query->when($request->filled('max_price'), function ($q) use ($request) {
            $q->where('price_monthly', '<=', $request->max_price);
        });

        // Gender Type Filter (type column: putra, putri, campur)
        $query->when($request->filled('type'), function ($q) use ($request) {
            $q->where('type', $request->type);
        });

        // Occupancy Filter (for Room Match feature)
        $query->when($request->filled('occupancy'), function ($q) use ($request) {
            if ($request->occupancy == '2') {
                // 2 people = Room Match enabled
                $q->where('is_room_match_enabled', true);
            }
            // 1 person = regular rental (no specific filter needed, shows all)
        });

        // Facilities Filter - Check if room_facilities JSON contains selected items
        $query->when($request->filled('facilities'), function ($q) use ($request) {
            $facilities = $request->facilities;
            if (is_array($facilities)) {
                foreach ($facilities as $facility) {
                    $q->whereJsonContains('room_facilities', $facility);
                }
            }
        });

        // Common Facilities Filter
        $query->when($request->filled('common_facilities'), function ($q) use ($request) {
            $commonFacilities = $request->common_facilities;
            if (is_array($commonFacilities)) {
                foreach ($commonFacilities as $facility) {
                    $q->whereJsonContains('common_facilities', $facility);
                }
            }
        });

        // Sort results
        $query->when($request->filled('sort'), function ($q) use ($request) {
            switch ($request->sort) {
                case 'price_asc':
                    $q->orderBy('price_monthly', 'asc');
                    break;
                case 'price_desc':
                    $q->orderBy('price_monthly', 'desc');
                    break;
                case 'newest':
                    $q->latest();
                    break;
                default:
                    $q->latest();
            }
        }, function ($q) {
            $q->latest(); // Default sort
        });

        // Paginate results (9 per page for 3x3 grid)
        $results = $query->paginate(9)->withQueryString();

        // Available facilities for filter options
        $availableRoomFacilities = [
            'WiFi',
            'AC',
            'Kasur',
            'Lemari',
            'Meja',
            'Kursi',
            'Kamar Mandi Dalam',
            'Water Heater',
            'TV',
            'Kulkas',
            'Dapur',
            'Listrik',
        ];

        $availableCommonFacilities = [
            'Parkir Motor',
            'Parkir Mobil',
            'CCTV',
            'Keamanan 24 Jam',
            'Laundry',
            'Dapur Bersama',
            'Ruang Tamu',
            'Jemuran',
            'Musholla',
        ];

        return view('renter.kos.search', compact(
            'results',
            'availableRoomFacilities',
            'availableCommonFacilities'
        ));
    }
}
