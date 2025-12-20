<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ajukan Sewa - {{ $boardingHouse->name }} - TriniStay</title>
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
                <a href="{{ route('renter.kost.show', $boardingHouse->slug) }}" class="flex items-center space-x-2 text-gray-600 hover:text-navy transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Kembali ke Detail</span>
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

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="bookingForm()">
        <!-- Breadcrumb -->
        <nav class="text-sm mb-6">
            <ol class="flex items-center space-x-2 text-gray-500">
                <li><a href="{{ route('renter.dashboard') }}" class="hover:text-navy">Beranda</a></li>
                <li><span>/</span></li>
                <li><a href="{{ route('renter.kost.show', $boardingHouse->slug) }}" class="hover:text-navy">{{ $boardingHouse->name }}</a></li>
                <li><span>/</span></li>
                <li class="text-navy font-medium">Ajukan Sewa</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Form Section -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Kost Summary -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-start space-x-4">
                        <img src="{{ $boardingHouse->first_image }}" alt="{{ $boardingHouse->name }}" class="w-28 h-20 object-cover rounded-xl">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-1">
                                <span class="px-2 py-0.5 text-xs font-medium rounded-full
                                    {{ $boardingHouse->type === 'putra' ? 'bg-blue-100 text-blue-700' : ($boardingHouse->type === 'putri' ? 'bg-pink-100 text-pink-700' : 'bg-purple-100 text-purple-700') }}">
                                    Kos {{ ucfirst($boardingHouse->type) }}
                                </span>
                            </div>
                            <h2 class="text-lg font-semibold text-navy">{{ $boardingHouse->name }}</h2>
                            <p class="text-sm text-gray-500 flex items-center mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $boardingHouse->address }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Form Booking -->
                <form action="{{ route('renter.booking.store') }}" method="POST" enctype="multipart/form-data" @submit="handleSubmit($event)" class="space-y-6">
                    @csrf
                    <input type="hidden" name="boarding_house_id" value="{{ $boardingHouse->id }}">
                    <input type="hidden" name="duration" value="{{ $duration }}">
                    <input type="hidden" name="occupant_type" value="{{ $occupantType }}">
                    <input type="hidden" name="room_id" x-model="selectedRoom">

                    <!-- Data Penyewa -->
                    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                        <h3 class="text-lg font-semibold text-navy mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Data Penyewa
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                <input type="text" value="{{ Auth::user()->name }}" disabled class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" value="{{ Auth::user()->email }}" disabled class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                                <input type="text" value="{{ Auth::user()->phone_number ?? '-' }}" disabled class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700">
                            </div>
                        </div>
                    </div>

                    <!-- Durasi & Penghuni yang Dipilih -->
                    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                        <h3 class="text-lg font-semibold text-navy mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Paket yang Dipilih
                        </h3>
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                        @if($occupantType === 'double')
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        @else
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold text-navy">
                                            {{ $occupantType === 'double' ? '2 Orang (Room Match)' : '1 Orang' }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            @php
                                                $durationLabels = [
                                                    '1_month' => '1 Bulan',
                                                    '3_months' => '3 Bulan',
                                                    '6_months' => '6 Bulan',
                                                    '1_year' => '1 Tahun'
                                                ];
                                                // For room match, show the period set by owner
                                                $displayDuration = $occupantType === 'double' && $boardingHouse->room_match_period
                                                    ? $durationLabels[$boardingHouse->room_match_period] ?? '1 Bulan'
                                                    : ($durationLabels[$duration] ?? '1 Bulan');
                                            @endphp
                                            Durasi: {{ $displayDuration }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($price, 0, ',', '.') }}</p>
                                    @if($occupantType === 'double')
                                    <p class="text-xs text-green-600">per orang</p>
                                    @endif
                                </div>
                            </div>
                            <a href="{{ route('renter.kost.show', $boardingHouse->slug) }}" class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                Ubah pilihan
                            </a>
                        </div>
                    </div>

                    <!-- Tanggal Mulai -->
                    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                        <h3 class="text-lg font-semibold text-navy mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Tanggal Mulai Sewa
                        </h3>
                        <div class="max-w-xs">
                            <input type="date" name="start_date" x-model="startDate" :min="minDate" required
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <p class="text-sm text-gray-500 mt-2">
                                <span x-show="startDate && duration">
                                    Berakhir pada: <span class="font-medium text-navy" x-text="calculateEndDate()"></span>
                                </span>
                            </p>
                        </div>
                    </div>

                    <!-- Pilih Kamar -->
                    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                        <h3 class="text-lg font-semibold text-navy mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Pilih Kamar
                        </h3>

                        @if($rooms->count() > 0)
                            <!-- Room Grid -->
                            <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-2">
                                @foreach($rooms->groupBy('floor') as $floor => $floorRooms)
                                    <div class="col-span-full mb-2 mt-4 first:mt-0">
                                        <span class="text-sm font-medium text-gray-600 bg-gray-100 px-3 py-1 rounded-full">Lantai {{ $floor }}</span>
                                    </div>
                                    @foreach($floorRooms as $room)
                                        @php
                                            // Check if room is truly available (no pending/approved bookings)
                                            $isRoomAvailable = $room->is_available ?? $room->isAvailable();
                                            $roomDisplayStatus = $isRoomAvailable ? 'available' : 'occupied';
                                        @endphp
                                        <label class="relative cursor-pointer" @click="selectedRoom = {{ $room->id }}"
                                               :class="{ 'pointer-events-none': {{ !$isRoomAvailable ? 'true' : 'false' }} }">
                                            <input type="radio" name="room_select" value="{{ $room->id }}" class="sr-only peer"
                                                   {{ !$isRoomAvailable ? 'disabled' : '' }}>
                                            <div class="w-full aspect-square flex items-center justify-center rounded-xl text-sm font-medium transition-all
                                                @if($isRoomAvailable)
                                                    border-2 border-gray-200 bg-white hover:border-blue-300 peer-checked:border-blue-500 peer-checked:bg-blue-500 peer-checked:text-white
                                                @elseif($room->status === 'maintenance')
                                                    bg-gray-100 text-gray-400 border-2 border-gray-200
                                                @else
                                                    bg-red-100 text-red-600 border-2 border-red-200
                                                @endif
                                                " :class="{ 'border-blue-500 bg-blue-500 text-white': selectedRoom === {{ $room->id }} && {{ $isRoomAvailable ? 'true' : 'false' }} }">
                                                {{ $room->room_number }}
                                            </div>
                                        </label>
                                    @endforeach
                                @endforeach
                            </div>
                            <!-- Legend -->
                            <div class="flex flex-wrap gap-4 mt-4 pt-4 border-t border-gray-100 text-sm">
                                <div class="flex items-center space-x-2">
                                    <div class="w-4 h-4 bg-white border-2 border-gray-200 rounded"></div>
                                    <span class="text-gray-600">Tersedia</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="w-4 h-4 bg-blue-500 rounded"></div>
                                    <span class="text-gray-600">Dipilih</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="w-4 h-4 bg-red-100 border-2 border-red-200 rounded"></div>
                                    <span class="text-gray-600">Terisi/Dipesan</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="w-4 h-4 bg-gray-100 border-2 border-gray-200 rounded"></div>
                                    <span class="text-gray-600">Maintenance</span>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <p class="text-gray-500">Belum ada data kamar</p>
                                <p class="text-sm text-gray-400 mt-1">Pemilik kos belum menambahkan data kamar</p>
                            </div>
                        @endif
                    </div>

                    <!-- Room Match (Hanya muncul jika memilih 2 orang) -->
                    @if($occupantType === 'double' && $boardingHouse->is_room_match_enabled)
                    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-navy mb-2 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Undang Teman Sekamar
                                </h3>
                                <p class="text-sm text-gray-500">Masukkan email teman yang ingin Anda ajak berbagi kamar</p>
                            </div>
                        </div>

                        <!-- Room Match Form (Always shown for double occupant) -->
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <div class="bg-green-50 rounded-xl p-4 mb-4">
                                <p class="text-sm text-green-800">
                                    <strong>Cara kerja:</strong> Temanmu akan menerima email undangan. Setelah mereka menerima, kalian akan berbagi kamar dengan biaya masing-masing <span class="font-bold">Rp {{ number_format($price, 0, ',', '.') }}</span>.
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Teman <span class="text-red-500">*</span></label>
                                <input type="email" name="shared_with_email" x-model="sharedEmail" placeholder="email@temanmu.com" required
                                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                <p class="text-xs text-gray-500 mt-1">Pastikan email terdaftar di TriniStay</p>
                            </div>
                        </div>
                        <input type="hidden" name="is_shared" value="1">
                    </div>
                    @else
                    <input type="hidden" name="is_shared" value="0">
                    @endif

                    <!-- Pembayaran & Rekening Pemilik Kos -->
                    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                        <h3 class="text-lg font-semibold text-navy mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            Pembayaran
                        </h3>

                        <!-- Rekening Pemilik Kos -->
                        @if($boardingHouse->user && $boardingHouse->user->bank_name && $boardingHouse->user->bank_account_number)
                        <div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-xl p-5 mb-5">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <p class="text-gray-400 text-xs uppercase tracking-wider">Rekening Pemilik Kos</p>
                                    <h4 class="text-white text-lg font-bold mt-1">{{ $boardingHouse->user->bank_name }}</h4>
                                </div>
                                <div class="bg-white/10 rounded-lg p-2">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="space-y-1">
                                <p class="text-gray-400 text-xs">Nomor Rekening</p>
                                <div class="flex items-center space-x-3">
                                    <p class="text-white text-xl font-mono tracking-widest" id="bankAccountNumber">{{ $boardingHouse->user->bank_account_number }}</p>
                                    <button type="button" onclick="copyBankNumber()" class="text-gray-400 hover:text-white transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            @if($boardingHouse->user->bank_account_name)
                            <div class="mt-3 pt-3 border-t border-gray-700">
                                <p class="text-gray-400 text-xs">Atas Nama</p>
                                <p class="text-white font-semibold">{{ $boardingHouse->user->bank_account_name }}</p>
                            </div>
                            @endif
                        </div>
                        @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-5">
                            <div class="flex">
                                <svg class="w-5 h-5 text-yellow-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-yellow-800">Rekening belum tersedia</p>
                                    <p class="text-xs text-yellow-700 mt-1">Pemilik kos belum mengatur rekening pembayaran. Hubungi pemilik kos untuk info pembayaran.</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Info Pembayaran -->
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-5">
                            <div class="flex">
                                <svg class="w-5 h-5 text-blue-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="text-sm text-blue-800">
                                        <strong>Langkah Pembayaran:</strong>
                                    </p>
                                    <ol class="text-xs text-blue-700 mt-2 space-y-1 list-decimal list-inside">
                                        <li>Transfer sesuai jumlah total ke rekening di atas</li>
                                        <li>Simpan bukti transfer (screenshot/foto)</li>
                                        <li>Unggah bukti transfer di bawah ini</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <!-- Upload Bukti Transfer -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Bukti Transfer <span class="text-red-500">*</span>
                            </label>
                            <div x-data="{ fileName: '', preview: null }" class="relative">
                                <input type="file" name="payment_proof" id="payment_proof" accept="image/jpeg,image/jpg,image/png" required
                                       class="sr-only"
                                       @change="
                                           fileName = $event.target.files[0]?.name || '';
                                           if ($event.target.files[0]) {
                                               const reader = new FileReader();
                                               reader.onload = (e) => preview = e.target.result;
                                               reader.readAsDataURL($event.target.files[0]);
                                           }
                                       ">
                                <label for="payment_proof"
                                       class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-all"
                                       :class="{ 'border-green-500 bg-green-50': preview }">
                                    <template x-if="!preview">
                                        <div class="flex flex-col items-center justify-center py-4">
                                            <svg class="w-10 h-10 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                            </svg>
                                            <p class="text-sm text-gray-500">Klik untuk upload bukti transfer</p>
                                            <p class="text-xs text-gray-400 mt-1">JPG, JPEG, PNG (Max 2MB)</p>
                                        </div>
                                    </template>
                                    <template x-if="preview">
                                        <div class="flex items-center space-x-4 p-4">
                                            <img :src="preview" alt="Preview" class="h-24 w-24 object-cover rounded-lg">
                                            <div>
                                                <p class="text-sm text-green-600 font-medium">Bukti transfer dipilih</p>
                                                <p class="text-xs text-gray-500" x-text="fileName"></p>
                                                <p class="text-xs text-blue-500 mt-1">Klik untuk ganti</p>
                                            </div>
                                        </div>
                                    </template>
                                </label>
                            </div>
                            @error('payment_proof')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Catatan (Optional) -->
                    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                        <h3 class="text-lg font-semibold text-navy mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Catatan (Opsional)
                        </h3>
                        <textarea name="notes" rows="3" placeholder="Tambahkan catatan khusus untuk pemilik kos..."
                                  class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all resize-none"></textarea>
                    </div>

                    <!-- Submit Button (Mobile) -->
                    <div class="lg:hidden">
                        <button type="submit" :disabled="!canSubmit || submitting"
                                class="w-full py-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-xl shadow-lg hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 disabled:opacity-50 disabled:cursor-not-allowed transition-all">
                            <span x-show="!submitting">Ajukan Sewa Sekarang</span>
                            <span x-show="submitting" class="flex items-center justify-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Memproses...
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Sidebar - Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 sticky top-24">
                    <h3 class="text-lg font-semibold text-navy mb-4">Ringkasan Pesanan</h3>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Jumlah Penghuni</span>
                            <span class="font-medium text-navy" x-text="occupantLabel"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Durasi</span>
                            <span class="font-medium text-navy" x-text="durationLabel"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Harga Sewa</span>
                            <span class="font-medium text-navy" x-text="formatPrice(selectedPrice)"></span>
                        </div>
                        <div class="flex justify-between" x-show="selectedRoom">
                            <span class="text-gray-600">Kamar</span>
                            <span class="font-medium text-navy" x-text="selectedRoomLabel"></span>
                        </div>
                        @if($occupantType === 'double')
                        <div class="flex justify-between">
                            <span class="text-gray-600">Room Match</span>
                            <span class="font-medium text-green-600">Ya</span>
                        </div>
                        @endif
                    </div>

                    <hr class="my-4">

                    <div class="flex justify-between text-lg">
                        <span class="font-semibold text-navy">Total Bayar</span>
                        <span class="font-bold text-blue-600" x-text="formatPrice(totalPrice)"></span>
                    </div>

                    @if($occupantType === 'double')
                    <p class="text-xs text-green-600 mt-2">
                        * Harga per orang (teman sekamar juga membayar Rp {{ number_format($price, 0, ',', '.') }})
                    </p>
                    @endif

                    <!-- Submit Button (Desktop) -->
                    <button type="submit" form="bookingForm" :disabled="!canSubmit || submitting"
                            @click="document.querySelector('form').dispatchEvent(new Event('submit', {cancelable: true, bubbles: true}))"
                            class="hidden lg:block w-full mt-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-xl shadow-lg hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 disabled:opacity-50 disabled:cursor-not-allowed transition-all">
                        <span x-show="!submitting">Ajukan Sewa Sekarang</span>
                        <span x-show="submitting" class="flex items-center justify-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Memproses...
                        </span>
                    </button>

                    <!-- Validation Messages -->
                    <div class="mt-4 space-y-2" x-show="!canSubmit">
                        <p class="text-xs text-red-500 flex items-center" x-show="!startDate">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Pilih tanggal mulai sewa
                        </p>
                        <p class="text-xs text-red-500 flex items-center" x-show="!selectedRoom && {{ $rooms->count() > 0 ? 'true' : 'false' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Pilih kamar yang tersedia
                        </p>
                        @if($occupantType === 'double')
                        <p class="text-xs text-red-500 flex items-center" x-show="!sharedEmail">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Masukkan email teman sekamar untuk Room Match
                        </p>
                        @endif
                        <p class="text-xs text-red-500 flex items-center" x-show="!hasPaymentProof">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Unggah bukti transfer pembayaran
                        </p>
                    </div>

                    <!-- Help -->
                    <div class="mt-6 pt-4 border-t border-gray-100">
                        <p class="text-xs text-gray-500 text-center">
                            Butuh bantuan? <a href="#" class="text-blue-500 hover:underline">Hubungi kami</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        // Copy bank account number
        function copyBankNumber() {
            const bankNumber = document.getElementById('bankAccountNumber')?.textContent;
            if (bankNumber) {
                navigator.clipboard.writeText(bankNumber).then(() => {
                    alert('Nomor rekening berhasil disalin!');
                }).catch(err => {
                    console.error('Failed to copy: ', err);
                });
            }
        }

        function bookingForm() {
            return {
                duration: '{{ $duration }}',
                occupantType: '{{ $occupantType }}',
                selectedPrice: {{ $price }},
                startDate: '',
                selectedRoom: null,
                sharedEmail: '',
                hasPaymentProof: false,
                submitting: false,
                rooms: @json($rooms->keyBy('id')->map(fn($r) => ['room_number' => $r->room_number, 'floor' => $r->floor])),

                init() {
                    // Watch for payment proof file input changes
                    const paymentInput = document.getElementById('payment_proof');
                    if (paymentInput) {
                        paymentInput.addEventListener('change', (e) => {
                            this.hasPaymentProof = e.target.files.length > 0;
                        });
                    }
                },

                get minDate() {
                    const today = new Date();
                    return today.toISOString().split('T')[0];
                },

                get totalPrice() {
                    return this.selectedPrice;
                },

                get durationLabel() {
                    const labels = {
                        '1_month': '1 Bulan',
                        '3_months': '3 Bulan',
                        '6_months': '6 Bulan',
                        '1_year': '1 Tahun'
                    };
                    return labels[this.duration];
                },

                get occupantLabel() {
                    return this.occupantType === 'double' ? '2 Orang' : '1 Orang';
                },

                get selectedRoomLabel() {
                    if (!this.selectedRoom || !this.rooms[this.selectedRoom]) return '-';
                    const room = this.rooms[this.selectedRoom];
                    return `No. ${room.room_number} (Lt. ${room.floor})`;
                },

                get canSubmit() {
                    const hasRoom = this.selectedRoom || {{ $rooms->count() === 0 ? 'true' : 'false' }};
                    const hasDate = this.startDate !== '';
                    // If double occupant (room match), require shared email
                    const hasRoomMatchEmail = this.occupantType !== 'double' || (this.occupantType === 'double' && this.sharedEmail);
                    const hasProof = this.hasPaymentProof;
                    return hasRoom && hasDate && hasRoomMatchEmail && hasProof;
                },

                formatPrice(price) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(price);
                },

                calculateEndDate() {
                    if (!this.startDate) return '-';
                    const start = new Date(this.startDate);
                    let months = 1;
                    if (this.duration === '3_months') months = 3;
                    if (this.duration === '6_months') months = 6;
                    if (this.duration === '1_year') months = 12;

                    const end = new Date(start);
                    end.setMonth(end.getMonth() + months);

                    return end.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                },

                handleSubmit(event) {
                    event.preventDefault();

                    if (!this.canSubmit) {
                        return false;
                    }

                    this.submitting = true;

                    const form = event.target;
                    const formData = new FormData(form);

                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => {
                        return response.json().then(data => {
                            if (!response.ok) {
                                throw data;
                            }
                            return data;
                        });
                    })
                    .then(data => {
                        if (data.success) {
                            // Redirect to orders page with success message
                            window.location.href = '{{ route("renter.orders.index") }}?success=1&booking_code=' + data.booking_code;
                        } else {
                            alert(data.message || 'Terjadi kesalahan. Silakan coba lagi.');
                            this.submitting = false;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        if (error && error.message) {
                            alert(error.message);
                        } else {
                            alert('Terjadi kesalahan. Silakan coba lagi.');
                        }
                        this.submitting = false;
                    });

                    return false;
                }
            }
        }
    </script>
</body>
</html>
