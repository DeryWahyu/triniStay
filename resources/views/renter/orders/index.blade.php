<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pemesanan Saya - TriniStay</title>
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
        [x-cloak] { display: none !important; }
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
                    <a href="{{ route('renter.kos.search') }}" class="text-gray-600 hover:text-navy transition-colors">Cari Kos</a>
                    <a href="{{ route('renter.room-match.index') }}" class="text-gray-600 hover:text-navy transition-colors">Cari Teman</a>
                    <a href="{{ route('renter.orders.index') }}" class="text-navy font-medium hover:text-blue-600 transition-colors">Pemesanan</a>
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

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ activeTab: 'my-orders' }">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-navy">Pemesanan Saya</h1>
            <p class="text-gray-500 mt-1">Kelola dan pantau status pemesanan kos Anda</p>
        </div>

        <!-- Alert Messages -->
        @if(request('success') == 1)
            <div class="mb-6 bg-green-50 border border-green-200 rounded-2xl p-6">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-green-800">Pemesanan Berhasil Diajukan! 🎉</h3>
                        <p class="text-green-700 mt-1">Kode Pemesanan: <span class="font-bold">{{ request('booking_code') }}</span></p>
                        <p class="text-sm text-green-600 mt-2">
                            Pemesanan sedang diproses. Menunggu konfirmasi dari pemilik kos dalam waktu <strong>1x24 jam</strong>.
                            Anda akan mendapatkan notifikasi setelah pemilik kos merespon.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Pending Invitations Banner -->
        @if($pendingInvitations->count() > 0)
            <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-2xl p-4">
                <div class="flex items-start space-x-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <div class="flex-1">
                        <h3 class="font-semibold text-yellow-800">Undangan Room Match Menunggu</h3>
                        <p class="text-sm text-yellow-700 mt-1">Anda memiliki {{ $pendingInvitations->count() }} undangan Room Match yang menunggu konfirmasi.</p>
                        <button @click="activeTab = 'shared'" class="mt-2 text-sm font-medium text-yellow-800 hover:underline">
                            Lihat Undangan →
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Tabs -->
        <div class="mb-6">
            <div class="border-b border-gray-200">
                <nav class="flex space-x-8">
                    <button @click="activeTab = 'my-orders'"
                            :class="{ 'border-blue-500 text-blue-600': activeTab === 'my-orders', 'border-transparent text-gray-500 hover:text-gray-700': activeTab !== 'my-orders' }"
                            class="py-3 px-1 border-b-2 font-medium text-sm transition-colors">
                        Pesanan Saya
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600">{{ $myBookings->count() }}</span>
                    </button>
                    <button @click="activeTab = 'shared'"
                            :class="{ 'border-blue-500 text-blue-600': activeTab === 'shared', 'border-transparent text-gray-500 hover:text-gray-700': activeTab !== 'shared' }"
                            class="py-3 px-1 border-b-2 font-medium text-sm transition-colors">
                        Room Match
                        @if($pendingInvitations->count() > 0)
                            <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-yellow-100 text-yellow-700">{{ $pendingInvitations->count() }} baru</span>
                        @else
                            <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600">{{ $sharedBookings->count() }}</span>
                        @endif
                    </button>
                </nav>
            </div>
        </div>

        <!-- My Orders Tab -->
        <div x-show="activeTab === 'my-orders'" x-transition>
            @if($myBookings->count() > 0)
                <div class="space-y-4">
                    @foreach($myBookings as $booking)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                            <div class="p-6">
                                <div class="flex flex-col md:flex-row md:items-start gap-4">
                                    <!-- Kost Image -->
                                    <img src="{{ $booking->boardingHouse->first_image ?? asset('images/kos-default.jpg') }}"
                                         alt="{{ $booking->boardingHouse->name }}"
                                         class="w-full md:w-32 h-24 object-cover rounded-xl">

                                    <!-- Booking Info -->
                                    <div class="flex-1">
                                        <div class="flex flex-wrap items-center gap-2 mb-2">
                                            <!-- Status Badge -->
                                            @php
                                                $statusColors = [
                                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                                    'approved' => 'bg-green-100 text-green-700',
                                                    'rejected' => 'bg-red-100 text-red-700',
                                                    'cancelled' => 'bg-gray-100 text-gray-700',
                                                    'completed' => 'bg-blue-100 text-blue-700',
                                                ];
                                                $statusLabels = [
                                                    'pending' => 'Menunggu Konfirmasi',
                                                    'approved' => 'Disetujui',
                                                    'rejected' => 'Ditolak',
                                                    'cancelled' => 'Dibatalkan',
                                                    'completed' => 'Selesai',
                                                ];
                                            @endphp
                                            <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-700' }}">
                                                {{ $statusLabels[$booking->status] ?? ucfirst($booking->status) }}
                                            </span>

                                            @if($booking->is_shared)
                                                <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-purple-100 text-purple-700">
                                                    Room Match
                                                    @if($booking->shared_status === 'pending')
                                                        (Menunggu)
                                                    @elseif($booking->shared_status === 'accepted')
                                                        (Diterima)
                                                    @elseif($booking->shared_status === 'rejected')
                                                        (Ditolak)
                                                    @endif
                                                </span>
                                            @endif
                                        </div>

                                        <h3 class="font-semibold text-navy text-lg">{{ $booking->boardingHouse->name }}</h3>
                                        <p class="text-sm text-gray-500 mt-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            </svg>
                                            {{ $booking->boardingHouse->address }}
                                        </p>

                                        <div class="mt-3 grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                                            <div>
                                                <span class="text-gray-500">Durasi</span>
                                                <p class="font-medium text-navy">{{ $booking->durationLabel }}</p>
                                            </div>
                                            <div>
                                                <span class="text-gray-500">Mulai</span>
                                                <p class="font-medium text-navy">{{ $booking->start_date->format('d M Y') }}</p>
                                            </div>
                                            <div>
                                                <span class="text-gray-500">Kamar</span>
                                                <p class="font-medium text-navy">{{ $booking->room ? 'No. ' . $booking->room->room_number : '-' }}</p>
                                            </div>
                                            <div>
                                                <span class="text-gray-500">Total</span>
                                                <p class="font-medium text-blue-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex flex-row md:flex-col gap-2">
                                        <a href="{{ route('renter.orders.show', $booking) }}"
                                           class="px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors text-center">
                                            Detail
                                        </a>

                                        @if(in_array($booking->status, ['approved', 'completed']))
                                            <a href="{{ route('renter.orders.download-receipt', $booking) }}"
                                               class="px-4 py-2 text-sm font-medium text-green-600 bg-green-50 rounded-xl hover:bg-green-100 transition-colors text-center flex items-center justify-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                                Unduh Bukti
                                            </a>
                                        @endif

                                        @if($booking->status === 'pending')
                                            <form action="{{ route('renter.booking.cancel', $booking) }}" method="POST"
                                                  onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                                @csrf
                                                <button type="submit"
                                                        class="w-full px-4 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-xl hover:bg-red-100 transition-colors">
                                                    Batalkan
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Footer Info -->
                            <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 text-xs text-gray-500">
                                Dipesan pada {{ $booking->created_at->format('d M Y, H:i') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3 class="text-lg font-semibold text-navy mb-2">Belum Ada Pesanan</h3>
                    <p class="text-gray-500 mb-6">Anda belum memiliki pesanan kos. Mulai cari kos impian Anda!</p>
                    <a href="{{ route('renter.kos.search') }}"
                       class="inline-flex items-center px-6 py-3 bg-blue-500 text-white font-medium rounded-xl hover:bg-blue-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Cari Kos
                    </a>
                </div>
            @endif
        </div>

        <!-- Shared/Room Match Tab -->
        <div x-show="activeTab === 'shared'" x-transition x-cloak>
            @if($sharedBookings->count() > 0)
                <div class="space-y-4">
                    @foreach($sharedBookings as $booking)
                        @php
                            // Determine if current user is the one who was invited
                            $isInvitedUser = $booking->shared_with_user_id === Auth::id() ||
                                            ($booking->parent_booking_id && $booking->user_id === Auth::id());

                            // Get the inviter's name
                            if ($booking->parent_booking_id) {
                                // This is a linked booking - get parent's user
                                $inviterName = $booking->sharedWithUser->name ?? 'Pengguna';
                            } else {
                                // Original booking - inviter is the user
                                $inviterName = $booking->user->name ?? 'Pengguna';
                            }
                        @endphp
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow
                                    {{ $booking->shared_status === 'pending' && $isInvitedUser ? 'ring-2 ring-yellow-400' : '' }}">
                            <div class="p-6">
                                <div class="flex flex-col md:flex-row md:items-start gap-4">
                                    <!-- Kost Image -->
                                    <img src="{{ $booking->boardingHouse->first_image ?? asset('images/kos-default.jpg') }}"
                                         alt="{{ $booking->boardingHouse->name }}"
                                         class="w-full md:w-32 h-24 object-cover rounded-xl">

                                    <!-- Booking Info -->
                                    <div class="flex-1">
                                        <div class="flex flex-wrap items-center gap-2 mb-2">
                                            @if($booking->shared_status === 'pending' && $isInvitedUser)
                                                <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">
                                                    Undangan Baru
                                                </span>
                                            @elseif($booking->shared_status === 'pending' && !$isInvitedUser)
                                                <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-orange-100 text-orange-700">
                                                    Menunggu Konfirmasi
                                                </span>
                                            @elseif($booking->shared_status === 'accepted')
                                                <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-700">
                                                    Diterima
                                                </span>
                                            @else
                                                <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-gray-100 text-gray-700">
                                                    {{ ucfirst($booking->shared_status ?? 'pending') }}
                                                </span>
                                            @endif
                                        </div>

                                        <h3 class="font-semibold text-navy text-lg">{{ $booking->boardingHouse->name }}</h3>
                                        <p class="text-sm text-gray-500 mt-1">Diundang oleh: <span class="font-medium">{{ $inviterName }}</span></p>

                                        <div class="mt-3 grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                                            <div>
                                                <span class="text-gray-500">Durasi</span>
                                                <p class="font-medium text-navy">{{ $booking->durationLabel }}</p>
                                            </div>
                                            <div>
                                                <span class="text-gray-500">Mulai</span>
                                                <p class="font-medium text-navy">{{ $booking->start_date->format('d M Y') }}</p>
                                            </div>
                                            <div>
                                                <span class="text-gray-500">Kamar</span>
                                                <p class="font-medium text-navy">{{ $booking->room ? 'No. ' . $booking->room->room_number : '-' }}</p>
                                            </div>
                                            <div>
                                                <span class="text-gray-500">Tagihan Anda</span>
                                                <p class="font-medium text-blue-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                            </div>
                                        </div>

                                        {{-- Info untuk user yang diundang setelah menerima undangan --}}
                                        @if($booking->parent_booking_id && $booking->user_id === Auth::id())
                                            @if($booking->shared_status === 'accepted' && !$booking->payment_proof)
                                                <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-xl">
                                                    <div class="flex items-start gap-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                        </svg>
                                                        <div>
                                                            <p class="text-sm font-medium text-yellow-700">Segera Upload Bukti Pembayaran</p>
                                                            <p class="text-xs text-yellow-600 mt-1">Anda perlu membayar dan upload bukti pembayaran untuk melanjutkan pemesanan Room Match ini.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif($booking->payment_proof && $booking->status === 'pending')
                                                <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-xl">
                                                    <div class="flex items-center gap-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        <p class="text-sm text-blue-700">Pembayaran sedang diverifikasi oleh pemilik kos</p>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex flex-row md:flex-col gap-2">
                                        {{-- Tombol Terima/Tolak HANYA untuk user yang DIUNDANG (original booking) --}}
                                        @if($booking->shared_status === 'pending' && $booking->shared_with_user_id === Auth::id())
                                            <form action="{{ route('renter.booking.accept-shared', $booking) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                        class="w-full px-4 py-2 text-sm font-medium text-white bg-green-500 rounded-xl hover:bg-green-600 transition-colors">
                                                    Terima
                                                </button>
                                            </form>
                                            <form action="{{ route('renter.booking.reject-shared', $booking) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                        class="w-full px-4 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-xl hover:bg-red-100 transition-colors">
                                                    Tolak
                                                </button>
                                            </form>
                                        @elseif($booking->shared_status === 'pending' && $booking->user_id === Auth::id() && !$booking->parent_booking_id)
                                            {{-- User adalah pembuat undangan (original) - hanya tampilkan status menunggu --}}
                                            <span class="px-4 py-2 text-sm font-medium text-yellow-700 bg-yellow-50 rounded-xl text-center">
                                                Menunggu Konfirmasi
                                            </span>
                                        @elseif($booking->parent_booking_id && $booking->user_id === Auth::id() && $booking->shared_status === 'accepted' && !$booking->payment_proof)
                                            {{-- User yang diundang sudah terima, perlu bayar --}}
                                            <a href="{{ route('renter.orders.show', $booking) }}"
                                               class="px-4 py-2 text-sm font-medium text-white bg-orange-500 rounded-xl hover:bg-orange-600 transition-colors text-center">
                                                Upload Bukti Bayar
                                            </a>
                                        @else
                                            <a href="{{ route('renter.orders.show', $booking) }}"
                                               class="px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors text-center">
                                                Detail
                                            </a>

                                            @if(in_array($booking->status, ['approved', 'completed']))
                                                <a href="{{ route('renter.orders.download-receipt', $booking) }}"
                                                   class="px-4 py-2 text-sm font-medium text-green-600 bg-green-50 rounded-xl hover:bg-green-100 transition-colors text-center flex items-center justify-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                    Unduh Bukti
                                                </a>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-navy mb-2">Tidak Ada Undangan Room Match</h3>
                    <p class="text-gray-500 mb-6">Anda belum diundang untuk berbagi kamar dengan siapapun.</p>
                    <a href="{{ route('renter.room-match.index') }}"
                       class="inline-flex items-center px-6 py-3 bg-purple-500 text-white font-medium rounded-xl hover:bg-purple-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Cari Teman Sekamar
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
