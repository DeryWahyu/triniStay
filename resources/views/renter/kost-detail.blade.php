<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $kost->name }} - TriniStay</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        'navy': '#1F2937',
                        'navy-dark': '#111827',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .gallery-main { aspect-ratio: 16/10; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="{{ route('renter.dashboard') }}" class="flex items-center space-x-2">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="#1F2937" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 22V12H15V22" stroke="#1F2937" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="text-xl font-bold text-navy">TriniStay</span>
                </a>

                <!-- Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('renter.dashboard') }}" class="text-gray-600 hover:text-navy transition-colors">Beranda</a>
                    <a href="{{ route('renter.kos.search') }}" class="text-navy font-medium hover:text-blue-600 transition-colors">Cari Kos</a>
                    <a href="{{ route('renter.room-match.index') }}" class="text-gray-600 hover:text-navy transition-colors">Cari Teman</a>
                    <a href="#" class="text-gray-600 hover:text-navy transition-colors">Pemesanan</a>
                </div>

                <!-- User Profile -->
                <div class="flex items-center space-x-4">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                            <div class="w-10 h-10 bg-gradient-to-br from-[#19608E] to-[#162D40] rounded-full flex items-center justify-center shadow-md">
                                <span class="text-white font-semibold text-sm">{{ Auth::user()->initials }}</span>
                            </div>
                            <span class="hidden sm:block text-navy font-medium">{{ Auth::user()->name }}</span>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false" x-cloak
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 z-50 border border-gray-100">
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">Profil Saya</a>
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">Pemesanan</a>
                            <hr class="my-2">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Breadcrumb -->
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex items-center space-x-2 text-sm">
                <a href="{{ route('renter.dashboard') }}" class="text-gray-500 hover:text-blue-600">Beranda</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-gray-500">Kos {{ $kost->type_label }}</span>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-gray-900 font-medium">{{ $kost->name }}</span>
            </nav>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Left Column - Main Content -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Image Gallery -->
                <div x-data="{ activeImage: 0 }" class="bg-white rounded-2xl shadow-sm overflow-hidden">
                    <!-- Main Image -->
                    <div class="gallery-main relative">
                        @if($kost->images && count($kost->images) > 0)
                            @foreach($kost->images as $index => $image)
                                <img
                                    x-show="activeImage === {{ $index }}"
                                    src="{{ asset('storage/' . $image) }}"
                                    alt="{{ $kost->name }}"
                                    class="w-full h-full object-cover"
                                >
                            @endforeach
                        @else
                            <img src="https://via.placeholder.com/800x500?text=No+Image" alt="{{ $kost->name }}" class="w-full h-full object-cover">
                        @endif

                        <!-- Type Badge -->
                        <div class="absolute top-4 left-4">
                            <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $kost->type_badge_color }}">
                                {{ $kost->type_label }}
                            </span>
                        </div>

                        <!-- Room Match Badge -->
                        @if($kost->is_room_match_enabled)
                            <div class="absolute top-4 right-4">
                                <span class="px-4 py-2 bg-green-500 text-white rounded-full text-sm font-semibold">
                                    Room Match Tersedia
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Thumbnails -->
                    @if($kost->images && count($kost->images) > 1)
                        <div class="p-4 flex space-x-3 overflow-x-auto">
                            @foreach($kost->images as $index => $image)
                                <button
                                    @click="activeImage = {{ $index }}"
                                    :class="{ 'ring-2 ring-blue-500': activeImage === {{ $index }} }"
                                    class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden focus:outline-none"
                                >
                                    <img src="{{ asset('storage/' . $image) }}" alt="Thumbnail" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Kost Title & Basic Info -->
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">{{ $kost->name }}</h1>
                            <div class="flex items-center mt-2 text-gray-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>{{ $kost->address }}</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                                Sisa {{ $kost->available_rooms }} Kamar
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Specifications -->
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                        </svg>
                        Spesifikasi Kamar
                    </h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="bg-gray-50 rounded-xl p-4 text-center">
                            <svg class="w-8 h-8 mx-auto text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                            </svg>
                            <p class="text-gray-500 text-sm">Ukuran Kamar</p>
                            <p class="font-semibold text-gray-900">{{ $kost->room_size ?? '-' }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4 text-center">
                            <svg class="w-8 h-8 mx-auto text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <p class="text-gray-500 text-sm">Total Kamar</p>
                            <p class="font-semibold text-gray-900">{{ $kost->total_rooms }} Kamar</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4 text-center">
                            <svg class="w-8 h-8 mx-auto text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-gray-500 text-sm">Tersedia</p>
                            <p class="font-semibold text-green-600">{{ $kost->available_rooms }} Kamar</p>
                        </div>
                    </div>
                </div>

                <!-- Common Facilities -->
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        Fasilitas Umum
                    </h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @if($kost->common_facilities && count($kost->common_facilities) > 0)
                            @foreach($kost->common_facilities as $facility)
                                <div class="flex items-center space-x-3 bg-gray-50 rounded-lg p-3">
                                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-gray-700">{{ $facility }}</span>
                                </div>
                            @endforeach
                        @else
                            <p class="text-gray-500 col-span-3">Belum ada informasi fasilitas umum</p>
                        @endif
                    </div>
                </div>

                <!-- Room Facilities -->
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                        Fasilitas Kamar
                    </h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @if($kost->room_facilities && count($kost->room_facilities) > 0)
                            @foreach($kost->room_facilities as $facility)
                                <div class="flex items-center space-x-3 bg-gray-50 rounded-lg p-3">
                                    <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-gray-700">{{ $facility }}</span>
                                </div>
                            @endforeach
                        @else
                            <p class="text-gray-500 col-span-3">Belum ada informasi fasilitas kamar</p>
                        @endif
                    </div>
                </div>

                <!-- Rules -->
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        Peraturan Kos
                    </h2>
                    <div class="bg-gray-50 rounded-xl p-4">
                        @if($kost->rules)
                            <div class="prose prose-sm text-gray-700 max-w-none">
                                {!! nl2br(e($kost->rules)) !!}
                            </div>
                        @else
                            <p class="text-gray-500">Belum ada peraturan yang ditentukan</p>
                        @endif
                    </div>
                </div>

                <!-- About -->
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Tentang Kos
                    </h2>
                    <div class="text-gray-700 leading-relaxed">
                        @if($kost->description)
                            <p>{{ $kost->description }}</p>
                        @else
                            <p class="text-gray-500">Belum ada deskripsi</p>
                        @endif
                    </div>
                </div>

                <!-- Location Map -->
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Lokasi
                    </h2>
                    @if($kost->latitude && $kost->longitude)
                        <div id="map" class="h-64 rounded-xl overflow-hidden border-2 border-gray-200"></div>
                    @else
                        <div class="h-64 rounded-xl bg-gray-100 flex items-center justify-center">
                            <div class="text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                                <p>Lokasi belum ditandai</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column - Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-24 space-y-6">

                    <!-- Pricing Card -->
                    <div class="bg-white rounded-2xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Harga Sewa</h3>

                        <!-- Monthly Price -->
                        <div class="mb-4">
                            <p class="text-3xl font-bold text-blue-600">{{ $kost->formatted_price_monthly }}</p>
                            <p class="text-gray-500">per bulan</p>
                        </div>

                        <!-- Other Prices -->
                        @if($kost->price_6months || $kost->price_yearly)
                            <div class="border-t pt-4 space-y-3">
                                @if($kost->price_6months)
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Per 6 Bulan</span>
                                        <span class="font-semibold text-gray-900">{{ $kost->formatted_price_6months }}</span>
                                    </div>
                                @endif
                                @if($kost->price_yearly)
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Per Tahun</span>
                                        <span class="font-semibold text-gray-900">{{ $kost->formatted_price_yearly }}</span>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Room Match Option -->
                        @if($kost->is_room_match_enabled)
                            <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-xl">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <span class="font-semibold text-green-800">Room Match</span>
                                </div>
                                <p class="text-sm text-green-700 mb-2">Berbagi kamar dengan teman sekamar yang cocok</p>
                                <p class="text-lg font-bold text-green-600">{{ $kost->formatted_room_match_price }}</p>
                            </div>
                        @endif

                        <!-- CTA Button -->
                        <div class="mt-6 space-y-3">
                            <button class="w-full py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors font-semibold">
                                Ajukan Sewa
                            </button>
                            @if($kost->is_room_match_enabled)
                                <button class="w-full py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-colors font-semibold flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    Cari Teman Sekamar
                                </button>
                            @endif
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $kost->owner->phone_number ?? '') }}?text=Halo, saya tertarik dengan kos {{ $kost->name }}"
                               target="_blank"
                               class="w-full py-3 border-2 border-green-500 text-green-600 rounded-xl hover:bg-green-50 transition-colors font-semibold flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                                Hubungi via WhatsApp
                            </a>
                        </div>
                    </div>

                    <!-- Owner Info -->
                    <div class="bg-white rounded-2xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Pemilik Kos</h3>
                        <div class="flex items-center space-x-4">
                            <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-xl font-bold text-blue-600">{{ substr($kost->owner->name ?? 'O', 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $kost->owner->name ?? 'Pemilik' }}</p>
                                <p class="text-sm text-gray-500">Pemilik Kos</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Kosts -->
        @if($relatedKosts->count() > 0)
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Kos {{ $kost->type_label }} Lainnya</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedKosts as $related)
                        <a href="{{ route('renter.kost.show', $related->slug) }}" class="group">
                            <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                                <div class="aspect-video relative overflow-hidden">
                                    <img src="{{ $related->first_image }}" alt="{{ $related->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    <span class="absolute top-3 left-3 px-3 py-1 rounded-full text-xs font-semibold {{ $related->type_badge_color }}">
                                        {{ $related->type_label }}
                                    </span>
                                </div>
                                <div class="bg-navy p-4">
                                    <h3 class="font-semibold text-white mb-1 truncate">{{ $related->name }}</h3>
                                    <p class="text-gray-400 text-sm mb-2 truncate">{{ $related->address }}</p>
                                    <div class="flex items-center justify-between">
                                        <p class="text-white font-bold">{{ $related->formatted_price_monthly }}<span class="text-gray-400 font-normal text-sm">/bulan</span></p>
                                        <span class="px-3 py-1 bg-white text-navy text-sm font-medium rounded-md">Detail</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-navy mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-2 mb-4 md:mb-0">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 22V12H15V22" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="text-xl font-bold text-white">TriniStay</span>
                </div>
                <p class="text-gray-400 text-sm">© {{ date('Y') }} TriniStay. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>

    @if($kost->latitude && $kost->longitude)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const map = L.map('map').setView([{{ $kost->latitude }}, {{ $kost->longitude }}], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap'
            }).addTo(map);
            L.marker([{{ $kost->latitude }}, {{ $kost->longitude }}])
                .addTo(map)
                .bindPopup('<strong>{{ addslashes($kost->name) }}</strong><br>{{ addslashes($kost->address) }}')
                .openPopup();
        });
    </script>
    @endif
</body>
</html>
