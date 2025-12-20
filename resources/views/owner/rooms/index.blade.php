@extends('layouts.owner')

@section('title', 'Kelola Kamar - ' . $boardingHouse->name)
@section('page-title', 'Kelola Kamar')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <nav class="text-sm mb-2">
                <ol class="flex items-center space-x-2 text-gray-500">
                    <li><a href="{{ route('owner.kost.index') }}" class="hover:text-blue-600">Kos Saya</a></li>
                    <li><span>/</span></li>
                    <li class="text-gray-900 font-medium">{{ $boardingHouse->name }}</li>
                </ol>
            </nav>
            <h2 class="text-2xl font-bold text-gray-900">Kelola Kamar</h2>
            <p class="text-gray-600 mt-1">{{ $boardingHouse->name }} - {{ $boardingHouse->type_label }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('owner.kost.edit', $boardingHouse) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Kos
            </a>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Statistics -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Kamar</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $statistics['total'] }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Tersedia</p>
                    <p class="text-2xl font-bold text-green-600">{{ $statistics['available'] }}</p>
                </div>
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Terisi</p>
                    <p class="text-2xl font-bold text-red-600">{{ $statistics['occupied'] }}</p>
                </div>
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Perbaikan</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $statistics['maintenance'] }}</p>
                </div>
                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Box -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
        <div class="flex">
            <svg class="w-5 h-5 text-blue-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <p class="text-sm text-blue-800">
                    <strong>Info:</strong> Kamar dibuat otomatis berdasarkan "Jumlah Kamar" yang Anda atur saat menambah/edit kos. 
                    Klik kamar untuk mengubah statusnya.
                </p>
                <p class="text-xs text-blue-700 mt-1">
                    Untuk menambah kamar, silakan <a href="{{ route('owner.kost.edit', $boardingHouse) }}" class="underline font-medium">edit kos</a> dan ubah jumlah kamar.
                </p>
            </div>
        </div>
    </div>

    <!-- Rooms Grid -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Daftar Kamar</h3>
            <!-- Legend -->
            <div class="flex flex-wrap gap-4 text-sm">
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 bg-green-500 rounded"></div>
                    <span class="text-gray-600">Tersedia</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 bg-red-500 rounded"></div>
                    <span class="text-gray-600">Terisi/Dipesan</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 bg-yellow-500 rounded"></div>
                    <span class="text-gray-600">Perbaikan</span>
                </div>
            </div>
        </div>
        
        @if($rooms->count() > 0)
            @foreach($roomsByFloor as $floor => $floorRooms)
                <div class="mb-6 last:mb-0">
                    <h4 class="text-sm font-medium text-gray-700 mb-3 flex items-center">
                        <span class="px-3 py-1 bg-gray-100 rounded-full">Lantai {{ $floor }}</span>
                        <span class="ml-2 text-gray-500">({{ $floorRooms->count() }} kamar)</span>
                    </h4>
                    <div class="grid grid-cols-5 sm:grid-cols-8 md:grid-cols-10 lg:grid-cols-12 gap-2">
                        @foreach($floorRooms as $room)
                            @php
                                // Determine visual status based on booking
                                $visualStatus = $room->status;
                                if ($room->has_active_booking && $room->status === 'available') {
                                    $visualStatus = 'occupied';
                                }
                            @endphp
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" 
                                        class="w-full aspect-square flex flex-col items-center justify-center rounded-lg text-sm font-medium transition-all shadow-sm
                                            @if($visualStatus === 'available')
                                                bg-green-500 text-white hover:bg-green-600
                                            @elseif($visualStatus === 'occupied')
                                                bg-red-500 text-white hover:bg-red-600
                                            @else
                                                bg-yellow-500 text-white hover:bg-yellow-600
                                            @endif
                                        ">
                                    <span class="text-base font-bold">{{ $room->room_number }}</span>
                                    @if($room->has_active_booking)
                                        <span class="text-xs opacity-75">●</span>
                                    @endif
                                </button>

                                <!-- Dropdown Menu -->
                                <div x-show="open" @click.away="open = false" x-cloak
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="absolute top-full left-0 mt-1 w-44 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-20">
                                    <div class="px-3 py-2 border-b bg-gray-50">
                                        <p class="text-sm font-semibold text-gray-900">Kamar {{ $room->room_number }}</p>
                                        <p class="text-xs text-gray-500">Lantai {{ $room->floor }}</p>
                                        @if($room->has_active_booking)
                                            <span class="inline-block mt-1 px-2 py-0.5 bg-red-100 text-red-700 text-xs rounded-full">Ada Booking Aktif</span>
                                        @endif
                                    </div>
                                    
                                    @if($room->currentBooking)
                                        <div class="px-3 py-2 border-b bg-blue-50">
                                            <p class="text-xs text-blue-600 font-medium">Penyewa:</p>
                                            <p class="text-sm text-gray-800">{{ $room->currentBooking->user->name ?? '-' }}</p>
                                        </div>
                                    @endif

                                    <div class="py-1">
                                        <p class="px-3 py-1 text-xs text-gray-500 uppercase tracking-wide">Ubah Status</p>
                                    </div>
                                    
                                    <!-- Status Change Buttons -->
                                    @if($room->status !== 'available')
                                        <form action="{{ route('owner.rooms.update-status', [$boardingHouse, $room]) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="available">
                                            <button type="submit" class="w-full px-3 py-2 text-left text-sm text-green-700 hover:bg-green-50 flex items-center">
                                                <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                                                Tersedia
                                            </button>
                                        </form>
                                    @endif
                                    @if($room->status !== 'occupied')
                                        <form action="{{ route('owner.rooms.update-status', [$boardingHouse, $room]) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="occupied">
                                            <button type="submit" class="w-full px-3 py-2 text-left text-sm text-red-700 hover:bg-red-50 flex items-center">
                                                <span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                                                Terisi
                                            </button>
                                        </form>
                                    @endif
                                    @if($room->status !== 'maintenance')
                                        <form action="{{ route('owner.rooms.update-status', [$boardingHouse, $room]) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="maintenance">
                                            <button type="submit" class="w-full px-3 py-2 text-left text-sm text-yellow-700 hover:bg-yellow-50 flex items-center">
                                                <span class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></span>
                                                Perbaikan
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <p class="text-gray-500 mb-2">Belum ada kamar</p>
                <p class="text-sm text-gray-400 mb-4">Kamar akan otomatis dibuat saat Anda menyimpan data kos.</p>
                <a href="{{ route('owner.kost.edit', $boardingHouse) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Kos
                </a>
            </div>
        @endif
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection
