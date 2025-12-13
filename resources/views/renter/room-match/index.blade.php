<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Teman Sekamar - TriniStay</title>
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
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }
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
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center shadow-md">
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
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Hero Header -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 p-8 md:p-12 mb-8">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.08\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-3">Temukan Teman Sekamar Ideal 🏠</h1>
                    <p class="text-blue-100 text-lg max-w-xl">Cocokkan preferensi Anda dengan calon teman sekamar untuk pengalaman tinggal yang nyaman</p>
                </div>
                <a href="{{ route('renter.room-match.edit') }}" class="inline-flex items-center px-6 py-3 bg-white text-indigo-600 font-semibold rounded-xl hover:bg-blue-50 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Edit Preferensi
                </a>
            </div>
        </div>

        <!-- My Profile Card -->
        @if(Auth::user()->roommatePreference)
        <div class="glass-card rounded-2xl p-6 mb-8 border border-white/50 shadow-xl">
            <div class="flex flex-col md:flex-row md:items-center gap-6">
                <!-- Avatar & Basic Info -->
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <div class="w-20 h-20 {{ Auth::user()->gender == 'Male' ? 'bg-gradient-to-br from-blue-400 to-blue-600' : 'bg-gradient-to-br from-pink-400 to-pink-600' }} rounded-2xl flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-2xl">{{ Auth::user()->initials }}</span>
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-navy">{{ Auth::user()->name }}</h2>
                        <div class="flex items-center flex-wrap gap-x-3 gap-y-1 mt-1">
                            @if(Auth::user()->gender)
                            <span class="inline-flex items-center text-sm {{ Auth::user()->gender == 'Male' ? 'text-blue-600' : 'text-pink-600' }} font-medium">
                                @if(Auth::user()->gender == 'Male')
                                <svg class="w-4 h-4 mr-1" viewBox="0 0 24 24" fill="currentColor"><path d="M9.5 11c1.93 0 3.5 1.57 3.5 3.5S11.43 18 9.5 18 6 16.43 6 14.5 7.57 11 9.5 11zm0-2C6.46 9 4 11.46 4 14.5S6.46 20 9.5 20s5.5-2.46 5.5-5.5c0-1.16-.36-2.24-.97-3.12L18 7.42V10h2V4h-6v2h2.58l-3.97 3.97C11.73 9.36 10.65 9 9.5 9z"/></svg>
                                @else
                                <svg class="w-4 h-4 mr-1" viewBox="0 0 24 24" fill="currentColor"><path d="M12 4c-2.76 0-5 2.24-5 5 0 2.42 1.72 4.44 4 4.9V16H9v2h2v2h2v-2h2v-2h-2v-2.1c2.28-.46 4-2.48 4-4.9 0-2.76-2.24-5-5-5zm0 2c1.65 0 3 1.35 3 3s-1.35 3-3 3-3-1.35-3-3 1.35-3 3-3z"/></svg>
                                @endif
                                {{ Auth::user()->gender == 'Male' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                            @endif
                            @if(Auth::user()->age)
                            <span class="text-gray-400">•</span>
                            <span class="text-sm text-gray-600 font-medium">{{ Auth::user()->age }} tahun</span>
                            @endif
                            @if(Auth::user()->phone_number)
                            <span class="text-gray-400">•</span>
                            <span class="inline-flex items-center text-sm text-gray-600 font-medium">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                {{ Auth::user()->phone_number }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Preference Tags -->
                <div class="flex-1">
                    <p class="text-sm text-gray-500 mb-2">Preferensi Anda:</p>
                    <div class="flex flex-wrap gap-2">
                        @if(Auth::user()->roommatePreference->sleep_lamp_off)
                            <span class="px-3 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-xs font-medium">🌙 Lampu Mati</span>
                        @endif
                        @if(Auth::user()->roommatePreference->clean_daily)
                            <span class="px-3 py-1.5 bg-teal-100 text-teal-700 rounded-full text-xs font-medium">✨ Rapi Harian</span>
                        @endif
                        @if(!Auth::user()->roommatePreference->smoking)
                            <span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-xs font-medium">🚭 Non-Perokok</span>
                        @else
                            <span class="px-3 py-1.5 bg-amber-100 text-amber-700 rounded-full text-xs font-medium">🚬 Perokok</span>
                        @endif
                        @if(Auth::user()->roommatePreference->introvert)
                            <span class="px-3 py-1.5 bg-purple-100 text-purple-700 rounded-full text-xs font-medium">🧘 Introvert</span>
                        @else
                            <span class="px-3 py-1.5 bg-orange-100 text-orange-700 rounded-full text-xs font-medium">🎉 Ekstrovert</span>
                        @endif
                        @if(Auth::user()->roommatePreference->pet_friendly)
                            <span class="px-3 py-1.5 bg-pink-100 text-pink-700 rounded-full text-xs font-medium">🐾 Suka Hewan</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-xl flex items-center shadow-sm">
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-4">
                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                {{ session('success') }}
            </div>
        @endif

        <!-- Results Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-xl font-bold text-navy">Calon Teman Sekamar</h2>
                <p class="text-gray-500">Ditemukan <span class="font-semibold text-indigo-600">{{ $matches->count() }}</span> pengguna yang cocok</p>
            </div>
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"/>
                </svg>
                <span>Kecocokan Tertinggi</span>
            </div>
        </div>

        <!-- Match Cards Grid -->
        @if($matches->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($matches as $match)
                    <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-indigo-200 transform hover:-translate-y-1">
                        <!-- Card Header with Match Ring -->
                        <div class="relative p-6 pb-4">
                            <!-- Match Percentage Circle -->
                            <div class="absolute top-4 right-4">
                                <div class="relative w-16 h-16">
                                    <svg class="w-16 h-16 transform -rotate-90">
                                        <circle cx="32" cy="32" r="28" stroke="#e5e7eb" stroke-width="4" fill="none"/>
                                        <circle cx="32" cy="32" r="28" 
                                            stroke="{{ $match['match_percentage'] >= 80 ? '#22c55e' : ($match['match_percentage'] >= 60 ? '#eab308' : ($match['match_percentage'] >= 40 ? '#f97316' : '#ef4444')) }}" 
                                            stroke-width="4" 
                                            fill="none"
                                            stroke-dasharray="{{ 2 * 3.14159 * 28 }}"
                                            stroke-dashoffset="{{ 2 * 3.14159 * 28 * (1 - $match['match_percentage'] / 100) }}"
                                            stroke-linecap="round"/>
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span class="text-sm font-bold {{ $match['match_percentage'] >= 80 ? 'text-green-600' : ($match['match_percentage'] >= 60 ? 'text-yellow-600' : ($match['match_percentage'] >= 40 ? 'text-orange-600' : 'text-red-600')) }}">{{ $match['match_percentage'] }}%</span>
                                    </div>
                                </div>
                            </div>

                            <!-- User Avatar & Info -->
                            <div class="flex items-start gap-4">
                                <div class="relative flex-shrink-0">
                                    <div class="w-16 h-16 {{ $match['user']->gender == 'Male' ? 'bg-gradient-to-br from-blue-400 to-blue-600' : 'bg-gradient-to-br from-pink-400 to-pink-600' }} rounded-2xl flex items-center justify-center shadow-md group-hover:shadow-lg transition-shadow">
                                        <span class="text-white font-bold text-xl">{{ $match['user']->initials }}</span>
                                    </div>
                                    <!-- Gender Badge -->
                                    <div class="absolute -bottom-1 -right-1 w-6 h-6 {{ $match['user']->gender == 'Male' ? 'bg-blue-500' : 'bg-pink-500' }} rounded-full border-2 border-white flex items-center justify-center">
                                        @if($match['user']->gender == 'Male')
                                        <svg class="w-3 h-3 text-white" viewBox="0 0 24 24" fill="currentColor"><path d="M9.5 11c1.93 0 3.5 1.57 3.5 3.5S11.43 18 9.5 18 6 16.43 6 14.5 7.57 11 9.5 11zm0-2C6.46 9 4 11.46 4 14.5S6.46 20 9.5 20s5.5-2.46 5.5-5.5c0-1.16-.36-2.24-.97-3.12L18 7.42V10h2V4h-6v2h2.58l-3.97 3.97C11.73 9.36 10.65 9 9.5 9z"/></svg>
                                        @else
                                        <svg class="w-3 h-3 text-white" viewBox="0 0 24 24" fill="currentColor"><path d="M12 4c-2.76 0-5 2.24-5 5 0 2.42 1.72 4.44 4 4.9V16H9v2h2v2h2v-2h2v-2h-2v-2.1c2.28-.46 4-2.48 4-4.9 0-2.76-2.24-5-5-5zm0 2c1.65 0 3 1.35 3 3s-1.35 3-3 3-3-1.35-3-3 1.35-3 3-3z"/></svg>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0 pr-16">
                                    <h3 class="font-bold text-navy text-lg truncate group-hover:text-indigo-600 transition-colors">{{ $match['user']->name }}</h3>
                                    <div class="flex items-center flex-wrap gap-x-2 gap-y-1 mt-1">
                                        <span class="text-sm {{ $match['user']->gender == 'Male' ? 'text-blue-600' : 'text-pink-600' }} font-medium">
                                            {{ $match['user']->gender == 'Male' ? 'Laki-laki' : 'Perempuan' }}
                                        </span>
                                        @if($match['user']->age)
                                        <span class="text-gray-300">•</span>
                                        <span class="text-sm text-gray-500">{{ $match['user']->age }} tahun</span>
                                        @endif
                                    </div>
                                    @if($match['user']->phone_number)
                                    <div class="flex items-center gap-1 mt-1 text-sm text-gray-500">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        <span>{{ $match['user']->phone_number }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="px-6">
                            @if($match['preference']->description)
                                <p class="text-gray-600 text-sm line-clamp-2 italic border-l-2 border-indigo-200 pl-3">
                                    "{{ Str::limit($match['preference']->description, 100) }}"
                                </p>
                            @else
                                <p class="text-gray-400 text-sm italic">Belum ada deskripsi</p>
                            @endif
                        </div>

                        <!-- Preference Tags -->
                        <div class="px-6 py-4">
                            <div class="flex flex-wrap gap-1.5">
                                @if(!$match['preference']->smoking)
                                    <span class="inline-flex items-center px-2 py-1 bg-green-50 text-green-700 rounded-lg text-xs font-medium">
                                        🚭 Non-Perokok
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 bg-amber-50 text-amber-700 rounded-lg text-xs font-medium">
                                        🚬 Perokok
                                    </span>
                                @endif
                                @if($match['preference']->introvert)
                                    <span class="inline-flex items-center px-2 py-1 bg-purple-50 text-purple-700 rounded-lg text-xs font-medium">
                                        🧘 Introvert
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 bg-orange-50 text-orange-700 rounded-lg text-xs font-medium">
                                        🎉 Ekstrovert
                                    </span>
                                @endif
                                @if($match['preference']->clean_daily)
                                    <span class="inline-flex items-center px-2 py-1 bg-teal-50 text-teal-700 rounded-lg text-xs font-medium">
                                        ✨ Rapi
                                    </span>
                                @endif
                                @if($match['preference']->sleep_lamp_off)
                                    <span class="inline-flex items-center px-2 py-1 bg-indigo-50 text-indigo-700 rounded-lg text-xs font-medium">
                                        🌙 Lampu Mati
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="px-6 pb-6">
                            <a href="{{ route('renter.room-match.show', $match['user']->id) }}" 
                               class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-blue-700 transition-all shadow-md hover:shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Lihat Profil
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-20 bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="w-24 h-24 bg-gradient-to-br from-indigo-100 to-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-navy mb-3">Belum Ada Teman Sekamar</h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">
                    Belum ada pengguna lain yang mengisi preferensi Room Match. Ajak teman-temanmu untuk mendaftar!
                </p>
                <a href="{{ route('renter.dashboard') }}" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-blue-700 transition-all shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-navy py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-gray-400 text-sm">© {{ date('Y') }} TriniStay. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
