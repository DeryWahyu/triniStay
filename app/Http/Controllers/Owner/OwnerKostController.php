<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\BoardingHouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OwnerKostController extends Controller
{
    /**
     * Display the owner dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();

        $boardingHouses = BoardingHouse::ownedBy($user->id)->latest()->get();

        // Redirect to create form if owner has no kos
        if ($boardingHouses->isEmpty()) {
            return redirect()->route('owner.kost.create')
                ->with('info', 'Anda belum memiliki kos. Silakan tambahkan kos pertama Anda.');
        }

        $latestKos = $boardingHouses->first();

        $totalKos = $boardingHouses->count();
        $totalRooms = $boardingHouses->sum('total_rooms');
        $availableRooms = $boardingHouses->sum('available_rooms');
        $roomMatchCount = $boardingHouses->where('is_room_match_enabled', true)->count();

        return view('owner.dashboard', compact(
            'boardingHouses',
            'latestKos',
            'totalKos',
            'totalRooms',
            'availableRooms',
            'roomMatchCount'
        ));
    }

    /**
     * Display a listing of the boarding houses.
     */
    public function index()
    {
        $boardingHouses = BoardingHouse::ownedBy(Auth::id())
            ->latest()
            ->paginate(9);

        return view('owner.kost.index', compact('boardingHouses'));
    }

    /**
     * Show the form for creating a new boarding house.
     */
    public function create()
    {
        return view('owner.kost.create');
    }

    /**
     * Store a newly created boarding house.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:putra,putri,campur',
            'price_monthly' => 'required|numeric|min:0',
            'price_6months' => 'nullable|numeric|min:0',
            'price_yearly' => 'nullable|numeric|min:0',
            'room_size' => 'nullable|string|max:50',
            'total_rooms' => 'required|integer|min:1',
            'available_rooms' => 'required|integer|min:0',
            'rent_schemes' => 'nullable|array',
            'room_facilities' => 'nullable|array',
            'common_facilities' => 'nullable|array',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'address' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'description' => 'nullable|string',
            'rules' => 'nullable|string',
            'is_room_match_enabled' => 'nullable|boolean',
            'room_match_price' => 'nullable|numeric|min:0',
            'room_match_period' => 'nullable|string',
        ], [
            'name.required' => 'Nama kos wajib diisi.',
            'type.required' => 'Jenis kos wajib dipilih.',
            'type.in' => 'Jenis kos tidak valid.',
            'price_monthly.required' => 'Harga per bulan wajib diisi.',
            'price_monthly.numeric' => 'Harga harus berupa angka.',
            'total_rooms.required' => 'Jumlah kamar wajib diisi.',
            'available_rooms.required' => 'Kamar tersedia wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'images.*.image' => 'File harus berupa gambar.',
            'images.*.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'images.*.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        // Handle image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('kosts', 'public');
                $imagePaths[] = $path;
            }
        }

        // Create boarding house
        $boardingHouse = BoardingHouse::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'type' => $validated['type'],
            'slug' => Str::slug($validated['name']) . '-' . Str::random(6),
            'price' => $validated['price_monthly'], // Keep old column for backward compatibility
            'price_monthly' => $validated['price_monthly'],
            'price_6months' => $validated['price_6months'] ?? null,
            'price_yearly' => $validated['price_yearly'] ?? null,
            'room_size' => $validated['room_size'] ?? null,
            'total_rooms' => $validated['total_rooms'],
            'available_rooms' => $validated['available_rooms'],
            'rent_schemes' => $validated['rent_schemes'] ?? [],
            'room_facilities' => $validated['room_facilities'] ?? [],
            'common_facilities' => $validated['common_facilities'] ?? [],
            'images' => $imagePaths,
            'address' => $validated['address'],
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'description' => $validated['description'] ?? null,
            'rules' => $validated['rules'] ?? null,
            'is_room_match_enabled' => $request->boolean('is_room_match_enabled'),
            'room_match_price' => $validated['room_match_price'] ?? null,
            'room_match_period' => $validated['room_match_period'] ?? null,
        ]);

        return redirect()
            ->route('owner.dashboard')
            ->with('success', 'Kos "' . $boardingHouse->name . '" berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified boarding house.
     */
    public function edit(BoardingHouse $boardingHouse)
    {
        // Ensure owner can only edit their own boarding houses
        if ($boardingHouse->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('owner.kost.edit', compact('boardingHouse'));
    }

    /**
     * Update the specified boarding house.
     */
    public function update(Request $request, BoardingHouse $boardingHouse)
    {
        // Ensure owner can only update their own boarding houses
        if ($boardingHouse->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:putra,putri,campur',
            'price_monthly' => 'required|numeric|min:0',
            'price_6months' => 'nullable|numeric|min:0',
            'price_yearly' => 'nullable|numeric|min:0',
            'room_size' => 'nullable|string|max:50',
            'total_rooms' => 'required|integer|min:1',
            'available_rooms' => 'required|integer|min:0',
            'rent_schemes' => 'nullable|array',
            'room_facilities' => 'nullable|array',
            'common_facilities' => 'nullable|array',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'delete_images' => 'nullable|array',
            'address' => 'required|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'description' => 'nullable|string',
            'rules' => 'nullable|string',
            'status' => 'nullable|in:active,inactive,pending',
            'is_room_match_enabled' => 'nullable|boolean',
            'room_match_price' => 'nullable|numeric|min:0',
            'room_match_period' => 'nullable|string',
        ]);

        // Handle image deletions
        $currentImages = $boardingHouse->images ?? [];
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $index) {
                if (isset($currentImages[$index])) {
                    Storage::disk('public')->delete($currentImages[$index]);
                    unset($currentImages[$index]);
                }
            }
            $currentImages = array_values($currentImages); // Re-index array
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('kosts', 'public');
                $currentImages[] = $path;
            }
        }

        // Update boarding house
        $boardingHouse->update([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'price' => $validated['price_monthly'], // Keep old column for backward compatibility
            'price_monthly' => $validated['price_monthly'],
            'price_6months' => $validated['price_6months'] ?? null,
            'price_yearly' => $validated['price_yearly'] ?? null,
            'room_size' => $validated['room_size'] ?? null,
            'total_rooms' => $validated['total_rooms'],
            'available_rooms' => $validated['available_rooms'],
            'rent_schemes' => $validated['rent_schemes'] ?? [],
            'room_facilities' => $validated['room_facilities'] ?? [],
            'common_facilities' => $validated['common_facilities'] ?? [],
            'images' => $currentImages,
            'address' => $validated['address'],
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'description' => $validated['description'] ?? null,
            'rules' => $validated['rules'] ?? null,
            'status' => $validated['status'] ?? 'active',
            'is_room_match_enabled' => $request->boolean('is_room_match_enabled'),
            'room_match_price' => $validated['room_match_price'] ?? null,
            'room_match_period' => $validated['room_match_period'] ?? null,
        ]);

        return redirect()
            ->route('owner.kost.index')
            ->with('success', 'Kos "' . $boardingHouse->name . '" berhasil diperbarui!');
    }

    /**
     * Remove the specified boarding house.
     */
    public function destroy(BoardingHouse $boardingHouse)
    {
        // Ensure owner can only delete their own boarding houses
        if ($boardingHouse->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $name = $boardingHouse->name;

        // Delete images from storage
        if ($boardingHouse->images) {
            foreach ($boardingHouse->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $boardingHouse->delete();

        return redirect()
            ->route('owner.kost.index')
            ->with('success', 'Kos "' . $name . '" berhasil dihapus!');
    }
}
