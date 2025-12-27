<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Owner Panel') - TriniStay</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        'navy': {
                            800: '#1e3a5f',
                            900: '#1F2937',
                            950: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #1F2937;
        }

        ::-webkit-scrollbar-thumb {
            background: #4B5563;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #6B7280;
        }

        /* Sidebar transition */
        .sidebar-transition {
            transition: width 0.3s ease-in-out;
        }

        .content-transition {
            transition: margin-left 0.3s ease-in-out;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-100 font-poppins" x-data="{ sidebarOpen: true, mobileMenuOpen: false }">
    <div class="min-h-screen flex">

        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-50 bg-navy-900 text-white sidebar-transition overflow-hidden"
            :class="sidebarOpen ? 'w-64' : 'w-20'"
        >
            <!-- Logo Section -->
            <div class="flex items-center justify-between h-16 px-4 border-b border-gray-700">
                <a href="{{ route('owner.dashboard') }}" class="flex items-center space-x-3">
                    <svg class="w-8 h-8 text-white flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="text-xl font-bold whitespace-nowrap" x-show="sidebarOpen" x-transition>TriniStay</span>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="mt-6 px-3">
                <ul class="space-y-2">
                    <!-- Beranda -->
                    <li>
                        <a href="{{ route('owner.dashboard') }}"
                           class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200
                                  {{ request()->routeIs('owner.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span class="ml-3 whitespace-nowrap" x-show="sidebarOpen" x-transition>Beranda</span>
                        </a>
                    </li>

                    <!-- Kelola Kos -->
                    <li>
                        <a href="{{ route('owner.kost.index') }}"
                           class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200
                                  {{ request()->routeIs('owner.kost.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <span class="ml-3 whitespace-nowrap" x-show="sidebarOpen" x-transition>Kelola Kos</span>
                        </a>
                    </li>

                    <!-- Pemesanan -->
                    <li>
                        <a href="{{ route('owner.bookings.index') }}"
                           class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200
                                  {{ request()->routeIs('owner.bookings.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="ml-3 whitespace-nowrap" x-show="sidebarOpen" x-transition>Pemesanan</span>
                        </a>
                    </li>


                    <!-- Profil & Pengaturan -->
                    <li>
                        <a href="{{ route('owner.profile.index') }}"
                           class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200
                                  {{ request()->routeIs('owner.profile.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="ml-3 whitespace-nowrap" x-show="sidebarOpen" x-transition>Pengaturan</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Toggle Button -->
            <div class="absolute bottom-4 left-0 right-0 px-3">
                <button
                    @click="sidebarOpen = !sidebarOpen"
                    class="w-full flex items-center justify-center px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg transition-colors duration-200"
                >
                    <svg x-show="sidebarOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                    </svg>
                    <svg x-show="!sidebarOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 content-transition" :class="sidebarOpen ? 'ml-64' : 'ml-20'">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-40">
                <div class="flex items-center justify-between px-6 py-4">
                    <!-- Page Title -->
                    <div>
                        <h1 class="text-xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                    </div>

                    <!-- Right Section -->
                    <div class="flex items-center space-x-4">
                        <!-- User Info -->
                        <div class="flex items-center space-x-3">
                            <div class="text-right hidden sm:block">
                                <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">Owner</p>
                            </div>
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center shadow-md">
                                <span class="text-white font-semibold text-sm">{{ Auth::user()->initials }}</span>
                            </div>
                        </div>

                        <!-- Logout Button -->
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="flex items-center px-4 py-2 text-sm text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <span class="hidden sm:inline">Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>


    <!-- Flash Message Data -->
    <script id="flash-messages" type="application/json">{!! json_encode([
        'success' => session('success'),
        'info' => session('info'),
        'error' => session('error'),
        'warning' => session('warning')
    ]) !!}</script>

    <!-- SweetAlert2 Notifications -->
    <script>
        // Toast configuration
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: function(toast) {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        // Flash message notifications
        (function() {
            var flashData = JSON.parse(document.getElementById('flash-messages').textContent);
            
            if (flashData.success) {
                Toast.fire({ icon: 'success', title: flashData.success });
            }
            if (flashData.info) {
                Toast.fire({ icon: 'info', title: flashData.info });
            }
            if (flashData.error) {
                Toast.fire({ icon: 'error', title: flashData.error });
            }
            if (flashData.warning) {
                Toast.fire({ icon: 'warning', title: flashData.warning });
            }
        })();

        // Delete confirmation function
        function confirmDelete(formId, itemName = 'item ini') {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Data ${itemName} akan dihapus secara permanen!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }

        // Delete confirmation with callback
        function confirmDeleteWithCallback(callback, itemName = 'item ini') {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Data ${itemName} akan dihapus secara permanen!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    callback();
                }
            });
        }

        // Success alert (for custom use)
        function showSuccess(title, message = '') {
            Swal.fire({
                icon: 'success',
                title: title,
                text: message,
                confirmButtonColor: '#3B82F6'
            });
        }

        // Error alert (for custom use)
        function showError(title, message = '') {
            Swal.fire({
                icon: 'error',
                title: title,
                text: message,
                confirmButtonColor: '#EF4444'
            });
        }

        // Info alert (for custom use)
        function showInfo(title, message = '') {
            Swal.fire({
                icon: 'info',
                title: title,
                text: message,
                confirmButtonColor: '#3B82F6'
            });
        }

        // Confirm action (generic)
        function confirmAction(title, text, callback, confirmText = 'Ya, Lanjutkan!') {
            Swal.fire({
                title: title,
                text: text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3B82F6',
                cancelButtonColor: '#6B7280',
                confirmButtonText: confirmText,
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    callback();
                }
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
