@extends('layouts.owner')

@section('title', 'Profil & Pengaturan')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Profil & Pengaturan</h1>
        <p class="text-gray-600">Kelola informasi profil dan rekening bank Anda</p>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Profile Form -->
    <form action="{{ route('owner.profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Personal Information Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Informasi Pribadi
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email (Read Only) -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email
                        </label>
                        <input type="email" id="email" value="{{ $user->email }}" readonly disabled
                               class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed">
                        <p class="mt-1 text-xs text-gray-500">Email tidak dapat diubah</p>
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor Telepon
                        </label>
                        <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}"
                               placeholder="Contoh: 081234567890"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('phone_number') border-red-500 @enderror">
                        @error('phone_number')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Bank Account Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    Informasi Rekening Bank
                </h2>
                <p class="text-sm text-gray-500 mt-1">Rekening bank untuk menerima pembayaran dari penyewa</p>
            </div>
            <div class="p-6">
                <!-- Info Box -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <svg class="w-5 h-5 text-blue-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm text-blue-700">
                            Informasi rekening bank akan ditampilkan kepada penyewa saat melakukan pembayaran. Pastikan data rekening sudah benar.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Bank Name -->
                    <div>
                        <label for="bank_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Bank
                        </label>
                        <select id="bank_name" name="bank_name"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('bank_name') border-red-500 @enderror">
                            <option value="">-- Pilih Bank --</option>
                            <option value="BCA" {{ old('bank_name', $user->bank_name) == 'BCA' ? 'selected' : '' }}>BCA</option>
                            <option value="BNI" {{ old('bank_name', $user->bank_name) == 'BNI' ? 'selected' : '' }}>BNI</option>
                            <option value="BRI" {{ old('bank_name', $user->bank_name) == 'BRI' ? 'selected' : '' }}>BRI</option>
                            <option value="Mandiri" {{ old('bank_name', $user->bank_name) == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                            <option value="CIMB Niaga" {{ old('bank_name', $user->bank_name) == 'CIMB Niaga' ? 'selected' : '' }}>CIMB Niaga</option>
                            <option value="Danamon" {{ old('bank_name', $user->bank_name) == 'Danamon' ? 'selected' : '' }}>Danamon</option>
                            <option value="Permata" {{ old('bank_name', $user->bank_name) == 'Permata' ? 'selected' : '' }}>Permata</option>
                            <option value="BTN" {{ old('bank_name', $user->bank_name) == 'BTN' ? 'selected' : '' }}>BTN</option>
                            <option value="BSI" {{ old('bank_name', $user->bank_name) == 'BSI' ? 'selected' : '' }}>BSI (Bank Syariah Indonesia)</option>
                            <option value="Maybank" {{ old('bank_name', $user->bank_name) == 'Maybank' ? 'selected' : '' }}>Maybank</option>
                            <option value="OCBC NISP" {{ old('bank_name', $user->bank_name) == 'OCBC NISP' ? 'selected' : '' }}>OCBC NISP</option>
                            <option value="Panin" {{ old('bank_name', $user->bank_name) == 'Panin' ? 'selected' : '' }}>Panin Bank</option>
                            <option value="Jenius" {{ old('bank_name', $user->bank_name) == 'Jenius' ? 'selected' : '' }}>Jenius (BTPN)</option>
                            <option value="Jago" {{ old('bank_name', $user->bank_name) == 'Jago' ? 'selected' : '' }}>Bank Jago</option>
                            <option value="Sea Bank" {{ old('bank_name', $user->bank_name) == 'Sea Bank' ? 'selected' : '' }}>Sea Bank</option>
                            <option value="OVO" {{ old('bank_name', $user->bank_name) == 'OVO' ? 'selected' : '' }}>OVO</option>
                            <option value="GoPay" {{ old('bank_name', $user->bank_name) == 'GoPay' ? 'selected' : '' }}>GoPay</option>
                            <option value="DANA" {{ old('bank_name', $user->bank_name) == 'DANA' ? 'selected' : '' }}>DANA</option>
                            <option value="ShopeePay" {{ old('bank_name', $user->bank_name) == 'ShopeePay' ? 'selected' : '' }}>ShopeePay</option>
                            <option value="Lainnya" {{ old('bank_name', $user->bank_name) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('bank_name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Account Number -->
                    <div>
                        <label for="bank_account_number" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor Rekening
                        </label>
                        <input type="text" id="bank_account_number" name="bank_account_number"
                               value="{{ old('bank_account_number', $user->bank_account_number) }}"
                               placeholder="Contoh: 1234567890"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('bank_account_number') border-red-500 @enderror">
                        @error('bank_account_number')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Account Name -->
                    <div class="md:col-span-2">
                        <label for="bank_account_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Pemilik Rekening
                        </label>
                        <input type="text" id="bank_account_name" name="bank_account_name"
                               value="{{ old('bank_account_name', $user->bank_account_name) }}"
                               placeholder="Sesuai dengan buku tabungan"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('bank_account_name') border-red-500 @enderror">
                        @error('bank_account_name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Bank Account Preview -->
        @if($user->bank_name && $user->bank_account_number)
        <div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-xl shadow-lg overflow-hidden mb-6">
            <div class="p-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <p class="text-gray-400 text-xs uppercase tracking-wider">Rekening Aktif</p>
                        <h3 class="text-white text-xl font-bold mt-1">{{ $user->bank_name }}</h3>
                    </div>
                    <div class="bg-white/10 rounded-lg p-2">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                </div>
                <div class="space-y-2">
                    <p class="text-gray-400 text-sm">Nomor Rekening</p>
                    <p class="text-white text-2xl font-mono tracking-widest">{{ $user->bank_account_number }}</p>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-700">
                    <p class="text-gray-400 text-sm">Atas Nama</p>
                    <p class="text-white font-semibold">{{ $user->bank_account_name ?? '-' }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit"
                    class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
