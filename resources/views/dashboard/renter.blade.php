<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penyewa - TriniStay</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: '#1F2937',
                        'navy-light': '#374151',
                    },
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-navy shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-2">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 22V12H15V22" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="text-xl font-semibold text-white">TriniStay</span>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-white text-sm">{{ Auth::user()->name }} (Penyewa)</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm p-8">
            <h1 class="text-2xl font-bold text-navy mb-4">Dashboard Penyewa</h1>
            <p class="text-gray-600">Selamat datang, {{ Auth::user()->name }}!</p>
            <p class="text-gray-500 mt-2">Anda login sebagai <span class="font-semibold text-navy">Penyewa</span>.</p>

            <div class="mt-8 p-6 bg-purple-50 rounded-lg">
                <h3 class="font-semibold text-purple-900 mb-2">Informasi Akun</h3>
                <ul class="space-y-2 text-gray-700">
                    <li><span class="font-medium">Nama:</span> {{ Auth::user()->name }}</li>
                    <li><span class="font-medium">Email:</span> {{ Auth::user()->email }}</li>
                    <li><span class="font-medium">Telepon:</span> {{ Auth::user()->phone_number }}</li>
                    <li><span class="font-medium">Usia:</span> {{ Auth::user()->age }} tahun</li>
                    <li><span class="font-medium">Jenis Kelamin:</span> {{ Auth::user()->gender == 'Male' ? 'Laki-laki' : 'Perempuan' }}</li>
                    <li><span class="font-medium">Bergabung:</span> {{ Auth::user()->created_at->format('d M Y') }}</li>
                </ul>
            </div>

            <div class="mt-6 p-6 bg-yellow-50 rounded-lg border border-yellow-200">
                <h3 class="font-semibold text-yellow-800 mb-2">🚧 Fitur Dalam Pengembangan</h3>
                <p class="text-yellow-700 text-sm">Halaman pencarian kos, fitur Cari Teman, dan lainnya sedang dalam pengembangan.</p>
            </div>

            <div class="mt-6">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-navy font-medium hover:underline">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </main>
</body>
</html>
