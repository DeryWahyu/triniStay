@extends('layouts.admin.owner')

@section('title', 'Tambah Kos')
@section('page-title', 'Tambah Kos Baru')

@section('content')
<div class="max-w-4xl mx-auto" x-data="{ roomMatch: false }">
    <form action="{{ route('owner.kost.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Basic Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Informasi Dasar
            </h3>

            <div class="space-y-4">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Kos <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name') }}"
                        placeholder="Contoh: Kos Putri Melati"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('name') border-red-500 @enderror"
                        required
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kos Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Jenis Kos <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-3 gap-4">
                        <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-colors {{ old('type') == 'putra' ? 'border-blue-500 bg-blue-50' : '' }}">
                            <input
                                type="radio"
                                name="type"
                                value="putra"
                                class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                {{ old('type') == 'putra' ? 'checked' : '' }}
                                required
                            >
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-700">Putra</span>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-pink-500 hover:bg-pink-50 transition-colors {{ old('type') == 'putri' ? 'border-pink-500 bg-pink-50' : '' }}">
                            <input
                                type="radio"
                                name="type"
                                value="putri"
                                class="w-4 h-4 text-pink-600 border-gray-300 focus:ring-pink-500"
                                {{ old('type') == 'putri' ? 'checked' : '' }}
                            >
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-700">Putri</span>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-purple-500 hover:bg-purple-50 transition-colors {{ old('type', 'campur') == 'campur' ? 'border-purple-500 bg-purple-50' : '' }}">
                            <input
                                type="radio"
                                name="type"
                                value="campur"
                                class="w-4 h-4 text-purple-600 border-gray-300 focus:ring-purple-500"
                                {{ old('type', 'campur') == 'campur' ? 'checked' : '' }}
                            >
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-700">Campur</span>
                            </div>
                        </label>
                    </div>
                    @error('type')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Pricing Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Harga Sewa
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Price Monthly -->
                <div>
                    <label for="price_monthly" class="block text-sm font-medium text-gray-700 mb-2">
                        Harga per Bulan <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                        <input
                            type="number"
                            name="price_monthly"
                            id="price_monthly"
                            value="{{ old('price_monthly') }}"
                            placeholder="500000"
                            class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('price_monthly') border-red-500 @enderror"
                            required
                        >
                    </div>
                    @error('price_monthly')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price 6 Months -->
                <div>
                    <label for="price_6months" class="block text-sm font-medium text-gray-700 mb-2">
                        Harga per 6 Bulan
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                        <input
                            type="number"
                            name="price_6months"
                            id="price_6months"
                            value="{{ old('price_6months') }}"
                            placeholder="2700000"
                            class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        >
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak tersedia</p>
                </div>

                <!-- Price Yearly -->
                <div>
                    <label for="price_yearly" class="block text-sm font-medium text-gray-700 mb-2">
                        Harga per Tahun
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                        <input
                            type="number"
                            name="price_yearly"
                            id="price_yearly"
                            value="{{ old('price_yearly') }}"
                            placeholder="5000000"
                            class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        >
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak tersedia</p>
                </div>
            </div>
        </div>

        <!-- Specifications -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                </svg>
                Spesifikasi Kamar
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Room Size -->
                <div>
                    <label for="room_size" class="block text-sm font-medium text-gray-700 mb-2">
                        Ukuran Kamar
                    </label>
                    <input
                        type="text"
                        name="room_size"
                        id="room_size"
                        value="{{ old('room_size') }}"
                        placeholder="3x4 meter"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    >
                </div>

                <!-- Total Rooms -->
                <div>
                    <label for="total_rooms" class="block text-sm font-medium text-gray-700 mb-2">
                        Jumlah Kamar <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        name="total_rooms"
                        id="total_rooms"
                        value="{{ old('total_rooms', 1) }}"
                        min="1"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('total_rooms') border-red-500 @enderror"
                        required
                    >
                    @error('total_rooms')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Available Rooms -->
                <div>
                    <label for="available_rooms" class="block text-sm font-medium text-gray-700 mb-2">
                        Kamar Tersedia <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        name="available_rooms"
                        id="available_rooms"
                        value="{{ old('available_rooms', 1) }}"
                        min="0"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('available_rooms') border-red-500 @enderror"
                        required
                    >
                    @error('available_rooms')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Rent Schemes -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Skema Pembayaran
            </h3>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @php
                    $rentSchemes = [
                        ['value' => '1', 'label' => '1 Bulan'],
                        ['value' => '3', 'label' => '3 Bulan'],
                        ['value' => '6', 'label' => '6 Bulan'],
                        ['value' => '12', 'label' => '1 Tahun'],
                    ];
                @endphp

                @foreach($rentSchemes as $scheme)
                    <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-colors">
                        <input
                            type="checkbox"
                            name="rent_schemes[]"
                            value="{{ $scheme['value'] }}"
                            class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                            {{ in_array($scheme['value'], old('rent_schemes', [])) ? 'checked' : '' }}
                        >
                        <span class="ml-3 text-sm font-medium text-gray-700">{{ $scheme['label'] }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Room Facilities -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
                Fasilitas Kamar
            </h3>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @php
                    $roomFacilities = [
                        'AC', 'WiFi', 'Kamar Mandi Dalam', 'Kasur',
                        'Lemari', 'Meja', 'Kursi', 'TV',
                        'Kulkas', 'Water Heater', 'Jendela', 'Balkon'
                    ];
                @endphp

                @foreach($roomFacilities as $facility)
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-colors">
                        <input
                            type="checkbox"
                            name="room_facilities[]"
                            value="{{ $facility }}"
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                            {{ in_array($facility, old('room_facilities', [])) ? 'checked' : '' }}
                        >
                        <span class="ml-2 text-sm text-gray-700">{{ $facility }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Common Facilities -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                Fasilitas Umum
            </h3>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @php
                    $commonFacilities = [
                        'Parkir Motor', 'Parkir Mobil', 'Dapur Bersama', 'Ruang Tamu',
                        'Laundry', 'Keamanan 24 Jam', 'CCTV', 'Taman',
                        'Mushola', 'R. Jemur', 'Dispenser', 'Mesin Cuci'
                    ];
                @endphp

                @foreach($commonFacilities as $facility)
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-colors">
                        <input
                            type="checkbox"
                            name="common_facilities[]"
                            value="{{ $facility }}"
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                            {{ in_array($facility, old('common_facilities', [])) ? 'checked' : '' }}
                        >
                        <span class="ml-2 text-sm text-gray-700">{{ $facility }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Images -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Foto Kos
            </h3>

            <div
                x-data="{
                    files: [],
                    handleFiles(event) {
                        const newFiles = Array.from(event.target.files);
                        newFiles.forEach(file => {
                            if (file.type.startsWith('image/')) {
                                this.files.push({
                                    name: file.name,
                                    url: URL.createObjectURL(file)
                                });
                            }
                        });
                    },
                    removeFile(index) {
                        this.files.splice(index, 1);
                    }
                }"
            >
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-500 transition-colors">
                    <input
                        type="file"
                        name="images[]"
                        id="images"
                        multiple
                        accept="image/*"
                        class="hidden"
                        @change="handleFiles($event)"
                    >
                    <label for="images" class="cursor-pointer">
                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <p class="text-gray-600 mb-2">Klik untuk upload atau drag & drop</p>
                        <p class="text-sm text-gray-400">PNG, JPG, JPEG (Max. 2MB per file)</p>
                    </label>
                </div>

                <!-- Image Preview -->
                <div x-show="files.length > 0" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                    <template x-for="(file, index) in files" :key="index">
                        <div class="relative group">
                            <img :src="file.url" :alt="file.name" class="w-full h-32 object-cover rounded-lg">
                            <button
                                type="button"
                                @click="removeFile(index)"
                                class="absolute top-2 right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </template>
                </div>
            </div>

            @error('images')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
            @error('images.*')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Location -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Lokasi
            </h3>

            <div class="space-y-4">
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat Lengkap <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        name="address"
                        id="address"
                        rows="3"
                        placeholder="Masukkan alamat lengkap kos..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('address') border-red-500 @enderror"
                        required
                    >{{ old('address') }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Map Section -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Lokasi di Peta <span class="text-gray-400">(Klik pada peta untuk menandai lokasi)</span>
                    </label>

                    <!-- Search Box -->
                    <div class="mb-3">
                        <div class="relative">
                            <input
                                type="text"
                                id="searchBox"
                                placeholder="Cari lokasi..."
                                class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            >
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Map Container -->
                    <div id="map" class="w-full h-80 rounded-lg border border-gray-300 z-0"></div>

                    <!-- Coordinates Display -->
                    <div class="mt-3 grid grid-cols-2 gap-4">
                        <div>
                            <label for="latitude" class="block text-sm font-medium text-gray-700 mb-1">Latitude</label>
                            <input
                                type="number"
                                step="any"
                                name="latitude"
                                id="latitude"
                                value="{{ old('latitude') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="Contoh: -6.2088"
                            >
                        </div>
                        <div>
                            <label for="longitude" class="block text-sm font-medium text-gray-700 mb-1">Longitude</label>
                            <input
                                type="number"
                                step="any"
                                name="longitude"
                                id="longitude"
                                value="{{ old('longitude') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="Contoh: 106.8456"
                            >
                        </div>
                    </div>

                    <!-- Get Current Location Button -->
                    <button
                        type="button"
                        id="getCurrentLocation"
                        class="mt-3 inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Gunakan Lokasi Saya
                    </button>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Tentang Kos
            </h3>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi
                </label>
                <textarea
                    name="description"
                    id="description"
                    rows="4"
                    placeholder="Ceritakan tentang kos Anda..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                >{{ old('description') }}</textarea>
            </div>
        </div>

        <!-- Rules -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                Peraturan Kos
            </h3>

            <div>
                <label for="rules" class="block text-sm font-medium text-gray-700 mb-2">
                    Peraturan
                </label>
                <textarea
                    name="rules"
                    id="rules"
                    rows="4"
                    placeholder="Tuliskan peraturan kos Anda..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                >{{ old('rules') }}</textarea>
            </div>
        </div>

        <!-- Room Match Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Berbagi Kamar (Room Match)
                </h3>

                <!-- Toggle Switch -->
                <label class="relative inline-flex items-center cursor-pointer">
                    <input
                        type="checkbox"
                        name="is_room_match_enabled"
                        x-model="roomMatch"
                        class="sr-only peer"
                        value="1"
                        {{ old('is_room_match_enabled') ? 'checked' : '' }}
                    >
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    <span class="ml-3 text-sm font-medium text-gray-700">Aktifkan</span>
                </label>
            </div>

            <p class="text-sm text-gray-500 mb-4">
                Aktifkan fitur ini jika Anda mengizinkan penyewa untuk berbagi kamar dengan orang lain.
            </p>

            <!-- Room Match Details (Show/Hide with Alpine.js) -->
            <div x-show="roomMatch" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Room Match Price -->
                    <div>
                        <label for="room_match_price" class="block text-sm font-medium text-gray-700 mb-2">
                            Harga Berbagi Kamar
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                            <input
                                type="number"
                                name="room_match_price"
                                id="room_match_price"
                                value="{{ old('room_match_price') }}"
                                placeholder="250000"
                                class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white"
                            >
                        </div>
                    </div>

                    <!-- Room Match Period -->
                    <div>
                        <label for="room_match_period" class="block text-sm font-medium text-gray-700 mb-2">
                            Periode
                        </label>
                        <select
                            name="room_match_period"
                            id="room_match_period"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white"
                        >
                            <option value="">Pilih Periode</option>
                            <option value="1 bulan" {{ old('room_match_period') == '1 bulan' ? 'selected' : '' }}>Per Bulan</option>
                            <option value="3 bulan" {{ old('room_match_period') == '3 bulan' ? 'selected' : '' }}>Per 3 Bulan</option>
                            <option value="6 bulan" {{ old('room_match_period') == '6 bulan' ? 'selected' : '' }}>Per 6 Bulan</option>
                            <option value="1 tahun" {{ old('room_match_period') == '1 tahun' ? 'selected' : '' }}>Per Tahun</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('owner.kost.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                Batal
            </a>
            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Kos
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Default coordinates (Indonesia - Jakarta)
    const defaultLat = -6.200000;
    const defaultLng = 106.816666;

    // Initialize map
    const map = L.map('map').setView([defaultLat, defaultLng], 13);

    // Add tile layer (OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Create marker
    let marker = null;

    // Function to update marker and inputs
    function updateLocation(lat, lng) {
        // Update inputs
        document.getElementById('latitude').value = lat.toFixed(8);
        document.getElementById('longitude').value = lng.toFixed(8);

        // Update or create marker
        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng], {
                draggable: true
            }).addTo(map);

            // Update coordinates when marker is dragged
            marker.on('dragend', function(e) {
                const position = marker.getLatLng();
                updateLocation(position.lat, position.lng);
            });
        }

        // Center map on marker
        map.setView([lat, lng], 16);
    }

    // Click on map to set location
    map.on('click', function(e) {
        updateLocation(e.latlng.lat, e.latlng.lng);
    });

    // Get current location button
    document.getElementById('getCurrentLocation').addEventListener('click', function() {
        if (navigator.geolocation) {
            this.innerHTML = '<svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Mencari...';

            navigator.geolocation.getCurrentPosition(
                function(position) {
                    updateLocation(position.coords.latitude, position.coords.longitude);
                    document.getElementById('getCurrentLocation').innerHTML = '<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg> Gunakan Lokasi Saya';
                },
                function(error) {
                    alert('Tidak dapat mengakses lokasi Anda. Pastikan GPS aktif.');
                    document.getElementById('getCurrentLocation').innerHTML = '<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg> Gunakan Lokasi Saya';
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        } else {
            alert('Browser Anda tidak mendukung Geolocation');
        }
    });

    // Search box functionality
    let searchTimeout;
    document.getElementById('searchBox').addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        const query = e.target.value;

        if (query.length < 3) return;

        searchTimeout = setTimeout(function() {
            // Using Nominatim (OpenStreetMap) for geocoding
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&countrycodes=id&limit=1`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        const result = data[0];
                        updateLocation(parseFloat(result.lat), parseFloat(result.lon));
                    }
                })
                .catch(error => console.error('Search error:', error));
        }, 500);
    });

    // If old values exist, set marker
    const oldLat = "{{ old('latitude') }}";
    const oldLng = "{{ old('longitude') }}";
    if (oldLat && oldLng) {
        updateLocation(parseFloat(oldLat), parseFloat(oldLng));
    }

    // Manual coordinate input - update marker when user types coordinates
    function updateMapFromInputs() {
        const lat = parseFloat(document.getElementById('latitude').value);
        const lng = parseFloat(document.getElementById('longitude').value);

        if (!isNaN(lat) && !isNaN(lng) && lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180) {
            if (marker) {
                marker.setLatLng([lat, lng]);
            } else {
                marker = L.marker([lat, lng], { draggable: true }).addTo(map);
                marker.on('dragend', function(e) {
                    const position = marker.getLatLng();
                    document.getElementById('latitude').value = position.lat.toFixed(8);
                    document.getElementById('longitude').value = position.lng.toFixed(8);
                });
            }
            map.setView([lat, lng], 16);
        }
    }

    document.getElementById('latitude').addEventListener('change', updateMapFromInputs);
    document.getElementById('longitude').addEventListener('change', updateMapFromInputs);
});
</script>
@endpush
