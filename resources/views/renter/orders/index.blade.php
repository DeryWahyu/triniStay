<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pemesanan Saya - TriniStay</title>
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
                    <a href="{{ route('renter.kos.search') }}" class="text-gray-600 hover:text-navy transition-colors">Cari Kos</a>
                    <a href="{{ route('renter.room-match.index') }}" class="text-gray-600 hover:text-navy transition-colors">Cari Teman</a>
                    <a href="{{ route('renter.orders.index') }}" class="text-blue-600 font-semibold">Pemesanan</a>
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

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ activeTab: 'my-orders' }">
        <!-- Page Header with Stats -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-6 md:p-8 mb-8 text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=%2260%22 height=%2260%22 viewBox=%220 0 60 60%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cg fill=%22none%22 fill-rule=%22evenodd%22%3E%3Cg fill=%22%23ffffff%22 fill-opacity=%220.08%22%3E%3Cpath d=%22M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2V36h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z%22/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
            <div class="relative z-10">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold mb-2">Pemesanan Saya</h1>
                        <p class="text-blue-100">Kelola dan pantau status pemesanan kos Anda dengan mudah</p>
                    </div>
                    
                    <!-- Quick Stats -->
                    <div class="flex gap-4">
                        @php
                            $pendingCount = $myBookings->where('status', 'pending')->count();
                            $approvedCount = $myBookings->where('status', 'approved')->count();
                            $completedCount = $myBookings->where('status', 'completed')->count();
                        @endphp
                        <div class="bg-white/20 backdrop-blur-sm rounded-xl px-4 py-3 text-center">
                            <p class="text-2xl font-bold">{{ $pendingCount }}</p>
                            <p class="text-xs text-blue-100">Menunggu</p>
                        </div>
                        <div class="bg-white/20 backdrop-blur-sm rounded-xl px-4 py-3 text-center">
                            <p class="text-2xl font-bold">{{ $approvedCount }}</p>
                            <p class="text-xs text-blue-100">Disetujui</p>
                        </div>
                        <div class="bg-white/20 backdrop-blur-sm rounded-xl px-4 py-3 text-center">
                            <p class="text-2xl font-bold">{{ $completedCount }}</p>
                            <p class="text-xs text-blue-100">Selesai</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(request('success') == 1)
            <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-2xl p-6">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-green-800">Pemesanan Berhasil Diajukan! 🎉</h3>
                        <p class="text-green-700 mt-1">Kode Pemesanan: <span class="font-bold bg-green-200 px-2 py-0.5 rounded">{{ request('booking_code') }}</span></p>
                        <p class="text-sm text-green-600 mt-2">
                            Pemilik kos akan mengkonfirmasi dalam waktu <strong>1x24 jam</strong>.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-xl flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Pending Invitations Banner -->
        @if($pendingInvitations->count() > 0)
            <div class="mb-6 bg-gradient-to-r from-amber-50 to-yellow-50 border border-yellow-300 rounded-2xl p-5">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center flex-shrink-0 animate-pulse">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-yellow-800">{{ $pendingInvitations->count() }} Undangan Room Match Menunggu!</h3>
                        <p class="text-sm text-yellow-700 mt-1">Ada yang mengajak Anda berbagi kamar. Segera konfirmasi!</p>
                    </div>
                    <button @click="activeTab = 'shared'" class="px-4 py-2 bg-yellow-500 text-white font-medium rounded-xl hover:bg-yellow-600 transition-colors text-sm">
                        Lihat Undangan
                    </button>
                </div>
            </div>
        @endif

        <!-- Modern Tabs -->
        <div class="mb-6">
            <div class="bg-white rounded-xl p-1.5 inline-flex shadow-sm border border-gray-200">
                <button @click="activeTab = 'my-orders'"
                        :class="{ 'bg-blue-500 text-white shadow-md': activeTab === 'my-orders', 'text-gray-600 hover:text-gray-800': activeTab !== 'my-orders' }"
                        class="flex items-center gap-2 px-5 py-2.5 rounded-lg font-medium text-sm transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Pesanan Saya
                    <span class="px-2 py-0.5 text-xs rounded-full" :class="activeTab === 'my-orders' ? 'bg-white/30' : 'bg-gray-100'">{{ $myBookings->count() }}</span>
                </button>
                <button @click="activeTab = 'shared'"
                        :class="{ 'bg-green-500 text-white shadow-md': activeTab === 'shared', 'text-gray-600 hover:text-gray-800': activeTab !== 'shared' }"
                        class="flex items-center gap-2 px-5 py-2.5 rounded-lg font-medium text-sm transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Room Match
                    @if($pendingInvitations->count() > 0)
                        <span class="px-2 py-0.5 text-xs rounded-full bg-yellow-400 text-yellow-900 animate-pulse">{{ $pendingInvitations->count() }} baru</span>
                    @else
                        <span class="px-2 py-0.5 text-xs rounded-full" :class="activeTab === 'shared' ? 'bg-white/30' : 'bg-gray-100'">{{ $sharedBookings->count() }}</span>
                    @endif
                </button>
            </div>
        </div>

        <!-- My Orders Tab -->
        <div x-show="activeTab === 'my-orders'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            @if($myBookings->count() > 0)
                <div class="space-y-4">
                    @foreach($myBookings as $booking)
                        @php
                            $statusConfig = [
                                'pending' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'icon' => '⏳', 'label' => 'Menunggu Konfirmasi'],
                                'approved' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'icon' => '✅', 'label' => 'Disetujui'],
                                'rejected' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'icon' => '❌', 'label' => 'Ditolak'],
                                'cancelled' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'icon' => '🚫', 'label' => 'Dibatalkan'],
                                'completed' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'icon' => '🎉', 'label' => 'Selesai'],
                            ];
                            $status = $statusConfig[$booking->status] ?? $statusConfig['pending'];
                        @endphp
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 group">
                            <div class="flex flex-col lg:flex-row">
                                <!-- Image Section -->
                                <div class="lg:w-56 h-48 lg:h-auto relative overflow-hidden">
                                    <img src="{{ $booking->boardingHouse->first_image ?? asset('images/kos-default.jpg') }}"
                                         alt="{{ $booking->boardingHouse->name }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    <div class="absolute top-3 left-3">
                                        <span class="px-3 py-1.5 text-xs font-semibold rounded-full {{ $status['bg'] }} {{ $status['text'] }} shadow-sm">
                                            {{ $status['icon'] }} {{ $status['label'] }}
                                        </span>
                                    </div>
                                    @if($booking->is_shared)
                                        <div class="absolute top-3 right-3">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-500 text-white">
                                                Room Match
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Content Section -->
                                <div class="flex-1 p-5 lg:p-6">
                                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                                        <div class="flex-1">
                                            <!-- Booking Code -->
                                            <p class="text-xs text-gray-400 mb-1">{{ $booking->booking_code }}</p>
                                            
                                            <!-- Title & Location -->
                                            <h3 class="font-bold text-navy text-lg group-hover:text-blue-600 transition-colors">{{ $booking->boardingHouse->name }}</h3>
                                            <p class="text-sm text-gray-500 flex items-center gap-1 mt-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                </svg>
                                                {{ Str::limit($booking->boardingHouse->address, 50) }}
                                            </p>

                                            <!-- Info Grid -->
                                            <div class="mt-4 grid grid-cols-2 lg:grid-cols-4 gap-4">
                                                <div class="bg-gray-50 rounded-xl p-3">
                                                    <p class="text-xs text-gray-500 mb-0.5">Durasi</p>
                                                    <p class="font-semibold text-navy text-sm">{{ $booking->durationLabel }}</p>
                                                </div>
                                                <div class="bg-gray-50 rounded-xl p-3">
                                                    <p class="text-xs text-gray-500 mb-0.5">Mulai</p>
                                                    <p class="font-semibold text-navy text-sm">{{ $booking->start_date->format('d M Y') }}</p>
                                                </div>
                                                <div class="bg-gray-50 rounded-xl p-3">
                                                    <p class="text-xs text-gray-500 mb-0.5">Kamar</p>
                                                    <p class="font-semibold text-navy text-sm">{{ $booking->room ? 'No. ' . $booking->room->room_number : 'Belum dipilih' }}</p>
                                                </div>
                                                <div class="bg-blue-50 rounded-xl p-3">
                                                    <p class="text-xs text-blue-500 mb-0.5">Total</p>
                                                    <p class="font-bold text-blue-600 text-sm">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex flex-row lg:flex-col gap-2 lg:ml-4">
                                            <a href="{{ route('renter.orders.show', $booking) }}"
                                               class="flex-1 lg:flex-none px-5 py-2.5 text-sm font-medium text-white bg-blue-500 rounded-xl hover:bg-blue-600 transition-colors text-center flex items-center justify-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                Detail
                                            </a>

                                            @if(in_array($booking->status, ['approved', 'completed']))
                                                <a href="{{ route('renter.orders.download-receipt', $booking) }}"
                                                   class="flex-1 lg:flex-none px-5 py-2.5 text-sm font-medium text-green-600 bg-green-50 rounded-xl hover:bg-green-100 transition-colors text-center flex items-center justify-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                    </svg>
                                                    Unduh
                                                </a>
                                            @endif

                                            @if($booking->status === 'pending')
                                                <form action="{{ route('renter.booking.cancel', $booking) }}" method="POST"
                                                      onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                                    @csrf
                                                    <button type="submit"
                                                            class="w-full px-5 py-2.5 text-sm font-medium text-red-600 bg-red-50 rounded-xl hover:bg-red-100 transition-colors">
                                                        Batalkan
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Footer -->
                                    <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-400">
                                        <span>Dipesan {{ $booking->created_at->diffForHumans() }}</span>
                                        <span>{{ $booking->created_at->format('d M Y, H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-navy mb-2">Belum Ada Pesanan</h3>
                    <p class="text-gray-500 mb-6 max-w-sm mx-auto">Anda belum memiliki pesanan kos. Mulai cari kos impian Anda sekarang!</p>
                    <a href="{{ route('renter.kos.search') }}"
                       class="inline-flex items-center px-6 py-3 bg-blue-500 text-white font-medium rounded-xl hover:bg-blue-600 transition-colors shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Cari Kos Sekarang
                    </a>
                </div>
            @endif
        </div>

        <!-- Shared/Room Match Tab -->
        <div x-show="activeTab === 'shared'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
            @if($sharedBookings->count() > 0)
                <div class="space-y-4">
                    @foreach($sharedBookings as $booking)
                        @php
                            $isInvitedUser = $booking->shared_with_user_id === Auth::id() ||
                                            ($booking->parent_booking_id && $booking->user_id === Auth::id());
                            if ($booking->parent_booking_id) {
                                $inviterName = $booking->sharedWithUser->name ?? 'Pengguna';
                            } else {
                                $inviterName = $booking->user->name ?? 'Pengguna';
                            }
                        @endphp
                        <div class="bg-white rounded-2xl shadow-sm border overflow-hidden hover:shadow-lg transition-all duration-300
                                    {{ $booking->shared_status === 'pending' && $isInvitedUser ? 'border-yellow-400 ring-2 ring-yellow-200' : 'border-gray-100' }}">
                            <div class="flex flex-col lg:flex-row">
                                <!-- Image Section -->
                                <div class="lg:w-56 h-48 lg:h-auto relative overflow-hidden">
                                    <img src="{{ $booking->boardingHouse->first_image ?? asset('images/kos-default.jpg') }}"
                                         alt="{{ $booking->boardingHouse->name }}"
                                         class="w-full h-full object-cover">
                                    
                                    @if($booking->shared_status === 'pending' && $isInvitedUser)
                                        <div class="absolute inset-0 bg-yellow-500/20 flex items-center justify-center">
                                            <span class="bg-yellow-500 text-white px-4 py-2 rounded-full text-sm font-bold animate-pulse">
                                                Undangan Baru!
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Content Section -->
                                <div class="flex-1 p-5 lg:p-6">
                                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                                        <div class="flex-1">
                                            <!-- Status Badge -->
                                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                                @if($booking->shared_status === 'pending' && $isInvitedUser)
                                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                                                        ⏳ Menunggu Konfirmasi Anda
                                                    </span>
                                                @elseif($booking->shared_status === 'pending')
                                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-700">
                                                        📤 Menunggu Respon
                                                    </span>
                                                @elseif($booking->shared_status === 'accepted')
                                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                                        ✅ Diterima
                                                    </span>
                                                @elseif($booking->shared_status === 'rejected')
                                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                                        ❌ Ditolak
                                                    </span>
                                                @endif
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">
                                                    🤝 Room Match
                                                </span>
                                            </div>

                                            <!-- Title -->
                                            <h3 class="font-bold text-navy text-lg">{{ $booking->boardingHouse->name }}</h3>
                                            <p class="text-sm text-gray-500 mt-1 flex items-center gap-2">
                                                <span class="inline-flex items-center gap-1">
                                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                    Bersama: <span class="font-medium text-green-600">{{ $inviterName }}</span>
                                                </span>
                                            </p>

                                            <!-- Info Grid -->
                                            <div class="mt-4 grid grid-cols-2 lg:grid-cols-4 gap-3">
                                                <div class="bg-gray-50 rounded-xl p-3">
                                                    <p class="text-xs text-gray-500 mb-0.5">Durasi</p>
                                                    <p class="font-semibold text-navy text-sm">{{ $booking->durationLabel }}</p>
                                                </div>
                                                <div class="bg-gray-50 rounded-xl p-3">
                                                    <p class="text-xs text-gray-500 mb-0.5">Mulai</p>
                                                    <p class="font-semibold text-navy text-sm">{{ $booking->start_date->format('d M Y') }}</p>
                                                </div>
                                                <div class="bg-gray-50 rounded-xl p-3">
                                                    <p class="text-xs text-gray-500 mb-0.5">Kamar</p>
                                                    <p class="font-semibold text-navy text-sm">{{ $booking->room ? 'No. ' . $booking->room->room_number : '-' }}</p>
                                                </div>
                                                <div class="bg-green-50 rounded-xl p-3">
                                                    <p class="text-xs text-green-500 mb-0.5">Tagihan Anda</p>
                                                    <p class="font-bold text-green-600 text-sm">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                                </div>
                                            </div>

                                            {{-- Info Alert --}}
                                            @if($booking->parent_booking_id && $booking->user_id === Auth::id())
                                                @if($booking->shared_status === 'accepted' && !$booking->payment_proof)
                                                    <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                                                        <div class="flex items-center gap-3">
                                                            <div class="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center flex-shrink-0">
                                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                                </svg>
                                                            </div>
                                                            <div>
                                                                <p class="font-medium text-yellow-800">Segera Upload Bukti Pembayaran</p>
                                                                <p class="text-sm text-yellow-600">Klik tombol untuk upload bukti bayar Anda</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif($booking->payment_proof && $booking->status === 'pending')
                                                    <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                                                        <div class="flex items-center gap-3">
                                                            <svg class="w-5 h-5 text-blue-500 animate-spin" fill="none" viewBox="0 0 24 24">
                                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                            </svg>
                                                            <p class="text-blue-700">Pembayaran sedang diverifikasi oleh pemilik kos...</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex flex-row lg:flex-col gap-2 lg:ml-4">
                                            @if($booking->shared_status === 'pending' && $booking->shared_with_user_id === Auth::id())
                                                <form action="{{ route('renter.booking.accept-shared', $booking) }}" method="POST" class="flex-1">
                                                    @csrf
                                                    <button type="submit"
                                                            class="w-full px-5 py-2.5 text-sm font-medium text-white bg-green-500 rounded-xl hover:bg-green-600 transition-colors flex items-center justify-center gap-2">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                        </svg>
                                                        Terima
                                                    </button>
                                                </form>
                                                <form action="{{ route('renter.booking.reject-shared', $booking) }}" method="POST" class="flex-1">
                                                    @csrf
                                                    <button type="submit"
                                                            class="w-full px-5 py-2.5 text-sm font-medium text-red-600 bg-red-50 rounded-xl hover:bg-red-100 transition-colors flex items-center justify-center gap-2">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                        Tolak
                                                    </button>
                                                </form>
                                            @elseif($booking->shared_status === 'pending' && $booking->user_id === Auth::id() && !$booking->parent_booking_id)
                                                <span class="px-5 py-2.5 text-sm font-medium text-yellow-700 bg-yellow-50 rounded-xl text-center">
                                                    Menunggu Konfirmasi...
                                                </span>
                                            @elseif($booking->parent_booking_id && $booking->user_id === Auth::id() && $booking->shared_status === 'accepted' && !$booking->payment_proof)
                                                <a href="{{ route('renter.orders.show', $booking) }}"
                                                   class="px-5 py-2.5 text-sm font-medium text-white bg-orange-500 rounded-xl hover:bg-orange-600 transition-colors text-center flex items-center justify-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                                    </svg>
                                                    Upload Bukti
                                                </a>
                                            @else
                                                <a href="{{ route('renter.orders.show', $booking) }}"
                                                   class="px-5 py-2.5 text-sm font-medium text-blue-600 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors text-center flex items-center justify-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    Detail
                                                </a>

                                                @if(in_array($booking->status, ['approved', 'completed']))
                                                    <a href="{{ route('renter.orders.download-receipt', $booking) }}"
                                                       class="px-5 py-2.5 text-sm font-medium text-green-600 bg-green-50 rounded-xl hover:bg-green-100 transition-colors text-center flex items-center justify-center gap-2">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                        </svg>
                                                        Unduh
                                                    </a>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                    <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-navy mb-2">Tidak Ada Undangan Room Match</h3>
                    <p class="text-gray-500 mb-6 max-w-sm mx-auto">Belum ada yang mengajak Anda berbagi kamar. Cari teman sekamar yang cocok!</p>
                    <a href="{{ route('renter.room-match.index') }}"
                       class="inline-flex items-center px-6 py-3 bg-green-500 text-white font-medium rounded-xl hover:bg-green-600 transition-colors shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Cari Teman Sekamar
                    </a>
                </div>
            @endif
        </div>
    </main>
</body>
</html>
