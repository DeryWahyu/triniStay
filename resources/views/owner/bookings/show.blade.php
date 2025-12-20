@extends('layouts.owner')

@section('title', 'Detail Pemesanan')
@section('page-title', 'Detail Pemesanan')

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <div>
        <a href="{{ route('owner.bookings.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar Pemesanan
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Booking Status Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Kode Pemesanan</p>
                        <h1 class="text-xl font-bold text-gray-900">{{ $booking->booking_code ?? '#' . str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</h1>
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

                    <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-xl border {{ $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-700' }}">
                        {{ $statusLabels[$booking->status] ?? ucfirst($booking->status) }}
                    </span>
                </div>

                <div class="mt-4 text-sm text-gray-500">
                    Dipesan pada {{ $booking->created_at->format('d F Y, H:i') }} WIB
                </div>
            </div>

            <!-- Renter Info -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Informasi Penyewa
                </h3>
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-white font-bold text-lg">{{ $booking->user->initials ?? 'U' }}</span>
                    </div>
                    <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Nama Lengkap</p>
                            <p class="font-medium text-gray-900">{{ $booking->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="font-medium text-gray-900">{{ $booking->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">No. Telepon</p>
                            <p class="font-medium text-gray-900">{{ $booking->user->phone_number ?? '-' }}</p>
                        </div>
                        @if($booking->user->gender)
                        <div>
                            <p class="text-sm text-gray-500">Jenis Kelamin</p>
                            <p class="font-medium text-gray-900">{{ strtolower($booking->user->gender) === 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                @if($booking->is_shared && $booking->sharedWithUser)
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <h4 class="font-medium text-purple-700 mb-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Room Match - Teman Sekamar
                    </h4>
                    <div class="bg-purple-50 rounded-xl p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-purple-600">Nama</p>
                                <p class="font-medium text-purple-900">{{ $booking->sharedWithUser->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-purple-600">Email</p>
                                <p class="font-medium text-purple-900">{{ $booking->sharedWithUser->email }}</p>
                            </div>
                        </div>
                        @php
                            $sharedStatusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'accepted' => 'bg-green-100 text-green-700',
                                'rejected' => 'bg-red-100 text-red-700',
                            ];
                            $sharedStatusLabels = [
                                'pending' => 'Menunggu Konfirmasi',
                                'accepted' => 'Diterima',
                                'rejected' => 'Ditolak',
                            ];
                        @endphp
                        <div class="mt-3">
                            <span class="px-3 py-1 text-xs font-medium rounded-full {{ $sharedStatusColors[$booking->shared_status] ?? 'bg-gray-100 text-gray-700' }}">
                                Status: {{ $sharedStatusLabels[$booking->shared_status] ?? ucfirst($booking->shared_status) }}
                            </span>
                        </div>
                    </div>
                </div>
                @elseif($booking->is_shared && $booking->shared_with_email)
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <h4 class="font-medium text-purple-700 mb-3">Room Match - Teman Sekamar</h4>
                    <div class="bg-purple-50 rounded-xl p-4">
                        <p class="text-sm text-purple-600">Email Teman</p>
                        <p class="font-medium text-purple-900">{{ $booking->shared_with_email }}</p>
                        <p class="text-xs text-purple-500 mt-1">(Pengguna belum terdaftar)</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Booking Details -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Detail Pemesanan
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Nama Kos</p>
                        <p class="font-medium text-gray-900 mt-1">{{ $booking->boardingHouse->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Nomor Kamar</p>
                        <p class="font-medium text-gray-900 mt-1">
                            @if($booking->room)
                                No. {{ $booking->room->room_number }} (Lt. {{ $booking->room->floor }})
                            @else
                                Belum ditentukan
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500">Durasi Sewa</p>
                        <p class="font-medium text-gray-900 mt-1">{{ $booking->durationLabel ?? $booking->duration }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Jumlah Penghuni</p>
                        <p class="font-medium text-gray-900 mt-1">{{ $booking->is_shared ? '2 Orang (Room Match)' : '1 Orang' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Tanggal Mulai</p>
                        <p class="font-medium text-gray-900 mt-1">{{ $booking->start_date->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Tanggal Selesai</p>
                        <p class="font-medium text-gray-900 mt-1">{{ $booking->end_date->format('d F Y') }}</p>
                    </div>
                </div>

                @if($booking->notes)
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-gray-500 text-sm">Catatan dari Penyewa</p>
                    <p class="text-gray-900 mt-1">{{ $booking->notes }}</p>
                </div>
                @endif
            </div>

            <!-- Payment Proof -->
            @if($booking->payment_proof)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Bukti Pembayaran
                </h3>
                <div class="bg-gray-50 rounded-xl p-4">
                    <a href="{{ asset('storage/' . $booking->payment_proof) }}" target="_blank" class="block">
                        <img src="{{ asset('storage/' . $booking->payment_proof) }}"
                             alt="Bukti Pembayaran"
                             class="max-w-full h-auto max-h-96 rounded-lg mx-auto shadow-sm hover:shadow-md transition-shadow">
                    </a>
                    <p class="text-center text-sm text-gray-500 mt-3">Klik gambar untuk melihat ukuran penuh</p>
                </div>
            </div>
            @endif

            <!-- Review -->
            @if($booking->review)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                    Ulasan Penyewa
                </h3>
                <div class="flex items-center gap-2 mb-3">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-5 h-5 {{ $i <= $booking->review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                    <span class="text-gray-600 ml-2">{{ $booking->review->rating }}/5</span>
                </div>
                @if($booking->review->comment)
                <p class="text-gray-700">{{ $booking->review->comment }}</p>
                @endif
                <p class="text-xs text-gray-500 mt-2">Ditulis pada {{ $booking->review->created_at->format('d F Y') }}</p>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Price Summary -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Ringkasan Pembayaran</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Harga per Periode</span>
                        <span class="font-medium text-gray-900">Rp {{ number_format($booking->price_per_period, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Durasi</span>
                        <span class="font-medium text-gray-900">{{ $booking->durationLabel ?? $booking->duration }}</span>
                    </div>
                    @if($booking->is_shared)
                    <div class="flex justify-between text-purple-600">
                        <span>Room Match (per orang)</span>
                        <span class="font-medium">50%</span>
                    </div>
                    @endif
                    <hr class="my-3">
                    <div class="flex justify-between text-lg">
                        <span class="font-semibold text-gray-900">Total Bayar</span>
                        <span class="font-bold text-blue-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    </div>
                    @if($booking->is_shared)
                    <p class="text-xs text-gray-500">* Total yang dibayar penyewa ini. Teman sekamar membayar jumlah yang sama.</p>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            @if($booking->status === 'pending')
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Tindakan</h3>
                <div class="space-y-3">
                    <form action="{{ route('owner.bookings.approve', $booking) }}" method="POST">
                        @csrf
                        <button type="submit"
                                onclick="return confirm('Yakin ingin menyetujui pemesanan ini?')"
                                class="w-full py-3 bg-green-500 text-white font-medium rounded-xl hover:bg-green-600 transition-colors flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Setujui Pemesanan
                        </button>
                    </form>
                    <form action="{{ route('owner.bookings.reject', $booking) }}" method="POST">
                        @csrf
                        <button type="submit"
                                onclick="return confirm('Yakin ingin menolak pemesanan ini?')"
                                class="w-full py-3 bg-red-50 text-red-600 font-medium rounded-xl hover:bg-red-100 transition-colors flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Tolak Pemesanan
                        </button>
                    </form>
                </div>
            </div>
            @elseif($booking->status === 'approved')
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Tindakan</h3>
                <form action="{{ route('owner.bookings.complete', $booking) }}" method="POST">
                    @csrf
                    <button type="submit"
                            onclick="return confirm('Tandai pemesanan ini sebagai selesai?')"
                            class="w-full py-3 bg-blue-500 text-white font-medium rounded-xl hover:bg-blue-600 transition-colors flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Tandai Selesai
                    </button>
                </form>
            </div>
            @endif

            <!-- Contact Renter -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Hubungi Penyewa</h3>
                @if($booking->user->phone_number)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $booking->user->phone_number) }}"
                   target="_blank"
                   class="block w-full py-3 text-center text-green-600 bg-green-50 font-medium rounded-xl hover:bg-green-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    Chat WhatsApp
                </a>
                @else
                <a href="mailto:{{ $booking->user->email }}"
                   class="block w-full py-3 text-center text-blue-600 bg-blue-50 font-medium rounded-xl hover:bg-blue-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Kirim Email
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
