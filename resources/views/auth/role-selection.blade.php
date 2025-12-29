<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Peran - TriniStay</title>
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
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50">
    <div class="flex min-h-screen">
        <!-- Left Side - Image -->
        <div class="hidden md:block md:w-1/2 relative">
            <img
                src="https://images.unsplash.com/photo-1616594039964-ae9021a400a0?w=1920&q=80"
                alt="Bedroom"
                class="w-full h-screen object-cover"
            >
            <div class="absolute inset-0 bg-navy/30"></div>
        </div>

        <!-- Right Side - Role Selection -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-8 md:p-12">
            <div class="w-full max-w-md">
                <!-- Logo -->
                <div class="flex items-center gap-2 mb-8">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="#3B82F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 22V12H15V22" stroke="#3B82F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="text-2xl font-semibold text-navy">TriniStay</span>
                </div>

                <!-- Title -->
                <h1 class="text-3xl font-bold text-navy mb-2">Daftar Akun Baru</h1>
                <p class="text-gray-500 mb-8">Pilih peran Anda untuk melanjutkan pendaftaran.</p>

                <!-- Role Cards -->
                <div class="space-y-4">
                    <!-- Owner Card -->
                    <a href="{{ route('register.owner') }}" class="block p-6 bg-white border-2 border-gray-200 rounded-xl hover:border-navy hover:shadow-lg transition-all duration-300 group">
                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition-colors">
                                <svg class="w-8 h-8 text-[#3B82F6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-navy mb-1">Pemilik Kos</h3>
                                <p class="text-gray-500 text-sm">Daftarkan dan kelola properti kos Anda. Terima penyewa dan pantau pembayaran dengan mudah.</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-navy group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>

                    <!-- Renter Card -->
                    <a href="{{ route('register.renter') }}" class="block p-6 bg-white border-2 border-gray-200 rounded-xl hover:border-navy hover:shadow-lg transition-all duration-300 group">
                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition-colors">
                                <svg class="w-8 h-8 text-[#3B82F6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-navy mb-1">Penyewa</h3>
                                <p class="text-gray-500 text-sm">Cari dan temukan kos impian Anda. Bandingkan harga dan fasilitas dengan mudah.</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-navy group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>
                </div>

                <!-- Login Link -->
                <p class="text-center text-gray-500 mt-8">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-navy font-semibold hover:underline">Masuk</a>
                </p>

                <!-- Back to Home -->
                <a href="{{ route('home') }}" class="flex items-center justify-center gap-2 text-gray-400 hover:text-navy mt-4 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</body>
</html>
