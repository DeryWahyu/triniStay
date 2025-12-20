@extends('layouts.superadmin')

@section('title', 'Dashboard')
@section('page-title', 'Beranda')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Users (Renters) -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Penyewa</p>
                    <p class="text-3xl font-bold text-blue-600 mt-1">{{ number_format($totalRenters) }}</p>
                </div>
                <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-3">Pengguna terdaftar sebagai penyewa</p>
        </div>

        <!-- Total Owners -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Pemilik Kos</p>
                    <p class="text-3xl font-bold text-green-600 mt-1">{{ number_format($totalOwners) }}</p>
                </div>
                <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-3">Pengguna terdaftar sebagai pemilik</p>
        </div>

        <!-- Total Boarding Houses -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Kos</p>
                    <p class="text-3xl font-bold text-purple-600 mt-1">{{ number_format($totalBoardingHouses) }}</p>
                </div>
                <div class="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-3">Kos terdaftar di sistem</p>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Rating Chart -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-navy mb-4">Rating Keseluruhan</h3>
            <div class="flex items-center justify-center">
                <div class="relative w-48 h-48">
                    <canvas id="ratingChart"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-4xl font-bold text-navy">{{ number_format($averageRating, 1) }}</span>
                        <span class="text-sm text-gray-500">dari 5</span>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <p class="text-sm text-gray-500">Berdasarkan {{ number_format($totalReviews) }} ulasan</p>
                <div class="flex items-center justify-center mt-2">
                    @for($i = 1; $i <= 5; $i++)
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $i <= round($averageRating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    @endfor
                </div>
            </div>
        </div>

        <!-- Monthly Activity Chart -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-navy mb-4">Aktivitas Bulanan</h3>
            <div class="h-64">
                <canvas id="activityChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Online Users -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-navy">Pengguna Online</h3>
            <span class="px-3 py-1 text-sm font-medium text-green-700 bg-green-100 rounded-full">
                {{ $onlineUsers->count() }} online
            </span>
        </div>

        @if($onlineUsers->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($onlineUsers as $user)
                    <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                        <div class="relative">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold">{{ $user->initials ?? substr($user->name, 0, 2) }}</span>
                            </div>
                            <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-navy">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500 capitalize">{{ $user->role }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-400">{{ $user->last_seen_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <p>Tidak ada pengguna online saat ini</p>
            </div>
        @endif
    </div>

    <!-- Recent Activities -->
    @if($recentActivities->count() > 0)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-navy">Aktivitas Terbaru</h3>
            <a href="{{ route('superadmin.activity.index') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
        </div>

        <div class="space-y-3">
            @foreach($recentActivities as $activity)
                <div class="flex items-center p-3 bg-gray-50 rounded-xl">
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                        <span class="text-gray-600 font-medium text-sm">
                            {{ $activity->user ? substr($activity->user->name, 0, 2) : 'SY' }}
                        </span>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-navy">{{ $activity->user?->name ?? 'System' }}</p>
                        <p class="text-xs text-gray-500">{{ $activity->description ?? $activity->action }}</p>
                    </div>
                    <div class="text-right">
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $activity->action_color }}">
                            {{ $activity->action }}
                        </span>
                        <p class="text-xs text-gray-400 mt-1">{{ $activity->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Rating Doughnut Chart
        const ratingCtx = document.getElementById('ratingChart').getContext('2d');
        const ratingValue = {{ $averageRating }};
        
        new Chart(ratingCtx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [ratingValue, 5 - ratingValue],
                    backgroundColor: ['#3B82F6', '#E5E7EB'],
                    borderWidth: 0,
                    cutout: '75%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: false }
                }
            }
        });

        // Monthly Activity Bar Chart
        const activityCtx = document.getElementById('activityChart').getContext('2d');
        const monthlyData = @json($monthlyData);
        
        new Chart(activityCtx, {
            type: 'bar',
            data: {
                labels: monthlyData.map(item => item.month),
                datasets: [
                    {
                        label: 'Booking',
                        data: monthlyData.map(item => item.bookings),
                        backgroundColor: '#3B82F6',
                        borderRadius: 6,
                        barThickness: 20,
                    },
                    {
                        label: 'Pengguna Baru',
                        data: monthlyData.map(item => item.users),
                        backgroundColor: '#10B981',
                        borderRadius: 6,
                        barThickness: 20,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 },
                        grid: { color: '#F3F4F6' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
@endpush
