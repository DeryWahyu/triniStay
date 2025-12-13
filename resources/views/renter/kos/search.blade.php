<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Kos - TriniStay</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-40">
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
                            <div class="w-10 h-10 bg-navy rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <span class="hidden sm:block text-navy font-medium">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Dropdown -->
                        <div x-show="open" @click.away="open = false" x-cloak
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profil Saya</a>
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Pemesanan</a>
                            <hr class="my-2">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="searchPage()">

        <!-- Page Title -->
        <div class="text-center mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-navy mb-2">Cari Kos Sesuai Selera Anda</h1>
            <p class="text-gray-500">Temukan kos impian dengan berbagai pilihan filter</p>
        </div>

        <!-- Search Bar & Filter -->
        <div class="mb-8">
            <form action="{{ route('renter.kos.search') }}" method="GET" id="searchForm">
                <div class="flex flex-col md:flex-row gap-4">
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
                            class="w-full pl-12 pr-4 py-4 bg-navy text-white placeholder-gray-400 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-lg"
                        >
                    </div>

                    <!-- Filter Button -->
                    <button
                        type="button"
                        @click="openFilter = true"
                        class="flex items-center justify-center px-6 py-4 bg-white border-2 border-navy text-navy font-semibold rounded-xl hover:bg-navy hover:text-white transition-colors"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Filter
                    </button>

                    <!-- Search Button -->
                    <button
                        type="submit"
                        class="flex items-center justify-center px-8 py-4 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Cari
                    </button>
                </div>

                <!-- Active Filters Tags -->
                @if(request()->hasAny(['type', 'min_price', 'max_price', 'facilities', 'occupancy']))
                    <div class="mt-4 flex flex-wrap gap-2">
                        <span class="text-sm text-gray-500 mr-2">Filter aktif:</span>

                        @if(request('type'))
                            <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">
                                Kos {{ ucfirst(request('type')) }}
                                <a href="{{ request()->fullUrlWithoutQuery('type') }}" class="ml-2 hover:text-blue-600">&times;</a>
                            </span>
                        @endif

                        @if(request('min_price') || request('max_price'))
                            <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">
                                Harga: {{ request('min_price') ? 'Rp '.number_format(request('min_price')) : '0' }} - {{ request('max_price') ? 'Rp '.number_format(request('max_price')) : '∞' }}
                                <a href="{{ request()->fullUrlWithoutQuery(['min_price', 'max_price']) }}" class="ml-2 hover:text-green-600">&times;</a>
                            </span>
                        @endif

                        @if(request('occupancy'))
                            <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-800 text-sm rounded-full">
                                {{ request('occupancy') }} Orang
                                <a href="{{ request()->fullUrlWithoutQuery('occupancy') }}" class="ml-2 hover:text-purple-600">&times;</a>
                            </span>
                        @endif

                        @if(request('facilities'))
                            @foreach(request('facilities') as $facility)
                                <span class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-800 text-sm rounded-full">
                                    {{ $facility }}
                                </span>
                            @endforeach
                        @endif

                        <a href="{{ route('renter.kos.search') }}" class="inline-flex items-center px-3 py-1 bg-red-100 text-red-800 text-sm rounded-full hover:bg-red-200">
                            Reset Semua
                        </a>
                    </div>
                @endif

                <!-- Hidden inputs for filter values -->
                <input type="hidden" name="type" x-model="selectedType">
                <input type="hidden" name="min_price" x-model="minPrice">
                <input type="hidden" name="max_price" x-model="maxPrice">
                <input type="hidden" name="occupancy" x-model="selectedOccupancy">
                <template x-for="facility in selectedFacilities" :key="facility">
                    <input type="hidden" name="facilities[]" :value="facility">
                </template>
            </form>
        </div>

        <!-- Results Info -->
        <div class="flex items-center justify-between mb-6">
            <p class="text-gray-600">
                Menampilkan <span class="font-semibold text-navy">{{ $results->total() }}</span> hasil
                @if(request('keyword'))
                    untuk "<span class="font-semibold">{{ request('keyword') }}</span>"
                @endif
            </p>

            <!-- Sort Dropdown -->
            <div class="relative" x-data="{ sortOpen: false }">
                <button @click="sortOpen = !sortOpen" class="flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    <span class="text-gray-700">Urutkan</span>
                    <svg class="w-4 h-4 ml-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="sortOpen" @click.away="sortOpen = false" x-cloak
                     class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-30">
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 {{ request('sort') == 'newest' ? 'bg-gray-100 font-medium' : '' }}">Terbaru</a>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 {{ request('sort') == 'price_asc' ? 'bg-gray-100 font-medium' : '' }}">Harga Terendah</a>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 {{ request('sort') == 'price_desc' ? 'bg-gray-100 font-medium' : '' }}">Harga Tertinggi</a>
                </div>
            </div>
        </div>

        <!-- Results Grid -->
        @if($results->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($results as $kos)
                    <a href="{{ route('renter.kost.show', $kos->slug) }}" class="group">
                        <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                            <!-- Image -->
                            <div class="aspect-video relative overflow-hidden">
                                <img src="{{ $kos->first_image }}"
                                     alt="{{ $kos->name }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute top-3 left-3">
                                    <span class="px-3 py-1 text-white text-xs font-semibold rounded-full
                                        {{ $kos->type === 'putra' ? 'bg-blue-500' : ($kos->type === 'putri' ? 'bg-pink-500' : 'bg-purple-500') }}">
                                        Kos {{ ucfirst($kos->type) }}
                                    </span>
                                </div>
                                @if($kos->is_room_match_enabled)
                                    <div class="absolute top-3 right-3">
                                        <span class="px-2 py-1 bg-green-500 text-white text-xs font-semibold rounded-full">
                                            Room Match
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="bg-navy p-4">
                                <h3 class="text-lg font-semibold text-white mb-1 truncate">{{ $kos->name }}</h3>
                                <p class="text-gray-400 text-sm mb-3 truncate flex items-center">
                                    <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    </svg>
                                    {{ $kos->address }}
                                </p>
                                <div class="flex items-center justify-between">
                                    <p class="text-white font-bold">{{ $kos->formatted_price_monthly }}<span class="text-gray-400 font-normal text-sm">/bulan</span></p>
                                    <span class="px-4 py-1.5 bg-white text-navy text-sm font-medium rounded-md hover:bg-gray-100 transition-colors">
                                        Detail
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
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

    <!-- Footer -->
    <footer class="bg-navy py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="flex items-center space-x-2 mb-4 md:mb-0">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 22V12H15V22" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="text-lg font-bold text-white">TriniStay</span>
                </div>
                <p class="text-gray-400 text-sm">© {{ date('Y') }} TriniStay. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        function searchPage() {
            return {
                openFilter: false,
                selectedType: '{{ request("type", "") }}',
                minPrice: '{{ request("min_price", "") }}',
                maxPrice: '{{ request("max_price", "") }}',
                selectedOccupancy: '{{ request("occupancy", "") }}',
                selectedFacilities: {!! json_encode(request('facilities', [])) !!},
                selectedCommonFacilities: {!! json_encode(request('common_facilities', [])) !!},

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
                    window.location.href = '{{ route("renter.kos.search") }}?' + params.toString();
                }
            }
        }
    </script>
</body>
</html>
