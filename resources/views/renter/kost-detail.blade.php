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
                    <a href="{{ route('renter.orders.index') }}" class="text-gray-600 hover:text-navy transition-colors">Pemesanan</a>
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
                            <a href="{{ route('renter.profile.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">Profil Saya</a>
                            <a href="{{ route('renter.orders.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">Pemesanan</a>
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
                                Sisa {{ $kost->available_rooms_count }} Kamar
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
                            <p class="font-semibold text-green-600">{{ $kost->available_rooms_count }} Kamar</p>
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

                    <!-- Pricing Card with Dynamic Selection -->
                    <div class="bg-white rounded-2xl shadow-sm p-6" x-data="pricingSelector()">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Harga Sewa</h3>

                        <!-- Occupant Type Selection -->
                        <div class="mb-4" x-show="hasRoomMatch">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Penghuni</label>
                            <div class="grid grid-cols-2 gap-3">
                                <!-- 1 Orang -->
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="occupant" value="single" x-model="occupantType" class="sr-only peer">
                                    <div class="p-3 border-2 rounded-xl text-center transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-blue-300">
                                        <div class="flex justify-center mb-1">
                                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                        <span class="block font-medium text-gray-900">1 Orang</span>
                                        <span class="text-xs text-gray-500">Sewa sendiri</span>
                                    </div>
                                </label>
                                <!-- 2 Orang -->
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="occupant" value="double" x-model="occupantType" class="sr-only peer">
                                    <div class="p-3 border-2 rounded-xl text-center transition-all peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-green-300">
                                        <div class="flex justify-center mb-1">
                                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                        </div>
                                        <span class="block font-medium text-gray-900">2 Orang</span>
                                        <span class="text-xs text-green-600">Room Match</span>
                                    </div>
                                </label>
                            </div>
                            <!-- Info for 2 person option -->
                            <div x-show="occupantType === 'double'" x-transition class="mt-3 p-3 bg-green-50 rounded-lg border border-green-200">
                                <p class="text-xs text-green-700 flex items-start">
                                    <svg class="w-4 h-4 mr-1 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                    Harga per orang. Anda bisa mengajak teman untuk berbagi kamar.
                                </p>
                            </div>
                        </div>

                        <!-- Duration Selection (Only for 1 Orang) -->
                        <div class="mb-4" x-show="occupantType === 'single'">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Durasi Sewa</label>
                            <div class="space-y-2">
                                <!-- 1 Bulan -->
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer transition-all"
                                       :class="duration === '1_month' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300'">
                                    <input type="radio" name="duration" value="1_month" x-model="duration" class="w-4 h-4 text-blue-600">
                                    <span class="ml-3 flex-1">
                                        <span class="block font-medium text-gray-900">1 Bulan</span>
                                    </span>
                                    <span class="font-semibold text-gray-900" x-text="formatPrice(prices.single['1_month'])"></span>
                                </label>

                                @if($kost->price_3months)
                                <!-- 3 Bulan -->
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer transition-all"
                                       :class="duration === '3_months' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300'">
                                    <input type="radio" name="duration" value="3_months" x-model="duration" class="w-4 h-4 text-blue-600">
                                    <span class="ml-3 flex-1">
                                        <span class="block font-medium text-gray-900">3 Bulan</span>
                                    </span>
                                    <span class="font-semibold text-gray-900" x-text="formatPrice(prices.single['3_months'])"></span>
                                </label>
                                @endif

                                @if($kost->price_6months)
                                <!-- 6 Bulan -->
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer transition-all"
                                       :class="duration === '6_months' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300'">
                                    <input type="radio" name="duration" value="6_months" x-model="duration" class="w-4 h-4 text-blue-600">
                                    <span class="ml-3 flex-1">
                                        <span class="block font-medium text-gray-900">6 Bulan</span>
                                    </span>
                                    <span class="font-semibold text-gray-900" x-text="formatPrice(prices.single['6_months'])"></span>
                                </label>
                                @endif

                                @if($kost->price_yearly)
                                <!-- 1 Tahun -->
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer transition-all"
                                       :class="duration === '1_year' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300'">
                                    <input type="radio" name="duration" value="1_year" x-model="duration" class="w-4 h-4 text-blue-600">
                                    <span class="ml-3 flex-1">
                                        <span class="block font-medium text-gray-900">1 Tahun</span>
                                    </span>
                                    <span class="font-semibold text-gray-900" x-text="formatPrice(prices.single['1_year'])"></span>
                                </label>
                                @endif
                            </div>
                        </div>

                        <!-- Room Match Price Display (For 2 Orang) -->
                        <div class="mb-4" x-show="occupantType === 'double'">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Harga Room Match</label>
                            <div class="p-4 border-2 border-green-500 bg-green-50 rounded-xl">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="block font-medium text-gray-900">{{ $kost->room_match_period ? ucfirst(str_replace(['1_month', '3_months', '6_months', '1_year'], ['1 Bulan', '3 Bulan', '6 Bulan', '1 Tahun'], $kost->room_match_period)) : 'Per Bulan' }}</span>
                                        <span class="text-xs text-green-600">Harga per orang (sudah dibagi 2)</span>
                                    </div>
                                    <span class="text-xl font-bold text-green-600">{{ $kost->room_match_price ? 'Rp ' . number_format($kost->room_match_price / 2, 0, ',', '.') : '-' }}</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Total harga kamar: Rp {{ number_format($kost->room_match_price ?? 0, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <!-- Total Price Display -->
                        <div class="border-t pt-4 mb-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Total Harga</span>
                                <span class="text-2xl font-bold text-blue-600" x-text="formatPrice(selectedPrice)"></span>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">
                                <span x-show="occupantType === 'single'" x-text="durationLabel"></span>
                                <span x-show="occupantType === 'double'">{{ $kost->room_match_period ? 'untuk ' . str_replace(['1_month', '3_months', '6_months', '1_year'], ['1 bulan', '3 bulan', '6 bulan', '1 tahun'], $kost->room_match_period) : 'per bulan' }}</span>
                                <span x-show="occupantType === 'double'" class="text-green-600"> • per orang</span>
                            </p>
                        </div>

                        <!-- Room Match Option - Only show as info if not already selected double -->
                        @if($kost->is_room_match_enabled)
                            <div x-show="occupantType === 'single'" class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <span class="font-semibold text-green-800">Room Match Tersedia</span>
                                </div>
                                <p class="text-sm text-green-700">Pilih "2 Orang" di atas untuk berbagi kamar & biaya</p>
                            </div>
                        @endif

                        <!-- CTA Button -->
                        <div class="space-y-3">
                            <a :href="getBookingUrl()"
                               class="w-full py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors font-semibold flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Ajukan Sewa
                            </a>
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
                <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Kos {{ $kost->type_label }} Lainnya</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($relatedKosts as $related)
                        <div class="bg-white rounded-2xl overflow-hidden shadow-md transition-all duration-300 hover:shadow-xl">
                            <!-- Image Header with Hover Effect -->
                            <div class="relative aspect-[4/3] overflow-hidden group">
                                <img src="{{ $related->first_image }}" alt="{{ $related->name }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">

                                <!-- Dark Overlay on Hover -->
                                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center">
                                    <a href="{{ route('renter.kost.show', $related->slug) }}"
                                       class="px-5 py-2.5 bg-white rounded-full flex items-center gap-2 text-gray-800 font-medium transform scale-90 opacity-0 group-hover:scale-100 group-hover:opacity-100 transition-all duration-300 hover:bg-blue-600 hover:text-white">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Lihat Detail
                                    </a>
                                </div>

                                <!-- Badge Left - Gender Type -->
                                <div class="absolute top-4 left-4">
                                    <span class="px-3 py-1.5 {{ $related->type === 'putra' ? 'bg-blue-500' : ($related->type === 'putri' ? 'bg-pink-500' : 'bg-purple-500') }} text-white text-xs font-semibold rounded-full uppercase tracking-wide">
                                        {{ $related->type_label }}
                                    </span>
                                </div>

                                <!-- Room Match Icon Right (if room sharing enabled) -->
                                @if($related->is_room_match_enabled)
                                    <div class="absolute top-4 right-4">
                                        <span class="w-9 h-9 bg-green-500 rounded-full flex items-center justify-center shadow-lg" title="Bisa Berbagi Kamar">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="9" cy="7" r="4"></circle>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                            </svg>
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Content Body -->
                            <div class="p-5">
                                <!-- Location -->
                                <div class="flex items-center gap-1.5 text-gray-500 text-sm mb-2">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span class="truncate">{{ $related->address }}</span>
                                </div>

                                <!-- Title -->
                                <h3 class="font-bold text-gray-900 text-lg mb-3 line-clamp-2">{{ $related->name }}</h3>

                                <!-- Tags Row -->
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @if($related->room_size ?? null)
                                        <span class="px-2.5 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded-full">{{ $related->room_size }}</span>
                                    @endif
                                    @if($related->total_rooms ?? null)
                                        <span class="px-2.5 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded-full">{{ $related->total_rooms }} Kamar</span>
                                    @endif
                                    @if($related->available_rooms ?? null)
                                        <span class="px-2.5 py-1 bg-green-50 text-green-600 text-xs font-medium rounded-full">{{ $related->available_rooms }} Tersedia</span>
                                    @endif
                                </div>

                                <!-- Footer -->
                                <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                    <p class="text-blue-600 font-bold text-lg">{{ $related->formatted_price_monthly }}<span class="text-gray-400 font-normal text-sm">/bln</span></p>
                                    <a href="{{ route('renter.kost.show', $related->slug) }}"
                                       class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-full hover:bg-blue-700 transition-colors">
                                        Pesan Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
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

    <!-- Kost Data (JSON) -->
    <script id="kost-data" type="application/json">
        {!! json_encode([
            'prices' => [
                'single' => [
                    '1_month' => $kost->price_monthly ?? $kost->price ?? 0,
                    '3_months' => $kost->price_3months ?? (($kost->price_monthly ?? 0) * 3),
                    '6_months' => $kost->price_6months ?? (($kost->price_monthly ?? 0) * 6),
                    '1_year' => $kost->price_yearly ?? (($kost->price_monthly ?? 0) * 12)
                ]
            ],
            'roomMatchPrice' => $kost->room_match_price ? intval($kost->room_match_price / 2) : 0,
            'roomMatchTotalPrice' => $kost->room_match_price ?? 0,
            'roomMatchPeriodRaw' => $kost->room_match_period ?? '1_month',
            'hasRoomMatch' => $kost->is_room_match_enabled && $kost->room_match_price ? true : false,
            'bookingUrl' => route('renter.booking.create', $kost->slug),
            'map' => [
                'latitude' => $kost->latitude,
                'longitude' => $kost->longitude,
                'name' => $kost->name,
                'address' => $kost->address
            ]
        ]) !!}
    </script>

    <script>
        function pricingSelector() {
            const kostData = JSON.parse(document.getElementById('kost-data').textContent);
            
            return {
                duration: '1_month',
                occupantType: 'single',
                prices: kostData.prices,
                roomMatchPrice: kostData.roomMatchPrice,
                roomMatchTotalPrice: kostData.roomMatchTotalPrice,
                roomMatchPeriodRaw: kostData.roomMatchPeriodRaw,
                hasRoomMatch: kostData.hasRoomMatch,
                bookingBaseUrl: kostData.bookingUrl,
                normalizePeriod(period) {
                    const periodMap = {
                        '1 bulan': '1_month',
                        '3 bulan': '3_months',
                        '6 bulan': '6_months',
                        '12 bulan': '1_year',
                        '1_month': '1_month',
                        '3_months': '3_months',
                        '6_months': '6_months',
                        '1_year': '1_year'
                    };
                    return periodMap[period] || '1_month';
                },
                get roomMatchPeriod() {
                    return this.normalizePeriod(this.roomMatchPeriodRaw);
                },
                get selectedPrice() {
                    if (this.occupantType === 'double') {
                        return this.roomMatchPrice;
                    }
                    return this.prices.single[this.duration] || this.prices.single['1_month'];
                },
                get selectedDuration() {
                    if (this.occupantType === 'double') {
                        return this.roomMatchPeriod;
                    }
                    return this.duration;
                },
                get durationLabel() {
                    const labels = {
                        '1_month': 'untuk 1 bulan',
                        '3_months': 'untuk 3 bulan',
                        '6_months': 'untuk 6 bulan',
                        '1_year': 'untuk 1 tahun'
                    };
                    return labels[this.duration];
                },
                get occupantLabel() {
                    return this.occupantType === 'single' ? '1 Orang' : '2 Orang';
                },
                formatPrice(price) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(price);
                },
                getBookingUrl() {
                    return this.bookingBaseUrl + '?duration=' + this.selectedDuration + '&occupant=' + this.occupantType + '&price=' + this.selectedPrice;
                }
            }
        }

        // Initialize Map
        document.addEventListener('DOMContentLoaded', function() {
            const kostData = JSON.parse(document.getElementById('kost-data').textContent);
            
            if (kostData.map.latitude && kostData.map.longitude) {
                const mapElement = document.getElementById('map');
                if (mapElement) {
                    const map = L.map('map').setView([kostData.map.latitude, kostData.map.longitude], 15);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap'
                    }).addTo(map);
                    L.marker([kostData.map.latitude, kostData.map.longitude])
                        .addTo(map)
                        .bindPopup('<strong>' + kostData.map.name + '</strong><br>' + kostData.map.address)
                        .openPopup();
                }
            }
        });
    </script>
</body>
</html>

