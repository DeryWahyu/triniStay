@extends('layouts.superadmin')

@section('title', 'Data Pengguna')
@section('page-title', 'Data Pengguna')

@section('content')
<div class="space-y-6">
    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('superadmin.users.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-4 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari nama atau email..."
                           class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                </div>
            </div>

            <!-- Role Filter -->
            <div class="w-full md:w-48">
                <select name="role" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    <option value="">Semua Role</option>
                    <option value="renter" {{ request('role') === 'renter' ? 'selected' : '' }}>Penyewa</option>
                    <option value="owner" {{ request('role') === 'owner' ? 'selected' : '' }}>Pemilik Kos</option>
                </select>
            </div>

            <!-- Status Filter -->
            <div class="w-full md:w-48">
                <select name="status" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="blocked" {{ request('status') === 'blocked' ? 'selected' : '' }}>Terblokir</option>
                </select>
            </div>

            <!-- Submit -->
            <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors">
                Filter
            </button>

            @if(request()->hasAny(['search', 'role', 'status']))
                <a href="{{ route('superadmin.users.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition-colors text-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $index => $user)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $users->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br {{ $user->role === 'owner' ? 'from-green-500 to-green-600' : 'from-blue-500 to-blue-600' }} rounded-full flex items-center justify-center">
                                        <span class="text-white font-semibold text-sm">{{ $user->initials ?? substr($user->name, 0, 2) }}</span>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-navy">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $user->phone_number ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs font-medium rounded-full {{ $user->role === 'owner' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $user->role === 'owner' ? 'Pemilik Kos' : 'Penyewa' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($user->is_blocked)
                                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">
                                        Diblokir
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">
                                        Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <!-- Block/Unblock -->
                                    <form id="toggle-block-{{ $user->id }}" action="{{ route('superadmin.users.toggle-block', $user) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="button" 
                                                class="px-3 py-1.5 text-xs font-medium rounded-lg transition-colors {{ $user->is_blocked ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200' }}"
                                                onclick="confirmToggleBlock('{{ $user->id }}', '{{ $user->name }}', {{ $user->is_blocked ? 'true' : 'false' }})">
                                            {{ $user->is_blocked ? 'Buka Blokir' : 'Blokir' }}
                                        </button>
                                    </form>

                                    <!-- Delete -->
                                    <form id="delete-user-{{ $user->id }}" action="{{ route('superadmin.users.destroy', $user) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="px-3 py-1.5 text-xs font-medium rounded-lg bg-red-100 text-red-700 hover:bg-red-200 transition-colors"
                                                onclick="confirmDeleteUser('{{ $user->id }}', '{{ $user->name }}')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <p class="text-gray-500">Tidak ada pengguna ditemukan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $users->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function confirmToggleBlock(userId, userName, isBlocked) {
    const action = isBlocked ? 'buka blokir' : 'blokir';
    const icon = isBlocked ? 'info' : 'warning';
    
    Swal.fire({
        title: isBlocked ? 'Buka Blokir Pengguna?' : 'Blokir Pengguna?',
        text: `Anda yakin ingin ${action} pengguna "${userName}"?`,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: isBlocked ? '#10B981' : '#F59E0B',
        cancelButtonColor: '#6B7280',
        confirmButtonText: isBlocked ? 'Ya, Buka Blokir' : 'Ya, Blokir',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('toggle-block-' + userId).submit();
        }
    });
}

function confirmDeleteUser(userId, userName) {
    Swal.fire({
        title: 'Hapus Pengguna?',
        text: `Anda yakin ingin menghapus pengguna "${userName}"? Tindakan ini tidak dapat dibatalkan.`,
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#EF4444',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-user-' + userId).submit();
        }
    });
}
</script>
@endpush
@endsection

