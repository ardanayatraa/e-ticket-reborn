<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BALI OM TOURS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <!-- reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- Midtrans Snap -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        .hero-gradient {
            background: linear-gradient(135deg, #06b6d4, #0891b2, #0e7490);
        }

        .custom-shadow {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }

        .package-card {
            transition: all 0.3s ease;
        }

        .package-card:hover {
            transform: translateY(-5px);
        }

        /* Mobile optimized flatpickr */
        .flatpickr-calendar {
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            border: none !important;
            width: 100% !important;
            max-width: 320px;
            font-size: 14px;
        }

        @media (max-width: 640px) {
            .flatpickr-calendar {
                max-width: 280px;
                font-size: 13px;
                left: 50% !important;
                transform: translateX(-50%) !important;
                margin: 0 !important;
            }

            .flatpickr-days {
                width: 100% !important;
            }

            .dayContainer {
                width: 100% !important;
                min-width: 100% !important;
                max-width: 100% !important;
            }

            .flatpickr-day {
                max-width: 32px !important;
                height: 32px !important;
                line-height: 32px !important;
            }

            .flatpickr-time input {
                font-size: 16px !important;
            }

            @media (max-width: 320px) {
                .flatpickr-calendar {
                    max-width: 260px;
                }

                .flatpickr-day {
                    max-width: 30px !important;
                    height: 30px !important;
                    line-height: 30px !important;
                }
            }
        }

        .flatpickr-day.selected {
            background: #0d9488 !important;
            border-color: #0d9488 !important;
        }

        .flatpickr-day:hover {
            background: #99f6e4 !important;
            border-color: #99f6e4 !important;
            color: #0d9488 !important;
        }

        .flatpickr-time .numInputWrapper span.arrowUp:after {
            border-bottom-color: #0d9488 !important;
        }

        .flatpickr-time .numInputWrapper span.arrowDown:after {
            border-top-color: #0d9488 !important;
        }

        /* Custom scrollbar */
        .scrollbar-thin::-webkit-scrollbar {
            width: 4px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #0d9488;
            border-radius: 10px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #0f766e;
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out forwards;
        }

        /* Pagination styles */
        .pagination-btn {
            transition: all 0.2s ease;
            min-width: 40px;
            min-height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pagination-btn.active {
            background-color: #0d9488;
            color: white;
        }

        /* Search animation */
        @keyframes highlightSearch {
            0% {
                background-color: transparent;
            }

            30% {
                background-color: rgba(13, 148, 136, 0.1);
            }

            100% {
                background-color: transparent;
            }
        }

        .highlight-search {
            animation: highlightSearch 1.5s ease;
        }

        /* Mobile optimizations */
        @media (max-width: 640px) {
            .mobile-full-height {
                min-height: 100vh;
                max-height: 100vh;
                overflow-y: auto;
            }

            .mobile-padding {
                padding-left: 16px !important;
                padding-right: 16px !important;
            }

            .mobile-text-center {
                text-align: center;
            }

            .mobile-stack {
                flex-direction: column;
            }

            .mobile-full-width {
                width: 100% !important;
            }

            input,
            select,
            textarea {
                font-size: 16px !important;
            }

            .touch-target {
                min-height: 44px;
                min-width: 44px;
            }
        }

        /* Sticky search bar for mobile */
        .sticky-search {
            position: sticky;
            top: 70px;
            z-index: 9;
            background-color: white;
            padding: 12px 16px;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
        }

        /* Loading indicator */
        .loading-spinner {
            border: 3px solid rgba(13, 148, 136, 0.3);
            border-radius: 50%;
            border-top: 3px solid #0d9488;
            width: 24px;
            height: 24px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .date-loading {
            position: relative;
        }

        .date-loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }

        /* Modal Styles - FIXED SCROLLING ISSUE */
        .modal-overlay {
            backdrop-filter: blur(8px);
            /* Make the overlay scrollable */
            overflow-y: auto;
            /* Ensure proper positioning */
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            /* Center content with padding for mobile */
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 1rem;
            /* Add minimum padding for mobile */
            padding-top: 2rem;
            padding-bottom: 2rem;
            z-index: 50;
            /* Default z-index untuk modal biasa */
        }

        /* Modal Login dan Register - Lapisan Paling Depan */
        #modalLogin,
        #modalRegister {
            z-index: 9999 !important;
            /* Z-index tertinggi untuk login/register */
        }

        /* Backdrop khusus untuk login/register */
        #modalLogin .modal-overlay,
        #modalRegister .modal-overlay {
            background-color: rgba(0, 0, 0, 0.75) !important;
            /* Backdrop lebih gelap */
            backdrop-filter: blur(12px) !important;
            /* Blur lebih kuat */
        }

        .modal-content {
            animation: modalSlideIn 0.3s ease-out;
            /* Ensure modal can shrink on small screens */
            width: 100%;
            max-width: 28rem;
            /* max-w-md equivalent */
            /* Allow content to determine height */
            max-height: calc(100vh - 4rem);
            /* Make modal content scrollable if needed */
            overflow-y: auto;
            /* Ensure modal stays in view */
            margin: auto 0;
        }

        /* For larger modals */
        .modal-content-large {
            max-width: 72rem;
            /* max-w-6xl equivalent */
        }

        .modal-content-xl {
            max-width: 80rem;
            /* max-w-5xl equivalent */
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-20px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Mobile modal adjustments */
        @media (max-width: 640px) {
            .modal-overlay {
                padding: 0.5rem;
                padding-top: 1rem;
                padding-bottom: 1rem;
                align-items: flex-start;
            }

            .modal-content {
                max-height: calc(100vh - 2rem);
                margin: 0;
            }

            /* Ensure modal content is scrollable on mobile */
            .modal-body {
                max-height: calc(100vh - 8rem);
                overflow-y: auto;
            }
        }

        /* Participant input validation styles */
        .input-error {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* Multiple car selection styles */
        .car-selected {
            border-color: #0d9488 !important;
            background-color: rgba(13, 148, 136, 0.1) !important;
            position: relative;
        }

        .car-selected::after {
            content: '✓';
            position: absolute;
            top: 8px;
            right: 8px;
            background-color: #0d9488;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }

        .car-counter {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #ef4444;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
            border: 2px solid white;
        }

        .multiple-booking-warning {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            border: 2px solid #d97706;
        }

        /* Member styles */
        .member-badge {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .points-display {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            padding: 8px 16px;
            border-radius: 25px;
            font-weight: bold;
        }

        /* Points redemption styles */
        .points-section {
            background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
            border: 2px solid #d1d5db;
            border-radius: 12px;
        }

        .points-active {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            border-color: #3b82f6;
        }

        .discount-applied {
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
            border-color: #16a34a;
        }
    </style>
    @livewireStyles
</head>

<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg fixed w-full z-10">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
            @php
                $path = public_path('assets/img/baliomtour.png');
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            @endphp

            <!-- Logo -->
            <div class="flex items-center gap-3">
                <img src="{{ $base64 }}" alt="Logo Bali Om" class="h-10 w-auto">
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-8 items-center">
                <a href="#beranda" class="text-gray-700 hover:text-teal-600 transition font-medium">Beranda</a>
                <a href="#paket" class="text-gray-700 hover:text-teal-600 transition font-medium">Paket Wisata</a>
                <a href="#tentang" class="text-gray-700 hover:text-teal-600 transition font-medium">Tentang Kami</a>

                @auth('pelanggan')
                    <!-- Member Status & Points -->
                    <div class="flex items-center space-x-3">
                        @if (Auth::guard('pelanggan')->user()->is_member)
                            <div class="member-badge">
                                <i class="fas fa-crown mr-1"></i>MEMBER
                            </div>
                            <div class="points-display">
                                <i class="fas fa-star mr-1"></i>{{ Auth::guard('pelanggan')->user()->points }} Poin
                            </div>
                        @else
                            <button onclick="bukaModalMember()"
                                class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition font-medium">
                                <i class="fas fa-crown mr-1"></i>Upgrade Member
                            </button>
                        @endif

                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center text-gray-700 hover:text-teal-600 transition font-medium">
                                <i class="fas fa-user-circle mr-2"></i>
                                {{ Auth::guard('pelanggan')->user()->nama_pemesan }}
                                <i class="fas fa-chevron-down ml-1"></i>
                            </button>
                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-20">
                                <button onclick="bukaModalDashboard()"
                                    class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-tachometer-alt mr-2"></i>Riwayat
                                </button>
                                <button onclick="bukaModalProfile()"
                                    class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user-edit mr-2"></i>Update Profil
                                </button>
                                <form method="POST" action="{{ route('pelanggan.logout') }}" class="block">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <button onclick="bukaModalLogin()"
                        class="text-gray-700 hover:text-teal-600 transition font-medium">Login</button>
                @endauth
            </div>

            <!-- Mobile Toggle -->
            <div class="md:hidden">
                <button id="menu-toggle" class="text-gray-700 bg-gray-100 p-3 rounded-full touch-target">
                    <i class="fas fa-bars text-lg"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white px-4 py-2 shadow-inner animate-fadeIn">
            <a href="#beranda"
                class="block py-4 px-4 text-gray-700 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition">Beranda</a>
            <a href="#paket"
                class="block py-4 px-4 text-gray-700 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition">Paket
                Wisata</a>
            <a href="#tentang"
                class="block py-4 px-4 text-gray-700 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition">Tentang
                Kami</a>

            @auth('pelanggan')
                @if (!Auth::guard('pelanggan')->user()->is_member)
                    <button onclick="bukaModalMember()"
                        class="block w-full text-left py-4 px-4 text-orange-600 hover:text-orange-700 hover:bg-orange-50 rounded-lg transition font-medium">
                        <i class="fas fa-crown mr-2"></i>Upgrade Member
                    </button>
                @endif
                <button onclick="bukaModalDashboard()"
                    class="block w-full text-left py-4 px-4 text-gray-700 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition">
                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                </button>
                <button onclick="bukaModalProfile()"
                    class="block w-full text-left py-4 px-4 text-gray-700 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition">
                    <i class="fas fa-user-edit mr-2"></i>Update Profil
                </button>
                <form method="POST" action="{{ route('pelanggan.logout') }}" class="block">
                    @csrf
                    <button type="submit"
                        class="block w-full text-left py-4 px-4 text-gray-700 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            @else
                <button onclick="bukaModalLogin()"
                    class="block py-4 px-4 text-gray-700 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition">Login</button>
            @endauth
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="hero-gradient text-white py-20 pt-24">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">Jelajahi Keindahan Bali</h1>
            <p class="text-xl md:text-2xl mb-8 opacity-90">Nikmati pengalaman wisata tak terlupakan bersama Bali Om
                Tours</p>
            <a href="#paket"
                class="inline-block bg-white text-teal-600 font-bold py-4 px-8 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 text-lg">
                Lihat Paket Wisata
            </a>
        </div>
    </section>

    <!-- Paket Wisata Section -->
    <section id="paket" class="py-16 pt-24 sm:py-24 bg-white">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="text-center mb-6 sm:mb-12">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4">Paket Wisata</h2>
                <div
                    class="w-20 sm:w-24 h-1 bg-gradient-to-r from-teal-400 to-teal-600 mx-auto mb-4 sm:mb-6 rounded-full">
                </div>
                <p class="text-gray-600 max-w-3xl mx-auto text-base sm:text-lg px-2">Pilih paket wisata sesuai dengan
                    kebutuhan dan budget Anda. Kami menawarkan berbagai pilihan destinasi menarik.</p>
            </div>

            <!-- Search Bar -->
            <div id="searchBarContainer" class="max-w-md mx-auto mb-6 sm:mb-8 sticky-search">
                <div class="relative">
                    <input type="text" id="searchPackage" placeholder="Cari paket wisata..."
                        class="w-full px-4 py-4 sm:py-3 pl-12 pr-12 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 text-lg"></i>
                    </div>
                    <button id="clearSearch"
                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 hidden touch-target">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                <div id="filterIndicator" class="hidden mt-2 text-sm text-center">
                    <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full inline-flex items-center">
                        <span id="resultCount">0</span> - paket ditemukan
                        <button id="clearFilter" class="ml-2 text-teal-600 hover:text-teal-800">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </span>
                </div>
            </div>

            <!-- No Results Message -->
            <div id="noResults" class="hidden text-center py-8">
                <div class="text-gray-500 mb-4"><i class="fas fa-search text-5xl"></i></div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Tidak ada hasil</h3>
                <p class="text-gray-500 mb-4">Maaf, tidak ada paket wisata yang sesuai dengan pencarian Anda.</p>
                <button id="resetSearch"
                    class="bg-teal-100 text-teal-800 px-4 py-2 rounded-lg hover:bg-teal-200 transition">
                    <i class="fas fa-redo mr-2"></i> Reset Pencarian
                </button>
            </div>

            <div id="packageContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
                @foreach ($paket as $item)
                    <div class="package-card bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition"
                        data-category="bali" data-name="{{ strtolower($item->judul) }}"
                        data-location="{{ strtolower($item->tempat) }}">
                        <div class="relative">
                            <img src="{{ $item->foto ? asset('storage/' . $item->foto) : 'https://images.unsplash.com/photo-1539367628448-4bc5c9d171c8?auto=format&fit=crop&w=1170&q=80' }}"
                                alt="{{ $item->judul }}" class="w-full h-48 sm:h-56 object-cover" loading="lazy" />
                            @if ($item->created_at->diffInDays(now()) < 7)
                                <span
                                    class="absolute top-3 left-3 bg-teal-100 text-teal-800 text-xs font-semibold px-3 py-1 rounded-full">Terbaru</span>
                            @endif
                        </div>
                        <div class="p-4 sm:p-6">
                            <h3 class="text-lg sm:text-xl font-semibold mb-2 sm:mb-3 text-gray-800">
                                {{ $item->judul }}</h3>
                            <p class="text-sm sm:text-base text-gray-600 mb-3 sm:mb-4 line-clamp-3">
                                {{ $item->deskripsi }}</p>
                            <div class="flex items-center mb-2">
                                <i class="fas fa-map-marker-alt text-teal-600 mr-2"></i>
                                <span class="text-sm sm:text-base text-gray-600">{{ $item->tempat }}</span>
                            </div>
                            <div class="flex flex-wrap gap-2 mb-4">
                                @if ($item->include)
                                    @if ($item->include->bensin)
                                        <span
                                            class="bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full flex items-center gap-1">
                                            <i class="fas fa-gas-pump"></i> Bensin
                                        </span>
                                    @endif

                                    @if ($item->include->sopir)
                                        <span
                                            class="bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full flex items-center gap-1">
                                            <i class="fas fa-user-tie"></i> Sopir
                                        </span>
                                    @endif

                                    @if ($item->include->parkir)
                                        <span
                                            class="bg-yellow-100 text-yellow-700 text-xs font-semibold px-3 py-1 rounded-full flex items-center gap-1">
                                            <i class="fas fa-parking"></i> Parkir
                                        </span>
                                    @endif

                                    @if ($item->include->makan_siang)
                                        <span
                                            class="bg-orange-100 text-orange-700 text-xs font-semibold px-3 py-1 rounded-full flex items-center gap-1">
                                            <i class="fas fa-utensils"></i> Makan Siang
                                        </span>
                                    @endif

                                    @if ($item->include->makan_malam)
                                        <span
                                            class="bg-purple-100 text-purple-700 text-xs font-semibold px-3 py-1 rounded-full flex items-center gap-1">
                                            <i class="fas fa-moon"></i> Makan Malam
                                        </span>
                                    @endif

                                    @if ($item->include->tiket_masuk)
                                        <span
                                            class="bg-indigo-100 text-indigo-700 text-xs font-semibold px-3 py-1 rounded-full flex items-center gap-1">
                                            <i class="fas fa-ticket-alt"></i> Tiket Masuk
                                        </span>
                                    @endif
                                @else
                                    <!-- Fallback jika tidak ada data include -->
                                    <span
                                        class="bg-gray-100 text-gray-600 text-xs font-semibold px-3 py-1 rounded-full">
                                        <i class="fas fa-info-circle"></i> Info fasilitas belum tersedia
                                    </span>
                                @endif
                            </div>

                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mt-4">
                                <div class="space-y-1">
                                    <span class="block text-xs text-gray-500 uppercase font-medium">Harga Mulai</span>
                                    <div class="flex items-baseline space-x-1">
                                        <span class="text-xl sm:text-2xl font-bold text-teal-600">
                                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                                        </span>
                                        <span class="text-xs sm:text-sm text-gray-500">/ {{ $item->durasi }}
                                            hari</span>
                                    </div>
                                </div>

                                <div class="flex flex-col gap-2">
                                    <a href="{{ route('paket-wisata.detail', $item->slug) }}"
                                        class="w-full sm:w-auto bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition-all duration-200 font-medium text-center text-sm inline-block">
                                        <i class="fas fa-eye mr-1"></i> Lihat Detail
                                    </a>

                                    @auth('pelanggan')
                                        <button
                                            onclick="bukaStep1({{ $item->paketwisata_id }}, '{{ addslashes($item->judul) }}', {{ $item->harga }}, '{{ $item->foto }}')"
                                            class="w-full sm:w-auto bg-teal-600 hover:bg-teal-500 text-white px-4 py-2 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 font-medium text-center text-sm">
                                            <i class="fas fa-calendar-check mr-1"></i> Pesan
                                        </button>
                                    @else
                                        <button onclick="bukaModalLogin()"
                                            class="w-full sm:w-auto bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 font-medium text-center text-sm">
                                            <i class="fas fa-sign-in-alt mr-1"></i> Login untuk Pesan
                                        </button>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div id="pagination" class="flex justify-center mt-8 sm:mt-10 space-x-1 sm:space-x-2 pagination-compact">
                <!-- Pagination buttons will be generated by JavaScript -->
            </div>

            <!-- Mobile Pagination Info -->
            <div id="paginationInfo" class="text-center text-sm text-gray-500 mt-2 hidden">
                Halaman <span id="currentPageInfo">1</span> dari <span id="totalPagesInfo">1</span>
            </div>
        </div>
    </section>

    <!-- Tentang Kami Section -->
    <section id="tentang" class="py-12 sm:py-20 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="flex flex-col lg:flex-row items-center gap-8 lg:gap-16">
                <div class="w-full lg:w-1/2">
                    <img src="https://images.unsplash.com/photo-1566559532512-004a6df74db5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1171&q=80"
                        alt="Wisata Indonesia"
                        class="rounded-2xl shadow-xl w-full object-cover h-64 sm:h-80 md:h-[400px]" loading="lazy" />
                </div>
                <div class="w-full lg:w-1/2 text-center lg:text-left">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-3 sm:mb-4">Tentang Bali Om Tour</h2>
                    <div
                        class="w-16 sm:w-20 h-1 bg-gradient-to-r from-teal-400 to-teal-600 mx-auto lg:mx-0 mb-4 sm:mb-6 rounded-full">
                    </div>
                    <p class="text-base sm:text-lg text-gray-600 leading-relaxed mb-6 sm:mb-8">
                        Bali Om Tours was founded by Indah Sari and her partner Arnd in early 2014. The mission of Bali
                        Om Tours is to share our personal experiences and the places we've found on our journey
                        throughout Indonesia. Here you will get all the necessary information about all your trips
                        throughout Indonesia without any kind of Pressure to buy.
                    </p>
                    <a href="#paket"
                        class="inline-block bg-gradient-to-r from-teal-500 to-teal-700 text-white font-medium py-3 px-6 sm:py-3 sm:px-8 rounded-lg hover:shadow-lg transition transform hover:-translate-y-1">
                        Lihat Paket Kami
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Login Modal - FIXED SCROLLING -->
    <div id="modalLogin" class="hidden modal-overlay">
        <div class="modal-content bg-white rounded-2xl shadow-2xl">
            <div class="modal-body p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">Login Pelanggan</h3>
                    <button onclick="tutupModalLogin()" class="text-gray-500 hover:text-gray-700 p-2">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div id="loginError" class="hidden bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <p class="text-red-600 text-sm"></p>
                </div>

                <form id="formLogin" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input type="password" name="password" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember"
                                class="rounded border-gray-300 text-teal-600 focus:ring-teal-500">
                            <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                        </label>
                    </div>

                    <button type="submit" id="tombolLogin"
                        class="w-full bg-gradient-to-r from-teal-500 to-teal-600 text-white font-bold py-3 px-4 rounded-lg hover:shadow-lg transition-all duration-200">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Masuk
                    </button>
                </form>

                <div class="text-center mt-6">
                    <p class="text-gray-600">
                        Belum punya akun?
                        <button onclick="bukaModalRegister()" class="text-teal-600 hover:text-teal-700 font-medium">
                            Daftar di sini
                        </button>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Register Modal - FIXED SCROLLING -->
    <div id="modalRegister" class="hidden modal-overlay">
        <div class="modal-content bg-white rounded-2xl shadow-2xl">
            <div class="modal-body p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">Daftar Pelanggan</h3>
                    <button onclick="tutupModalRegister()" class="text-gray-500 hover:text-gray-700 p-2">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div id="registerError" class="hidden bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <p class="text-red-600 text-sm"></p>
                </div>

                <form id="formRegister" class="space-y-6">
                    @csrf
                    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="nama_pemesan" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nomor WhatsApp</label>
                        <input type="text" name="nomor_whatsapp" required placeholder="08xxxxxxxxxx"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                        <textarea name="alamat" rows="3" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input type="password" name="password" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    </div>

                    <!-- reCAPTCHA -->
                    <div class="g-recaptcha" data-sitekey="{{ config('app.recaptcha.site_key') }}"></div>

                    <button type="submit" id="tombolRegister"
                        class="w-full bg-gradient-to-r from-teal-500 to-teal-600 text-white font-bold py-3 px-4 rounded-lg hover:shadow-lg transition-all duration-200">
                        <i class="fas fa-user-plus mr-2"></i>
                        Daftar
                    </button>
                </form>

                <div class="text-center mt-6">
                    <p class="text-gray-600">
                        Sudah punya akun?
                        <button onclick="bukaModalLogin()" class="text-teal-600 hover:text-teal-700 font-medium">
                            Masuk di sini
                        </button>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Member Upgrade Modal -->
    <div id="modalMember" class="hidden modal-overlay">
        <div class="modal-content bg-white rounded-2xl shadow-2xl">
            <div class="modal-body p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">Upgrade ke Member</h3>
                    <button onclick="tutupModalMember()" class="text-gray-500 hover:text-gray-700 p-2">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div class="text-center mb-8">
                    <div class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-white p-6 rounded-xl mb-6">
                        <i class="fas fa-crown text-4xl mb-3"></i>
                        <h4 class="text-xl font-bold">Menjadi Member Premium</h4>
                        <p class="text-yellow-100 mt-2">Dapatkan berbagai keuntungan eksklusif</p>
                    </div>

                    <div class="text-3xl font-bold text-orange-600 mb-6">
                        Hanya Rp 25.000
                    </div>

                    <div class="bg-blue-50 rounded-lg p-4 mb-6 text-left">
                        <h5 class="font-bold text-blue-800 mb-3">Keuntungan Member:</h5>
                        <ul class="text-sm text-blue-700 space-y-2">
                            <li class="flex items-center">
                                <i class="fas fa-star text-blue-600 mr-2"></i>
                                Dapatkan poin setiap pembelian
                            </li>
                            @if($activePointSettings->isNotEmpty())
                                @php
                                    $firstSetting = $activePointSettings->first();
                                @endphp
                                <li class="flex items-center">
                                    <i class="fas fa-calculator text-blue-600 mr-2"></i>
                                    Setiap Rp {{ number_format($firstSetting->minimum_transaksi, 0, ',', '.') }}
                                    = {{ $firstSetting->jumlah_point_diperoleh }} poin
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-tags text-blue-600 mr-2"></i>
                                    {{ $firstSetting->jumlah_point_diperoleh }} poin = Rp
                                    {{ number_format($firstSetting->harga_satuan_point, 0, ',', '.') }}
                                    potongan
                                </li>
                            @else
                                <li class="flex items-center">
                                    <i class="fas fa-calculator text-blue-600 mr-2"></i>
                                    Setiap Rp 500.000 = 5 poin
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-tags text-blue-600 mr-2"></i>
                                    5 poin = Rp 10.000 potongan
                                </li>
                            @endif
                            <li class="flex items-center">
                                <i class="fas fa-priority-high text-blue-600 mr-2"></i>
                                Akses prioritas booking
                            </li>
                        </ul>
                    </div>

                    <button onclick="bayarMember()" id="tombolBayarMember"
                        class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold py-4 px-6 rounded-lg hover:shadow-lg transition-all duration-200">
                        <i class="fas fa-credit-card mr-2"></i>
                        Bayar Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Modal -->
    <div id="modalDashboard" class="hidden modal-overlay">
        <div class="modal-content modal-content-large bg-white rounded-2xl shadow-2xl">
            <div class="modal-body p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">Dashboard Member</h3>
                    <button onclick="tutupModalDashboard()" class="text-gray-500 hover:text-gray-700 p-2">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                @auth('pelanggan')
                    <div class="grid lg:grid-cols-3 gap-6">
                        <!-- Member Status -->
                        <div class="bg-gray-50 rounded-xl p-6">
                            <h4 class="text-lg font-bold text-gray-800 mb-4">Status Keanggotaan</h4>

                            @if (Auth::guard('pelanggan')->user()->is_member)
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                                        <div class="flex items-center">
                                            <i class="fas fa-check-circle text-green-600 mr-3"></i>
                                            <span class="font-medium text-green-800">Status Member Aktif</span>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg">
                                        <div class="flex items-center">
                                            <i class="fas fa-star text-blue-600 mr-3"></i>
                                            <span class="font-medium text-blue-800">Total Poin</span>
                                        </div>
                                        <span
                                            class="text-2xl font-bold text-blue-600">{{ Auth::guard('pelanggan')->user()->points }}</span>
                                    </div>

                                    <div class="p-4 bg-yellow-50 rounded-lg">
                                        <p class="text-sm text-yellow-800">
                                            <i class="fas fa-calendar mr-1"></i>
                                            Member sejak:
                                            {{ Auth::guard('pelanggan')->user()->member_since->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                            @else
                                <div class="text-center p-6 bg-orange-50 rounded-lg">
                                    <i class="fas fa-crown text-orange-600 text-3xl mb-3"></i>
                                    <h5 class="font-bold text-orange-800 mb-2">Belum Member</h5>
                                    <p class="text-orange-700 text-sm mb-4">Upgrade sekarang untuk mendapatkan berbagai
                                        keuntungan</p>
                                    <button onclick="tutupModalDashboard(); bukaModalMember();"
                                        class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition">
                                        Upgrade Member
                                    </button>
                                </div>
                            @endif
                        </div>

                        <!-- Recent Bookings -->
                        <div class="lg:col-span-2 bg-gray-50 rounded-xl p-6">
                            <h4 class="text-lg font-bold text-gray-800 mb-4">Riwayat Pemesanan</h4>

                            @if (Auth::guard('pelanggan')->user()->ketersediaans->count() > 0)
                                <div class="space-y-4 max-h-96 overflow-y-auto">
                                    @foreach (Auth::guard('pelanggan')->user()->ketersediaans->sortByDesc('created_at')->take(10) as $ketersediaan)
                                        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                                            <div class="flex justify-between items-start mb-3">
                                                <div class="flex-1">
                                                    <h5 class="font-semibold text-gray-800 text-base">
                                                        {{ $ketersediaan->paketWisata->judul }}
                                                    </h5>
                                                    <p class="text-sm text-gray-600 mt-1">
                                                        <i class="fas fa-calendar mr-1"></i>
                                                        {{ \Carbon\Carbon::parse($ketersediaan->tanggal_keberangkatan)->format('d M Y') }}
                                                        <span class="ml-3">
                                                            <i class="fas fa-clock mr-1"></i>
                                                            {{ $ketersediaan->jam_mulai }}
                                                        </span>
                                                    </p>
                                                </div>
                                                <div class="text-right">
                                                    @if ($ketersediaan->transaksi && $ketersediaan->transaksi->transaksi_status == 'paid')
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            <i class="fas fa-check-circle mr-1"></i>
                                                            Lunas
                                                        </span>
                                                    @elseif($ketersediaan->transaksi && $ketersediaan->transaksi->transaksi_status == 'pending')
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                            <i class="fas fa-clock mr-1"></i>
                                                            Pending
                                                        </span>
                                                    @else
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                            <i class="fas fa-question-circle mr-1"></i>
                                                            Belum Bayar
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-2 gap-4 text-sm">
                                                <div>
                                                    <span class="text-gray-500">Mobil:</span>
                                                    <p class="font-medium text-gray-800">
                                                        {{ $ketersediaan->mobil->nama_kendaraan ?? 'N/A' }}</p>
                                                </div>
                                                <div>
                                                    <span class="text-gray-500">Peserta:</span>
                                                    <p class="font-medium text-gray-800">
                                                        {{ $ketersediaan->transaksi->jumlah_peserta }}
                                                        orang</p>
                                                </div>
                                                <div>
                                                    <span class="text-gray-500">Total Harga:</span>
                                                    <p class="font-semibold text-teal-600">
                                                        Rp
                                                        {{ number_format($ketersediaan->transaksi->total_transaksi ?? $ketersediaan->paketWisata->harga, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <span class="text-gray-500">Tanggal Pesan:</span>
                                                    <p class="font-medium text-gray-800">
                                                        {{ $ketersediaan->created_at->format('d M Y') }}</p>
                                                </div>
                                            </div>

                                            @if ($ketersediaan->transaksi && $ketersediaan->transaksi->transaksi_status == 'paid')
                                                <div class="mt-3 pt-3 border-t border-gray-200">
                                                    <div class="flex items-center justify-between">
                                                        <span class="text-sm text-green-600 font-medium flex items-center">
                                                            <i class="fas fa-ticket-alt mr-1"></i>
                                                            E-ticket tersedia

                                                            <!-- Tombol download -->
                                                            <a href="{{ route('download.eticket', ['transaksi' => $ketersediaan->transaksi->transaksi_id]) }}"
                                                                class="ml-3 text-sm text-white bg-green-500 hover:bg-green-600 px-3 py-1 rounded inline-flex items-center"
                                                                target="_blank">
                                                                <i class="fas fa-download mr-1"></i> Download
                                                            </a>
                                                        </span>

                                                        @if (Auth::guard('pelanggan')->user()->is_member && $ketersediaan->transaksi->deposit)
                                                            @php
                                                                $pointsEarned = \App\Models\PointSetting::calculateEarnedPoints($ketersediaan->transaksi->deposit);
                                                            @endphp
                                                            @if ($pointsEarned > 0)
                                                                <span class="text-sm text-blue-600 font-medium">
                                                                    <i class="fas fa-star mr-1"></i>
                                                                    +{{ $pointsEarned }} poin
                                                                </span>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <i class="fas fa-calendar-times text-gray-400 text-4xl mb-4"></i>
                                    <h5 class="text-lg font-semibold text-gray-700 mb-2">Belum ada pemesanan</h5>
                                    <p class="text-gray-500 mb-4">Mulai jelajahi paket wisata kami dan buat pemesanan
                                        pertama Anda</p>
                                    <button
                                        onclick="tutupModalDashboard(); document.getElementById('paket').scrollIntoView({behavior: 'smooth'});"
                                        class="bg-teal-600 text-white px-6 py-2 rounded-lg hover:bg-teal-700 transition">
                                        Lihat Paket Wisata
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- Profile Update Modal -->
    <div id="modalProfile" class="hidden modal-overlay">
        <div class="modal-content bg-white rounded-2xl shadow-2xl">
            <div class="modal-body p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">Update Profil</h3>
                    <button onclick="tutupModalProfile()" class="text-gray-500 hover:text-gray-700 p-2">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div id="profileError" class="hidden bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <p class="text-red-600 text-sm"></p>
                </div>

                <div id="profileSuccess" class="hidden bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <p class="text-green-600 text-sm"></p>
                </div>

                @auth('pelanggan')
                    <form id="formProfile" class="space-y-6">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="nama_pemesan"
                                value="{{ Auth::guard('pelanggan')->user()->nama_pemesan }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" value="{{ Auth::guard('pelanggan')->user()->email }}"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor WhatsApp</label>
                            <input type="text" name="nomor_whatsapp"
                                value="{{ Auth::guard('pelanggan')->user()->nomor_whatsapp }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                            <textarea name="alamat" rows="3" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">{{ Auth::guard('pelanggan')->user()->alamat }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru (Kosongkan jika tidak
                                ingin mengubah)</label>
                            <input type="password" name="password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        </div>

                        <button type="submit" id="tombolUpdateProfile"
                            class="w-full bg-gradient-to-r from-teal-500 to-teal-600 text-white font-bold py-3 px-4 rounded-lg hover:shadow-lg transition-all duration-200">
                            <i class="fas fa-save mr-2"></i>
                            Update Profil
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </div>

    <!-- Detail Paket Modal -->
    <div id="modalDetailPaket" class="hidden modal-overlay">
        <div class="modal-content modal-content-xl bg-white rounded-2xl shadow-2xl">
            <div class="modal-body p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 id="detailPaketJudul" class="text-2xl font-bold text-gray-800"></h3>
                    <button onclick="tutupModalDetailPaket()" class="text-gray-500 hover:text-gray-700 p-2">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div id="detailPaketContent" class="space-y-6">
                    <!-- Content will be loaded dynamically -->
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Modal (Enhanced) -->
    <div id="kontainerPicker" class="hidden modal-overlay overflow-y-auto">
        <div
            class="modal-content modal-content-xl bg-white rounded-xl sm:rounded-2xl shadow-2xl my-4 sm:my-8 mx-3 sm:mx-auto animate-fadeIn">
            {{-- STEP 1 --}}
            <div id="step1" class="modal-body p-4 sm:p-6">
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center gap-3">
                        <h4 class="text-lg sm:text-2xl font-bold text-gray-800">1. Pilih Tanggal & Mobil</h4>
                        <div id="selectedCarsCounter"
                            class="hidden bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm font-medium">
                            <i class="fas fa-car mr-1"></i>
                            <span id="selectedCarsCount">0</span> mobil dipilih
                        </div>
                    </div>
                    <button onclick="tutupPicker()" class="text-gray-500 hover:text-gray-700 p-2 touch-target">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div id="peringatanWaktuBooking"
                    class="hidden mb-4 p-3 bg-orange-100 border border-orange-300 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-orange-600 mr-2"></i>
                        <span class="text-orange-800 text-sm font-medium">
                            Booking untuk besok hanya tersedia sampai jam 21:00. Setelah itu semua mobil tidak tersedia
                            karena kantor tutup jam 21:00.
                        </span>
                    </div>
                </div>

                <div id="peringatanMultipleBooking" class="hidden mb-4 p-4 multiple-booking-warning rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-orange-800 mr-3 text-xl"></i>
                        <div>
                            <h5 class="text-orange-900 font-bold text-sm mb-1">Pemesanan Multiple Mobil</h5>
                            <p class="text-orange-800 text-sm">
                                Anda akan memesan <strong id="jumlahMobilDipesan">0</strong> mobil sekaligus.
                                Pastikan data yang Anda masukkan sudah benar karena setiap mobil akan memerlukan input
                                data terpisah.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col lg:flex-row lg:gap-6">
                    {{-- Kalender --}}
                    <div class="w-full lg:w-1/2 mb-6 lg:mb-0">
                        <div class="bg-gray-50 p-3 sm:p-4 rounded-xl mb-4">
                            <label class="block text-gray-700 font-medium mb-2 text-sm sm:text-base">Pilih
                                Tanggal</label>
                            <input id="tglPicker" type="text"
                                class="w-full cursor-pointer rounded-lg border border-gray-300 shadow-sm py-3 px-3 focus:outline-none focus:ring-2 focus:ring-teal-500 text-center font-medium text-sm sm:text-base"
                                readonly placeholder="Pilih Tanggal" />

                            <div id="indikatorLoadingTanggal" class="hidden mt-2">
                                <div class="flex items-center justify-center space-x-2 text-sm text-gray-500">
                                    <div class="loading-spinner"></div>
                                    <span>Memeriksa ketersediaan mobil...</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-3 sm:p-4 rounded-xl">
                            <label class="block text-gray-700 font-medium mb-2 text-sm sm:text-base">Jam Mulai</label>
                            <input id="timePicker" type="text" readonly
                                class="w-full cursor-pointer rounded-lg border border-gray-300 shadow-sm py-3 px-3 focus:outline-none focus:ring-2 focus:ring-teal-500 text-center font-medium text-sm sm:text-base"
                                placeholder="Pilih Jam" />
                        </div>
                    </div>

                    {{-- Mobil --}}
                    <div class="w-full lg:w-1/2">
                        <div class="flex justify-between items-center mb-3">
                            <h5 class="font-medium text-gray-700 text-base sm:text-lg">Mobil
                                </cut_off_point>

                                Tersedia</h5>
                            <button id="tombolResetPilihan" onclick="resetPilihanMobil()"
                                class="hidden text-sm text-red-600 hover:text-red-800 font-medium">
                                <i class="fas fa-undo mr-1"></i> Reset Pilihan
                            </button>
                        </div>

                        <div id="pesanTidakAdaMobil" class="hidden text-center py-8">
                            <div class="text-gray-500 mb-4">
                                <i class="fas fa-car text-4xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">Tidak ada mobil yang tersedia</h3>
                            <p class="text-gray-500 text-sm">Silahkan pilih tanggal lain</p>
                        </div>

                        <div id="daftarKendaraan"
                            class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-64 sm:max-h-80 overflow-y-auto pr-2 scrollbar-thin">
                            @foreach ($mobil as $m)
                                <button type="button" data-tipe="{{ $m->nama_kendaraan }}"
                                    data-id="{{ $m->mobil_id }}" data-seats="{{ $m->jumlah_tempat_duduk }}"
                                    class="tombol-kendaraan flex flex-col items-center text-center bg-white p-3 rounded-xl shadow-md
                                    border-2 border-transparent hover:border-teal-400 transition duration-200 hover:shadow-lg relative">
                                    <div class="w-full h-24 sm:h-28 mb-2 sm:mb-3 overflow-hidden rounded-lg">
                                        <img src="{{ $m->foto ? asset('storage/' . $m->foto) : asset('images/default-car.jpg') }}"
                                            alt="{{ $m->nama_kendaraan }}" class="w-full h-full object-cover"
                                            loading="lazy" />
                                    </div>
                                    <span
                                        class="font-semibold text-gray-800 text-sm sm:text-base">{{ $m->nama_kendaraan }}</span>
                                    <span class="text-xs sm:text-sm text-gray-500 mt-1">{{ $m->jumlah_tempat_duduk }}
                                        Kursi</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="mt-6 sm:mt-8 flex justify-end space-x-3">
                    <button onclick="tutupPicker()"
                        class="px-4 py-3 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 transition font-medium text-sm sm:text-base">
                        Batal
                    </button>
                    <button id="tombolLanjutStep" onclick="keStep2()" disabled
                        class="px-4 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white rounded-lg shadow-md hover:shadow-lg transition font-medium text-sm sm:text-base opacity-50 cursor-not-allowed">
                        Input Data Pemesan
                    </button>
                </div>
            </div>

            {{-- STEP 2 --}}
            <div id="step2" class="hidden modal-body p-4 sm:p-6 bg-gray-50">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-lg sm:text-2xl font-bold text-gray-800">2. Lengkapi Data Pemesan</h4>
                    <button onclick="tutupPicker()" class="text-gray-500 hover:text-gray-700 p-2 touch-target">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div id="wrapperPreviewFoto" class="hidden mb-4 sm:mb-6">
                    <img id="previewFoto" src="/placeholder.svg" alt="Foto Paket"
                        class="w-full h-40 sm:h-48 object-cover rounded-xl shadow-md" />
                </div>

                <form id="formBooking" class="flex flex-col lg:flex-row lg:gap-6">
                    @csrf

                    {{-- Ringkasan Pemesanan --}}
                    <div class="w-full lg:w-1/2 mb-4 lg:mb-0 space-y-4">
                        <div class="bg-white p-4 sm:p-5 rounded-xl shadow-lg">
                            <h5 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 text-gray-700">Ringkasan
                                Pemesanan</h5>
                            <ul class="space-y-2 sm:space-y-3 text-gray-600 text-sm sm:text-base">
                                <li class="flex items-center p-2 hover:bg-gray-50 rounded-lg transition">
                                    <i class="fas fa-box-open text-teal-600 w-5 sm:w-6 text-center"></i>
                                    <span class="ml-2 sm:ml-3 font-medium">Paket:</span>
                                    <span id="previewPaket"
                                        class="ml-auto font-medium text-gray-800 text-right"></span>
                                </li>
                                <li class="flex items-center p-2 hover:bg-gray-50 rounded-lg transition">
                                    <i class="fas fa-calendar-alt text-teal-600 w-5 sm:w-6 text-center"></i>
                                    <span class="ml-2 sm:ml-3 font-medium">Tanggal:</span>
                                    <span id="previewTanggal" class="ml-auto font-medium text-gray-800"></span>
                                </li>
                                <li class="flex items-center p-2 hover:bg-gray-50 rounded-lg transition">
                                    <i class="fas fa-clock text-teal-600 w-5 sm:w-6 text-center"></i>
                                    <span class="ml-2 sm:ml-3 font-medium">Jam Mulai:</span>
                                    <span id="previewWaktu" class="ml-auto font-medium text-gray-800"></span>
                                </li>
                                <li class="flex items-start p-2 hover:bg-gray-50 rounded-lg transition">
                                    <i class="fas fa-car-side text-teal-600 w-5 sm:w-6 text-center mt-1"></i>
                                    <span class="ml-2 sm:ml-3 font-medium">Mobil:</span>
                                    <div id="previewKendaraan" class="ml-auto text-right">
                                        <!-- Will be populated by JavaScript -->
                                    </div>
                                </li>
                                <li class="flex items-center p-2 hover:bg-gray-50 rounded-lg transition">
                                    <i class="fas fa-tag text-teal-600 w-5 sm:w-6 text-center"></i>
                                    <span class="ml-2 sm:ml-3 font-medium">Subtotal:</span>
                                    <span id="previewSubtotal" class="ml-auto font-semibold text-gray-800"></span>
                                </li>
                            </ul>

                            <!-- Points Redemption Section for Members -->
                            @auth('pelanggan')
                                @if (Auth::guard('pelanggan')->user()->is_member && $activePointSettings->isNotEmpty())
                                    @php
                                        $firstSetting = $activePointSettings->first();
                                        $minPoints = $firstSetting->jumlah_point_diperoleh;
                                    @endphp
                                    @if (Auth::guard('pelanggan')->user()->points >= $minPoints)
                                        <div id="pointsRedemptionSection" class="mt-4 p-4 points-section rounded-lg">
                                            <div class="flex items-center justify-between mb-3">
                                                <h6 class="font-semibold text-gray-700">Tukar Poin</h6>
                                                <div class="text-sm text-blue-600 font-medium">
                                                    <i class="fas fa-star mr-1"></i>
                                                    {{ Auth::guard('pelanggan')->user()->points }} poin tersedia
                                                </div>
                                            </div>

                                            <div class="space-y-3">
                                                <div class="flex items-center">
                                                    <input type="checkbox" id="usePoints" onchange="togglePointsRedemption()"
                                                        class="rounded border-gray-300 text-teal-600 focus:ring-teal-500">
                                                    <label for="usePoints" class="ml-2 text-sm text-gray-700">
                                                        Gunakan poin untuk potongan harga
                                                    </label>
                                                </div>

                                                <div id="pointsInputSection" class="hidden">
                                                    <div class="flex items-center space-x-2">
                                                        <input type="number" id="pointsToUse"
                                                            min="{{ $minPoints }}"
                                                            max="{{ Auth::guard('pelanggan')->user()->points }}"
                                                            step="{{ $minPoints }}"
                                                            placeholder="{{ $minPoints }}"
                                                            onchange="calculatePointsDiscount()"
                                                            class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm">
                                                        <span class="text-sm text-gray-600">poin</span>
                                                    </div>
                                                    <p class="text-xs text-gray-500 mt-1">
                                                        {{ $minPoints }} poin = Rp
                                                        {{ number_format($firstSetting->harga_satuan_point, 0, ',', '.') }}
                                                        potongan (kelipatan {{ $minPoints }})
                                                    </p>
                                                    <div id="pointsDiscountPreview"
                                                        class="hidden mt-2 text-sm font-medium text-green-600">
                                                        Potongan: <span id="discountAmount">Rp 0</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endauth

                            <!-- Final Total -->
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <div class="flex items-center justify-between">
                                    <span class="text-lg font-bold text-gray-800">Total Bayar:</span>
                                    <span id="previewHarga" class="text-xl font-bold text-teal-600"></span>
                                </div>
                                <div id="savingsInfo" class="hidden mt-1 text-sm text-green-600 font-medium">
                                    <i class="fas fa-tag mr-1"></i>
                                    Hemat <span id="totalSavings">Rp 0</span> dengan poin!
                                </div>
                            </div>
                        </div>

                        {{-- Hidden fields --}}
                        <input type="hidden" name="paket_id" id="inputPaketId">
                        <input type="hidden" name="tanggal" id="inputTanggal">
                        <input type="hidden" name="jam_mulai" id="inputWaktu">
                        <input type="hidden" name="points_used" id="inputPointsUsed" value="0">
                        <div id="hiddenMobilInputs">
                            <!-- Will be populated by JavaScript -->
                        </div>
                    </div>

                    {{-- Form Data Pemesan --}}
                    <div class="w-full lg:w-1/2 space-y-4">
                        {{-- Update Alamat Section --}}
                        <div class="bg-white p-4 rounded-xl shadow-lg">
                            <h5 class="text-lg font-semibold mb-3 text-gray-700">
                                <i class="fas fa-map-marker-alt mr-2 text-teal-600"></i>
                                Alamat Penjemputan
                            </h5>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-gray-700 font-medium mb-2 text-sm">Alamat Saat Ini</label>
                                    <div class="p-3 bg-gray-50 rounded-lg text-sm text-gray-600">
                                        {{ Auth::guard('pelanggan')->user()->alamat ?? 'Alamat belum diisi' }}
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="updateAlamat" onchange="toggleUpdateAlamat()"
                                        class="rounded border-gray-300 text-teal-600 focus:ring-teal-500">
                                    <label for="updateAlamat" class="ml-2 text-sm text-gray-700">
                                        Update alamat untuk penjemputan
                                    </label>
                                </div>
                                <div id="alamatInputSection" class="hidden">
                                    <label class="block text-gray-700 font-medium mb-2 text-sm">Alamat Baru</label>
                                    <textarea id="alamatBaru" name="alamat_baru" rows="3"
                                        placeholder="Masukkan alamat lengkap untuk penjemputan..."
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm resize-none"></textarea>
                                    <p class="text-xs text-gray-500 mt-1">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Alamat ini akan digunakan untuk penjemputan pada tanggal
                                        {{ date('d M Y', strtotime('+1 day')) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div id="participantInputsContainer">
                            <!-- Will be populated by JavaScript -->
                        </div>

                        {{-- Aksi --}}
                        <div class="flex justify-between mt-4 sm:mt-6">
                            <button type="button" onclick="kembaliKeStep1()"
                                class="px-4 py-3 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 transition font-medium text-sm sm:text-base">
                                <i class="fas fa-arrow-left mr-2"></i> Kembali
                            </button>
                            <button type="button" onclick="prosesBooking()" id="tombolKonfirmasiBooking"
                                class="px-4 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white rounded-lg shadow-md hover:shadow-lg transition font-medium text-sm sm:text-base">
                                Konfirmasi & Bayar <i class="fas fa-check ml-2"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Multiple Booking Confirmation Modal -->
    <div id="modalKonfirmasiMultiple" class="hidden modal-overlay">
        <div class="modal-content bg-white rounded-2xl shadow-2xl">
            <div class="modal-body p-6 text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-orange-100 mb-4">
                    <i class="fas fa-exclamation-triangle text-orange-600 text-2xl"></i>
                </div>

                <h3 class="text-xl font-bold text-gray-900 mb-4">Konfirmasi Multiple Booking</h3>

                <div class="text-gray-600 text-sm space-y-3 mb-6">
                    <p class="font-medium">Apakah Anda yakin ingin memesan <strong
                            id="konfirmasiJumlahMobil">0</strong> mobil sekaligus?</p>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 text-left">
                        <h4 class="font-semibold text-blue-800 text-sm mb-2">Yang akan Anda lakukan:</h4>
                        <ul class="text-blue-700 text-xs space-y-1">
                            <li>• Input data peserta untuk setiap mobil secara terpisah</li>
                            <li>• Pembayaran dan e-ticket akan dibuat sesuai jumlah mobil</li>
                            <li>• Setiap mobil akan memiliki booking terpisah</li>
                        </ul>
                    </div>
                </div>

                <div class="flex space-x-3">
                    <button onclick="batalkanMultipleBooking()"
                        class="flex-1 bg-gray-100 text-gray-700 font-medium py-3 px-6 rounded-lg hover:bg-gray-200 transition">
                        Batal
                    </button>
                    <button onclick="lanjutkanMultipleBooking()"
                        class="flex-1 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-medium py-3 px-6 rounded-lg hover:shadow-lg transition">
                        Ya, Lanjutkan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Confirmation Modal -->
    <div id="modalKonfirmasi" class="hidden modal-overlay">
        <div class="modal-content bg-white rounded-2xl shadow-2xl">
            <div class="modal-body p-6 text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                    <i class="fas fa-check text-green-600 text-2xl"></i>
                </div>

                <h3 class="text-xl font-bold text-gray-900 mb-4">Booking Berhasil!</h3>

                <div class="text-gray-600 text-sm space-y-3 mb-6">
                    <p class="font-medium">
                        <span id="pesanSukses">Booking berhasil dibuat</span>
                    </p>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-6 text-left">
                    <h4 class="font-semibold text-blue-800 text-sm mb-2">
                        <i class="fas fa-info-circle mr-1"></i> Informasi Penting:
                    </h4>
                    <ul class="text-blue-700 text-xs space-y-1">
                        <li>• Untuk booking online besok atau 1 hari setelahnya, customer hanya bisa booking maksimal
                            jam 21:00</li>
                        <li>• Jika di atas jam 21:00, semua mobil tidak tersedia karena kantor tutup jam 21:00</li>

                    </ul>
                </div>

                <button onclick="tutupModalKonfirmasi()"
                    class="w-full bg-gradient-to-r from-teal-500 to-teal-600 text-white font-medium py-3 px-6 rounded-lg hover:shadow-lg transition">
                    OK
                </button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 sm:py-12">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                <div class="text-center md:text-left">
                    <div class="flex items-center mb-3 gap-3">
                        <img src="{{ $base64 }}" alt="Logo Bali Om" class="h-10 w-auto">
                    </div>
                    <p class="text-gray-300 mb-4 text-sm sm:text-base">Menyediakan pengalaman wisata terbaik di Bali
                        dengan pelayanan profesional dan harga terjangkau.</p>
                    <div class="flex space-x-4 justify-center md:justify-start">
                        <a href="#" class="text-gray-300 hover:text-teal-400 transition p-2 touch-target"><i
                                class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-300 hover:text-teal-400 transition p-2 touch-target"><i
                                class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-300 hover:text-teal-400 transition p-2 touch-target"><i
                                class="fab fa-whatsapp"></i></a>
                    </div>
                </div>

                <div class="text-center md:text-left">
                    <h3 class="text-lg font-semibold mb-3 sm:mb-4">Kontak Kami</h3>
                    <ul class="space-y-2 sm:space-y-3 text-gray-300 text-sm sm:text-base">
                        <li class="flex items-start justify-center md:justify-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-teal-400"></i>
                            <span>Jl. Bisma No. 3 Ubud, Gianyar Bali 80571</span>
                        </li>
                        <li class="flex items-start justify-center md:justify-start">
                            <i class="fas fa-phone-alt mt-1 mr-3 text-teal-400"></i>
                            <span>+62 822 3739 7076</span>
                        </li>
                        <li class="flex items-start justify-center md:justify-start">
                            <i class="fas fa-envelope mt-1 mr-3 text-teal-400"></i>
                            <span>info@baliomtours.com</span>
                        </li>
                    </ul>
                </div>

                <div class="text-center lg:text-left">
                    <h3 class="text-lg font-semibold mb-3 sm:mb-4">Jam Operasional</h3>
                    <ul class="space-y-2 text-gray-300 text-sm sm:text-base max-w-xs mx-auto lg:mx-0">
                        <li class="flex justify-between">
                            <span>Senin - Jumat:</span>
                            <span>08:00 - 21:00</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Sabtu:</span>
                            <span>09:00 - 15:00</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Minggu:</span>
                            <span>Tutup</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-6 pt-6 text-center text-gray-400 text-sm">
                <p>&copy; 2025 Bali Om Tour. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // Global variables
        const urlStorage = "{{ asset('storage') }}";
        const urlApi = "{{ route('check-availability') }}";
        const isLoggedIn = {{ Auth::guard('pelanggan')->check() ? 'true' : 'false' }};
        const currentUser = @json(Auth::guard('pelanggan')->user());

        // State untuk menyimpan pilihan
        const terpilih = {
            paketId: null,
            paketNama: '',
            harga: 0,
            tanggal: '',
            waktu: '',
            fotoPath: '',
            mobil: [],
            pointsUsed: 0,
            discount: 0
        };

        // Menu toggle
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Modal functions
        function bukaModalLogin() {
            document.getElementById('modalLogin').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function tutupModalLogin() {
            document.getElementById('modalLogin').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function bukaModalRegister() {
            tutupModalLogin();
            document.getElementById('modalRegister').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function tutupModalRegister() {
            document.getElementById('modalRegister').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function bukaModalMember() {
            document.getElementById('modalMember').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function tutupModalMember() {
            document.getElementById('modalMember').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function bukaModalDashboard() {
            document.getElementById('modalDashboard').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function tutupModalDashboard() {
            document.getElementById('modalDashboard').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function bukaModalProfile() {
            document.getElementById('modalProfile').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function tutupModalProfile() {
            document.getElementById('modalProfile').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function bukaModalDetailPaket() {
            document.getElementById('modalDetailPaket').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function tutupModalDetailPaket() {
            document.getElementById('modalDetailPaket').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Login form handler
        document.getElementById('formLogin').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const tombolLogin = document.getElementById('tombolLogin');
            const loginError = document.getElementById('loginError');

            tombolLogin.disabled = true;
            tombolLogin.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
            loginError.classList.add('hidden');

            try {
                const response = await fetch('/pelanggan/login', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                });

                if (response.ok) {
                    window.location.reload();
                } else {
                    const data = await response.json();
                    loginError.querySelector('p').textContent = data.message || 'Email atau password salah.';
                    loginError.classList.remove('hidden');
                }
            } catch (error) {
                loginError.querySelector('p').textContent = 'Terjadi kesalahan. Silakan coba lagi.';
                loginError.classList.remove('hidden');
            } finally {
                tombolLogin.disabled = false;
                tombolLogin.innerHTML = '<i class="fas fa-sign-in-alt mr-2"></i>Masuk';
            }
        });

        // Register form handler
        document.getElementById('formRegister').addEventListener('submit', async function(e) {
            e.preventDefault();

            // Validate reCAPTCHA
            const recaptchaResponse = grecaptcha.getResponse();
            if (!recaptchaResponse) {
                const registerError = document.getElementById('registerError');
                registerError.querySelector('p').textContent = 'Silakan lengkapi CAPTCHA terlebih dahulu.';
                registerError.classList.remove('hidden');
                return;
            }

            const formData = new FormData(this);
            formData.set('g-recaptcha-response', recaptchaResponse);
            
            const tombolRegister = document.getElementById('tombolRegister');
            const registerError = document.getElementById('registerError');

            tombolRegister.disabled = true;
            tombolRegister.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
            registerError.classList.add('hidden');

            try {
                const response = await fetch('/pelanggan/register', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                });

                if (response.ok) {
                    window.location.reload();
                } else {
                    const data = await response.json();
                    registerError.querySelector('p').textContent = data.message ||
                        'Terjadi kesalahan saat mendaftar.';
                    registerError.classList.remove('hidden');
                    grecaptcha.reset();
                }
            } catch (error) {
                registerError.querySelector('p').textContent = 'Terjadi kesalahan. Silakan coba lagi.';
                registerError.classList.remove('hidden');
                grecaptcha.reset();
            } finally {
                tombolRegister.disabled = false;
                tombolRegister.innerHTML = '<i class="fas fa-user-plus mr-2"></i>Daftar';
            }
        });

        // Profile update form handler
        document.getElementById('formProfile').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const tombolUpdate = document.getElementById('tombolUpdateProfile');
            const profileError = document.getElementById('profileError');
            const profileSuccess = document.getElementById('profileSuccess');

            tombolUpdate.disabled = true;
            tombolUpdate.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
            profileError.classList.add('hidden');
            profileSuccess.classList.add('hidden');

            try {
                const response = await fetch('/pelanggan/profile/update', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    profileSuccess.querySelector('p').textContent = data.message;
                    profileSuccess.classList.remove('hidden');

                    // Refresh page after 2 seconds to show updated data
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    profileError.querySelector('p').textContent = data.message ||
                        'Terjadi kesalahan saat memperbarui profil.';
                    profileError.classList.remove('hidden');
                }
            } catch (error) {
                profileError.querySelector('p').textContent = 'Terjadi kesalahan. Silakan coba lagi.';
                profileError.classList.remove('hidden');
            } finally {
                tombolUpdate.disabled = false;
                tombolUpdate.innerHTML = '<i class="fas fa-save mr-2"></i>Update Profil';
            }
        });

        // Points can only be used for booking discounts, not redeemed for cash

        function togglePointsRedemption() {
            const usePoints = document.getElementById('usePoints').checked;
            const pointsInputSection = document.getElementById('pointsInputSection');
            const pointsSection = document.getElementById('pointsRedemptionSection');

            if (usePoints) {
                pointsInputSection.classList.remove('hidden');
                pointsSection.classList.add('points-active');
                // Set default value
                @if($activePointSettings->isNotEmpty())
                    document.getElementById('pointsToUse').value = {{ $activePointSettings->first()->jumlah_point_diperoleh }};
                @else
                    document.getElementById('pointsToUse').value = 5;
                @endif
                calculatePointsDiscount();
            } else {
                pointsInputSection.classList.add('hidden');
                pointsSection.classList.remove('points-active', 'discount-applied');
                document.getElementById('pointsDiscountPreview').classList.add('hidden');
                terpilih.pointsUsed = 0;
                terpilih.discount = 0;
                updateTotalPrice();
            }
        }

        function toggleUpdateAlamat() {
            const updateAlamat = document.getElementById('updateAlamat').checked;
            const alamatInputSection = document.getElementById('alamatInputSection');

            if (updateAlamat) {
                alamatInputSection.classList.remove('hidden');
                // Set default value dari alamat saat ini
                const alamatSaatIni = currentUser ? currentUser.alamat : '';
                document.getElementById('alamatBaru').value = alamatSaatIni;
            } else {
                alamatInputSection.classList.add('hidden');
                document.getElementById('alamatBaru').value = '';
            }
        }

        function validateParticipantCount(input) {
            const mobilIndex = input.dataset.mobilIndex;
            const maxCapacity = parseInt(input.dataset.maxCapacity);
            const currentValue = parseInt(input.value);
            const errorElement = document.getElementById(`error-${mobilIndex}`);
            const tombolKonfirmasi = document.getElementById('tombolKonfirmasiBooking');

            // Validasi input
            if (currentValue < 1) {
                input.value = 1;
                input.classList.add('border-red-500');
                errorElement.classList.remove('hidden');
                errorElement.innerHTML = '<i class="fas fa-exclamation-triangle mr-1"></i>Minimal 1 peserta';
                tombolKonfirmasi.disabled = true;
                return false;
            }

            if (currentValue > maxCapacity) {
                input.value = maxCapacity;
                input.classList.add('border-red-500');
                errorElement.classList.remove('hidden');
                errorElement.innerHTML = '<i class="fas fa-exclamation-triangle mr-1"></i>Maksimal ' + maxCapacity +
                    ' peserta';
                tombolKonfirmasi.disabled = true;
                return false;
            }

            // Input valid
            input.classList.remove('border-red-500');
            errorElement.classList.add('hidden');

            // Cek apakah semua input valid
            const allInputs = document.querySelectorAll('.participant-input');
            let allValid = true;
            allInputs.forEach(input => {
                const value = parseInt(input.value);
                const maxCap = parseInt(input.dataset.maxCapacity);
                if (value < 1 || value > maxCap) {
                    allValid = false;
                }
            });

            tombolKonfirmasi.disabled = !allValid;
            return true;
        }

        function calculatePointsDiscount() {
            const pointsToUse = parseInt(document.getElementById('pointsToUse').value) || 0;
            const maxPoints = currentUser ? currentUser.points : 0;

            // Validate points
            if (pointsToUse > maxPoints) {
                document.getElementById('pointsToUse').value = maxPoints;
                return calculatePointsDiscount();
            }

            @if($activePointSettings->isNotEmpty())
                const pointsForDiscount = {{ $activePointSettings->first()->jumlah_point_diperoleh }};
                const discountPerPoints = {{ $activePointSettings->first()->harga_satuan_point }};
            @else
                const pointsForDiscount = 5;
                const discountPerPoints = 10000;
            @endif

            if (pointsToUse % pointsForDiscount !== 0) {
                document.getElementById('pointsToUse').value = Math.floor(pointsToUse / pointsForDiscount) *
                    pointsForDiscount;
                return calculatePointsDiscount();
            }

            const discount = (pointsToUse / pointsForDiscount) * discountPerPoints;

            terpilih.pointsUsed = pointsToUse;
            terpilih.discount = discount;

            if (pointsToUse > 0) {
                document.getElementById('discountAmount').textContent = 'Rp ' + discount.toLocaleString('id-ID');
                document.getElementById('pointsDiscountPreview').classList.remove('hidden');
                document.getElementById('pointsRedemptionSection').classList.add('discount-applied');
            } else {
                document.getElementById('pointsDiscountPreview').classList.add('hidden');
                document.getElementById('pointsRedemptionSection').classList.remove('discount-applied');
            }

            updateTotalPrice();
        }

        function updateTotalPrice() {
            let totalHarga = 0;
            terpilih.mobil.forEach(() => {
                totalHarga += terpilih.harga;
            });

            const subtotal = totalHarga;
            const finalTotal = Math.max(0, subtotal - terpilih.discount);

            document.getElementById('previewSubtotal').innerText = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(subtotal);

            document.getElementById('previewHarga').innerText = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(finalTotal);

            // Show savings info
            if (terpilih.discount > 0) {
                document.getElementById('totalSavings').textContent = 'Rp ' + terpilih.discount.toLocaleString('id-ID');
                document.getElementById('savingsInfo').classList.remove('hidden');
            } else {
                document.getElementById('savingsInfo').classList.add('hidden');
            }
        }

        // Member payment function
        function bayarMember() {
            if (!isLoggedIn) {
                tutupModalMember();
                bukaModalLogin();
                return;
            }

            const tombolBayar = document.getElementById('tombolBayarMember');
            tombolBayar.disabled = true;
            tombolBayar.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';

            // Create member payment order
            fetch('/member/upgrade', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.snap_token) {
                        snap.pay(data.snap_token, {
                            onSuccess: function(result) {
                                console.log("Hasil pembayaran:", result);
                                alert("Pembayaran berhasil! Anda sekarang adalah member.");

                                // Jika mau kirim data ke server (tanpa callback Midtrans)
                                fetch('/member/payment/success', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector(
                                                'meta[name="csrf-token"]').getAttribute('content')
                                        },
                                        body: JSON.stringify(result)
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        console.log(data.message);
                                        window.location.reload();
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        alert("Terjadi kesalahan saat memperbarui status member.");
                                    });
                            },
                            onPending: function(result) {
                                alert("Menunggu pembayaran!");
                                tutupModalMember();
                            },
                            onError: function(result) {
                                alert("Pembayaran gagal!");
                            },
                            onClose: function() {
                                alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                            }
                        });
                    } else {
                        alert('Gagal membuat pembayaran');
                    }
                })

                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan');
                })
                .finally(() => {
                    tombolBayar.disabled = false;
                    tombolBayar.innerHTML = '<i class="fas fa-credit-card mr-2"></i>Bayar Sekarang';
                });
        }

        // Detail paket function
        function lihatDetail(slug) {
            fetch(`/paket/${slug}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => response.text())
                .then(html => {
                    // Parse the HTML and extract the content we need
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    // Extract title and content
                    const title = doc.querySelector('h1').textContent;
                    const content = doc.querySelector('.container').innerHTML;

                    document.getElementById('detailPaketJudul').textContent = title;
                    document.getElementById('detailPaketContent').innerHTML = content;

                    bukaModalDetailPaket();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal memuat detail paket');
                });
        }

        // Booking functions
        function bukaStep1(id, nama, harga, foto) {
            if (!isLoggedIn) {
                bukaModalLogin();
                return;
            }

            terpilih.paketId = id;
            terpilih.paketNama = nama;
            terpilih.harga = harga;
            terpilih.fotoPath = foto ? urlStorage + '/' + foto : '';
            terpilih.mobil = [];
            terpilih.pointsUsed = 0;
            terpilih.discount = 0;

            resetPilihanKendaraan();

            const hariIni = new Date();
            const tahun = hariIni.getFullYear();
            const bulan = String(hariIni.getMonth() + 1).padStart(2, '0');
            const hari = String(hariIni.getDate()).padStart(2, '0');
            const tanggalTerformat = `${tahun}-${bulan}-${hari}`;

            terpilih.tanggal = tanggalTerformat;
            perbaruiPeringatanWaktuBooking(tanggalTerformat);

            setTimeout(() => {
                cekKetersediaanKendaraan(tanggalTerformat);
            }, 100);

            document.getElementById('kontainerPicker').classList.remove('hidden');
            document.getElementById('step1').classList.remove('hidden');
            document.getElementById('step2').classList.add('hidden');
            document.body.style.overflow = 'hidden';
        }

        function tutupPicker() {
            document.getElementById('kontainerPicker').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function tutupModalKonfirmasi() {
            document.getElementById('modalKonfirmasi').classList.add('hidden');
            document.body.style.overflow = 'auto';
            tutupPicker();

            // Refresh halaman untuk update status member jika ada perubahan
            window.location.reload();
        }

        // Booking process function
        function prosesBooking() {
            if (!isLoggedIn) {
                bukaModalLogin();
                return;
            }

            // Validasi kapasitas mobil sebelum submit
            const allInputs = document.querySelectorAll('.participant-input');
            let validationError = false;

            allInputs.forEach(input => {
                const value = parseInt(input.value);
                const maxCap = parseInt(input.dataset.maxCapacity);
                if (value < 1 || value > maxCap) {
                    validationError = true;
                    validateParticipantCount(input);
                }
            });

            if (validationError) {
                alert('Mohon periksa jumlah peserta untuk setiap mobil');
                return;
            }

            const tombolKonfirmasi = document.getElementById('tombolKonfirmasiBooking');
            tombolKonfirmasi.disabled = true;
            tombolKonfirmasi.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';

            // Validate form data
            const formData = new FormData();

            // Add CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (csrfToken) {
                formData.append('_token', csrfToken.getAttribute('content'));
            } else {
                // Fallback: get from form
                const tokenInput = document.querySelector('input[name="_token"]');
                if (tokenInput) {
                    formData.append('_token', tokenInput.value);
                }
            }

            // Add basic booking data
            formData.append('paket_id', terpilih.paketId);
            formData.append('tanggal', terpilih.tanggal);
            formData.append('jam_mulai', terpilih.waktu);
            formData.append('points_used', terpilih.pointsUsed);

            // Add address data
            const updateAlamat = document.getElementById('updateAlamat').checked;
            formData.append('update_alamat', updateAlamat.toString());
            if (updateAlamat) {
                const alamatBaru = document.getElementById('alamatBaru').value;
                formData.append('alamat_baru', alamatBaru);
            }

            // Add selected cars data
            terpilih.mobil.forEach((mobil, index) => {
                formData.append('mobil_ids[]', mobil.id);
            });

            // Add participant data
            const participantInputs = document.querySelectorAll('input[name="jumlah_peserta[]"]');
            participantInputs.forEach(input => {
                formData.append('jumlah_peserta[]', input.value);
            });

            // Debug: Log form data
            console.log('Sending booking data:');
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }

            // Submit booking
            fetch('/booking', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => Promise.reject(err));
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Jangan tampilkan modal konfirmasi dulu
                        // Langsung trigger pembayaran jika ada snap token
                        if (data.snap_token) {
                            snap.pay(data.snap_token, {
                                onSuccess: function(result) {
                                    console.log("Hasil pembayaran:", result);

                                    // Kirim data ke server dulu
                                    fetch('/booking/payment/success', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': document.querySelector(
                                                    'meta[name="csrf-token"]').getAttribute(
                                                    'content')
                                            },
                                            body: JSON.stringify(result)
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            console.log(data.message);

                                            // Baru tampilkan modal setelah server berhasil diupdate
                                            let successMessage =
                                                "Pembayaran berhasil! E-ticket akan segera dikirim.";
                                            if (terpilih.pointsUsed > 0) {
                                                successMessage +=
                                                    ` Anda menghemat Rp ${terpilih.discount.toLocaleString('id-ID')} dengan ${terpilih.pointsUsed} poin!`;
                                            }
                                            document.getElementById('pesanSukses').textContent =
                                                successMessage;
                                            document.getElementById('modalKonfirmasi').classList.remove(
                                                'hidden');
                                        })
                                        .catch(error => {
                                            console.error('Error:', error);

                                            // Tetap tampilkan modal meski ada error server
                                            document.getElementById('pesanSukses').textContent =
                                                "Pembayaran berhasil, namun terjadi kesalahan saat memperbarui status. Silakan hubungi customer service.";
                                            document.getElementById('modalKonfirmasi').classList.remove(
                                                'hidden');
                                        });
                                },
                                onPending: function(result) {
                                    // Tampilkan modal untuk pending payment
                                    document.getElementById('pesanSukses').textContent =
                                        "Pembayaran sedang diproses. E-ticket akan dikirim setelah pembayaran dikonfirmasi.";
                                    document.getElementById('modalKonfirmasi').classList.remove('hidden');
                                },
                                onError: function(result) {
                                    alert("Pembayaran gagal! Silakan coba lagi.");
                                    console.error('Payment error:', result);
                                },
                                onClose: function() {
                                    // User menutup popup pembayaran


                                    // Tampilkan modal dengan pesan hold
                                    document.getElementById('pesanSukses').textContent =
                                        "Booking berhasil dibuat dan silakan cek email untuk melihat detail E-Ticket.";
                                    document.getElementById('modalKonfirmasi').classList.remove('hidden');
                                }
                            });
                        } else {
                            // Jika tidak ada snap token, tampilkan pesan error
                            alert('Gagal membuat pembayaran. Silakan coba lagi.');
                        }
                    } else {
                        alert(data.message || 'Terjadi kesalahan saat membuat booking');
                    }
                })
                .catch(error => {
                    console.error('Booking Error:', error);
                    if (error.message) {
                        alert(error.message);
                    } else if (error.error) {
                        alert(error.error);
                    } else {
                        alert('Terjadi kesalahan saat memproses booking');
                    }
                })
                .finally(() => {
                    tombolKonfirmasi.disabled = false;
                    tombolKonfirmasi.innerHTML = 'Konfirmasi & Bayar <i class="fas fa-check ml-2"></i>';
                });
        }

        // Initialize flatpickr and other booking functionality
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize flatpickr
            flatpickr("#tglPicker", {
                inline: true,
                locale: "id",
                dateFormat: "Y-m-d",
                minDate: "today",
                defaultDate: "today",
                static: true,
                onChange: (dates, str) => {
                    terpilih.tanggal = str;
                    perbaruiPeringatanWaktuBooking(str);
                    cekKetersediaanKendaraan(str);
                }
            });

            flatpickr("#timePicker", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
                minuteIncrement: 30,
                onChange: (dates, str) => {
                    terpilih.waktu = str;
                    aktifkanTombolLanjutJikaSiap();
                }
            });

            // Car selection event listeners
            document.querySelectorAll('.tombol-kendaraan').forEach(btn => {
                btn.addEventListener('click', () => {
                    if (btn.style.display === 'none') return;

                    const mobilId = btn.dataset.id;
                    const mobilNama = btn.dataset.tipe;
                    const mobilKursi = parseInt(btn.dataset.seats);

                    const indexMobil = terpilih.mobil.findIndex(m => m.id === mobilId);

                    if (indexMobil >= 0) {
                        terpilih.mobil.splice(indexMobil, 1);
                        btn.classList.remove('car-selected');
                        const counter = btn.querySelector('.car-counter');
                        if (counter) counter.remove();
                    } else {
                        terpilih.mobil.push({
                            id: mobilId,
                            nama: mobilNama,
                            kursi: mobilKursi
                        });

                        btn.classList.add('car-selected');

                        if (terpilih.mobil.length > 1) {
                            const oldCounter = btn.querySelector('.car-counter');
                            if (oldCounter) oldCounter.remove();

                            const counter = document.createElement('span');
                            counter.className = 'car-counter';
                            counter.textContent = terpilih.mobil.length;
                            btn.appendChild(counter);
                        }
                    }

                    perbaruiCounterMobil();
                    aktifkanTombolLanjutJikaSiap();
                });
            });

            // Initialize pagination and search
            initializePagination();
        });

        // Helper functions for booking
        function apakahBookingDiizinkan(tanggalTerpilih) {
            const sekarang = new Date();
            const terpilih = new Date(tanggalTerpilih);
            const besok = new Date();
            besok.setDate(besok.getDate() + 1);

            if (terpilih.toDateString() === besok.toDateString()) {
                const jamSekarang = sekarang.getHours();
                if (jamSekarang >= 17) {
                    return false;
                }
            }

            return true;
        }

        function perbaruiPeringatanWaktuBooking(tanggalTerpilih) {
            const peringatanWaktuBooking = document.getElementById('peringatanWaktuBooking');
            if (!apakahBookingDiizinkan(tanggalTerpilih)) {
                peringatanWaktuBooking.classList.remove('hidden');
            } else {
                peringatanWaktuBooking.classList.add('hidden');
            }
        }

        function cekKetersediaanKendaraan(tanggal) {
            resetPilihanKendaraan();
            const indikatorLoadingTanggal = document.getElementById('indikatorLoadingTanggal');
            indikatorLoadingTanggal.classList.remove('hidden');

            if (!apakahBookingDiizinkan(tanggal)) {
                indikatorLoadingTanggal.classList.add('hidden');
                perbaruiKetersediaanKendaraan([]);
                return;
            }

            fetch(`${urlApi}?date=${tanggal}`)
                .then(response => response.json())
                .then(data => {
                    indikatorLoadingTanggal.classList.add('hidden');
                    perbaruiKetersediaanKendaraan(data || []);
                })
                .catch(error => {
                    console.error('Error saat mengecek ketersediaan:', error);
                    indikatorLoadingTanggal.classList.add('hidden');
                    perbaruiKetersediaanKendaraan([1, 3]); // fallback data
                });
        }

        function perbaruiKetersediaanKendaraan(idKendaraanTersedia) {
            const tombolKendaraan = document.querySelectorAll('.tombol-kendaraan');
            const pesanTidakAdaMobil = document.getElementById('pesanTidakAdaMobil');
            const daftarKendaraan = document.getElementById('daftarKendaraan');
            let adaKendaraanTersedia = false;

            tombolKendaraan.forEach(btn => {
                const idKendaraan = parseInt(btn.dataset.id);

                if (idKendaraanTersedia.includes(idKendaraan)) {
                    btn.style.display = 'flex';
                    btn.disabled = false;
                    adaKendaraanTersedia = true;
                } else {
                    btn.style.display = 'none';
                }
            });

            if (!adaKendaraanTersedia) {
                pesanTidakAdaMobil.classList.remove('hidden');
                daftarKendaraan.classList.add('hidden');
            } else {
                pesanTidakAdaMobil.classList.add('hidden');
                daftarKendaraan.classList.remove('hidden');
            }

            aktifkanTombolLanjutJikaSiap();
        }

        function resetPilihanMobil() {
            terpilih.mobil = [];

            document.querySelectorAll('.tombol-kendaraan').forEach(btn => {
                btn.classList.remove('car-selected');
                const counter = btn.querySelector('.car-counter');
                if (counter) counter.remove();
            });

            perbaruiCounterMobil();
            aktifkanTombolLanjutJikaSiap();
            document.getElementById('tombolResetPilihan').classList.add('hidden');
        }

        function resetPilihanKendaraan() {
            resetPilihanMobil();

            document.querySelectorAll('.tombol-kendaraan').forEach(btn => {
                btn.style.display = 'flex';
                btn.disabled = false;
            });

            document.getElementById('pesanTidakAdaMobil').classList.add('hidden');
            document.getElementById('daftarKendaraan').classList.remove('hidden');
            document.getElementById('peringatanMultipleBooking').classList.add('hidden');
            aktifkanTombolLanjutJikaSiap();
        }

        function perbaruiCounterMobil() {
            const jumlahMobil = terpilih.mobil.length;
            const selectedCarsCounter = document.getElementById('selectedCarsCounter');
            const selectedCarsCount = document.getElementById('selectedCarsCount');
            const peringatanMultipleBooking = document.getElementById('peringatanMultipleBooking');
            const jumlahMobilDipesan = document.getElementById('jumlahMobilDipesan');
            const tombolResetPilihan = document.getElementById('tombolResetPilihan');

            if (jumlahMobil > 0) {
                selectedCarsCount.textContent = jumlahMobil;
                selectedCarsCounter.classList.remove('hidden');

                if (jumlahMobil > 1) {
                    peringatanMultipleBooking.classList.remove('hidden');
                    jumlahMobilDipesan.textContent = jumlahMobil;
                } else {
                    peringatanMultipleBooking.classList.add('hidden');
                }

                tombolResetPilihan.classList.remove('hidden');
            } else {
                selectedCarsCounter.classList.add('hidden');
                peringatanMultipleBooking.classList.add('hidden');
                tombolResetPilihan.classList.add('hidden');
            }
        }

        function aktifkanTombolLanjutJikaSiap() {
            const tombolLanjutStep = document.getElementById('tombolLanjutStep');
            if (terpilih.tanggal && terpilih.waktu && terpilih.mobil.length > 0) {
                tombolLanjutStep.disabled = false;
                tombolLanjutStep.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                tombolLanjutStep.disabled = true;
                tombolLanjutStep.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }

        function keStep2() {
            if (!terpilih.tanggal) return alert('Pilih tanggal dahulu');
            if (!terpilih.waktu) return alert('Pilih jam mulai dahulu');
            if (terpilih.mobil.length === 0) return alert('Pilih minimal 1 mobil dahulu');

            if (terpilih.mobil.length > 1) {
                document.getElementById('konfirmasiJumlahMobil').textContent = terpilih.mobil.length;
                document.getElementById('modalKonfirmasiMultiple').classList.remove('hidden');
                return;
            }

            lanjutkanKeStep2();
        }

        function batalkanMultipleBooking() {
            document.getElementById('modalKonfirmasiMultiple').classList.add('hidden');
        }

        function lanjutkanMultipleBooking() {
            document.getElementById('modalKonfirmasiMultiple').classList.add('hidden');
            lanjutkanKeStep2();
        }

        function lanjutkanKeStep2() {
            // Fill preview
            document.getElementById('previewPaket').innerText =
                terpilih.paketNama;
            document.getElementById('previewTanggal').innerText = new Date(terpilih.tanggal).toLocaleDateString(
                'id-ID', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            document.getElementById('previewWaktu').innerText = terpilih.waktu;

            // Preview foto
            const wrapperPreviewFoto = document.getElementById('wrapperPreviewFoto');
            const previewFoto = document.getElementById('previewFoto');

            if (terpilih.fotoPath) {
                previewFoto.src = terpilih.fotoPath;
                wrapperPreviewFoto.classList.remove('hidden');
            } else {
                previewFoto.src = '/placeholder.svg';
                wrapperPreviewFoto.classList.add('hidden');
            }

            // Preview mobil
            const previewKendaraan = document.getElementById('previewKendaraan');
            previewKendaraan.innerHTML = '';
            terpilih.mobil.forEach(mobil => {
                const div = document.createElement('div');
                div.className = 'flex items-center justify-end space-x-2';
                div.innerHTML = `
                    <span class="text-sm font-medium">${mobil.nama}</span>
                    <i class="fas fa-user text-gray-500"></i>
                    <span class="text-xs text-gray-500">${mobil.kursi} Kursi</span>
                `;
                previewKendaraan.appendChild(div);
            });

            // Input hidden
            document.getElementById('inputPaketId').value = terpilih.paketId;
            document.getElementById('inputTanggal').value = terpilih.tanggal;
            document.getElementById('inputWaktu').value = terpilih.waktu;
            document.getElementById('inputPointsUsed').value = terpilih.pointsUsed;

            // Input mobil
            const hiddenMobilInputs = document.getElementById('hiddenMobilInputs');
            hiddenMobilInputs.innerHTML = '';
            terpilih.mobil.forEach(mobil => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'mobil_ids[]';
                input.value = mobil.id;
                hiddenMobilInputs.appendChild(input);
            });

            // Participant inputs
            const participantInputsContainer = document.getElementById('participantInputsContainer');
            participantInputsContainer.innerHTML = '';

            terpilih.mobil.forEach((mobil, index) => {
                const div = document.createElement('div');
                div.className = 'bg-white p-4 rounded-xl shadow-lg';
                div.innerHTML = `
                    <h5 class="text-lg font-semibold mb-3 text-gray-700">Mobil ${index + 1}: ${mobil.nama}</h5>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2 text-sm">Jumlah Peserta</label>
                        <input type="number" name="jumlah_peserta[]" min="1" max="${mobil.kursi}" value="${mobil.kursi}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm participant-input"
                            data-mobil-index="${index}" data-max-capacity="${mobil.kursi}" required
                            onchange="validateParticipantCount(this)">
                        <div class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Kapasitas maksimal: ${mobil.kursi} orang
                        </div>
                        <div class="mt-1 text-xs text-red-500 hidden" id="error-${index}">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            Jumlah peserta tidak boleh melebihi kapasitas mobil
                        </div>
                    </div>
                `;
                participantInputsContainer.appendChild(div);
            });

            // Update total price
            updateTotalPrice();

            // Show step 2
            document.getElementById('step1').classList.add('hidden');
            document.getElementById('step2').classList.remove('hidden');
        }

        function kembaliKeStep1() {
            document.getElementById('step1').classList.remove('hidden');
            document.getElementById('step2').classList.add('hidden');
        }

        // Search functionality
        const searchPackage = document.getElementById('searchPackage');
        const clearSearch = document.getElementById('clearSearch');
        const packageContainer = document.getElementById('packageContainer');
        const noResults = document.getElementById('noResults');
        const resetSearch = document.getElementById('resetSearch');
        const filterIndicator = document.getElementById('filterIndicator');
        const resultCount = document.getElementById('resultCount');
        const clearFilter = document.getElementById('clearFilter');

        searchPackage.addEventListener('input', function() {
            const searchTerm = searchPackage.value.toLowerCase();
            let resultFound = false;
            let count = 0;

            packageContainer.querySelectorAll('.package-card').forEach(function(card) {
                const packageName = card.dataset.name;
                const packageLocation = card.dataset.location;

                if (packageName.includes(searchTerm) || packageLocation.includes(searchTerm)) {
                    card.style.display = 'block';
                    resultFound = true;
                    count++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (searchTerm !== '' && resultFound) {
                noResults.style.display = 'none';
                filterIndicator.style.display = 'block';
                resultCount.textContent = count;
                clearSearch.classList.remove('hidden');
            } else if (searchTerm !== '' && !resultFound) {
                noResults.style.display = 'block';
                filterIndicator.style.display = 'none';
                clearSearch.classList.remove('hidden');
            } else {
                noResults.style.display = 'none';
                filterIndicator.style.display = 'none';
                clearSearch.classList.add('hidden');

                packageContainer.querySelectorAll('.package-card').forEach(function(card) {
                    card.style.display = 'block';
                });
            }

            updatePagination();
        });

        clearSearch.addEventListener('click', function() {
            searchPackage.value = '';
            noResults.style.display = 'none';
            filterIndicator.style.display = 'none';
            clearSearch.classList.add('hidden');

            packageContainer.querySelectorAll('.package-card').forEach(function(card) {
                card.style.display = 'block';
            });

            updatePagination();
        });

        resetSearch.addEventListener('click', function() {
            searchPackage.value = '';
            noResults.style.display = 'none';
            filterIndicator.style.display = 'none';
            clearSearch.classList.add('hidden');

            packageContainer.querySelectorAll('.package-card').forEach(function(card) {
                card.style.display = 'block';
            });

            updatePagination();
        });

        clearFilter.addEventListener('click', function() {
            searchPackage.value = '';
            noResults.style.display = 'none';
            filterIndicator.style.display = 'none';
            clearSearch.classList.add('hidden');

            packageContainer.querySelectorAll('.package-card').forEach(function(card) {
                card.style.display = 'block';
            });

            updatePagination();
        });

        // Pagination functionality
        const itemsPerPage = 6;
        let currentPage = 1;
        let packages = Array.from(document.getElementById('packageContainer').children);
        const paginationContainer = document.getElementById('pagination');
        const paginationInfo = document.getElementById('paginationInfo');
        const currentPageInfo = document.getElementById('currentPageInfo');
        const totalPagesInfo = document.getElementById('totalPagesInfo');

        function displayPage(page) {
            packages.forEach((item, index) => {
                if (index >= (page - 1) * itemsPerPage && index < page * itemsPerPage) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        function setupPagination() {
            const totalPages = Math.ceil(packages.length / itemsPerPage);
            paginationContainer.innerHTML = '';

            for (let i = 1; i <= totalPages; i++) {
                const btn = document.createElement('button');
                btn.textContent = i;
                btn.classList.add('pagination-btn', 'touch-target');
                btn.addEventListener('click', () => {
                    currentPage = i;
                    displayPage(currentPage);
                    updatePaginationButtons();
                    updatePaginationInfo();
                });

                paginationContainer.appendChild(btn);
            }

            updatePaginationButtons();
            updatePaginationInfo();
        }

        function updatePaginationButtons() {
            document.querySelectorAll('.pagination-btn').forEach(btn => {
                btn.classList.remove('active');
                if (parseInt(btn.textContent) === currentPage) {
                    btn.classList.add('active');
                }
            });
        }

        function updatePaginationInfo() {
            const totalPages = Math.ceil(packages.length / itemsPerPage);
            currentPageInfo.textContent = currentPage;
            totalPagesInfo.textContent = totalPages;
        }

        function checkMobileView() {
            if (window.innerWidth <= 640) {
                paginationContainer.classList.remove('space-x-1', 'sm:space-x-2', 'pagination-compact');
                paginationInfo.classList.remove('hidden');
            } else {
                paginationContainer.classList.add('space-x-1', 'sm:space-x-2', 'pagination-compact');
                paginationInfo.classList.add('hidden');
            }
        }

        function updatePagination() {
            packages = Array.from(document.getElementById('packageContainer').children);
            currentPage = 1;
            displayPage(currentPage);
            setupPagination();
            updatePaginationButtons();
            updatePaginationInfo();
        }

        function initializePagination() {
            displayPage(currentPage);
            setupPagination();
            checkMobileView();

            window.addEventListener('resize', () => {
                checkMobileView();
            });
        }
    </script>
    @livewireScripts
</body>

</html>
