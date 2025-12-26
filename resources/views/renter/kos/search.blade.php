<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Kos - TriniStay</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
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
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white shadow sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <a href="{{ route('renter.dashboard') }}" class="flex items-center space-x-2">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="#3B82F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 22V12H15V22" stroke="#3B82F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="text-2xl font-bold text-navy">TriniStay</span>
                </a>

                <!-- Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('renter.dashboard') }}" class="text-gray-600 hover:text-navy transition-colors">Beranda</a>
                    <a href="{{ route('renter.kos.search') }}" class="text-blue-600 font-semibold">Cari Kos</a>
                    <a href="{{ route('renter.room-match.index') }}" class="text-gray-600 hover:text-navy transition-colors">Cari Teman</a>
                    <a href="{{ route('renter.orders.index') }}" class="text-gray-600 hover:text-navy transition-colors">Pemesanan</a>
                </div>

                <!-- User Profile -->
                <div class="flex items-center space-x-4">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center shadow-md ring-2 ring-blue-200">
                                <span class="text-white font-semibold text-sm">{{ Auth::user()->initials }}</span>
                            </div>
                            <span class="hidden sm:block text-navy font-medium">{{ Auth::user()->name }}</span>
                        </button>

                        <!-- Dropdown -->
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

    <!-- Page Wrapper with Alpine.js data -->
    <div x-data="searchPage()">
        <!-- Hero Header with Gradient -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
            <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-800 relative overflow-hidden rounded-3xl">
                <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=%2260%22 height=%2260%22 viewBox=%220 0 60 60%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cg fill=%22none%22 fill-rule=%22evenodd%22%3E%3Cg fill=%22%23ffffff%22 fill-opacity=%220.08%22%3E%3Cpath d=%22M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2V36h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z%22/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
                <div class="px-6 sm:px-8 lg:px-12 py-10 relative z-10">
                    <div class="text-center mb-8">
                        <h1 class="text-3xl md:text-4xl font-bold text-white mb-3">Cari Kos Sesuai Selera Anda</h1>
                        <p class="text-blue-100 text-lg">Temukan kos impian dengan berbagai pilihan filter</p>
                    </div>

                    <!-- Search Bar -->
                    <form action="{{ route('renter.kos.search') }}" method="GET" id="searchForm" class="max-w-4xl mx-auto">
                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-2 border border-white/20">
                            <div class="flex flex-col md:flex-row gap-2">
                                <!-- Search Input -->
                                <div class="flex-1 relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        name="keyword"
                                        value="{{ request('keyword') }}"
                                        placeholder="Cari nama kos atau lokasi..."
                                        class="w-full pl-12 pr-4 py-4 bg-white rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 text-gray-800 placeholder-gray-400"
                                    >
                                </div>

                                <!-- Filter & Search Buttons -->
                                <div class="flex gap-2">
                                    <button
                                        type="button"
                                        @click="openFilter = true"
                                        class="flex items-center justify-center px-5 py-4 bg-white/20 text-white font-medium rounded-xl hover:bg-white/30 transition-colors border border-white/30"
                                    >
                                        <svg class="w-5 h-5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                        </svg>
                                        <span class="hidden md:inline">Filter</span>
                                    </button>

                                    <button
                                        type="submit"
                                        class="flex items-center justify-center px-8 py-4 bg-white text-blue-600 font-semibold rounded-xl hover:bg-blue-50 transition-colors shadow-lg"
                                    >
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                        Cari
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <!-- Active Filters Tags -->
        @if(request()->hasAny(['type', 'min_price', 'max_price', 'facilities', 'occupancy']))
            <div class="mb-6 flex flex-wrap items-center gap-2 bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                <span class="text-sm text-gray-500 font-medium">Filter aktif:</span>

                @if(request('type'))
                    <span class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                        Kos {{ ucfirst(request('type')) }}
                        <a href="{{ request()->fullUrlWithoutQuery('type') }}" class="ml-2 hover:text-blue-600">&times;</a>
                    </span>
                @endif

                @if(request('min_price') || request('max_price'))
                    <span class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-800 text-sm font-medium rounded-full">
                        Harga: {{ request('min_price') ? 'Rp '.number_format(request('min_price')) : '0' }} - {{ request('max_price') ? 'Rp '.number_format(request('max_price')) : '∞' }}
                        <a href="{{ request()->fullUrlWithoutQuery(['min_price', 'max_price']) }}" class="ml-2 hover:text-green-600">&times;</a>
                    </span>
                @endif

                @if(request('occupancy'))
                    <span class="inline-flex items-center px-3 py-1.5 bg-indigo-100 text-indigo-800 text-sm font-medium rounded-full">
                        {{ request('occupancy') }} Orang
                        <a href="{{ request()->fullUrlWithoutQuery('occupancy') }}" class="ml-2 hover:text-indigo-600">&times;</a>
                    </span>
                @endif

                @if(request('facilities'))
                    @foreach(request('facilities') as $facility)
                        <span class="inline-flex items-center px-3 py-1.5 bg-amber-100 text-amber-800 text-sm font-medium rounded-full">
                            {{ $facility }}
                        </span>
                    @endforeach
                @endif

                <a href="{{ route('renter.kos.search') }}" class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 text-sm font-medium rounded-full hover:bg-red-200 transition-colors">
                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Reset Semua
                </a>
            </div>
        @endif

        <!-- Hidden inputs for filter values -->
        <form id="filterForm" class="hidden">
            <input type="hidden" name="type" x-model="selectedType">
            <input type="hidden" name="min_price" x-model="minPrice">
            <input type="hidden" name="max_price" x-model="maxPrice">
            <input type="hidden" name="occupancy" x-model="selectedOccupancy">
            <template x-for="facility in selectedFacilities" :key="facility">
                <input type="hidden" name="facilities[]" :value="facility">
            </template>
        </form>

        <!-- Results Info -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <p class="text-gray-600">
                Menampilkan <span class="font-bold text-navy">{{ $results->total() }}</span> hasil
                @if(request('keyword'))
                    untuk "<span class="font-semibold text-blue-600">{{ request('keyword') }}</span>"
                @endif
            </p>

            <!-- Sort Dropdown -->
            <div class="relative" x-data="{ sortOpen: false }">
                <button @click="sortOpen = !sortOpen" class="flex items-center px-4 py-2.5 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 shadow-sm">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"/>
                    </svg>
                    <span class="text-gray-700 font-medium">Urutkan</span>
                    <svg class="w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="sortOpen" @click.away="sortOpen = false" x-cloak
                     class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 z-30 border border-gray-100">
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" class="block px-4 py-2.5 text-gray-700 hover:bg-gray-50 {{ request('sort') == 'newest' ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">Terbaru</a>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" class="block px-4 py-2.5 text-gray-700 hover:bg-gray-50 {{ request('sort') == 'price_asc' ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">Harga Terendah</a>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" class="block px-4 py-2.5 text-gray-700 hover:bg-gray-50 {{ request('sort') == 'price_desc' ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">Harga Tertinggi</a>
                </div>
            </div>
        </div>

        <!-- Results Grid -->
        @if($results->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($results as $kos)
                    <div class="bg-white rounded-2xl overflow-hidden shadow-md transition-all duration-300 hover:shadow-xl">
                        <!-- Image Header with Hover Effect -->
                        <div class="relative aspect-[4/3] overflow-hidden group">
                            <img src="{{ $kos->first_image }}"
                                 alt="{{ $kos->name }}"
                                 class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">

                            <!-- Dark Overlay on Hover -->
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center">
                                <a href="{{ route('renter.kost.show', $kos->slug) }}"
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
                                <span class="px-3 py-1.5 {{ $kos->type === 'putra' ? 'bg-blue-500' : ($kos->type === 'putri' ? 'bg-pink-500' : 'bg-purple-500') }} text-white text-xs font-semibold rounded-full uppercase tracking-wide">
                                    Kos {{ ucfirst($kos->type) }}
                                </span>
                            </div>

                            <!-- Room Match Icon Right (if room sharing enabled) -->
                            @if($kos->is_room_match_enabled)
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
                                <span class="truncate">{{ $kos->address }}</span>
                            </div>

                            <!-- Title -->
                            <h3 class="font-bold text-gray-900 text-lg mb-3 line-clamp-2">{{ $kos->name }}</h3>

                            <!-- Tags Row -->
                            <div class="flex flex-wrap gap-2 mb-4">
                                @if($kos->room_size ?? null)
                                    <span class="px-2.5 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded-full">{{ $kos->room_size }}</span>
                                @endif
                                @if($kos->total_rooms ?? null)
                                    <span class="px-2.5 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded-full">{{ $kos->total_rooms }} Kamar</span>
                                @endif
                                @if($kos->available_rooms ?? null)
                                    <span class="px-2.5 py-1 bg-green-50 text-green-600 text-xs font-medium rounded-full">{{ $kos->available_rooms }} Tersedia</span>
                                @endif
                            </div>

                            <!-- Footer -->
                            <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                <p class="text-blue-600 font-bold text-lg">{{ $kos->formatted_price_monthly }}<span class="text-gray-400 font-normal text-sm">/bln</span></p>
                                <a href="{{ route('renter.kost.show', $kos->slug) }}"
                                   class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-full hover:bg-blue-700 transition-colors">
                                    Pesan Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $results->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-xl p-12 text-center">
                <svg class="w-24 h-24 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Tidak Ada Hasil</h3>
                <p class="text-gray-500 mb-6 max-w-md mx-auto">
                    Maaf, tidak ada kos yang sesuai dengan filter Anda. Coba ubah kata kunci atau filter pencarian.
                </p>
                <a href="{{ route('renter.kos.search') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                    Reset Filter
                </a>
            </div>
        @endif

        <!-- Filter Modal/Sidebar -->
        <div
            x-show="openFilter"
            x-cloak
            class="fixed inset-0 z-50 overflow-hidden"
            aria-labelledby="filter-title"
            role="dialog"
            aria-modal="true"
        >
            <!-- Backdrop -->
            <div
                x-show="openFilter"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="openFilter = false"
                class="fixed inset-0 bg-black/50 transition-opacity"
            ></div>

            <!-- Sidebar Panel -->
            <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
                <div
                    x-show="openFilter"
                    x-transition:enter="transform transition ease-in-out duration-300"
                    x-transition:enter-start="translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition ease-in-out duration-300"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="translate-x-full"
                    class="w-screen max-w-md"
                >
                    <div class="h-full flex flex-col bg-white shadow-xl overflow-y-auto">
                        <!-- Header -->
                        <div class="px-6 py-4 bg-navy">
                            <div class="flex items-center justify-between">
                                <h2 id="filter-title" class="text-xl font-bold text-white">Filter Pencarian</h2>
                                <button @click="openFilter = false" class="text-white hover:text-gray-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Filter Content -->
                        <div class="flex-1 px-6 py-6 space-y-8">

                            <!-- Harga -->
                            <div>
                                <h3 class="text-lg font-semibold text-navy mb-4">Harga</h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm text-gray-600 mb-2">Minimum</label>
                                        <div class="relative">
                                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm">Rp</span>
                                            <input
                                                type="number"
                                                x-model="minPrice"
                                                placeholder="0"
                                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            >
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm text-gray-600 mb-2">Maksimum</label>
                                        <div class="relative">
                                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm">Rp</span>
                                            <input
                                                type="number"
                                                x-model="maxPrice"
                                                placeholder="5000000"
                                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Jenis Kos -->
                            <div>
                                <h3 class="text-lg font-semibold text-navy mb-4">Jenis Kos</h3>
                                <div class="grid grid-cols-3 gap-3">
                                    <button
                                        type="button"
                                        @click="selectedType = selectedType === 'putri' ? '' : 'putri'"
                                        :class="selectedType === 'putri' ? 'bg-white border-2 border-navy text-navy' : 'bg-transparent border border-gray-300 text-gray-600 hover:border-gray-400'"
                                        class="px-4 py-3 rounded-lg font-medium transition-all"
                                    >
                                        Putri
                                    </button>
                                    <button
                                        type="button"
                                        @click="selectedType = selectedType === 'putra' ? '' : 'putra'"
                                        :class="selectedType === 'putra' ? 'bg-white border-2 border-navy text-navy' : 'bg-transparent border border-gray-300 text-gray-600 hover:border-gray-400'"
                                        class="px-4 py-3 rounded-lg font-medium transition-all"
                                    >
                                        Putra
                                    </button>
                                    <button
                                        type="button"
                                        @click="selectedType = selectedType === 'campur' ? '' : 'campur'"
                                        :class="selectedType === 'campur' ? 'bg-white border-2 border-navy text-navy' : 'bg-transparent border border-gray-300 text-gray-600 hover:border-gray-400'"
                                        class="px-4 py-3 rounded-lg font-medium transition-all"
                                    >
                                        Campur
                                    </button>
                                </div>
                            </div>

                            <!-- Jumlah Penghuni -->
                            <div>
                                <h3 class="text-lg font-semibold text-navy mb-4">Jumlah Penghuni</h3>
                                <div class="grid grid-cols-2 gap-3">
                                    <button
                                        type="button"
                                        @click="selectedOccupancy = selectedOccupancy === '1' ? '' : '1'"
                                        :class="selectedOccupancy === '1' ? 'bg-white border-2 border-navy text-navy' : 'bg-transparent border border-gray-300 text-gray-600 hover:border-gray-400'"
                                        class="px-4 py-3 rounded-lg font-medium transition-all"
                                    >
                                        1 Orang
                                    </button>
                                    <button
                                        type="button"
                                        @click="selectedOccupancy = selectedOccupancy === '2' ? '' : '2'"
                                        :class="selectedOccupancy === '2' ? 'bg-white border-2 border-navy text-navy' : 'bg-transparent border border-gray-300 text-gray-600 hover:border-gray-400'"
                                        class="px-4 py-3 rounded-lg font-medium transition-all"
                                    >
                                        2 Orang (Room Match)
                                    </button>
                                </div>
                            </div>

                            <!-- Fasilitas Kamar -->
                            <div>
                                <h3 class="text-lg font-semibold text-navy mb-4">Fasilitas Kamar</h3>
                                <div class="space-y-3">
                                    @foreach($availableRoomFacilities as $facility)
                                        <label class="flex items-center cursor-pointer group">
                                            <input
                                                type="checkbox"
                                                :checked="selectedFacilities.includes('{{ $facility }}')"
                                                @change="toggleFacility('{{ $facility }}')"
                                                class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                            >
                                            <span class="ml-3 text-gray-700 group-hover:text-navy">{{ $facility }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Fasilitas Umum -->
                            <div>
                                <h3 class="text-lg font-semibold text-navy mb-4">Fasilitas Umum</h3>
                                <div class="space-y-3">
                                    @foreach($availableCommonFacilities as $facility)
                                        <label class="flex items-center cursor-pointer group">
                                            <input
                                                type="checkbox"
                                                :checked="selectedCommonFacilities.includes('{{ $facility }}')"
                                                @change="toggleCommonFacility('{{ $facility }}')"
                                                class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                            >
                                            <span class="ml-3 text-gray-700 group-hover:text-navy">{{ $facility }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                            <div class="flex gap-4">
                                <button
                                    type="button"
                                    @click="resetFilters()"
                                    class="flex-1 px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-100 transition-colors"
                                >
                                    Reset
                                </button>
                                <button
                                    type="button"
                                    @click="applyFilters()"
                                    class="flex-1 px-6 py-3 bg-navy text-white font-semibold rounded-lg hover:bg-navy-dark transition-colors"
                                >
                                    Terapkan Filter
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </main>
    </div>

    <!-- Search Data (JSON) -->
    <script id="search-data" type="application/json">
        {!! json_encode([
            'filters' => [
                'type' => request('type', ''),
                'minPrice' => request('min_price', ''),
                'maxPrice' => request('max_price', ''),
                'occupancy' => request('occupancy', ''),
                'facilities' => request('facilities', []),
                'commonFacilities' => request('common_facilities', [])
            ],
            'searchUrl' => route('renter.kos.search')
        ]) !!}
    </script>

    <script>
        function searchPage() {
            const searchData = JSON.parse(document.getElementById('search-data').textContent);
            
            return {
                openFilter: false,
                selectedType: searchData.filters.type,
                minPrice: searchData.filters.minPrice,
                maxPrice: searchData.filters.maxPrice,
                selectedOccupancy: searchData.filters.occupancy,
                selectedFacilities: searchData.filters.facilities,
                selectedCommonFacilities: searchData.filters.commonFacilities,
                searchUrl: searchData.searchUrl,

                toggleFacility(facility) {
                    const index = this.selectedFacilities.indexOf(facility);
                    if (index > -1) {
                        this.selectedFacilities.splice(index, 1);
                    } else {
                        this.selectedFacilities.push(facility);
                    }
                },

                toggleCommonFacility(facility) {
                    const index = this.selectedCommonFacilities.indexOf(facility);
                    if (index > -1) {
                        this.selectedCommonFacilities.splice(index, 1);
                    } else {
                        this.selectedCommonFacilities.push(facility);
                    }
                },

                resetFilters() {
                    this.selectedType = '';
                    this.minPrice = '';
                    this.maxPrice = '';
                    this.selectedOccupancy = '';
                    this.selectedFacilities = [];
                    this.selectedCommonFacilities = [];
                },

                applyFilters() {
                    // Build query string
                    const params = new URLSearchParams();

                    const keyword = document.querySelector('input[name="keyword"]').value;
                    if (keyword) params.append('keyword', keyword);
                    if (this.selectedType) params.append('type', this.selectedType);
                    if (this.minPrice) params.append('min_price', this.minPrice);
                    if (this.maxPrice) params.append('max_price', this.maxPrice);
                    if (this.selectedOccupancy) params.append('occupancy', this.selectedOccupancy);

                    this.selectedFacilities.forEach(f => params.append('facilities[]', f));
                    this.selectedCommonFacilities.forEach(f => params.append('common_facilities[]', f));

                    // Redirect with filters
                    window.location.href = this.searchUrl + '?' + params.toString();
                }
            }
        }
    </script>
</body>
</html>

