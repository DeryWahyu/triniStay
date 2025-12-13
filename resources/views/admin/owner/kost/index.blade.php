@extends('layouts.admin.owner')

@section('title', 'Kelola Kos')
@section('page-title', 'Kelola Kos')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Kelola informasi kos Anda</h2>
            <p class="text-gray-500 mt-1">Atur dan perbarui informasi kos-kosan yang Anda miliki</p>
        </div>
        <a href="{{ route('owner.kost.create') }}"
           class="inline-flex items-center px-5 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold shadow-md">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            TAMBAH KOS
        </a>
    </div>

    <!-- Kost List (Accordion) -->
    @if(isset($boardingHouses) && $boardingHouses->count() > 0)
        <div class="space-y-4">
            @foreach($boardingHouses as $kost)
                <div x-data="{ open: false }" class="bg-white border-2 border-gray-800 rounded-xl overflow-hidden shadow-sm">

                    <!-- Accordion Header (Collapsed State) -->
                    <button
                        @click="open = !open"
                        class="w-full px-6 py-5 flex items-center justify-between hover:bg-gray-50 transition-colors focus:outline-none"
                    >
                        <div class="flex items-center space-x-4">
                            <!-- Kost Type Badge -->
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $kost->type_badge_color }}">
                                {{ $kost->type_label }}
                            </span>
                            <!-- Kost Name -->
                            <h3 class="text-xl font-bold text-gray-900 uppercase">{{ $kost->name }}</h3>
                            <!-- Status Badge -->
                            <span class="px-2 py-1 text-xs font-medium rounded-full
                                {{ $kost->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $kost->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>

                        <!-- Chevron Icon -->
                        <svg
                            class="w-6 h-6 text-gray-600 transform transition-transform duration-300"
                            :class="{ 'rotate-180': open }"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- Accordion Body (Expanded State) -->
                    <div
                        x-show="open"
                        x-collapse
                        x-cloak
                        class="border-t-2 border-gray-800"
                    >
                        <div class="p-6 space-y-6">

                            <!-- Photo Grid & Price Section -->
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                                <!-- Main Photo -->
                                <div class="lg:col-span-2">
                                    <div class="relative h-64 lg:h-80 rounded-xl overflow-hidden">
                                        <img
                                            src="{{ $kost->first_image }}"
                                            alt="{{ $kost->name }}"
                                            class="w-full h-full object-cover"
                                        >
                                    </div>
                                </div>

                                <!-- Thumbnail Photos -->
                                <div class="grid grid-rows-2 gap-4">
                                    @if($kost->images && count($kost->images) > 1)
                                        <div class="h-32 lg:h-36 rounded-xl overflow-hidden">
                                            <img
                                                src="{{ asset('storage/' . $kost->images[1]) }}"
                                                alt="{{ $kost->name }}"
                                                class="w-full h-full object-cover"
                                            >
                                        </div>
                                    @else
                                        <div class="h-32 lg:h-36 rounded-xl overflow-hidden bg-gray-200 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif

                                    @if($kost->images && count($kost->images) > 2)
                                        <div class="h-32 lg:h-36 rounded-xl overflow-hidden relative">
                                            <img
                                                src="{{ asset('storage/' . $kost->images[2]) }}"
                                                alt="{{ $kost->name }}"
                                                class="w-full h-full object-cover"
                                            >
                                            @if(count($kost->images) > 3)
                                                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                                    <span class="text-white text-xl font-bold">+{{ count($kost->images) - 3 }} Foto</span>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <div class="h-32 lg:h-36 rounded-xl overflow-hidden bg-gray-200 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Price Bar -->
                            <div class="bg-blue-600 rounded-xl p-4 flex flex-wrap items-center justify-between gap-4">
                                <div class="flex items-center space-x-6">
                                    <div class="text-white">
                                        <span class="text-sm opacity-80">Harga per Bulan</span>
                                        <p class="text-2xl font-bold">{{ $kost->formatted_price_monthly }}</p>
                                    </div>
                                    @if($kost->price_6months)
                                        <div class="text-white border-l border-blue-400 pl-6">
                                            <span class="text-sm opacity-80">Per 6 Bulan</span>
                                            <p class="text-lg font-semibold">{{ $kost->formatted_price_6months }}</p>
                                        </div>
                                    @endif
                                    @if($kost->price_yearly)
                                        <div class="text-white border-l border-blue-400 pl-6">
                                            <span class="text-sm opacity-80">Per Tahun</span>
                                            <p class="text-lg font-semibold">{{ $kost->formatted_price_yearly }}</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Tags -->
                                <div class="flex flex-wrap items-center gap-3">
                                    <span class="px-4 py-2 bg-white rounded-full text-sm font-semibold {{ $kost->type === 'putra' ? 'text-blue-600' : ($kost->type === 'putri' ? 'text-pink-600' : 'text-purple-600') }}">
                                        {{ $kost->type_label }}
                                    </span>
                                    <span class="px-4 py-2 bg-yellow-400 text-gray-900 rounded-full text-sm font-semibold">
                                        Sisa {{ $kost->available_rooms }} Kamar
                                    </span>
                                    @if($kost->is_room_match_enabled)
                                        <span class="px-4 py-2 bg-green-400 text-gray-900 rounded-full text-sm font-semibold">
                                            Room Match
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Two Column Details -->
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                                <!-- Left Column -->
                                <div class="space-y-6">

                                    <!-- Spesifikasi Kamar -->
                                    <div>
                                        <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                            </svg>
                                            Spesifikasi Kamar
                                        </h4>
                                        <div class="bg-gray-50 rounded-xl p-4 space-y-3">
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Ukuran Kamar</span>
                                                <span class="font-semibold text-gray-900">{{ $kost->room_size ?? '-' }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Total Kamar</span>
                                                <span class="font-semibold text-gray-900">{{ $kost->total_rooms }} Kamar</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Kamar Tersedia</span>
                                                <span class="font-semibold text-green-600">{{ $kost->available_rooms }} Kamar</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Fasilitas Umum -->
                                    <div>
                                        <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                            Fasilitas Umum
                                        </h4>
                                        <div class="grid grid-cols-2 gap-3">
                                            @if($kost->common_facilities && count($kost->common_facilities) > 0)
                                                @foreach($kost->common_facilities as $facility)
                                                    <div class="flex items-center space-x-2 bg-gray-50 rounded-lg p-3">
                                                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                        </svg>
                                                        <span class="text-gray-700 text-sm">{{ $facility }}</span>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p class="text-gray-500 text-sm col-span-2">Belum ada fasilitas umum</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Peraturan Kos -->
                                    <div>
                                        <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                            </svg>
                                            Peraturan Kos
                                        </h4>
                                        <div class="bg-gray-50 rounded-xl p-4">
                                            @if($kost->rules)
                                                <div class="prose prose-sm text-gray-700">
                                                    {!! nl2br(e($kost->rules)) !!}
                                                </div>
                                            @else
                                                <p class="text-gray-500 text-sm">Belum ada peraturan</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="space-y-6">

                                    <!-- Fasilitas Kamar -->
                                    <div>
                                        <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                            </svg>
                                            Fasilitas Kamar
                                        </h4>
                                        <div class="grid grid-cols-2 gap-3">
                                            @if($kost->room_facilities && count($kost->room_facilities) > 0)
                                                @foreach($kost->room_facilities as $facility)
                                                    <div class="flex items-center space-x-2 bg-gray-50 rounded-lg p-3">
                                                        <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                        </svg>
                                                        <span class="text-gray-700 text-sm">{{ $facility }}</span>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p class="text-gray-500 text-sm col-span-2">Belum ada fasilitas kamar</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Lokasi -->
                                    <div>
                                        <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            Lokasi
                                        </h4>

                                        <!-- Address -->
                                        <div class="bg-gray-50 rounded-xl p-4 mb-4">
                                            <p class="text-gray-700 text-sm">{{ $kost->address }}</p>
                                        </div>

                                        <!-- Map -->
                                        @if($kost->latitude && $kost->longitude)
                                            <div class="rounded-xl overflow-hidden border-2 border-gray-200 h-48">
                                                <div id="map-{{ $kost->id }}" class="w-full h-full" data-lat="{{ $kost->latitude }}" data-lng="{{ $kost->longitude }}" data-name="{{ $kost->name }}"></div>
                                            </div>
                                        @else
                                            <div class="rounded-xl overflow-hidden border-2 border-gray-200 h-48 bg-gray-100 flex items-center justify-center">
                                                <div class="text-center text-gray-500">
                                                    <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    </svg>
                                                    <p class="text-sm">Lokasi belum ditandai</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Room Match Info -->
                                    @if($kost->is_room_match_enabled)
                                        <div>
                                            <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                </svg>
                                                Room Match (Berbagi Kamar)
                                            </h4>
                                            <div class="bg-green-50 border border-green-200 rounded-xl p-4 space-y-2">
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Harga Room Match</span>
                                                    <span class="font-semibold text-green-600">{{ $kost->formatted_room_match_price }}</span>
                                                </div>
                                                @if($kost->room_match_period)
                                                    <div class="flex justify-between">
                                                        <span class="text-gray-600">Periode</span>
                                                        <span class="font-semibold text-gray-900">{{ $kost->room_match_period }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- About Section -->
                            <div>
                                <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Tentang Kos
                                </h4>
                                <div class="bg-gray-50 rounded-xl p-4">
                                    @if($kost->description)
                                        <p class="text-gray-700 leading-relaxed">{{ $kost->description }}</p>
                                    @else
                                        <p class="text-gray-500 text-sm">Belum ada deskripsi</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Action Footer -->
                            <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t border-gray-200">
                                <a href="{{ route('owner.kost.edit', $kost) }}"
                                   class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-colors font-semibold">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit Kos
                                </a>

                                <form action="{{ route('owner.kost.destroy', $kost) }}" method="POST" class="flex-1"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus kos {{ $kost->name }}? Tindakan ini tidak dapat dibatalkan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-full inline-flex items-center justify-center px-6 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-colors font-semibold">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus Kos
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($boardingHouses->hasPages())
            <div class="mt-6">
                {{ $boardingHouses->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="bg-white border-2 border-gray-800 rounded-xl p-12 text-center">
            <svg class="w-24 h-24 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Kos Terdaftar</h3>
            <p class="text-gray-500 mb-8 max-w-md mx-auto">Anda belum memiliki kos yang terdaftar. Mulai tambahkan kos pertama Anda dan kelola dengan mudah!</p>
            <a href="{{ route('owner.kost.create') }}"
               class="inline-flex items-center px-8 py-4 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors font-bold text-lg shadow-lg">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Kos Pertama
            </a>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize maps when accordion opens
    document.querySelectorAll('[x-data]').forEach(function(accordion) {
        const mapContainers = accordion.querySelectorAll('[id^="map-"]');

        mapContainers.forEach(function(mapElement) {
            // Use MutationObserver to detect when map becomes visible
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.target.style.display !== 'none' && !mapElement.dataset.initialized) {
                        initializeMap(mapElement);
                    }
                });
            });

            // Also check on click
            accordion.querySelector('button')?.addEventListener('click', function() {
                setTimeout(function() {
                    if (!mapElement.dataset.initialized && mapElement.offsetParent !== null) {
                        initializeMap(mapElement);
                    }
                }, 100);
            });
        });
    });

    function initializeMap(mapElement) {
        const lat = parseFloat(mapElement.dataset.lat);
        const lng = parseFloat(mapElement.dataset.lng);
        const name = mapElement.dataset.name;

        if (lat && lng) {
            const map = L.map(mapElement.id).setView([lat, lng], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap'
            }).addTo(map);
            L.marker([lat, lng]).addTo(map)
                .bindPopup('<strong>' + name + '</strong>');
            mapElement.dataset.initialized = 'true';

            // Invalidate size to fix rendering issues
            setTimeout(function() { map.invalidateSize(); }, 200);
        }
    }
});
</script>
@endpush
