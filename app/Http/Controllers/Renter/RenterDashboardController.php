<?php

namespace App\Http\Controllers\Renter;

use App\Http\Controllers\Controller;
use App\Models\BoardingHouse;
use Illuminate\Http\Request;

class RenterDashboardController extends Controller
{
    /**
     * Display the renter dashboard with kos recommendations.
     */
    public function index()
    {
        // Fetch latest 3 Kos Putra
        $kosPutra = BoardingHouse::where('status', 'active')
            ->where('type', 'putra')
            ->latest()
            ->take(3)
            ->get();

        // Fetch latest 3 Kos Putri
        $kosPutri = BoardingHouse::where('status', 'active')
            ->where('type', 'putri')
            ->latest()
            ->take(3)
            ->get();

        // Fetch latest 3 Kos Campur
        $kosCampur = BoardingHouse::where('status', 'active')
            ->where('type', 'campur')
            ->latest()
            ->take(3)
            ->get();

        return view('renter.dashboard', compact('kosPutra', 'kosPutri', 'kosCampur'));
    }

    /**
     * Show kos detail page.
     */
    public function showKos($slug)
    {
        $kost = BoardingHouse::where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        // Get related kosts (same type, excluding current)
        $relatedKosts = BoardingHouse::where('status', 'active')
            ->where('id', '!=', $kost->id)
            ->where('type', $kost->type)
            ->take(3)
            ->get();

        return view('renter.kost-detail', compact('kost', 'relatedKosts'));
    }
}
