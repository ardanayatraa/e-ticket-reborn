<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
    <!-- Adds the Core Table Styles -->
    @rappasoftTableStyles

    <!-- Adds any relevant Third-Party Styles (Used for DateRangeFilter (Flatpickr) and NumberRangeFilter) -->
    @rappasoftTableThirdPartyStyles
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="bg-gray-800 text-white w-64 flex-shrink-0 hidden md:block">
            <div class="p-4 flex items-center border-b border-gray-700">
                <span class="font-bold text-xl">BALI OM TOURS</span>
            </div>
            <nav class="mt-4">
                <div class="px-4 py-2 text-gray-400 text-xs font-semibold">MENU UTAMA</div>

                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}"
                    class="flex items-center px-4 py-3 {{ request()->routeIs('dashboard') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white transition' }}">
                    <i class="fas fa-tachometer-alt w-6"></i>
                    <span class="ml-2">Dashboard</span>
                </a>
                @if (auth()->user()->type == 'admin')
                    {{-- Paket Wisata --}}
                    <a href="{{ route('admin.index') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('admin.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white transition' }}">
                        <i class="fas fa-circle-user w-6"></i>
                        <span class="ml-2">Admin</span>
                    </a>
                    {{-- Paket Wisata --}}
                    <a href="{{ route('paket-wisata.index') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('paket-wisata.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white transition' }}">
                        <i class="fas fa-suitcase w-6"></i>
                        <span class="ml-2">Paket Wisata</span>
                    </a>

                    {{-- Kendaraan (Mobil) --}}
                    <a href="{{ route('mobil.index') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('mobil.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white transition' }}">
                        <i class="fas fa-car w-6"></i>
                        <span class="ml-2">Kendaraan</span>
                    </a>

                    {{-- Sopir --}}
                    <a href="{{ route('sopir.index') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('sopir.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white transition' }}">
                        <i class="fas fa-user-tie w-6"></i>
                        <span class="ml-2">Sopir</span>
                    </a>

                    {{-- Pemesanan --}}
                    <a href="{{ route('pemesanan.index') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('pemesanan.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white transition' }}">
                        <i class="fas fa-calendar-check w-6"></i>
                        <span class="ml-2">Pemesanan</span>
                    </a>

                    {{-- Pelanggan --}}
                    <a href="{{ route('pelanggan.index') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('pelanggan.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white transition' }}">
                        <i class="fas fa-users w-6"></i>
                        <span class="ml-2">Pelanggan</span>
                    </a>

                    {{-- Ketersediaan --}}
                    <a href="{{ route('ketersediaan.index') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('ketersediaan.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white transition' }}">
                        <i class="fas fa-clock w-6"></i>
                        <span class="ml-2">List Booking</span>
                    </a>

                    {{-- Include --}}
                    {{-- <a href="{{ route('include.index') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('include.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white transition' }}">
                        <i class="fas fa-plus-square w-6"></i>
                        <span class="ml-2">Include</span>
                    </a> --}}

                    {{-- Exclude --}}
                    {{-- <a href="{{ route('exclude.index') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('exclude.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white transition' }}">
                        <i class="fas fa-minus-square w-6"></i>
                        <span class="ml-2">Exclude</span>
                    </a> --}}

                    {{-- Pembayaran (Transaksi) --}}
                    <a href="{{ route('transaksi.index') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('transaksi.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white transition' }}">
                        <i class="fas fa-file-invoice-dollar w-6"></i>
                        <span class="ml-2">Verifikasi Pembayaran</span>
                    </a>
                @endif
                {{-- Laporan Transaksi --}}
                <a href="{{ route('laporan') }}"
                    class="flex items-center px-4 py-3 {{ request()->routeIs('laporan') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white transition' }}">
                    <i class="fas fa-file-alt w-6"></i>
                    <span class="ml-2">Laporan</span>
                </a>

            </nav>
        </aside>


        <!-- Mobile Sidebar Toggle -->
        <div class="md:hidden fixed bottom-4 right-4 z-50">
            <button id="sidebarToggle" class="bg-teal-600 text-white p-3 rounded-full shadow-lg">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <!-- Mobile Sidebar -->
        <div id="mobileSidebar" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 hidden md:hidden">
            <div class="bg-gray-800 text-white w-64 h-full overflow-y-auto">
                <div class="p-4 flex items-center justify-between border-b border-gray-700">
                    <div class="flex items-center">
                        <i class="fas fa-mountain text-teal-400 text-2xl mr-2"></i>
                        <span class="font-bold text-xl">BALI OM TOURS</span>
                    </div>
                    <button id="closeSidebar" class="text-white">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <nav class="mt-4">
                    {{-- Dashboard --}}
                    <a href="{{ route('admin.index') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('admin.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white transition' }}">
                        <i class="fas fa-tachometer-alt w-6"></i>
                        <span class="ml-2">Dashboard</span>
                    </a>

                    {{-- Paket Wisata --}}
                    <a href="{{ route('admin.index') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('admin.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white transition' }}">
                        <i class="fas fa-circle-user w-6"></i>
                        <span class="ml-2">Admin</span>
                    </a>

                    {{-- Paket Wisata --}}
                    <a href="{{ route('paket-wisata.index') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('paket-wisata.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white transition' }}">
                        <i class="fas fa-suitcase w-6"></i>
                        <span class="ml-2">Paket Wisata</span>
                    </a>

                    {{-- Kendaraan (Mobil) --}}
                    <a href="{{ route('mobil.index') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('mobil.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white transition' }}">
                        <i class="fas fa-car w-6"></i>
                        <span class="ml-2">Kendaraan</span>
                    </a>

                    {{-- Sopir --}}
                    <a href="{{ route('sopir.index') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('sopir.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white transition' }}">
                        <i class="fas fa-user-tie w-6"></i>
                        <span class="ml-2">Sopir</span>
                    </a>

                    {{-- Pemesanan --}}
                    <a href="{{ route('pemesanan.index') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('pemesanan.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white transition' }}">
                        <i class="fas fa-calendar-check w-6"></i>
                        <span class="ml-2">Pemesanan</span>
                    </a>

                    {{-- Pelanggan --}}
                    <a href="{{ route('pelanggan.index') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('pelanggan.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white transition' }}">
                        <i class="fas fa-users w-6"></i>
                        <span class="ml-2">Pelanggan</span>
                    </a>

                    {{-- Ketersediaan --}}
                    <a href="{{ route('ketersediaan.index') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('ketersediaan.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white transition' }}">
                        <i class="fas fa-clock w-6"></i>
                        <span class="ml-2">List Booking</span>
                    </a>

                    {{-- Include --}}
                    {{-- <a href="{{ route('include.index') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('include.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white transition' }}">
                        <i class="fas fa-plus-square w-6"></i>
                        <span class="ml-2">Include</span>
                    </a> --}}

                    {{-- Exclude --}}
                    {{-- <a href="{{ route('exclude.index') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('exclude.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white transition' }}">
                        <i class="fas fa-minus-square w-6"></i>
                        <span class="ml-2">Exclude</span>
                    </a> --}}

                    {{-- Pembayaran (Transaksi) --}}
                    <a href="{{ route('transaksi.index') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('transaksi.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white transition' }}">
                        <i class="fas fa-file-invoice-dollar w-6"></i>
                        <span class="ml-2">Verifikasi Pembayaran</span>
                    </a>


                    {{-- Laporan Transaksi --}}
                    <a href="{{ route('laporan') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('laporan') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white transition' }}">
                        <i class="fas fa-file-alt w-6"></i>
                        <span class="ml-2">Laporan</span>
                    </a>


                </nav>
            </div>
        </div>


        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white shadow-sm z-10">
                <div class="flex items-center justify-between p-4">
                    <div class="flex items-center">

                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button id="userDropdownBtn" class="flex items-center space-x-2">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nama_admin) }}&background=34d399&color=fff&bold=true"
                                    alt="Avatar" class="w-8 h-8 rounded-full">
                                <span class="hidden md:inline-block text-gray-700">
                                    {{ auth()->user()->nama_admin }}
                                </span>
                                <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                            </button>

                            <div id="userDropdown"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg overflow-hidden z-20 hidden">
                                <div class="border-t border-gray-200"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto bg-gray-100 p-4">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script>
        // Toggle Mobile Sidebar
        const sidebarToggle = document.getElementById('sidebarToggle');
        const mobileSidebar = document.getElementById('mobileSidebar');
        const closeSidebar = document.getElementById('closeSidebar');

        sidebarToggle.addEventListener('click', () => {
            mobileSidebar.classList.toggle('hidden');
        });

        closeSidebar.addEventListener('click', () => {
            mobileSidebar.classList.add('hidden');
        });



        // Toggle User Dropdown
        const userDropdownBtn = document.getElementById('userDropdownBtn');
        const userDropdown = document.getElementById('userDropdown');

        userDropdownBtn.addEventListener('click', () => {
            userDropdown.classList.toggle('hidden');
            // Close notification dropdown if open
            notificationDropdown.classList.add('hidden');
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', (event) => {
            if (!notificationBtn.contains(event.target) && !notificationDropdown.contains(event.target)) {
                notificationDropdown.classList.add('hidden');
            }
            if (!userDropdownBtn.contains(event.target) && !userDropdown.contains(event.target)) {
                userDropdown.classList.add('hidden');
            }
        });
    </script>
</body>

</html>
