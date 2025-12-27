@extends('layouts.superadmin')

@section('title', 'Detail Kos')
@section('page-title', 'Detail Kos')

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <div>
        <a href="{{ route('superadmin.kost.index') }}" class="inline-flex items-center text-gray-600 hover:text-navy transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar Kos
        </a>
    </div>

    <!-- Main Info -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6">
            <!-- Image -->
            <div class="lg:col-span-1">
                @if($boardingHouse->images && count($boardingHouse->images) > 0)
                    <img src="{{ asset('storage/' . $boardingHouse->images[0]) }}" alt="{{ $boardingHouse->name }}" class="w-full h-64 object-cover rounded-xl">
                @else
                    <div class="w-full h-64 bg-gray-200 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Details -->
            <div class="lg:col-span-2 space-y-4">
                <div class="flex items-start justify-between">
                    <div>
                        <div class="flex items-center space-x-2 mb-2">
                            @php
                                $typeColors = [
                                    'putra' => 'bg-blue-100 text-blue-700',
                                    'putri' => 'bg-pink-100 text-pink-700',
                                    'campur' => 'bg-purple-100 text-purple-700',
                                ];
                            @endphp
                            <span class="px-3 py-1 text-xs font-medium rounded-full {{ $typeColors[$boardingHouse->type] ?? 'bg-gray-100 text-gray-700' }}">
                                Kos {{ ucfirst($boardingHouse->type) }}
                            </span>
                            @if($boardingHouse->status === 'active')
                                <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Aktif</span>
                            @else
                                <span class="px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-700">Nonaktif</span>
                            @endif
                            @if($boardingHouse->is_room_match_enabled)
                                <span class="px-3 py-1 text-xs font-medium rounded-full bg-emerald-100 text-emerald-700">Room Match</span>
                            @endif
                        </div>
                        <h1 class="text-2xl font-bold text-navy">{{ $boardingHouse->name }}</h1>
                        <p class="text-gray-500 flex items-center mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $boardingHouse->address }}
                        </p>
                    </div>

                    <!-- Delete Button -->
                    <form action="{{ route('superadmin.kost.destroy', $boardingHouse) }}" method="POST" 
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus kos ini? Semua data terkait akan ikut terhapus.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus Kos
                        </button>
                    </form>
                </div>

                <!-- Price & Room Info -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-4">
                    <div class="bg-gray-50 rounded-xl p-4 text-center">
                        <p class="text-sm text-gray-500">Harga/Bulan</p>
                        <p class="text-lg font-bold text-blue-600">Rp {{ number_format($boardingHouse->price_monthly ?? $boardingHouse->price ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 text-center">
                        <p class="text-sm text-gray-500">Total Kamar</p>
                        <p class="text-lg font-bold text-navy">{{ $boardingHouse->rooms->count() }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 text-center">
                        <p class="text-sm text-gray-500">Tersedia</p>
                        <p class="text-lg font-bold text-green-600">{{ $boardingHouse->rooms->where('status', 'available')->count() }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 text-center">
                        <p class="text-sm text-gray-500">Terisi</p>
                        <p class="text-lg font-bold text-red-600">{{ $boardingHouse->rooms->where('status', 'occupied')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Owner Info -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-semibold text-navy mb-4 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            Informasi Pemilik
        </h2>
        <div class="flex items-center">
            <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center">
                <span class="text-white font-bold text-lg">{{ substr($boardingHouse->owner->name ?? 'O', 0, 2) }}</span>
            </div>
            <div class="ml-4">
                <p class="text-lg font-semibold text-navy">{{ $boardingHouse->owner->name ?? '-' }}</p>
                <p class="text-gray-500">{{ $boardingHouse->owner->email ?? '-' }}</p>
                <p class="text-gray-500">{{ $boardingHouse->owner->phone_number ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Description & Rules -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Description -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-navy mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Deskripsi
            </h2>
            <p class="text-gray-600 leading-relaxed">{{ $boardingHouse->description ?? 'Tidak ada deskripsi.' }}</p>
        </div>

        <!-- Rules -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-navy mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                Peraturan
            </h2>
            <div class="text-gray-600 leading-relaxed">
                @if($boardingHouse->rules)
                    {!! nl2br(e($boardingHouse->rules)) !!}
                @else
                    Tidak ada peraturan.
                @endif
            </div>
        </div>
    </div>

    <!-- Facilities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Common Facilities -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-navy mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Fasilitas Umum
            </h2>
            <div class="flex flex-wrap gap-2">
                @if($boardingHouse->common_facilities && count($boardingHouse->common_facilities) > 0)
                    @foreach($boardingHouse->common_facilities as $facility)
                        <span class="px-3 py-1.5 bg-gray-100 text-gray-700 text-sm rounded-full">{{ $facility }}</span>
                    @endforeach
                @else
                    <p class="text-gray-500">Tidak ada fasilitas umum.</p>
                @endif
            </div>
        </div>

        <!-- Room Facilities -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-navy mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                </svg>
                Fasilitas Kamar
            </h2>
            <div class="flex flex-wrap gap-2">
                @if($boardingHouse->room_facilities && count($boardingHouse->room_facilities) > 0)
                    @foreach($boardingHouse->room_facilities as $facility)
                        <span class="px-3 py-1.5 bg-blue-100 text-blue-700 text-sm rounded-full">{{ $facility }}</span>
                    @endforeach
                @else
                    <p class="text-gray-500">Tidak ada fasilitas kamar.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Reviews -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-semibold text-navy mb-4 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
            </svg>
            Ulasan ({{ $boardingHouse->reviews->count() }})
        </h2>
        
        @if($boardingHouse->reviews->count() > 0)
            <div class="space-y-4">
                @foreach($boardingHouse->reviews->take(5) as $review)
                    <div class="border-b border-gray-100 pb-4 last:border-0">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-blue-600 font-semibold text-sm">{{ $review->user->initials ?? 'U' }}</span>
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium text-navy">{{ $review->user->name ?? 'Unknown' }}</p>
                                    <div class="flex items-center">
                                        <div class="flex text-yellow-400">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                                @else
                                                    <svg class="w-4 h-4 fill-current text-gray-300" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="text-xs text-gray-400 ml-2">{{ $review->created_at->format('d M Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-600 mt-2 ml-13">{{ $review->comment ?: '-' }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">Belum ada ulasan.</p>
        @endif
    </div>
</div>
@endsection
