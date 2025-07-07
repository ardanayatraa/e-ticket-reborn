<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $paket->judul }} - BALI OM TOURS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
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

        .sticky-header {
            position: sticky;
            top: 70px;
            z-index: 9;
            backdrop-filter: blur(8px);
            background-color: rgba(255, 255, 255, 0.95);
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

        /* Gallery styles */
        .gallery-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 12px;
        }

        .gallery-item {
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .gallery-item:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        /* Modal styles */
        .modal-overlay {
            backdrop-filter: blur(8px);
        }

        .modal-content {
            animation: modalSlideIn 0.3s ease-out;
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

        /* Mobile optimizations */
        @media (max-width: 640px) {
            .mobile-padding {
                padding-left: 16px !important;
                padding-right: 16px !important;
            }

            .touch-target {
                min-height: 44px;
                min-width: 44px;
            }
        }

        /* Package details styles */
        .detail-card {
            transition: all 0.3s ease;
        }

        .detail-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .price-highlight {
            background: linear-gradient(135deg, #0d9488, #0f766e);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .badge {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
    </style>
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
                <a href="/" class="flex items-center gap-3">
                    <img src="{{ $base64 }}" alt="Logo Bali Om" class="h-10 w-auto">
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-8 items-center">
                <a href="/" class="text-gray-700 hover:text-teal-600 transition font-medium">Beranda</a>
                <a href="/#paket" class="text-gray-700 hover:text-teal-600 transition font-medium">Paket Wisata</a>
                <a href="/#tentang" class="text-gray-700 hover:text-teal-600 transition font-medium">Tentang Kami</a>

                @auth('pelanggan')
                    <!-- Member Status & Points -->
                    <div class="flex items-center space-x-3">
                        @if (Auth::guard('pelanggan')->user()->is_member)
                            <div class="badge">
                                <i class="fas fa-crown mr-1"></i>MEMBER
                            </div>
                            <div
                                class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-3 py-1 rounded-full text-sm font-bold">
                                <i class="fas fa-star mr-1"></i>{{ Auth::guard('pelanggan')->user()->points }} Poin
                            </div>
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
                    <a href="/" class="text-gray-700 hover:text-teal-600 transition font-medium">Login</a>
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
            <a href="/"
                class="block py-4 px-4 text-gray-700 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition">Beranda</a>
            <a href="/#paket"
                class="block py-4 px-4 text-gray-700 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition">Paket
                Wisata</a>
            <a href="/#tentang"
                class="block py-4 px-4 text-gray-700 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition">Tentang
                Kami</a>

            @auth('pelanggan')
                <form method="POST" action="{{ route('pelanggan.logout') }}" class="block">
                    @csrf
                    <button type="submit"
                        class="block w-full text-left py-4 px-4 text-gray-700 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            @else
                <a href="/"
                    class="block py-4 px-4 text-gray-700 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition">Login</a>
            @endauth
        </div>
    </nav>

    <!-- Breadcrumb -->
    <div class="bg-white border-b pt-20">
        <div class="container mx-auto px-4 py-4">
            <nav class="flex text-sm text-gray-600">
                <a href="/" class="hover:text-teal-600 transition">Beranda</a>
                <span class="mx-2">/</span>
                <a href="/#paket" class="hover:text-teal-600 transition">Paket Wisata</a>
                <span class="mx-2">/</span>
                <span class="text-gray-800 font-medium">{{ $paket->judul }}</span>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Hero Section -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    @if ($paket->foto)
                        <div class="relative">
                            <img src="{{ asset('storage/' . $paket->foto) }}" alt="{{ $paket->judul }}"
                                class="w-full h-64 md:h-80 lg:h-96 object-cover">
                            <div class="absolute bottom-4 left-4">
                                <span class="bg-teal-600 text-white px-4 py-2 rounded-full font-semibold shadow-lg">
                                    {{ $paket->durasi }} Hari
                                </span>
                            </div>
                            @if ($paket->created_at->diffInDays(now()) < 7)
                                <span
                                    class="absolute top-4 left-4 bg-orange-500 text-white text-sm font-semibold px-3 py-1 rounded-full">
                                    Terbaru
                                </span>
                            @endif
                        </div>
                    @endif

                    <div class="p-6 md:p-8">
                        <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800 mb-4">
                            {{ $paket->judul }}
                        </h1>

                        <div class="flex flex-wrap items-center gap-4 mb-6">
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-map-marker-alt text-teal-600 mr-2"></i>
                                <span class="font-medium">{{ $paket->tempat }}</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-calendar-alt text-teal-600 mr-2"></i>
                                <span class="font-medium">{{ $paket->durasi }} Hari</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-clock text-teal-600 mr-2"></i>
                                <span class="font-medium">Maks {{ $paket->max_duration }} Jam/Hari</span>
                            </div>
                        </div>

                        <div class="text-gray-700 leading-relaxed text-lg">
                            {!! nl2br(e($paket->deskripsi)) !!}
                        </div>
                    </div>
                </div>

                <!-- Gallery Section -->
                @if ($paket->gallery && count($paket->gallery) > 0)
                    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">
                            <i class="fas fa-images text-teal-600 mr-3"></i>
                            Gallery Foto
                        </h2>
                        <div class="gallery-container">
                            @foreach ($paket->gallery as $index => $image)
                                <div class="gallery-item"
                                    onclick="openImageModal('{{ asset('storage/' . $image) }}', {{ $index }})">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Gallery {{ $index + 1 }}"
                                        class="w-full h-48 object-cover">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Include & Exclude Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Included -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 detail-card">
                        <h3 class="text-xl font-bold text-green-700 mb-6 flex items-center">
                            <i class="fas fa-check-circle text-green-600 mr-3"></i>
                            Yang Termasuk
                        </h3>
                        <div class="space-y-4">
                            @php
                                $includeItems = [
                                    'bensin' => ['label' => 'Bensin', 'icon' => '⛽'],
                                    'parkir' => ['label' => 'Parkir', 'icon' => '🅿️'],
                                    'sopir' => ['label' => 'Sopir', 'icon' => '👨‍✈️'],
                                    'makan_siang' => ['label' => 'Makan Siang', 'icon' => '🍽️'],
                                    'makan_malam' => ['label' => 'Makan Malam', 'icon' => '🍽️'],
                                    'tiket_masuk' => ['label' => 'Tiket Masuk', 'icon' => '🎫'],
                                ];
                                $hasInclude = false;
                            @endphp

                            @foreach ($includeItems as $field => $data)
                                @if ($paket->include && $paket->include->$field)
                                    @php $hasInclude = true; @endphp
                                    <div class="flex items-center text-green-700 bg-green-50 p-3 rounded-lg">
                                        <span class="text-2xl mr-3">{{ $data['icon'] }}</span>
                                        <span class="font-medium">{{ $data['label'] }}</span>
                                    </div>
                                @endif
                            @endforeach

                            @if (!$hasInclude)
                                <p class="text-gray-500 italic text-center py-4">Tidak ada fasilitas yang termasuk
                                    dalam paket ini</p>
                            @endif
                        </div>
                    </div>

                    <!-- Excluded -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 detail-card">
                        <h3 class="text-xl font-bold text-red-700 mb-6 flex items-center">
                            <i class="fas fa-times-circle text-red-600 mr-3"></i>
                            Yang Tidak Termasuk
                        </h3>
                        <div class="space-y-4">
                            @php $hasExclude = false; @endphp

                            @foreach ($includeItems as $field => $data)
                                @if ($paket->exclude && $paket->exclude->$field)
                                    @php $hasExclude = true; @endphp
                                    <div class="flex items-center text-red-700 bg-red-50 p-3 rounded-lg">
                                        <span class="text-2xl mr-3">{{ $data['icon'] }}</span>
                                        <span class="font-medium">{{ $data['label'] }}</span>
                                    </div>
                                @endif
                            @endforeach

                            @if (!$hasExclude)
                                <p class="text-gray-500 italic text-center py-4">Semua fasilitas termasuk dalam paket
                                    ini</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="space-y-6">
                <!-- Booking Card -->
                <div class="bg-white rounded-2xl shadow-lg p-6 detail-card sticky-header">
                    <div class="text-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Harga Paket</h3>
                        <div class="text-4xl font-bold price-highlight mb-2">
                            Rp {{ number_format($paket->harga, 0, ',', '.') }}
                        </div>
                        <p class="text-gray-600">per paket / {{ $paket->durasi }} hari</p>
                    </div>

                    <div class="space-y-4 mb-6">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-gray-600 flex items-center">
                                <i class="fas fa-map-marker-alt text-teal-600 mr-2"></i>
                                Lokasi
                            </span>
                            <span class="font-medium text-gray-800">{{ $paket->tempat }}</span>
                        </div>

                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-gray-600 flex items-center">
                                <i class="fas fa-calendar-alt text-teal-600 mr-2"></i>
                                Durasi
                            </span>
                            <span class="font-medium text-gray-800">{{ $paket->durasi }} Hari</span>
                        </div>

                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-gray-600 flex items-center">
                                <i class="fas fa-clock text-teal-600 mr-2"></i>
                                Max/Hari
                            </span>
                            <span class="font-medium text-gray-800">{{ $paket->max_duration }} Jam</span>
                        </div>
                    </div>

                    @auth('pelanggan')
                        <button onclick="bukaBooking()"
                            class="w-full bg-gradient-to-r from-teal-500 to-teal-600 text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 text-lg">
                            <i class="fas fa-calendar-check mr-2"></i>
                            Pesan Sekarang
                        </button>
                    @else
                        <a href="/"
                            class="block w-full text-center bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 text-lg">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Login untuk Pesan
                        </a>
                    @endauth

                    <div class="mt-4 text-center">
                        <a href="/#paket" class="text-teal-600 hover:text-teal-700 font-medium">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Lihat Paket Lainnya
                        </a>
                    </div>
                </div>

                <!-- Available Cars -->
                @if ($mobil && $mobil->count() > 0)
                    <div class="bg-white rounded-2xl shadow-lg p-6 detail-card">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-car text-teal-600 mr-3"></i>
                            Mobil Tersedia
                        </h3>
                        <div class="space-y-3">
                            @foreach ($mobil->take(5) as $car)
                                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                    <i class="fas fa-car text-blue-500 mr-3"></i>
                                    <div class="flex-1">
                                        <div class="font-medium text-gray-800">
                                            {{ $car->nama_kendaraan ?? ($car->merk ?? 'Mobil') }}</div>
                                        <div class="text-sm text-gray-600">{{ $car->jumlah_tempat_duduk ?? 'N/A' }}
                                            kursi</div>
                                    </div>
                                </div>
                            @endforeach
                            @if ($mobil->count() > 5)
                                <p class="text-sm text-gray-500 text-center mt-3">
                                    +{{ $mobil->count() - 5 }} mobil lainnya tersedia
                                </p>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Contact Info -->
                <div class="bg-gradient-to-br from-teal-500 to-teal-600 rounded-2xl shadow-lg p-6 text-white">
                    <h3 class="text-xl font-bold mb-4 flex items-center">
                        <i class="fas fa-phone-alt mr-3"></i>
                        Butuh Bantuan?
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <i class="fas fa-phone mr-3"></i>
                            <span>+62 822 3739 7076</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-envelope mr-3"></i>
                            <span>info@baliomtours.com</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fab fa-whatsapp mr-3"></i>
                            <span>WhatsApp Customer Service</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal"
        class="hidden fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50 modal-overlay">
        <div class="relative max-w-6xl max-h-full p-4 modal-content">
            <img id="modalImage" src="" alt="Full Image"
                class="max-w-full max-h-full object-contain rounded-lg shadow-2xl">
            <button onclick="closeImageModal()"
                class="absolute top-2 right-2 bg-white text-black rounded-full w-10 h-10 flex items-center justify-center hover:bg-gray-200 transition">
                <i class="fas fa-times"></i>
            </button>
            <div id="imageNavigation" class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                <button onclick="previousImage()"
                    class="bg-white bg-opacity-80 text-black rounded-full w-10 h-10 flex items-center justify-center hover:bg-opacity-100 transition">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button onclick="nextImage()"
                    class="bg-white bg-opacity-80 text-black rounded-full w-10 h-10 flex items-center justify-center hover:bg-opacity-100 transition">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12 mt-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                <div class="text-center md:text-left">
                    <div class="flex items-center mb-3 gap-3">
                        <img src="{{ $base64 }}" alt="Logo Bali Om" class="h-10 w-auto">
                    </div>
                    <p class="text-gray-300 mb-4">Menyediakan pengalaman wisata terbaik di Bali dengan pelayanan
                        profesional dan harga terjangkau.</p>
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
                    <h3 class="text-lg font-semibold mb-4">Kontak Kami</h3>
                    <ul class="space-y-3 text-gray-300">
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
                    <h3 class="text-lg font-semibold mb-4">Jam Operasional</h3>
                    <ul class="space-y-2 text-gray-300 max-w-xs mx-auto lg:mx-0">
                        <li class="flex justify-between">
                            <span>Senin - Jumat:</span>
                            <span>08:00 - 17:00</span>
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
        // Menu toggle
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Gallery functionality
        let currentImageIndex = 0;
        let galleryImages = [];

        // Initialize gallery images array
        @if ($paket->gallery && count($paket->gallery) > 0)
            galleryImages = [
                @foreach ($paket->gallery as $image)
                    "{{ asset('storage/' . $image) }}",
                @endforeach
            ];
        @endif

        function openImageModal(src, index) {
            currentImageIndex = index || 0;
            document.getElementById('modalImage').src = src;
            document.getElementById('imageModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Show/hide navigation buttons based on gallery size
            const navigation = document.getElementById('imageNavigation');
            if (galleryImages.length > 1) {
                navigation.classList.remove('hidden');
            } else {
                navigation.classList.add('hidden');
            }
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function previousImage() {
            if (galleryImages.length > 1) {
                currentImageIndex = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
                document.getElementById('modalImage').src = galleryImages[currentImageIndex];
            }
        }

        function nextImage() {
            if (galleryImages.length > 1) {
                currentImageIndex = (currentImageIndex + 1) % galleryImages.length;
                document.getElementById('modalImage').src = galleryImages[currentImageIndex];
            }
        }

        // Close modal when clicking outside image
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            const modal = document.getElementById('imageModal');
            if (!modal.classList.contains('hidden')) {
                switch (e.key) {
                    case 'Escape':
                        closeImageModal();
                        break;
                    case 'ArrowLeft':
                        previousImage();
                        break;
                    case 'ArrowRight':
                        nextImage();
                        break;
                }
            }
        });

        // Booking functionality
        function bukaBooking() {
            @auth('pelanggan')
                // Redirect to homepage with booking parameters
                const url = new URL('/', window.location.origin);
                url.hash = 'paket';
                url.searchParams.set('book', '{{ $paket->paketwisata_id }}');
                window.location.href = url.toString();
            @else
                // Redirect to login
                window.location.href = '/';
            @endauth
        }

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fadeIn');
                }
            });
        }, observerOptions);

        // Observe all detail cards
        document.querySelectorAll('.detail-card').forEach(card => {
            observer.observe(card);
        });

        // Back to top button functionality
        const backToTopButton = document.createElement('button');
        backToTopButton.innerHTML = '<i class="fas fa-chevron-up"></i>';
        backToTopButton.className =
            'fixed bottom-6 right-6 bg-teal-600 text-white p-3 rounded-full shadow-lg hover:bg-teal-700 transition-all duration-300 z-40 opacity-0 pointer-events-none';
        backToTopButton.id = 'backToTop';
        document.body.appendChild(backToTopButton);

        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopButton.style.opacity = '1';
                backToTopButton.style.pointerEvents = 'auto';
            } else {
                backToTopButton.style.opacity = '0';
                backToTopButton.style.pointerEvents = 'none';
            }
        });

        backToTopButton.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Share functionality
        function sharePackage() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $paket->judul }} - Bali Om Tours',
                    text: '{{ Str::limit($paket->deskripsi, 100) }}',
                    url: window.location.href
                });
            } else {
                // Fallback: copy to clipboard
                navigator.clipboard.writeText(window.location.href).then(() => {
                    alert('Link berhasil disalin ke clipboard!');
                });
            }
        }

        // Add share button to booking card
        document.addEventListener('DOMContentLoaded', function() {
            const bookingCard = document.querySelector('.sticky-header');
            if (bookingCard) {
                const shareButton = document.createElement('button');
                shareButton.innerHTML = '<i class="fas fa-share-alt mr-2"></i>Bagikan Paket';
                shareButton.className =
                    'w-full mt-3 bg-gray-100 text-gray-700 font-medium py-3 px-6 rounded-xl hover:bg-gray-200 transition-all duration-200';
                shareButton.onclick = sharePackage;

                const lastButton = bookingCard.querySelector('button, a');
                if (lastButton && lastButton.parentNode) {
                    lastButton.parentNode.insertBefore(shareButton, lastButton.nextSibling);
                }
            }
        });

        // Auto-detect if user came from booking link
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const shouldBook = urlParams.get('book');

            if (shouldBook === '{{ $paket->paketwisata_id }}') {
                // Scroll to booking section
                const bookingCard = document.querySelector('.sticky-header');
                if (bookingCard) {
                    bookingCard.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });

                    // Highlight booking card briefly
                    bookingCard.style.transform = 'scale(1.02)';
                    bookingCard.style.boxShadow = '0 20px 40px rgba(13, 148, 136, 0.3)';

                    setTimeout(() => {
                        bookingCard.style.transform = '';
                        bookingCard.style.boxShadow = '';
                    }, 2000);
                }
            }
        });
    </script>
</body>

</html>
