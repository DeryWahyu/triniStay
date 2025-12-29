<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\BoardingHouse;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomManagementController extends Controller
{
    /**
     * Display rooms for a specific boarding house.
     */
    public function index(BoardingHouse $boardingHouse)
    {
        // Check authorization
        if ($boardingHouse->user_id !== Auth::id()) {
            abort(403);
        }

        $rooms = Room::where('boarding_house_id', $boardingHouse->id)
            ->with(['currentBooking' => function($query) {
                $query->where('status', 'approved')
                    ->where('end_date', '>=', now());
            }])
            ->orderBy('floor')
            ->orderByRaw('CAST(room_number AS UNSIGNED)')
            ->get();

        // Add computed is_available property and has_active_booking for each room
        $rooms = $rooms->map(function ($room) {
            $room->is_available = $room->isAvailable();
            $room->has_active_booking = $room->bookings()
                ->whereIn('status', ['pending', 'approved'])
                ->where('end_date', '>=', now())
                ->exists();
            return $room;
        });

        $roomsByFloor = $rooms->groupBy('floor');
        
        // Calculate statistics based on actual availability
        $statistics = [
            'total' => $rooms->count(),
            'available' => $rooms->filter(fn($r) => $r->is_available)->count(),
            'occupied' => $rooms->filter(fn($r) => !$r->is_available && $r->status !== 'maintenance')->count(),
            'maintenance' => $rooms->where('status', 'maintenance')->count(),
        ];

        return view('owner.rooms.index', compact('boardingHouse', 'rooms', 'roomsByFloor', 'statistics'));
    }

    /**
     * Store a new room.
     */
    public function store(Request $request, BoardingHouse $boardingHouse)
    {
        // Check authorization
        if ($boardingHouse->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'room_number' => 'required|string|max:10',
            'floor' => 'required|integer|min:1',
            'status' => 'nullable|in:available,occupied,maintenance',
        ]);

        // Check if room number already exists
        $exists = Room::where('boarding_house_id', $boardingHouse->id)
            ->where('room_number', $validated['room_number'])
            ->exists();
            
        if ($exists) {
            return back()->withErrors(['room_number' => 'Nomor kamar sudah ada.'])->withInput();
        }

        Room::create([
            'boarding_house_id' => $boardingHouse->id,
            'room_number' => $validated['room_number'],
            'floor' => $validated['floor'],
            'status' => $validated['status'] ?? 'available',
        ]);

        // Sync available_rooms count in boarding house
        $this->syncAvailableRoomsCount($boardingHouse);

        return back()->with('success', 'Kamar berhasil ditambahkan!');
    }

    /**
     * Bulk create rooms.
     */
    public function bulkStore(Request $request, BoardingHouse $boardingHouse)
    {
        // Check authorization
        if ($boardingHouse->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'floor' => 'required|integer|min:1',
            'start_number' => 'required|integer|min:1',
            'count' => 'required|integer|min:1|max:50',
            'prefix' => 'nullable|string|max:5',
        ]);

        $prefix = $validated['prefix'] ?? '';
        $created = 0;
        
        for ($i = 0; $i < $validated['count']; $i++) {
            $roomNumber = $prefix . ($validated['start_number'] + $i);
            
            // Skip if room already exists
            $exists = Room::where('boarding_house_id', $boardingHouse->id)
                ->where('room_number', $roomNumber)
                ->exists();
                
            if (!$exists) {
                Room::create([
                    'boarding_house_id' => $boardingHouse->id,
                    'room_number' => $roomNumber,
                    'floor' => $validated['floor'],
                    'status' => 'available',
                ]);
                $created++;
            }
        }

        // Sync available_rooms count in boarding house
        $this->syncAvailableRoomsCount($boardingHouse);

        return back()->with('success', "{$created} kamar berhasil ditambahkan!");
    }

    /**
     * Update room status.
     */
    public function updateStatus(Request $request, BoardingHouse $boardingHouse, Room $room)
    {
        // Check authorization
        if ($boardingHouse->user_id !== Auth::id() || $room->boarding_house_id !== $boardingHouse->id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:available,occupied,maintenance',
        ]);

        $room->update(['status' => $validated['status']]);

        // Sync available_rooms count in boarding house
        $this->syncAvailableRoomsCount($boardingHouse);

        return back()->with('success', 'Status kamar berhasil diperbarui!');
    }

    /**
     * Sync the available_rooms count in boarding house based on actual room status.
     */
    private function syncAvailableRoomsCount(BoardingHouse $boardingHouse): void
    {
        $availableCount = $boardingHouse->rooms()
            ->where('status', 'available')
            ->whereDoesntHave('bookings', function ($query) {
                $query->whereIn('status', ['pending', 'approved'])
                    ->where('end_date', '>=', now());
            })
            ->count();

        $boardingHouse->update(['available_rooms' => $availableCount]);
    }

    /**
     * Delete a room.
     */
    public function destroy(BoardingHouse $boardingHouse, Room $room)
    {
        // Check authorization
        if ($boardingHouse->user_id !== Auth::id() || $room->boarding_house_id !== $boardingHouse->id) {
            abort(403);
        }

        // Check if room has any active bookings
        $hasActiveBooking = $room->bookings()
            ->whereIn('status', ['pending', 'approved'])
            ->exists();
            
        if ($hasActiveBooking) {
            return back()->withErrors(['error' => 'Kamar memiliki booking aktif dan tidak dapat dihapus.']);
        }

        $room->delete();

        // Sync available_rooms count in boarding house
        $this->syncAvailableRoomsCount($boardingHouse);

        return back()->with('success', 'Kamar berhasil dihapus!');
    }
}
