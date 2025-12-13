<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - TriniStay</title>
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
                    <span class="text-white text-sm">{{ Auth::user()->name }} (Super Admin)</span>
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
        <div class="bg-white rounded-xl shadow-sm p-8">
            <h1 class="text-2xl font-bold text-navy mb-4">Dashboard Super Admin</h1>
            <p class="text-gray-600">Selamat datang, {{ Auth::user()->name }}!</p>
            <p class="text-gray-500 mt-2">Anda login sebagai <span class="font-semibold text-navy">Super Admin</span>.</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                <div class="bg-blue-50 rounded-lg p-6">
                    <h3 class="font-semibold text-blue-900">Total Pengguna</h3>
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ \App\Models\User::count() }}</p>
                </div>
                <div class="bg-green-50 rounded-lg p-6">
                    <h3 class="font-semibold text-green-900">Total Pemilik</h3>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ \App\Models\User::where('role', 'owner')->count() }}</p>
                </div>
                <div class="bg-purple-50 rounded-lg p-6">
                    <h3 class="font-semibold text-purple-900">Total Penyewa</h3>
                    <p class="text-3xl font-bold text-purple-600 mt-2">{{ \App\Models\User::where('role', 'renter')->count() }}</p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
