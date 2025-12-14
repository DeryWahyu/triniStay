<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Preferensi Room Match - TriniStay</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-40 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('renter.dashboard') }}" class="flex items-center space-x-2">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="#1F2937" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 22V12H15V22" stroke="#1F2937" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="text-xl font-bold text-navy">TriniStay</span>
                </a>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('renter.dashboard') }}" class="text-gray-600 hover:text-navy transition-colors">Beranda</a>
                    <a href="{{ route('renter.kos.search') }}" class="text-gray-600 hover:text-navy transition-colors">Cari Kos</a>
                    <a href="{{ route('renter.room-match.index') }}" class="text-navy font-medium">Cari Teman</a>
                    <a href="#" class="text-gray-600 hover:text-navy transition-colors">Pemesanan</a>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                            <div class="w-10 h-10 bg-gradient-to-br from-[#19608E] to-[#162D40] rounded-full flex items-center justify-center shadow-md">
                                <span class="text-white font-semibold text-sm">{{ Auth::user()->initials }}</span>
                            </div>
                            <span class="hidden sm:block text-navy font-medium">{{ Auth::user()->name }}</span>
                        </button>
                        <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 z-50 border border-gray-100">
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">Profil Saya</a>
                            <hr class="my-2">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 p-8 mb-8">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.08\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
            <div class="relative z-10 text-center">
                <div class="w-16 h-16 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Edit Preferensi Room Match ✏️</h1>
                <p class="text-blue-100">Perbarui preferensi Anda untuk menemukan teman sekamar yang lebih cocok</p>
            </div>
        </div>

        <form action="{{ route('renter.room-match.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Kebiasaan Tidur -->
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-indigo-600 to-blue-600 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        🌙 Kebiasaan Tidur
                    </h2>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Sleep Lamp Off -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <p class="font-medium text-gray-900">Apakah Anda suka tidur dengan lampu mati?</p>
                            <p class="text-sm text-gray-500">Preferensi pencahayaan saat tidur</p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-green-500 hover:bg-green-50 transition-colors has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                <input type="radio" name="sleep_lamp_off" value="1" class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500" {{ $preference->sleep_lamp_off == 1 ? 'checked' : '' }} required>
                                <span class="ml-2 text-gray-700">Ya</span>
                            </label>
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-red-500 hover:bg-red-50 transition-colors has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
                                <input type="radio" name="sleep_lamp_off" value="0" class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500" {{ $preference->sleep_lamp_off == 0 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Tidak</span>
                            </label>
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-amber-500 hover:bg-amber-50 transition-colors has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50">
                                <input type="radio" name="sleep_lamp_off" value="2" class="w-4 h-4 text-amber-600 border-gray-300 focus:ring-amber-500" {{ $preference->sleep_lamp_off == 2 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Kadang</span>
                            </label>
                        </div>
                    </div>

                    <!-- Sleep Late -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-4 border-t">
                        <div>
                            <p class="font-medium text-gray-900">Apakah Anda sering tidur larut malam?</p>
                            <p class="text-sm text-gray-500">Biasanya tidur setelah jam 12 malam</p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-green-500 hover:bg-green-50 transition-colors has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                <input type="radio" name="sleep_late" value="1" class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500" {{ $preference->sleep_late == 1 ? 'checked' : '' }} required>
                                <span class="ml-2 text-gray-700">Ya</span>
                            </label>
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-red-500 hover:bg-red-50 transition-colors has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
                                <input type="radio" name="sleep_late" value="0" class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500" {{ $preference->sleep_late == 0 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Tidak</span>
                            </label>
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-amber-500 hover:bg-amber-50 transition-colors has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50">
                                <input type="radio" name="sleep_late" value="2" class="w-4 h-4 text-amber-600 border-gray-300 focus:ring-amber-500" {{ $preference->sleep_late == 2 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Kadang</span>
                            </label>
                        </div>
                    </div>

                    <!-- Sleep Noise Tolerant -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-4 border-t">
                        <div>
                            <p class="font-medium text-gray-900">Apakah Anda toleran terhadap suara saat tidur?</p>
                            <p class="text-sm text-gray-500">Tidak mudah terganggu oleh suara</p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-green-500 hover:bg-green-50 transition-colors has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                <input type="radio" name="sleep_noise_tolerant" value="1" class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500" {{ $preference->sleep_noise_tolerant == 1 ? 'checked' : '' }} required>
                                <span class="ml-2 text-gray-700">Ya</span>
                            </label>
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-red-500 hover:bg-red-50 transition-colors has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
                                <input type="radio" name="sleep_noise_tolerant" value="0" class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500" {{ $preference->sleep_noise_tolerant == 0 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Tidak</span>
                            </label>
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-amber-500 hover:bg-amber-50 transition-colors has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50">
                                <input type="radio" name="sleep_noise_tolerant" value="2" class="w-4 h-4 text-amber-600 border-gray-300 focus:ring-amber-500" {{ $preference->sleep_noise_tolerant == 2 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Kadang</span>
                            </label>
                        </div>
                    </div>

                    <!-- Sleep Snore -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-4 border-t">
                        <div>
                            <p class="font-medium text-gray-900">Apakah Anda mendengkur saat tidur?</p>
                            <p class="text-sm text-gray-500">Informasi ini membantu menemukan teman yang cocok</p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-green-500 hover:bg-green-50 transition-colors has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                <input type="radio" name="sleep_snore" value="1" class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500" {{ $preference->sleep_snore == 1 ? 'checked' : '' }} required>
                                <span class="ml-2 text-gray-700">Ya</span>
                            </label>
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-red-500 hover:bg-red-50 transition-colors has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
                                <input type="radio" name="sleep_snore" value="0" class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500" {{ $preference->sleep_snore == 0 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Tidak</span>
                            </label>
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-amber-500 hover:bg-amber-50 transition-colors has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50">
                                <input type="radio" name="sleep_snore" value="2" class="w-4 h-4 text-amber-600 border-gray-300 focus:ring-amber-500" {{ $preference->sleep_snore == 2 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Kadang</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kebersihan -->
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-teal-600 to-emerald-600 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                        ✨ Kebersihan
                    </h2>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Clean Daily -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <p class="font-medium text-gray-900">Apakah Anda merapikan barang setiap hari?</p>
                            <p class="text-sm text-gray-500">Kebiasaan menjaga kerapian kamar</p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-green-500 hover:bg-green-50 transition-colors has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                <input type="radio" name="clean_daily" value="1" class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500" {{ $preference->clean_daily == 1 ? 'checked' : '' }} required>
                                <span class="ml-2 text-gray-700">Ya</span>
                            </label>
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-red-500 hover:bg-red-50 transition-colors has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
                                <input type="radio" name="clean_daily" value="0" class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500" {{ $preference->clean_daily == 0 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Tidak</span>
                            </label>
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-amber-500 hover:bg-amber-50 transition-colors has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50">
                                <input type="radio" name="clean_daily" value="2" class="w-4 h-4 text-amber-600 border-gray-300 focus:ring-amber-500" {{ $preference->clean_daily == 2 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Kadang</span>
                            </label>
                        </div>
                    </div>

                    <!-- Clean Tolerance -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-4 border-t">
                        <div>
                            <p class="font-medium text-gray-900">Apakah Anda toleran dengan keadaan berantakan?</p>
                            <p class="text-sm text-gray-500">Tidak masalah jika kamar sedikit berantakan</p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-green-500 hover:bg-green-50 transition-colors has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                <input type="radio" name="clean_tolerance" value="1" class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500" {{ $preference->clean_tolerance == 1 ? 'checked' : '' }} required>
                                <span class="ml-2 text-gray-700">Ya</span>
                            </label>
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-red-500 hover:bg-red-50 transition-colors has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
                                <input type="radio" name="clean_tolerance" value="0" class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500" {{ $preference->clean_tolerance == 0 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Tidak</span>
                            </label>
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-amber-500 hover:bg-amber-50 transition-colors has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50">
                                <input type="radio" name="clean_tolerance" value="2" class="w-4 h-4 text-amber-600 border-gray-300 focus:ring-amber-500" {{ $preference->clean_tolerance == 2 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Kadang</span>
                            </label>
                        </div>
                    </div>

                    <!-- Clean Self Wash -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-4 border-t">
                        <div>
                            <p class="font-medium text-gray-900">Apakah Anda mencuci alat makan sendiri?</p>
                            <p class="text-sm text-gray-500">Langsung mencuci setelah makan</p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-green-500 hover:bg-green-50 transition-colors has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                <input type="radio" name="clean_self_wash" value="1" class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500" {{ $preference->clean_self_wash == 1 ? 'checked' : '' }} required>
                                <span class="ml-2 text-gray-700">Ya</span>
                            </label>
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-red-500 hover:bg-red-50 transition-colors has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
                                <input type="radio" name="clean_self_wash" value="0" class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500" {{ $preference->clean_self_wash == 0 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Tidak</span>
                            </label>
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-amber-500 hover:bg-amber-50 transition-colors has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50">
                                <input type="radio" name="clean_self_wash" value="2" class="w-4 h-4 text-amber-600 border-gray-300 focus:ring-amber-500" {{ $preference->clean_self_wash == 2 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Kadang</span>
                            </label>
                        </div>
                    </div>

                    <!-- Clean Shared Duty -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-4 border-t">
                        <div>
                            <p class="font-medium text-gray-900">Bersedia berbagi tugas kebersihan?</p>
                            <p class="text-sm text-gray-500">Membagi jadwal bersih-bersih dengan teman sekamar</p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-green-500 hover:bg-green-50 transition-colors has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                <input type="radio" name="clean_shared_duty" value="1" class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500" {{ $preference->clean_shared_duty == 1 ? 'checked' : '' }} required>
                                <span class="ml-2 text-gray-700">Ya</span>
                            </label>
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-red-500 hover:bg-red-50 transition-colors has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
                                <input type="radio" name="clean_shared_duty" value="0" class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500" {{ $preference->clean_shared_duty == 0 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Tidak</span>
                            </label>
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-amber-500 hover:bg-amber-50 transition-colors has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50">
                                <input type="radio" name="clean_shared_duty" value="2" class="w-4 h-4 text-amber-600 border-gray-300 focus:ring-amber-500" {{ $preference->clean_shared_duty == 2 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Kadang</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kebiasaan Belajar/Kerja -->
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        📚 Kebiasaan Belajar/Kerja
                    </h2>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Study Late -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <p class="font-medium text-gray-900">Apakah Anda sering belajar/kerja larut malam?</p>
                            <p class="text-sm text-gray-500">Aktivitas setelah jam 10 malam</p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-green-500 hover:bg-green-50 transition-colors has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                <input type="radio" name="study_late" value="1" class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500" {{ $preference->study_late == 1 ? 'checked' : '' }} required>
                                <span class="ml-2 text-gray-700">Ya</span>
                            </label>
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-red-500 hover:bg-red-50 transition-colors has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
                                <input type="radio" name="study_late" value="0" class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500" {{ $preference->study_late == 0 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Tidak</span>
                            </label>
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-amber-500 hover:bg-amber-50 transition-colors has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50">
                                <input type="radio" name="study_late" value="2" class="w-4 h-4 text-amber-600 border-gray-300 focus:ring-amber-500" {{ $preference->study_late == 2 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Kadang</span>
                            </label>
                        </div>
                    </div>

                    <!-- Study Quiet Needed -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-4 border-t">
                        <div>
                            <p class="font-medium text-gray-900">Apakah Anda membutuhkan suasana hening saat belajar?</p>
                            <p class="text-sm text-gray-500">Preferensi lingkungan belajar</p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-green-500 hover:bg-green-50 transition-colors has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                <input type="radio" name="study_quiet_needed" value="1" class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500" {{ $preference->study_quiet_needed == 1 ? 'checked' : '' }} required>
                                <span class="ml-2 text-gray-700">Ya</span>
                            </label>
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-red-500 hover:bg-red-50 transition-colors has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
                                <input type="radio" name="study_quiet_needed" value="0" class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500" {{ $preference->study_quiet_needed == 0 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Tidak</span>
                            </label>
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-amber-500 hover:bg-amber-50 transition-colors has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50">
                                <input type="radio" name="study_quiet_needed" value="2" class="w-4 h-4 text-amber-600 border-gray-300 focus:ring-amber-500" {{ $preference->study_quiet_needed == 2 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Kadang</span>
                            </label>
                        </div>
                    </div>

                    <!-- Study Music -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-4 border-t">
                        <div>
                            <p class="font-medium text-gray-900">Apakah Anda suka mendengarkan musik saat belajar?</p>
                            <p class="text-sm text-gray-500">Menggunakan speaker atau headphone</p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-green-500 hover:bg-green-50 transition-colors has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                <input type="radio" name="study_music" value="1" class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500" {{ $preference->study_music == 1 ? 'checked' : '' }} required>
                                <span class="ml-2 text-gray-700">Ya</span>
                            </label>
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-red-500 hover:bg-red-50 transition-colors has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
                                <input type="radio" name="study_music" value="0" class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500" {{ $preference->study_music == 0 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Tidak</span>
                            </label>
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-amber-500 hover:bg-amber-50 transition-colors has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50">
                                <input type="radio" name="study_music" value="2" class="w-4 h-4 text-amber-600 border-gray-300 focus:ring-amber-500" {{ $preference->study_music == 2 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Kadang</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sosial -->
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        🎉 Sosial
                    </h2>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Guest Welcome -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <p class="font-medium text-gray-900">Apakah Anda menerima tamu di kamar?</p>
                            <p class="text-sm text-gray-500">Teman atau keluarga berkunjung</p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-green-500 hover:bg-green-50 transition-colors has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                <input type="radio" name="guest_welcome" value="1" class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500" {{ $preference->guest_welcome == 1 ? 'checked' : '' }} required>
                                <span class="ml-2 text-gray-700">Ya</span>
                            </label>
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-red-500 hover:bg-red-50 transition-colors has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
                                <input type="radio" name="guest_welcome" value="0" class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500" {{ $preference->guest_welcome == 0 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Tidak</span>
                            </label>
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-amber-500 hover:bg-amber-50 transition-colors has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50">
                                <input type="radio" name="guest_welcome" value="2" class="w-4 h-4 text-amber-600 border-gray-300 focus:ring-amber-500" {{ $preference->guest_welcome == 2 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Kadang</span>
                            </label>
                        </div>
                    </div>

                    <!-- Introvert -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-4 border-t">
                        <div>
                            <p class="font-medium text-gray-900">Apakah Anda lebih suka menyendiri?</p>
                            <p class="text-sm text-gray-500">Tipe introvert atau ekstrovert</p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-green-500 hover:bg-green-50 transition-colors has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                <input type="radio" name="introvert" value="1" class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500" {{ $preference->introvert == 1 ? 'checked' : '' }} required>
                                <span class="ml-2 text-gray-700">Ya</span>
                            </label>
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-red-500 hover:bg-red-50 transition-colors has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
                                <input type="radio" name="introvert" value="0" class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500" {{ $preference->introvert == 0 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Tidak</span>
                            </label>
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-amber-500 hover:bg-amber-50 transition-colors has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50">
                                <input type="radio" name="introvert" value="2" class="w-4 h-4 text-amber-600 border-gray-300 focus:ring-amber-500" {{ $preference->introvert == 2 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Kadang</span>
                            </label>
                        </div>
                    </div>

                    <!-- Smoking -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-4 border-t">
                        <div>
                            <p class="font-medium text-gray-900">Apakah Anda merokok?</p>
                            <p class="text-sm text-gray-500">Kebiasaan merokok</p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-green-500 hover:bg-green-50 transition-colors has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                <input type="radio" name="smoking" value="1" class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500" {{ $preference->smoking == 1 ? 'checked' : '' }} required>
                                <span class="ml-2 text-gray-700">Ya</span>
                            </label>
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-red-500 hover:bg-red-50 transition-colors has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
                                <input type="radio" name="smoking" value="0" class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500" {{ $preference->smoking == 0 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Tidak</span>
                            </label>
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-amber-500 hover:bg-amber-50 transition-colors has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50">
                                <input type="radio" name="smoking" value="2" class="w-4 h-4 text-amber-600 border-gray-300 focus:ring-amber-500" {{ $preference->smoking == 2 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Kadang</span>
                            </label>
                        </div>
                    </div>

                    <!-- Pet Friendly -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-4 border-t">
                        <div>
                            <p class="font-medium text-gray-900">Apakah Anda suka hewan peliharaan?</p>
                            <p class="text-sm text-gray-500">Tidak keberatan dengan hewan di sekitar</p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-green-500 hover:bg-green-50 transition-colors has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                <input type="radio" name="pet_friendly" value="1" class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500" {{ $preference->pet_friendly == 1 ? 'checked' : '' }} required>
                                <span class="ml-2 text-gray-700">Ya</span>
                            </label>
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-red-500 hover:bg-red-50 transition-colors has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
                                <input type="radio" name="pet_friendly" value="0" class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500" {{ $preference->pet_friendly == 0 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Tidak</span>
                            </label>
                            <label class="flex items-center px-3 py-1.5 border border-gray-200 rounded-lg cursor-pointer hover:border-amber-500 hover:bg-amber-50 transition-colors has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50">
                                <input type="radio" name="pet_friendly" value="2" class="w-4 h-4 text-amber-600 border-gray-300 focus:ring-amber-500" {{ $preference->pet_friendly == 2 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Kadang</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tentang Saya & Kontak -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="bg-navy px-6 py-4">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Tentang Saya
                    </h2>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Description -->
                    <div>
                        <label for="description" class="block font-medium text-gray-900 mb-2">Ceritakan tentang diri Anda</label>
                        <textarea
                            name="description"
                            id="description"
                            rows="4"
                            maxlength="500"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                            placeholder="Contoh: Saya mahasiswa semester 4 jurusan Informatika. Suka bermain game dan nonton film di waktu luang..."
                        >{{ $preference->description }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Maksimal 500 karakter</p>
                    </div>

                    <!-- Contact Preference -->
                    <div class="pt-4 border-t">
                        <label class="block font-medium text-gray-900 mb-3">Preferensi Kontak</label>
                        <div class="flex flex-wrap gap-4">
                            <label class="flex items-center px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition-colors">
                                <input type="radio" name="contact_preference" value="whatsapp" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" {{ ($preference->contact_preference ?? 'whatsapp') === 'whatsapp' ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">WhatsApp</span>
                            </label>
                            <label class="flex items-center px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition-colors">
                                <input type="radio" name="contact_preference" value="email" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" {{ ($preference->contact_preference ?? '') === 'email' ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Email</span>
                            </label>
                            <label class="flex items-center px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition-colors">
                                <input type="radio" name="contact_preference" value="phone" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" {{ ($preference->contact_preference ?? '') === 'phone' ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Telepon</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-4">
                <a href="{{ route('renter.room-match.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-blue-700 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                    ✨ Simpan Perubahan
                </button>
            </div>
        </form>
    </main>

    <!-- Footer -->
    <footer class="bg-navy py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-gray-400 text-sm">© {{ date('Y') }} TriniStay. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
