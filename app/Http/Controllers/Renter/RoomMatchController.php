<?php

namespace App\Http\Controllers\Renter;

use App\Http\Controllers\Controller;
use App\Models\RoommatePreference;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomMatchController extends Controller
{
    /**
     * Display the roommate listing page.
     * If user has no preference, redirect to create form.
     */
    public function index()
    {
        $user = Auth::user();

        // Check if user has created their preference profile
        $userPreference = RoommatePreference::where('user_id', $user->id)->first();

        if (!$userPreference) {
            // Scenario A: No profile exists - redirect to form
            return redirect()->route('renter.room-match.create')
                ->with('info', 'Silakan isi preferensi teman sekamar Anda terlebih dahulu.');
        }

        // Scenario B: Profile exists - show listing with matches
        // Fetch other users with active roommate preferences
        $otherPreferences = RoommatePreference::with('user')
            ->where('user_id', '!=', $user->id)
            ->where('is_active', true)
            ->whereHas('user', function ($query) {
                $query->where('role', 'renter');
            })
            ->get();

        // Calculate match percentage for each user
        $matches = $otherPreferences->map(function ($preference) use ($userPreference) {
            $matchPercentage = $userPreference->calculateMatchPercentage($preference);

            return [
                'user' => $preference->user,
                'preference' => $preference,
                'match_percentage' => $matchPercentage,
                'badge_color' => $userPreference->getMatchBadgeColor($matchPercentage),
            ];
        });

        // Sort by match percentage (highest first)
        $matches = $matches->sortByDesc('match_percentage')->values();

        return view('renter.room-match.index', compact('matches', 'userPreference'));
    }

    /**
     * Show the preference form.
     */
    public function create()
    {
        $user = Auth::user();

        // Check if user already has preference
        $existingPreference = RoommatePreference::where('user_id', $user->id)->first();

        if ($existingPreference) {
            // If already has preference, redirect to edit
            return redirect()->route('renter.room-match.edit');
        }

        return view('renter.room-match.create');
    }

    /**
     * Store the roommate preference.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Sleep habits
            'sleep_lamp_off' => 'required|boolean',
            'sleep_late' => 'required|boolean',
            'sleep_noise_tolerant' => 'required|boolean',
            'sleep_snore' => 'required|boolean',
            // Cleanliness
            'clean_daily' => 'required|boolean',
            'clean_tolerance' => 'required|boolean',
            'clean_self_wash' => 'required|boolean',
            'clean_shared_duty' => 'required|boolean',
            // Study/Work
            'study_late' => 'required|boolean',
            'study_quiet_needed' => 'required|boolean',
            'study_music' => 'required|boolean',
            // Social
            'guest_welcome' => 'required|boolean',
            'introvert' => 'required|boolean',
            'smoking' => 'required|boolean',
            'pet_friendly' => 'required|boolean',
            // Bio
            'description' => 'nullable|string|max:500',
            'contact_preference' => 'required|in:whatsapp,email,phone',
        ], [
            'required' => 'Pilihan ini wajib diisi.',
            'boolean' => 'Pilihan tidak valid.',
            'description.max' => 'Deskripsi maksimal 500 karakter.',
        ]);

        // Add user_id
        $validated['user_id'] = Auth::id();
        $validated['is_active'] = true;

        RoommatePreference::create($validated);

        return redirect()->route('renter.room-match.index')
            ->with('success', 'Preferensi teman sekamar berhasil disimpan! Sekarang Anda dapat melihat kecocokan dengan pengguna lain.');
    }

    /**
     * Show the edit form.
     */
    public function edit()
    {
        $preference = RoommatePreference::where('user_id', Auth::id())->firstOrFail();

        return view('renter.room-match.edit', compact('preference'));
    }

    /**
     * Update the roommate preference.
     */
    public function update(Request $request)
    {
        $preference = RoommatePreference::where('user_id', Auth::id())->firstOrFail();

        $validated = $request->validate([
            // Sleep habits
            'sleep_lamp_off' => 'required|boolean',
            'sleep_late' => 'required|boolean',
            'sleep_noise_tolerant' => 'required|boolean',
            'sleep_snore' => 'required|boolean',
            // Cleanliness
            'clean_daily' => 'required|boolean',
            'clean_tolerance' => 'required|boolean',
            'clean_self_wash' => 'required|boolean',
            'clean_shared_duty' => 'required|boolean',
            // Study/Work
            'study_late' => 'required|boolean',
            'study_quiet_needed' => 'required|boolean',
            'study_music' => 'required|boolean',
            // Social
            'guest_welcome' => 'required|boolean',
            'introvert' => 'required|boolean',
            'smoking' => 'required|boolean',
            'pet_friendly' => 'required|boolean',
            // Bio
            'description' => 'nullable|string|max:500',
            'contact_preference' => 'required|in:whatsapp,email,phone',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $preference->update($validated);

        return redirect()->route('renter.room-match.index')
            ->with('success', 'Preferensi berhasil diperbarui!');
    }

    /**
     * Show detail of a potential roommate.
     */
    public function show($id)
    {
        $currentUser = Auth::user();
        $userPreference = RoommatePreference::where('user_id', $currentUser->id)->firstOrFail();

        $otherPreference = RoommatePreference::with('user')
            ->where('user_id', $id)
            ->where('is_active', true)
            ->firstOrFail();

        $matchPercentage = $userPreference->calculateMatchPercentage($otherPreference);
        $badgeColor = $userPreference->getMatchBadgeColor($matchPercentage);

        // Get detailed comparison
        $comparison = $this->getDetailedComparison($userPreference, $otherPreference);

        // Variables for view
        $user = $otherPreference->user;
        $preference = $otherPreference;

        return view('renter.room-match.show', compact(
            'user',
            'preference',
            'matchPercentage',
            'comparison'
        ));
    }

    /**
     * Get detailed comparison between two preferences.
     */
    private function getDetailedComparison(RoommatePreference $mine, RoommatePreference $theirs): array
    {
        return [
            'sleep' => [
                'sleep_lamp_off' => [
                    'label' => 'Tidur dengan lampu mati',
                    'my_value' => $mine->sleep_lamp_off,
                    'their_value' => $theirs->sleep_lamp_off,
                    'match' => $mine->sleep_lamp_off === $theirs->sleep_lamp_off,
                ],
                'sleep_late' => [
                    'label' => 'Tidur larut malam',
                    'my_value' => $mine->sleep_late,
                    'their_value' => $theirs->sleep_late,
                    'match' => $mine->sleep_late === $theirs->sleep_late,
                ],
                'sleep_noise_tolerant' => [
                    'label' => 'Toleran terhadap suara',
                    'my_value' => $mine->sleep_noise_tolerant,
                    'their_value' => $theirs->sleep_noise_tolerant,
                    'match' => $mine->sleep_noise_tolerant === $theirs->sleep_noise_tolerant,
                ],
                'sleep_snore' => [
                    'label' => 'Mendengkur',
                    'my_value' => $mine->sleep_snore,
                    'their_value' => $theirs->sleep_snore,
                    'match' => $mine->sleep_snore === $theirs->sleep_snore,
                ],
            ],
            'clean' => [
                'clean_daily' => [
                    'label' => 'Merapikan setiap hari',
                    'my_value' => $mine->clean_daily,
                    'their_value' => $theirs->clean_daily,
                    'match' => $mine->clean_daily === $theirs->clean_daily,
                ],
                'clean_tolerance' => [
                    'label' => 'Toleran berantakan',
                    'my_value' => $mine->clean_tolerance,
                    'their_value' => $theirs->clean_tolerance,
                    'match' => $mine->clean_tolerance === $theirs->clean_tolerance,
                ],
                'clean_self_wash' => [
                    'label' => 'Cuci alat makan sendiri',
                    'my_value' => $mine->clean_self_wash,
                    'their_value' => $theirs->clean_self_wash,
                    'match' => $mine->clean_self_wash === $theirs->clean_self_wash,
                ],
                'clean_shared_duty' => [
                    'label' => 'Berbagi tugas bersih',
                    'my_value' => $mine->clean_shared_duty,
                    'their_value' => $theirs->clean_shared_duty,
                    'match' => $mine->clean_shared_duty === $theirs->clean_shared_duty,
                ],
            ],
            'study' => [
                'study_late' => [
                    'label' => 'Belajar larut malam',
                    'my_value' => $mine->study_late,
                    'their_value' => $theirs->study_late,
                    'match' => $mine->study_late === $theirs->study_late,
                ],
                'study_quiet_needed' => [
                    'label' => 'Butuh suasana hening',
                    'my_value' => $mine->study_quiet_needed,
                    'their_value' => $theirs->study_quiet_needed,
                    'match' => $mine->study_quiet_needed === $theirs->study_quiet_needed,
                ],
                'study_music' => [
                    'label' => 'Dengar musik saat belajar',
                    'my_value' => $mine->study_music,
                    'their_value' => $theirs->study_music,
                    'match' => $mine->study_music === $theirs->study_music,
                ],
            ],
            'social' => [
                'guest_welcome' => [
                    'label' => 'Menerima tamu',
                    'my_value' => $mine->guest_welcome,
                    'their_value' => $theirs->guest_welcome,
                    'match' => $mine->guest_welcome === $theirs->guest_welcome,
                ],
                'introvert' => [
                    'label' => 'Introvert',
                    'my_value' => $mine->introvert,
                    'their_value' => $theirs->introvert,
                    'match' => $mine->introvert === $theirs->introvert,
                ],
                'smoking' => [
                    'label' => 'Merokok',
                    'my_value' => $mine->smoking,
                    'their_value' => $theirs->smoking,
                    'match' => $mine->smoking === $theirs->smoking,
                ],
                'pet_friendly' => [
                    'label' => 'Suka hewan',
                    'my_value' => $mine->pet_friendly,
                    'their_value' => $theirs->pet_friendly,
                    'match' => $mine->pet_friendly === $theirs->pet_friendly,
                ],
            ],
        ];
    }
}
