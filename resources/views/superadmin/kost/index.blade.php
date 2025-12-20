@extends('layouts.superadmin')

@section('title', 'Data Kos')
@section('page-title', 'Data Kos')

@section('content')
<div class="space-y-6">
    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('superadmin.kost.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-4 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari nama kos atau pemilik..."
                           class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                </div>
            </div>

            <!-- Submit -->
            <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors">
                Cari
            </button>

            @if(request('search'))
                <a href="{{ route('superadmin.kost.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition-colors text-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Kost Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Pemilik</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Kos</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tipe</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Kamar</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kamar Tersedia</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($boardingHouses as $index => $kost)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $boardingHouses->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center">
                                        <span class="text-white font-semibold text-sm">{{ substr($kost->owner->name ?? 'O', 0, 2) }}</span>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-navy">{{ $kost->owner->name ?? '-' }}</p>
                                        <p class="text-xs text-gray-500">{{ $kost->owner->email ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($kost->images && count($kost->images) > 0)
                                        <img src="{{ asset('storage/' . $kost->images[0]) }}" alt="{{ $kost->name }}" class="w-12 h-12 rounded-lg object-cover">
                                    @else
                                        <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-navy">{{ $kost->name }}</p>
                                        <p class="text-xs text-gray-500">{{ Str::limit($kost->address, 30) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $typeColors = [
                                        'putra' => 'bg-blue-100 text-blue-700',
                                        'putri' => 'bg-pink-100 text-pink-700',
                                        'campur' => 'bg-purple-100 text-purple-700',
                                    ];
                                @endphp
                                <span class="px-3 py-1 text-xs font-medium rounded-full {{ $typeColors[$kost->type] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($kost->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <span class="font-semibold text-navy">{{ $kost->rooms->count() }}</span> kamar
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @php
                                    $availableRooms = $kost->rooms->where('status', 'available')->count();
                                @endphp
                                <span class="font-semibold {{ $availableRooms > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $availableRooms }}
                                </span>
                                <span class="text-gray-500">tersedia</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($kost->status === 'active')
                                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-700">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <p class="text-gray-500">Tidak ada data kos ditemukan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($boardingHouses->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $boardingHouses->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
