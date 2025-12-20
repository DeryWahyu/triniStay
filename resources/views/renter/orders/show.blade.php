<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Pesanan - TriniStay</title>
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

                <!-- Back Button -->
                <a href="{{ route('renter.orders.index') }}" class="flex items-center space-x-2 text-gray-600 hover:text-navy transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Kembali ke Pemesanan</span>
                </a>

                <!-- User Profile -->
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-[#19608E] to-[#162D40] rounded-full flex items-center justify-center shadow-md">
                        <span class="text-white font-semibold text-sm">{{ Auth::user()->initials }}</span>
                    </div>
                    <span class="hidden sm:block text-navy font-medium">{{ Auth::user()->name }}</span>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="orderDetail()">
        <!-- Alert Messages -->
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

        <!-- Order Status Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <p class="text-sm text-gray-500">Nomor Pesanan</p>
                    <h1 class="text-xl font-bold text-navy">#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</h1>
                </div>

                @php
                    $statusColors = [
                        'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                        'approved' => 'bg-green-100 text-green-700 border-green-200',
                        'rejected' => 'bg-red-100 text-red-700 border-red-200',
                        'cancelled' => 'bg-gray-100 text-gray-700 border-gray-200',
                        'completed' => 'bg-blue-100 text-blue-700 border-blue-200',
                    ];
                    $statusLabels = [
                        'pending' => 'Menunggu Konfirmasi',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'cancelled' => 'Dibatalkan',
                        'completed' => 'Selesai',
                    ];
                @endphp

                <div class="flex items-center space-x-3">
                    <span class="px-4 py-2 text-sm font-semibold rounded-xl border {{ $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-700' }}">
                        {{ $statusLabels[$booking->status] ?? ucfirst($booking->status) }}
                    </span>

                    @if($booking->is_shared)
                        <span class="px-3 py-2 text-sm font-medium rounded-xl bg-purple-100 text-purple-700 border border-purple-200">
                            Room Match
                        </span>
                    @endif
                </div>
            </div>

            <!-- Order Timeline -->
            <div class="mt-6 pt-6 border-t border-gray-100">
                <div class="flex items-center justify-between text-xs text-gray-500">
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full {{ $booking->created_at ? 'bg-green-500' : 'bg-gray-200' }} flex items-center justify-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span>Dipesan</span>
                    </div>
                    <div class="flex-1 h-1 mx-2 {{ $booking->payment_proof ? 'bg-green-500' : 'bg-gray-200' }}"></div>
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full {{ $booking->payment_proof ? 'bg-green-500' : 'bg-gray-200' }} flex items-center justify-center mb-2">
                            @if($booking->payment_proof)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            @else
                                <span class="text-gray-400 font-medium">2</span>
                            @endif
                        </div>
                        <span>Bayar</span>
                    </div>
                    <div class="flex-1 h-1 mx-2 {{ $booking->status === 'approved' || $booking->status === 'completed' ? 'bg-green-500' : 'bg-gray-200' }}"></div>
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full {{ $booking->status === 'approved' || $booking->status === 'completed' ? 'bg-green-500' : 'bg-gray-200' }} flex items-center justify-center mb-2">
                            @if($booking->status === 'approved' || $booking->status === 'completed')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            @else
                                <span class="text-gray-400 font-medium">3</span>
                            @endif
                        </div>
                        <span>Konfirmasi</span>
                    </div>
                    <div class="flex-1 h-1 mx-2 {{ $booking->status === 'completed' ? 'bg-green-500' : 'bg-gray-200' }}"></div>
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full {{ $booking->status === 'completed' ? 'bg-green-500' : 'bg-gray-200' }} flex items-center justify-center mb-2">
                            @if($booking->status === 'completed')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            @else
                                <span class="text-gray-400 font-medium">4</span>
                            @endif
                        </div>
                        <span>Selesai</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Kost Info -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-semibold text-navy mb-4">Informasi Kos</h3>
                    <div class="flex gap-4">
                        <img src="{{ $booking->boardingHouse->first_image ?? asset('images/kos-default.jpg') }}"
                             alt="{{ $booking->boardingHouse->name }}"
                             class="w-28 h-20 object-cover rounded-xl">
                        <div>
                            <h4 class="font-semibold text-navy">{{ $booking->boardingHouse->name }}</h4>
                            <p class="text-sm text-gray-500 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                                {{ $booking->boardingHouse->address }}
                            </p>
                            <a href="{{ route('renter.kost.show', $booking->boardingHouse->slug) }}"
                               class="inline-block mt-2 text-sm text-blue-500 hover:underline">
                                Lihat Detail Kos →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Booking Details -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-semibold text-navy mb-4">Detail Pesanan</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">Durasi Sewa</span>
                            <p class="font-medium text-navy mt-1">{{ $booking->durationLabel }}</p>
                        </div>
                        <div>
                            <span class="text-gray-500">Kamar</span>
                            <p class="font-medium text-navy mt-1">
                                {{ $booking->room ? 'No. ' . $booking->room->room_number . ' (Lt. ' . $booking->room->floor . ')' : 'Belum ditentukan' }}
                            </p>
                        </div>
                        <div>
                            <span class="text-gray-500">Tanggal Mulai</span>
                            <p class="font-medium text-navy mt-1">{{ $booking->start_date->format('d F Y') }}</p>
                        </div>
                        <div>
                            <span class="text-gray-500">Tanggal Selesai</span>
                            <p class="font-medium text-navy mt-1">{{ $booking->end_date->format('d F Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Room Match Info -->
                @if($booking->is_shared)
                    <div class="bg-purple-50 rounded-2xl border border-purple-100 p-6">
                        <h3 class="font-semibold text-purple-800 mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Room Match
                        </h3>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-purple-700">
                                    @if($booking->user_id === Auth::id())
                                        Teman Sekamar (yang Anda undang)
                                    @else
                                        Diundang oleh
                                    @endif
                                </p>
                                <p class="font-medium text-purple-900">
                                    @if($booking->user_id === Auth::id())
                                        {{ $booking->sharedUser ? $booking->sharedUser->name : $booking->shared_with_email }}
                                    @else
                                        {{ $booking->user->name }}
                                    @endif
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-purple-700">Status</p>
                                @if($booking->shared_status === 'pending')
                                    <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">Menunggu</span>
                                @elseif($booking->shared_status === 'accepted')
                                    <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-700">Diterima</span>
                                @elseif($booking->shared_status === 'rejected')
                                    <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-red-100 text-red-700">Ditolak</span>
                                @endif
                            </div>
                        </div>

                        {{-- Tombol Terima/Tolak - HANYA untuk user yang DIUNDANG, bukan yang membuat --}}
                        @if($booking->shared_status === 'pending' && $booking->shared_with_user_id === Auth::id())
                            <div class="mt-4 pt-4 border-t border-purple-200 flex gap-3">
                                <form action="{{ route('renter.booking.accept-shared', $booking) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit"
                                            class="w-full px-4 py-2 text-sm font-medium text-white bg-green-500 rounded-xl hover:bg-green-600 transition-colors">
                                        Terima Undangan
                                    </button>
                                </form>
                                <form action="{{ route('renter.booking.reject-shared', $booking) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit"
                                            class="w-full px-4 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-xl hover:bg-red-100 transition-colors">
                                        Tolak Undangan
                                    </button>
                                </form>
                            </div>
                        @elseif($booking->shared_status === 'pending' && $booking->user_id === Auth::id())
                            <div class="mt-4 pt-4 border-t border-purple-200">
                                <p class="text-sm text-purple-600 italic">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Menunggu konfirmasi dari teman sekamar Anda
                                </p>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Payment Proof -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-semibold text-navy mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Bukti Pembayaran
                    </h3>

                    @if($booking->payment_proof)
                        <div class="relative">
                            <img src="{{ Storage::url($booking->payment_proof) }}" alt="Bukti Pembayaran"
                                 class="w-full max-w-md rounded-xl cursor-pointer hover:opacity-90 transition-opacity"
                                 @click="showImageModal = true; modalImage = '{{ Storage::url($booking->payment_proof) }}'">
                            <p class="text-xs text-gray-500 mt-2">Klik gambar untuk memperbesar</p>
                        </div>

                        @if($booking->status === 'pending' && ($booking->user_id === Auth::id() || $booking->shared_with_user_id === Auth::id()))
                            <button @click="showPaymentModal = true"
                                    class="mt-4 px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                                Ganti Bukti Pembayaran
                            </button>
                        @endif
                    @else
                        <div class="text-center py-6 bg-gray-50 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-gray-500 mb-4">Belum ada bukti pembayaran</p>

                            @if($booking->status === 'pending' && ($booking->user_id === Auth::id() || $booking->shared_with_user_id === Auth::id()))
                                <button @click="showPaymentModal = true"
                                        class="px-6 py-3 bg-blue-500 text-white font-medium rounded-xl hover:bg-blue-600 transition-colors">
                                    Upload Bukti Pembayaran
                                </button>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Review Section -->
                @if(in_array($booking->status, ['approved', 'completed']))
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-semibold text-navy mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                            Ulasan
                        </h3>

                        @if($booking->review && $booking->review->user_id === Auth::id())
                            <div class="bg-gray-50 rounded-xl p-4">
                                <div class="flex items-center space-x-1 mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $i <= $booking->review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <p class="text-gray-700">{{ $booking->review->comment ?? 'Tidak ada komentar' }}</p>
                                <p class="text-xs text-gray-500 mt-2">Dikirim pada {{ $booking->review->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        @else
                            <div class="text-center py-6 bg-gray-50 rounded-xl">
                                <p class="text-gray-500 mb-4">Bagikan pengalaman Anda tinggal di kos ini</p>
                                <button @click="showReviewModal = true"
                                        class="px-6 py-3 bg-yellow-500 text-white font-medium rounded-xl hover:bg-yellow-600 transition-colors">
                                    Tulis Ulasan
                                </button>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Price Summary -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                    <h3 class="font-semibold text-navy mb-4">Ringkasan Biaya</h3>

                    <div class="space-y-3 text-sm">
                        @if($booking->is_shared)
                            {{-- Room Match booking - price is already per person --}}
                            <div class="flex justify-between">
                                <span class="text-gray-600">Biaya Sewa ({{ $booking->durationLabel }})</span>
                                <span class="font-medium text-navy">Rp {{ number_format($booking->total_price * 2, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-green-600">
                                <span>Bagian Anda (Room Match 50%)</span>
                                <span class="font-medium">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                            </div>
                        @else
                            <div class="flex justify-between">
                                <span class="text-gray-600">Biaya Sewa ({{ $booking->durationLabel }})</span>
                                <span class="font-medium text-navy">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                            </div>
                        @endif
                    </div>

                    <hr class="my-4">

                    <div class="flex justify-between text-lg">
                        <span class="font-semibold text-navy">Total Bayar</span>
                        <span class="font-bold text-blue-600">
                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                        </span>
                    </div>

                    @if($booking->is_shared)
                        <p class="text-xs text-green-600 mt-3 flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Harga sudah dibagi 2 dengan teman sekamar</span>
                        </p>
                    @endif

                    <!-- Bank Info - Show if payment needed -->
                    @if(!$booking->payment_proof || ($booking->is_shared && $booking->shared_status === 'pending'))
                        <div class="mt-6 pt-4 border-t border-gray-100">
                            <p class="text-sm text-gray-600 mb-2">Transfer ke:</p>
                            <div class="bg-gray-50 rounded-xl p-4">
                                <p class="font-semibold text-navy">{{ $booking->boardingHouse->owner->bank_name ?? 'Bank' }}</p>
                                <p class="text-lg font-mono text-navy mt-1">{{ $booking->boardingHouse->owner->bank_account_number ?? '-' }}</p>
                                <p class="text-sm text-gray-500 mt-1">a.n. {{ $booking->boardingHouse->owner->bank_account_name ?? $booking->boardingHouse->owner->name ?? 'Pemilik Kos' }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons for Main Booker -->
                    @if($booking->status === 'pending' && $booking->user_id === Auth::id() && !$booking->parent_booking_id)
                        <div class="mt-6 space-y-2">
                            @if(!$booking->payment_proof)
                                <button @click="showPaymentModal = true"
                                        class="w-full py-3 bg-blue-500 text-white font-medium rounded-xl hover:bg-blue-600 transition-colors">
                                    Upload Bukti Pembayaran
                                </button>
                            @endif
                            <form action="{{ route('renter.booking.cancel', $booking) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                @csrf
                                <button type="submit"
                                        class="w-full py-3 text-red-600 bg-red-50 font-medium rounded-xl hover:bg-red-100 transition-colors">
                                    Batalkan Pesanan
                                </button>
                            </form>
                        </div>
                    @endif

                    <!-- Action Buttons for Invited User (Room Match) -->
                    @if($booking->parent_booking_id && $booking->user_id === Auth::id())
                        <div class="mt-6 space-y-2">
                            @if($booking->shared_status === 'accepted')
                                {{-- User has accepted invitation, now needs to pay --}}
                                @if(!$booking->payment_proof)
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-3">
                                        <p class="text-sm text-yellow-800 font-medium flex items-start">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                            <span>Silakan upload bukti pembayaran untuk menyelesaikan pemesanan Room Match Anda.</span>
                                        </p>
                                    </div>
                                    <button @click="showPaymentModal = true"
                                            class="w-full py-3 bg-blue-500 text-white font-medium rounded-xl hover:bg-blue-600 transition-colors">
                                        Upload Bukti Pembayaran
                                    </button>
                                @else
                                    <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                                        <p class="text-sm text-green-800 font-medium flex items-start">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>Bukti pembayaran sudah diupload. Menunggu konfirmasi pemilik kos.</span>
                                        </p>
                                    </div>
                                @endif
                            @elseif($booking->shared_status === 'pending')
                                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                                    <p class="text-sm text-blue-800">
                                        Terima undangan Room Match terlebih dahulu untuk melanjutkan pembayaran.
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Download Receipt Button -->
                    @if(in_array($booking->status, ['approved', 'completed']))
                        <div class="mt-6 flex justify-center">
                            <a href="{{ route('renter.orders.download-receipt', $booking) }}"
                               class="flex items-center py-3 px-4 bg-green-500 text-white font-medium rounded-xl hover:bg-green-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download Bukti Transaksi
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Payment Upload Modal -->
        <div x-show="showPaymentModal" x-cloak
             class="fixed inset-0 z-50 overflow-y-auto"
             @keydown.escape.window="showPaymentModal = false">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="showPaymentModal = false"></div>

                <div class="relative inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-navy">Upload Bukti Pembayaran</h3>
                        <button @click="showPaymentModal = false" class="text-gray-400 hover:text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route('renter.booking.payment-proof', $booking) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="block w-full cursor-pointer">
                                <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-blue-400 transition-colors"
                                     :class="{ 'border-blue-500 bg-blue-50': paymentFile }">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-gray-600" x-text="paymentFile ? paymentFile.name : 'Klik untuk pilih gambar'"></p>
                                    <p class="text-xs text-gray-400 mt-1">JPG, JPEG, PNG (Max. 2MB)</p>
                                </div>
                                <input type="file" name="payment_proof" accept="image/jpg,image/jpeg,image/png" class="hidden"
                                       @change="paymentFile = $event.target.files[0]" required>
                            </label>
                        </div>

                        <div class="flex space-x-3">
                            <button type="button" @click="showPaymentModal = false"
                                    class="flex-1 py-3 text-gray-700 bg-gray-100 font-medium rounded-xl hover:bg-gray-200 transition-colors">
                                Batal
                            </button>
                            <button type="submit" :disabled="!paymentFile"
                                    class="flex-1 py-3 bg-blue-500 text-white font-medium rounded-xl hover:bg-blue-600 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                                Upload
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Review Modal -->
        <div x-show="showReviewModal" x-cloak
             class="fixed inset-0 z-50 overflow-y-auto"
             @keydown.escape.window="showReviewModal = false">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="showReviewModal = false"></div>

                <div class="relative inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-navy">Tulis Ulasan</h3>
                        <button @click="showReviewModal = false" class="text-gray-400 hover:text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route('renter.review.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="boarding_house_id" value="{{ $booking->boarding_house_id }}">
                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                        <input type="hidden" name="rating" x-model="reviewRating">

                        <!-- Star Rating -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                            <div class="flex items-center space-x-1">
                                <template x-for="star in 5" :key="star">
                                    <button type="button" @click="reviewRating = star" class="focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 transition-colors"
                                             :class="star <= reviewRating ? 'text-yellow-400' : 'text-gray-300'"
                                             fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    </button>
                                </template>
                            </div>
                        </div>

                        <!-- Comment -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Komentar (Opsional)</label>
                            <textarea name="comment" rows="4" placeholder="Ceritakan pengalaman Anda tinggal di kos ini..."
                                      class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"></textarea>
                        </div>

                        <div class="flex space-x-3">
                            <button type="button" @click="showReviewModal = false"
                                    class="flex-1 py-3 text-gray-700 bg-gray-100 font-medium rounded-xl hover:bg-gray-200 transition-colors">
                                Batal
                            </button>
                            <button type="submit" :disabled="reviewRating === 0"
                                    class="flex-1 py-3 bg-yellow-500 text-white font-medium rounded-xl hover:bg-yellow-600 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                                Kirim Ulasan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Image Preview Modal -->
        <div x-show="showImageModal" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-90"
             @click="showImageModal = false">
            <button class="absolute top-4 right-4 text-white hover:text-gray-300" @click="showImageModal = false">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <img :src="modalImage" class="max-w-full max-h-full object-contain" @click.stop>
        </div>
    </div>

    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        function orderDetail() {
            return {
                showPaymentModal: false,
                showReviewModal: false,
                showImageModal: false,
                modalImage: '',
                paymentFile: null,
                reviewRating: 0
            }
        }
    </script>
</body>
</html>
