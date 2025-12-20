@extends('layouts.owner')

@section('title', 'Pemesanan')
@section('page-title', 'Kelola Pemesanan')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kelola Pemesanan</h1>
            <p class="text-gray-500 mt-1">Lihat dan kelola semua pemesanan kos Anda</p>
        </div>
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

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Pemesanan</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalCount }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Menunggu Konfirmasi</p>
                    <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $pendingCount }}</p>
                </div>
                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Disetujui</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">{{ $approvedCount }}</p>
                </div>
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px">
                <a href="{{ route('owner.bookings.index') }}"
                   class="px-6 py-4 text-sm font-medium border-b-2 transition-colors
                          {{ !$status || $status === 'all' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    Semua
                </a>
                <a href="{{ route('owner.bookings.index', ['status' => 'pending']) }}"
                   class="px-6 py-4 text-sm font-medium border-b-2 transition-colors
                          {{ $status === 'pending' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    Menunggu
                    @if($pendingCount > 0)
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-yellow-100 text-yellow-700">{{ $pendingCount }}</span>
                    @endif
                </a>
                <a href="{{ route('owner.bookings.index', ['status' => 'approved']) }}"
                   class="px-6 py-4 text-sm font-medium border-b-2 transition-colors
                          {{ $status === 'approved' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    Disetujui
                </a>
                <a href="{{ route('owner.bookings.index', ['status' => 'completed']) }}"
                   class="px-6 py-4 text-sm font-medium border-b-2 transition-colors
                          {{ $status === 'completed' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    Selesai
                </a>
                <a href="{{ route('owner.bookings.index', ['status' => 'rejected']) }}"
                   class="px-6 py-4 text-sm font-medium border-b-2 transition-colors
                          {{ $status === 'rejected' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    Ditolak
                </a>
            </nav>
        </div>

        <!-- Bookings Table -->
        <div class="overflow-x-auto">
            @if($bookings->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penyewa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kos</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kamar</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($bookings as $booking)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                                            <span class="text-white font-semibold text-sm">{{ $booking->user->initials ?? 'U' }}</span>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $booking->user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $booking->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-sm text-gray-900">{{ $booking->boardingHouse->name }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-sm text-gray-900">{{ $booking->room ? 'No. ' . $booking->room->room_number : '-' }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-sm text-gray-900">{{ $booking->durationLabel ?? $booking->duration . ' bulan' }}</p>
                                    <p class="text-xs text-gray-500">{{ $booking->start_date->format('d M Y') }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-sm font-medium text-gray-900">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                    @if($booking->is_shared)
                                        <span class="text-xs text-purple-600">Room Match</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-700',
                                            'approved' => 'bg-green-100 text-green-700',
                                            'rejected' => 'bg-red-100 text-red-700',
                                            'cancelled' => 'bg-gray-100 text-gray-700',
                                            'completed' => 'bg-blue-100 text-blue-700',
                                        ];
                                        $statusLabels = [
                                            'pending' => 'Menunggu',
                                            'approved' => 'Disetujui',
                                            'rejected' => 'Ditolak',
                                            'cancelled' => 'Dibatalkan',
                                            'completed' => 'Selesai',
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ $statusLabels[$booking->status] ?? ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm" x-data="{ open: false }">
                                    <div class="relative">
                                        <button @click="open = !open" class="text-gray-400 hover:text-gray-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                            </svg>
                                        </button>
                                        <div x-show="open" @click.away="open = false" x-transition
                                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-10 border border-gray-100">
                                            <a href="{{ route('owner.bookings.show', $booking) }}"
                                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                                Lihat Detail
                                            </a>
                                            @if($booking->status === 'pending')
                                                <form action="{{ route('owner.bookings.approve', $booking) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-green-600 hover:bg-green-50">
                                                        Setujui
                                                    </button>
                                                </form>
                                                <button @click="$dispatch('open-reject-modal', { bookingId: {{ $booking->id }} })"
                                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                                    Tolak
                                                </button>
                                            @endif
                                            @if($booking->status === 'approved')
                                                <form action="{{ route('owner.bookings.complete', $booking) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-blue-600 hover:bg-blue-50">
                                                        Tandai Selesai
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $bookings->appends(request()->query())->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Pemesanan</h3>
                    <p class="text-gray-500">Belum ada pemesanan untuk kos Anda.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div x-data="{ showModal: false, bookingId: null }"
     @open-reject-modal.window="showModal = true; bookingId = $event.detail.bookingId"
     x-cloak>
    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showModal = false"></div>

            <div class="relative bg-white rounded-2xl max-w-md w-full p-6 shadow-xl">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Tolak Pemesanan</h3>
                <form :action="'/dashboard/owner/bookings/' + bookingId + '/reject'" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan</label>
                        <textarea name="reason" rows="3" required
                                  class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                  placeholder="Berikan alasan penolakan..."></textarea>
                    </div>
                    <div class="flex space-x-3">
                        <button type="button" @click="showModal = false"
                                class="flex-1 py-2 px-4 text-gray-700 bg-gray-100 font-medium rounded-xl hover:bg-gray-200 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                                class="flex-1 py-2 px-4 bg-red-500 text-white font-medium rounded-xl hover:bg-red-600 transition-colors">
                            Tolak Pemesanan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
