<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wonderful Journey - Paket Wisata Terbaik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                        },
                        secondary: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                        },
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-section {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://images.unsplash.com/photo-1542640244-7e672d6cef4e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
        }

        .package-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .package-card {
            transition: all 0.3s ease;
        }

        .vehicle-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .vehicle-card {
            transition: all 0.3s ease;
        }
    </style>
</head>

<body class="font-sans bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <a href="#" class="flex items-center">
                        <i class="fas fa-map-marked-alt text-primary-600 text-2xl mr-2"></i>
                        <span class="text-xl font-bold text-gray-800">Wonderful Journey</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex space-x-8">
                    <a href="#" class="text-primary-600 font-medium">Beranda</a>
                    <a href="#packages" class="text-gray-600 hover:text-primary-600 font-medium">Paket Wisata</a>
                    <a href="#vehicles" class="text-gray-600 hover:text-primary-600 font-medium">Kendaraan</a>
                    <a href="#testimonials" class="text-gray-600 hover:text-primary-600 font-medium">Testimoni</a>
                    <a href="#contact" class="text-gray-600 hover:text-primary-600 font-medium">Kontak</a>
                </nav>

                <div class="flex items-center">
                    <a href="#"
                        class="hidden md:inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Pesan Sekarang
                    </a>
                    <button class="md:hidden text-gray-600 focus:outline-none" id="mobileMenuButton">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div class="md:hidden hidden" id="mobileMenu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white shadow-md">
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-primary-600">Beranda</a>
                <a href="#packages"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-primary-600 hover:bg-gray-50">Paket
                    Wisata</a>
                <a href="#vehicles"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-primary-600 hover:bg-gray-50">Kendaraan</a>
                <a href="#testimonials"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-primary-600 hover:bg-gray-50">Testimoni</a>
                <a href="#contact"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-primary-600 hover:bg-gray-50">Kontak</a>
                <a href="#"
                    class="block px-3 py-2 rounded-md text-base font-medium text-white bg-primary-600 hover:bg-primary-700 mt-4">Pesan
                    Sekarang</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section py-20 md:py-32">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-3xl md:text-5xl font-bold text-white mb-6">Temukan Petualangan Wisata Terbaik</h1>
                <p class="text-lg md:text-xl text-white mb-8">Jelajahi destinasi wisata terbaik dengan paket perjalanan
                    yang sesuai dengan kebutuhan Anda</p>

                <!-- Search Form -->
                <div class="bg-white p-4 md:p-6 rounded-lg shadow-lg">
                    <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                        <div class="flex-1">
                            <label for="destination"
                                class="block text-sm font-medium text-gray-700 text-left mb-1">Destinasi</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-map-marker-alt text-gray-400"></i>
                                </div>
                                <input type="text" id="destination" name="destination"
                                    placeholder="Kemana Anda ingin pergi?"
                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                            </div>
                        </div>
                        <div class="flex-1">
                            <label for="date"
                                class="block text-sm font-medium text-gray-700 text-left mb-1">Tanggal</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar text-gray-400"></i>
                                </div>
                                <input type="date" id="date" name="date"
                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                            </div>
                        </div>
                        <div class="flex-1">
                            <label for="guests" class="block text-sm font-medium text-gray-700 text-left mb-1">Jumlah
                                Orang</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-users text-gray-400"></i>
                                </div>
                                <select id="guests" name="guests"
                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                                    <option value="1">1 Orang</option>
                                    <option value="2">2 Orang</option>
                                    <option value="3">3 Orang</option>
                                    <option value="4">4 Orang</option>
                                    <option value="5+">5+ Orang</option>
                                </select>
                            </div>
                        </div>
                        <div class="md:flex-none md:self-end">
                            <button type="submit"
                                class="w-full md:w-auto px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                <i class="fas fa-search mr-2"></i> Cari
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Packages Section -->
    <section id="packages" class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Paket Wisata Populer</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Temukan paket wisata terbaik dengan harga terjangkau
                    dan fasilitas lengkap untuk liburan yang tak terlupakan</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Package Card 1 -->
                <div class="package-card bg-white rounded-lg overflow-hidden shadow-md">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1539367628448-4bc5c9d171c8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1035&q=80"
                            alt="Bali Paradise" class="w-full h-56 object-cover">
                        <div
                            class="absolute top-4 right-4 bg-primary-500 text-white text-sm font-semibold px-3 py-1 rounded-full">
                            Terlaris</div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Bali Paradise Tour</h3>
                        <div class="flex items-center mb-2">
                            <i class="fas fa-map-marker-alt text-primary-500 mr-2"></i>
                            <span class="text-gray-600">Bali, Indonesia</span>
                        </div>
                        <div class="flex items-center mb-4">
                            <i class="fas fa-clock text-primary-500 mr-2"></i>
                            <span class="text-gray-600">3 Hari 2 Malam</span>
                        </div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <span class="text-gray-600 ml-2">(128 ulasan)</span>
                            </div>
                        </div>
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Mulai dari</p>
                                    <p class="text-2xl font-bold text-primary-600">Rp 2.500.000</p>
                                    <p class="text-gray-500 text-sm">per orang</p>
                                </div>
                                <a href="#"
                                    class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-md">Lihat
                                    Detail</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Package Card 2 -->
                <div class="package-card bg-white rounded-lg overflow-hidden shadow-md">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1584810359583-96fc3448beaa?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1169&q=80"
                            alt="Lombok Beach" class="w-full h-56 object-cover">
                        <div
                            class="absolute top-4 right-4 bg-secondary-500 text-white text-sm font-semibold px-3 py-1 rounded-full">
                            Hemat 15%</div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Lombok Beach Tour</h3>
                        <div class="flex items-center mb-2">
                            <i class="fas fa-map-marker-alt text-primary-500 mr-2"></i>
                            <span class="text-gray-600">Lombok, Indonesia</span>
                        </div>
                        <div class="flex items-center mb-4">
                            <i class="fas fa-clock text-primary-500 mr-2"></i>
                            <span class="text-gray-600">4 Hari 3 Malam</span>
                        </div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star-half-alt text-yellow-400"></i>
                                <span class="text-gray-600 ml-2">(96 ulasan)</span>
                            </div>
                        </div>
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Mulai dari</p>
                                    <p class="text-2xl font-bold text-primary-600">Rp 3.500.000</p>
                                    <p class="text-gray-500 text-sm">per orang</p>
                                </div>
                                <a href="#"
                                    class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-md">Lihat
                                    Detail</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Package Card 3 -->
                <div class="package-card bg-white rounded-lg overflow-hidden shadow-md">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1586351012965-861632fcd3db?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                            alt="Yogyakarta Heritage" class="w-full h-56 object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Yogyakarta Heritage</h3>
                        <div class="flex items-center mb-2">
                            <i class="fas fa-map-marker-alt text-primary-500 mr-2"></i>
                            <span class="text-gray-600">Yogyakarta, Indonesia</span>
                        </div>
                        <div class="flex items-center mb-4">
                            <i class="fas fa-clock text-primary-500 mr-2"></i>
                            <span class="text-gray-600">2 Hari 1 Malam</span>
                        </div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="far fa-star text-yellow-400"></i>
                                <span class="text-gray-600 ml-2">(75 ulasan)</span>
                            </div>
                        </div>
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Mulai dari</p>
                                    <p class="text-2xl font-bold text-primary-600">Rp 1.500.000</p>
                                    <p class="text-gray-500 text-sm">per orang</p>
                                </div>
                                <a href="#"
                                    class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-md">Lihat
                                    Detail</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Package Card 4 -->
                <div class="package-card bg-white rounded-lg overflow-hidden shadow-md">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                            alt="Bromo Sunrise" class="w-full h-56 object-cover">
                        <div
                            class="absolute top-4 right-4 bg-red-500 text-white text-sm font-semibold px-3 py-1 rounded-full">
                            Terbatas</div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Bromo Sunrise Tour</h3>
                        <div class="flex items-center mb-2">
                            <i class="fas fa-map-marker-alt text-primary-500 mr-2"></i>
                            <span class="text-gray-600">Jawa Timur, Indonesia</span>
                        </div>
                        <div class="flex items-center mb-4">
                            <i class="fas fa-clock text-primary-500 mr-2"></i>
                            <span class="text-gray-600">3 Hari 2 Malam</span>
                        </div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star-half-alt text-yellow-400"></i>
                                <span class="text-gray-600 ml-2">(112 ulasan)</span>
                            </div>
                        </div>
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Mulai dari</p>
                                    <p class="text-2xl font-bold text-primary-600">Rp 2.000.000</p>
                                    <p class="text-gray-500 text-sm">per orang</p>
                                </div>
                                <a href="#"
                                    class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-md">Lihat
                                    Detail</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Package Card 5 -->
                <div class="package-card bg-white rounded-lg overflow-hidden shadow-md">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1516690561799-46d8f74f9abf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                            alt="Raja Ampat" class="w-full h-56 object-cover">
                        <div
                            class="absolute top-4 right-4 bg-green-500 text-white text-sm font-semibold px-3 py-1 rounded-full">
                            Premium</div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Raja Ampat Diving</h3>
                        <div class="flex items-center mb-2">
                            <i class="fas fa-map-marker-alt text-primary-500 mr-2"></i>
                            <span class="text-gray-600">Papua Barat, Indonesia</span>
                        </div>
                        <div class="flex items-center mb-4">
                            <i class="fas fa-clock text-primary-500 mr-2"></i>
                            <span class="text-gray-600">5 Hari 4 Malam</span>
                        </div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <span class="text-gray-600 ml-2">(89 ulasan)</span>
                            </div>
                        </div>
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Mulai dari</p>
                                    <p class="text-2xl font-bold text-primary-600">Rp 8.500.000</p>
                                    <p class="text-gray-500 text-sm">per orang</p>
                                </div>
                                <a href="#"
                                    class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-md">Lihat
                                    Detail</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Package Card 6 -->
                <div class="package-card bg-white rounded-lg overflow-hidden shadow-md">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1555400038-63f5ba517a47?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                            alt="Labuan Bajo" class="w-full h-56 object-cover">
                        <div
                            class="absolute top-4 right-4 bg-secondary-500 text-white text-sm font-semibold px-3 py-1 rounded-full">
                            Hemat 10%</div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Labuan Bajo Adventure</h3>
                        <div class="flex items-center mb-2">
                            <i class="fas fa-map-marker-alt text-primary-500 mr-2"></i>
                            <span class="text-gray-600">Nusa Tenggara Timur, Indonesia</span>
                        </div>
                        <div class="flex items-center mb-4">
                            <i class="fas fa-clock text-primary-500 mr-2"></i>
                            <span class="text-gray-600">4 Hari 3 Malam</span>
                        </div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star-half-alt text-yellow-400"></i>
                                <span class="text-gray-600 ml-2">(64 ulasan)</span>
                            </div>
                        </div>
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Mulai dari</p>
                                    <p class="text-2xl font-bold text-primary-600">Rp 6.000.000</p>
                                    <p class="text-gray-500 text-sm">per orang</p>
                                </div>
                                <a href="#"
                                    class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-md">Lihat
                                    Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="#"
                    class="inline-flex items-center px-6 py-3 border border-primary-600 text-base font-medium rounded-md text-primary-600 bg-white hover:bg-primary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Lihat Semua Paket <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Vehicles Section -->
    <section id="vehicles" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Pilihan Kendaraan</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Kami menyediakan berbagai pilihan kendaraan nyaman
                    untuk perjalanan wisata Anda</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Vehicle Card 1 -->
                <div class="vehicle-card bg-white rounded-lg overflow-hidden shadow-md">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                            alt="Toyota Avanza" class="w-full h-48 object-cover">
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Toyota Avanza</h3>
                        <div class="flex items-center mb-3">
                            <i class="fas fa-users text-primary-500 mr-2"></i>
                            <span class="text-gray-600">7 Penumpang</span>
                        </div>
                        <div class="flex items-center mb-3">
                            <i class="fas fa-suitcase text-primary-500 mr-2"></i>
                            <span class="text-gray-600">3 Koper</span>
                        </div>
                        <div class="flex items-center mb-3">
                            <i class="fas fa-snowflake text-primary-500 mr-2"></i>
                            <span class="text-gray-600">AC</span>
                        </div>
                        <div class="border-t border-gray-200 pt-4 mt-2">
                            <a href="#"
                                class="block text-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-md">Pilih
                                Kendaraan</a>
                        </div>
                    </div>
                </div>

                <!-- Vehicle Card 2 -->
                <div class="vehicle-card bg-white rounded-lg overflow-hidden shadow-md">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1580273916550-e323be2ae537?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=764&q=80"
                            alt="Toyota Hiace" class="w-full h-48 object-cover">
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Toyota Hiace</h3>
                        <div class="flex items-center mb-3">
                            <i class="fas fa-users text-primary-500 mr-2"></i>
                            <span class="text-gray-600">12 Penumpang</span>
                        </div>
                        <div class="flex items-center mb-3">
                            <i class="fas fa-suitcase text-primary-500 mr-2"></i>
                            <span class="text-gray-600">8 Koper</span>
                        </div>
                        <div class="flex items-center mb-3">
                            <i class="fas fa-snowflake text-primary-500 mr-2"></i>
                            <span class="text-gray-600">AC</span>
                        </div>
                        <div class="border-t border-gray-200 pt-4 mt-2">
                            <a href="#"
                                class="block text-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-md">Pilih
                                Kendaraan</a>
                        </div>
                    </div>
                </div>

                <!-- Vehicle Card 3 -->
                <div class="vehicle-card bg-white rounded-lg overflow-hidden shadow-md">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                            alt="Suzuki Ertiga" class="w-full h-48 object-cover">
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Suzuki Ertiga</h3>
                        <div class="flex items-center mb-3">
                            <i class="fas fa-users text-primary-500 mr-2"></i>
                            <span class="text-gray-600">7 Penumpang</span>
                        </div>
                        <div class="flex items-center mb-3">
                            <i class="fas fa-suitcase text-primary-500 mr-2"></i>
                            <span class="text-gray-600">3 Koper</span>
                        </div>
                        <div class="flex items-center mb-3">
                            <i class="fas fa-snowflake text-primary-500 mr-2"></i>
                            <span class="text-gray-600">AC</span>
                        </div>
                        <div class="border-t border-gray-200 pt-4 mt-2">
                            <a href="#"
                                class="block text-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-md">Pilih
                                Kendaraan</a>
                        </div>
                    </div>
                </div>

                <!-- Vehicle Card 4 -->
                <div class="vehicle-card bg-white rounded-lg overflow-hidden shadow-md">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                            alt="Toyota Fortuner" class="w-full h-48 object-cover">
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Toyota Fortuner</h3>
                        <div class="flex items-center mb-3">
                            <i class="fas fa-users text-primary-500 mr-2"></i>
                            <span class="text-gray-600">7 Penumpang</span>
                        </div>
                        <div class="flex items-center mb-3">
                            <i class="fas fa-suitcase text-primary-500 mr-2"></i>
                            <span class="text-gray-600">4 Koper</span>
                        </div>
                        <div class="flex items-center mb-3">
                            <i class="fas fa-snowflake text-primary-500 mr-2"></i>
                            <span class="text-gray-600">AC</span>
                        </div>
                        <div class="border-t border-gray-200 pt-4 mt-2">
                            <a href="#"
                                class="block text-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-md">Pilih
                                Kendaraan</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-10">
                <a href="#"
                    class="inline-flex items-center px-6 py-3 border border-primary-600 text-base font-medium rounded-md text-primary-600 bg-white hover:bg-primary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Lihat Semua Kendaraan <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Apa Kata Mereka</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Pengalaman pelanggan kami yang telah menikmati
                    layanan perjalanan wisata bersama kami</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-gray-50 rounded-lg p-6 shadow-sm">
                    <div class="flex items-center mb-4">
                        <img src="https://randomuser.me/api/portraits/women/12.jpg" alt="Testimonial"
                            class="w-12 h-12 rounded-full">
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-gray-900">Siti Nurhaliza</h4>
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"Pengalaman liburan terbaik! Paket wisata Bali sangat terorganisir
                        dengan baik, pemandu wisata ramah dan profesional. Akomodasi dan transportasi juga sangat
                        nyaman. Pasti akan menggunakan jasa mereka lagi!"</p>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-gray-50 rounded-lg p-6 shadow-sm">
                    <div class="flex items-center mb-4">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Testimonial"
                            class="w-12 h-12 rounded-full">
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-gray-900">Budi Santoso</h4>
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"Saya dan keluarga sangat puas dengan paket wisata Yogyakarta.
                        Semua tempat wisata yang dikunjungi sangat menarik dan sesuai dengan itinerary. Mobil yang
                        disediakan juga sangat nyaman untuk perjalanan keluarga."</p>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-gray-50 rounded-lg p-6 shadow-sm">
                    <div class="flex items-center mb-4">
                        <img src="https://randomuser.me/api/portraits/women/28.jpg" alt="Testimonial"
                            class="w-12 h-12 rounded-full">
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-gray-900">Dewi Lestari</h4>
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"Paket wisata Raja Ampat benar-benar luar biasa! Pemandangan bawah
                        laut yang menakjubkan, penginapan yang nyaman, dan pelayanan yang sangat baik. Meskipun harganya
                        premium, tapi sebanding dengan pengalaman yang didapat."</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-16 bg-primary-600">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-3xl font-bold text-white mb-6">Siap Untuk Petualangan Berikutnya?</h2>
                <p class="text-lg text-primary-100 mb-8">Jangan lewatkan kesempatan untuk menjelajahi keindahan
                    Indonesia dengan paket wisata terbaik dari kami</p>
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="#packages"
                        class="px-8 py-3 bg-white text-primary-600 font-medium rounded-md hover:bg-primary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">Lihat
                        Paket Wisata</a>
                    <a href="#contact"
                        class="px-8 py-3 bg-transparent border border-white text-white font-medium rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">Hubungi
                        Kami</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">Wonderful Journey</h3>
                    <p class="text-gray-400 mb-4">Menyediakan paket wisata terbaik dengan harga terjangkau dan
                        pelayanan profesional untuk liburan yang tak terlupakan.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white"><i
                                class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">Paket Wisata</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Bali</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Lombok</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Yogyakarta</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Bromo</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Raja Ampat</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Labuan Bajo</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">Informasi</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Tentang Kami</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Kebijakan Privasi</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Cara Pemesanan</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">FAQ</a></li>
                    </ul>
                </div>

                <div id="contact">
                    <h3 class="text-lg font-semibold mb-4">Kontak Kami</h3>
                    <ul class="space-y-2">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-primary-400"></i>
                            <span class="text-gray-400">Jl. Raya Kuta No. 88, Kuta, Bali 80361, Indonesia</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone-alt mr-3 text-primary-400"></i>
                            <span class="text-gray-400">+62 361 123456</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-primary-400"></i>
                            <span class="text-gray-400">info@wonderfuljourney.com</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-clock mr-3 text-primary-400"></i>
                            <span class="text-gray-400">Senin - Sabtu: 09:00 - 17:00</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-10 pt-6 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">&copy; 2023 Wonderful Journey. All rights reserved.</p>
                <div class="mt-4 md:mt-0">
                    <img src="https://via.placeholder.com/200x30?text=Payment+Methods" alt="Payment Methods"
                        class="h-8">
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobileMenuButton');
            const mobileMenu = document.getElementById('mobileMenu');

            mobileMenuButton.addEventListener('click', function() {
                if (mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.remove('hidden');
                } else {
                    mobileMenu.classList.add('hidden');
                }
            });

            // Close mobile menu when clicking on a link
            const mobileMenuLinks = mobileMenu.querySelectorAll('a');
            mobileMenuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    mobileMenu.classList.add('hidden');
                });
            });

            // Close mobile menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!mobileMenu.contains(event.target) && !mobileMenuButton.contains(event.target) && !
                    mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                }
            });
        });
    </script>
</body>

</html>
