@extends('layouts.owner')

@section('title', 'Dashboard')
@section('page-title', 'Beranda')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h2>
                <p class="text-blue-100">Kelola kos-kosan Anda dengan mudah dan efisien.</p>
            </div>
            <div class="hidden md:block">
                <svg class="w-24 h-24 text-blue-400 opacity-50" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Kos -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Kos</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalKos ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Kamar -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Kamar</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalRooms ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Kamar Tersedia -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Kamar Tersedia</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $availableRooms ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Room Match Enabled -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Room Match Aktif</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $roomMatchCount ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Section -->
    @if(isset($boardingHouses) && $boardingHouses->count() > 0)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Peta Lokasi Kos Anda
        </h3>
        <div id="dashboard-map" class="w-full h-80 rounded-lg border border-gray-200"></div>
    </div>
    @endif

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Kos Anda Section -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Kos Anda</h3>
                <a href="{{ route('owner.kost.create') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Kos
                </a>
            </div>

            @if(isset($latestKos) && $latestKos)
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Kos Image -->
                    <div class="w-full md:w-48 h-48 rounded-lg overflow-hidden flex-shrink-0">
                        <img src="{{ $latestKos->first_image }}" alt="{{ $latestKos->name }}" class="w-full h-full object-cover">
                    </div>

                    <!-- Kos Details -->
                    <div class="flex-1">
                        <h4 class="text-xl font-semibold text-gray-900 mb-2">{{ $latestKos->name }}</h4>
                        <p class="text-2xl font-bold text-blue-600 mb-3">{{ $latestKos->formatted_price }}<span class="text-sm font-normal text-gray-500">/bulan</span></p>

                        <div class="space-y-2 text-sm text-gray-600">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ Str::limit($latestKos->address, 50) }}
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                {{ $latestKos->available_rooms_count }} dari {{ $latestKos->total_rooms }} kamar tersedia
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                </svg>
                                Ukuran: {{ $latestKos->room_size ?? '-' }}
                            </div>
                        </div>

                        <div class="mt-4 flex flex-wrap gap-2">
                            @if($latestKos->room_facilities)
                                @foreach(array_slice($latestKos->room_facilities, 0, 4) as $facility)
                                    <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">{{ $facility }}</span>
                                @endforeach
                                @if(count($latestKos->room_facilities) > 4)
                                    <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">+{{ count($latestKos->room_facilities) - 4 }} lainnya</span>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <p class="text-gray-500 mb-4">Belum ada kos yang terdaftar</p>
                    <a href="{{ route('owner.kost.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Kos Pertama
                    </a>
                </div>
            @endif
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <!-- Status Pemesanan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Pemesanan</h3>

                <div class="space-y-4">
                    <!-- Menunggu Konfirmasi -->
                    <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Menunggu Konfirmasi</p>
                                <p class="text-xs text-gray-500">Perlu ditindaklanjuti</p>
                            </div>
                        </div>
                        <span class="text-2xl font-bold text-yellow-600">{{ $pendingOrders ?? 0 }}</span>
                    </div>

                    <!-- Dikonfirmasi -->
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Dikonfirmasi</p>
                                <p class="text-xs text-gray-500">Sedang berjalan</p>
                            </div>
                        </div>
                        <span class="text-2xl font-bold text-blue-600">{{ $confirmedOrders ?? 0 }}</span>
                    </div>

                    <!-- Selesai -->
                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Selesai</p>
                                <p class="text-xs text-gray-500">Bulan ini</p>
                            </div>
                        </div>
                        <span class="text-2xl font-bold text-green-600">{{ $completedOrders ?? 0 }}</span>
                    </div>

                    <!-- Dibatalkan -->
                    <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Dibatalkan</p>
                                <p class="text-xs text-gray-500">Bulan ini</p>
                            </div>
                        </div>
                        <span class="text-2xl font-bold text-red-600">{{ $cancelledOrders ?? 0 }}</span>
                    </div>
                </div>

                <a href="{{ route('owner.bookings.index') }}" class="mt-4 block text-center text-sm text-blue-600 hover:text-blue-800 font-medium">
                    Lihat Semua Pemesanan →
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Kos List -->
    @if(isset($boardingHouses) && $boardingHouses->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Daftar Kos Terbaru</h3>
                <a href="{{ route('owner.kost.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    Lihat Semua →
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <th class="pb-3">Nama Kos</th>
                            <th class="pb-3">Harga</th>
                            <th class="pb-3">Kamar</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($boardingHouses->take(5) as $kos)
                            <tr>
                                <td class="py-4">
                                    <div class="flex items-center">
                                        <img src="{{ $kos->first_image }}" alt="{{ $kos->name }}" class="w-12 h-12 rounded-lg object-cover mr-3">
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $kos->name }}</p>
                                            <p class="text-xs text-gray-500">{{ Str::limit($kos->address, 30) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4">
                                    <span class="font-semibold text-gray-900">{{ $kos->formatted_price }}</span>
                                </td>
                                <td class="py-4">
                                    <span class="text-gray-600">{{ $kos->available_rooms_count }}/{{ $kos->total_rooms }}</span>
                                </td>
                                <td class="py-4">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                        {{ $kos->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($kos->status) }}
                                    </span>
                                </td>
                                <td class="py-4">
                                    <a href="{{ route('owner.kost.edit', $kos) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection

@php
$kosMapData = isset($boardingHouses) ? $boardingHouses->map(function($kos) {
    return [
        'id' => $kos->id,
        'name' => $kos->name,
        'type' => $kos->type ?? 'campur',
        'type_label' => $kos->type_label ?? 'Campur',
        'price' => $kos->formatted_price,
        'address' => $kos->address,
        'lat' => $kos->latitude,
        'lng' => $kos->longitude,
        'image' => $kos->first_image,
        'available_rooms' => $kos->available_rooms_count,
        'total_rooms' => $kos->total_rooms,
        'room_match' => $kos->is_room_match_enabled ?? false,
        'edit_url' => route('owner.kost.edit', $kos->id),
    ];
})->values()->toArray() : [];
@endphp

@push('scripts')
<script id="kos-map-data" type="application/json">{!! json_encode($kosMapData) !!}</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var mapElement = document.getElementById('dashboard-map');
    if (!mapElement) return;

    // Kos data from JSON script tag
    var kosDataScript = document.getElementById('kos-map-data');
    var kosData = JSON.parse(kosDataScript.textContent);

    // Filter kos with valid coordinates
    const validKos = kosData.filter(k => k.lat && k.lng);

    if (validKos.length === 0) {
        mapElement.innerHTML = '<div class="flex items-center justify-center h-full text-gray-500"><p>Belum ada kos dengan lokasi yang ditandai</p></div>';
        return;
    }

    // Initialize map with first kos location
    const map = L.map('dashboard-map').setView([validKos[0].lat, validKos[0].lng], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Custom icons based on kos type
    const icons = {
        putra: L.divIcon({
            className: 'custom-marker',
            html: `<div style="position: relative; width: 40px; height: 50px;">
                <div style="background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%); width: 40px; height: 40px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);">
                    <svg style="transform: rotate(45deg); width: 20px; height: 20px; fill: white;" viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
                </div>
                <div style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 8px; height: 8px; background: #1D4ED8; border-radius: 50%;"></div>
            </div>`,
            iconSize: [40, 50],
            iconAnchor: [20, 50]
        }),
        putri: L.divIcon({
            className: 'custom-marker',
            html: `<div style="position: relative; width: 40px; height: 50px;">
                <div style="background: linear-gradient(135deg, #EC4899 0%, #BE185D 100%); width: 40px; height: 40px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(236, 72, 153, 0.4);">
                    <svg style="transform: rotate(45deg); width: 20px; height: 20px; fill: white;" viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
                </div>
                <div style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 8px; height: 8px; background: #BE185D; border-radius: 50%;"></div>
            </div>`,
            iconSize: [40, 50],
            iconAnchor: [20, 50]
        }),
        campur: L.divIcon({
            className: 'custom-marker',
            html: `<div style="position: relative; width: 40px; height: 50px;">
                <div style="background: linear-gradient(135deg, #8B5CF6 0%, #6D28D9 100%); width: 40px; height: 40px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.4);">
                    <svg style="transform: rotate(45deg); width: 20px; height: 20px; fill: white;" viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
                </div>
                <div style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 8px; height: 8px; background: #6D28D9; border-radius: 50%;"></div>
            </div>`,
            iconSize: [40, 50],
            iconAnchor: [20, 50]
        })
    };

    // Add markers
    const markers = [];
    validKos.forEach(kos => {
        const icon = icons[kos.type] || icons.campur;
        const marker = L.marker([kos.lat, kos.lng], { icon: icon }).addTo(map);

        // Popup content
        const popupContent = `
            <div class="w-64">
                <img src="${kos.image}" class="w-full h-32 object-cover rounded-t-lg" alt="${kos.name}">
                <div class="p-3">
                    <h4 class="font-semibold text-gray-900">${kos.name}</h4>
                    <span class="inline-block px-2 py-1 text-xs rounded-full mt-1 ${kos.type === 'putra' ? 'bg-blue-100 text-blue-800' : kos.type === 'putri' ? 'bg-pink-100 text-pink-800' : 'bg-purple-100 text-purple-800'}">${kos.type_label}</span>
                    <p class="text-blue-600 font-bold mt-2">${kos.price}/bulan</p>
                    <p class="text-sm text-gray-500 mt-1">${kos.available_rooms}/${kos.total_rooms} kamar tersedia</p>
                    ${kos.room_match ? '<p class="text-xs text-green-600 mt-1">✓ Room Match tersedia</p>' : ''}
                    <a href="${kos.edit_url}" class="mt-3 block text-center px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700" style="color: white !important; background-color: #2563eb; display: block; text-align: center; padding: 8px 12px; border-radius: 8px; text-decoration: none;">Edit Kos</a>
                </div>
            </div>
        `;

        marker.bindPopup(popupContent, { maxWidth: 300 });
        markers.push(marker);
    });

    // Fit bounds to show all markers
    if (markers.length > 1) {
        const group = new L.featureGroup(markers);
        map.fitBounds(group.getBounds().pad(0.1));
    }
});
</script>
@endpush
