<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Penyewa - TriniStay</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
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
    </style>
</head>
<body class="bg-gray-50">
    <!-- Hero Section with Full Screen Height -->
    <section class="relative w-full h-screen">
        <!-- Background Image -->
        <img src="https://images.unsplash.com/photo-1616594039964-ae9021a400a0?w=1920&q=80"
             alt="Cozy Bedroom"
             class="absolute inset-0 w-full h-full object-cover">

        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-black/40 to-black/60"></div>

        <!-- Transparent Navbar (Overlay) -->
        <nav class="absolute top-0 left-0 w-full z-50 bg-transparent">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <!-- Logo -->
                    <a href="{{ route('renter.dashboard') }}" class="flex items-center space-x-2">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9 22V12H15V22" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="text-2xl font-bold text-white">TriniStay</span>
                    </a>

                    <!-- Menu -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="{{ route('renter.dashboard') }}" class="text-white font-medium hover:text-gray-300 transition-colors">Beranda</a>
                        <a href="{{ route('renter.kos.search') }}" class="text-white/80 hover:text-white transition-colors">Cari Kos</a>
                        <a href="{{ route('renter.room-match.index') }}" class="text-white/80 hover:text-white transition-colors">Cari Teman</a>
                        <a href="#" class="text-white/80 hover:text-white transition-colors">Pemesanan</a>
                    </div>

                    <!-- User Profile -->
                    <div class="flex items-center space-x-4">
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                                <div class="w-10 h-10 bg-white/20 backdrop-blur-sm border border-white/30 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <span class="hidden sm:block text-white font-medium">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
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

        <!-- Hero Content (Centered) -->
        <div class="relative z-10 flex flex-col items-center justify-center h-full text-center text-white px-4">
            <div class="max-w-3xl">
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold mb-4 drop-shadow-lg">TriniStay</h1>
                <h2 class="text-xl md:text-2xl lg:text-3xl font-semibold mb-6 drop-shadow-md">SELAMAT DATANG!</h2>
                <p class="text-lg md:text-xl text-gray-200 leading-relaxed max-w-2xl mx-auto drop-shadow">
                    Sedang mencari tempat tinggal yang nyaman? TriniStay hadir untuk membantu Anda menemukan kos-kosan terbaik dengan fasilitas lengkap, harga terjangkau, dan lokasi strategis di sekitar kampus Anda.
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" id="kos">

        <!-- Kos Putra Section -->
        <section class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-navy mx-auto">Rekomendasi Kos Putra</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($kosPutra as $kos)
                    <a href="{{ route('renter.kost.show', $kos->slug) }}" class="group">
                        <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                            <!-- Image -->
                            <div class="aspect-video relative overflow-hidden">
                                <img src="{{ $kos->first_image }}"
                                     alt="{{ $kos->name }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute top-3 left-3">
                                    <span class="px-3 py-1 bg-blue-500 text-white text-xs font-semibold rounded-full">
                                        Kos Putra
                                    </span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="bg-navy p-4">
                                <h3 class="text-lg font-semibold text-white mb-1 truncate">{{ $kos->name }}</h3>
                                <p class="text-gray-400 text-sm mb-3 truncate">{{ $kos->address }}</p>
                                <div class="flex items-center justify-between">
                                    <p class="text-white font-bold">{{ $kos->formatted_price_monthly }}<span class="text-gray-400 font-normal text-sm">/bulan</span></p>
                                    <span class="px-4 py-1.5 bg-white text-navy text-sm font-medium rounded-md hover:bg-gray-100 transition-colors">
                                        Detail
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-3 bg-white rounded-xl p-8 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <p class="text-gray-500">Belum ada kos putra tersedia</p>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Kos Putri Section -->
        <section class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-navy mx-auto">Rekomendasi Kos Putri</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($kosPutri as $kos)
                    <a href="{{ route('renter.kost.show', $kos->slug) }}" class="group">
                        <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                            <!-- Image -->
                            <div class="aspect-video relative overflow-hidden">
                                <img src="{{ $kos->first_image }}"
                                     alt="{{ $kos->name }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute top-3 left-3">
                                    <span class="px-3 py-1 bg-pink-500 text-white text-xs font-semibold rounded-full">
                                        Kos Putri
                                    </span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="bg-navy p-4">
                                <h3 class="text-lg font-semibold text-white mb-1 truncate">{{ $kos->name }}</h3>
                                <p class="text-gray-400 text-sm mb-3 truncate">{{ $kos->address }}</p>
                                <div class="flex items-center justify-between">
                                    <p class="text-white font-bold">{{ $kos->formatted_price_monthly }}<span class="text-gray-400 font-normal text-sm">/bulan</span></p>
                                    <span class="px-4 py-1.5 bg-white text-navy text-sm font-medium rounded-md hover:bg-gray-100 transition-colors">
                                        Detail
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-3 bg-white rounded-xl p-8 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <p class="text-gray-500">Belum ada kos putri tersedia</p>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Kos Campur Section -->
        <section class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-navy mx-auto">Rekomendasi Kos Campur</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($kosCampur as $kos)
                    <a href="{{ route('renter.kost.show', $kos->slug) }}" class="group">
                        <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                            <!-- Image -->
                            <div class="aspect-video relative overflow-hidden">
                                <img src="{{ $kos->first_image }}"
                                     alt="{{ $kos->name }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute top-3 left-3">
                                    <span class="px-3 py-1 bg-purple-500 text-white text-xs font-semibold rounded-full">
                                        Kos Campur
                                    </span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="bg-navy p-4">
                                <h3 class="text-lg font-semibold text-white mb-1 truncate">{{ $kos->name }}</h3>
                                <p class="text-gray-400 text-sm mb-3 truncate">{{ $kos->address }}</p>
                                <div class="flex items-center justify-between">
                                    <p class="text-white font-bold">{{ $kos->formatted_price_monthly }}<span class="text-gray-400 font-normal text-sm">/bulan</span></p>
                                    <span class="px-4 py-1.5 bg-white text-navy text-sm font-medium rounded-md hover:bg-gray-100 transition-colors">
                                        Detail
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-3 bg-white rounded-xl p-8 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <p class="text-gray-500">Belum ada kos campur tersedia</p>
                    </div>
                @endforelse
            </div>
        </section>
    </main>

    <!-- CTA Section - Cari Teman -->
    <section class="bg-navy-dark py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">Mulai Cari Teman Sekamar</h2>
            <p class="text-gray-400 mb-8 max-w-2xl mx-auto">
                Temukan teman sekamar yang cocok dengan kepribadian dan gaya hidupmu melalui fitur Room Match kami.
            </p>
            <a href="{{ route('renter.room-match.index') }}" class="inline-flex items-center px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Mulai Cari Teman
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-navy py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Logo & Description -->
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-2 mb-4">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9 22V12H15V22" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="text-xl font-bold text-white">TriniStay</span>
                    </div>
                    <p class="text-gray-400 leading-relaxed">
                        Temukan hunian nyaman di TriniStay yang mendukung fokus belajar atau bekerja. Platform terpercaya untuk mencari kos-kosan berkualitas.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Menu</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('renter.dashboard') }}" class="text-gray-400 hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="{{ route('renter.kos.search') }}" class="text-gray-400 hover:text-white transition-colors">Cari Kos</a></li>
                        <li><a href="{{ route('renter.room-match.index') }}" class="text-gray-400 hover:text-white transition-colors">Cari Teman</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Pemesanan</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Hubungi Kami</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>Jl. Babarsari 2, Sleman, Yogyakarta</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>info@trinistay.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-400 text-sm">© {{ date('Y') }} TriniStay. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</body>
</html>
