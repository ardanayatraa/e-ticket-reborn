<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelEase - Your Travel Partner</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'green-soft': {
                            50: '#f0faf0',
                            100: '#e0f5e0',
                            200: '#c3e6cb',
                            300: '#9ed1a9',
                            400: '#75c282',
                            500: '#4d8d59',
                            600: '#3a6943',
                            700: '#2c4f33',
                            800: '#1e3522',
                            900: '#0f1a11',
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-green-soft-50 text-gray-800 font-sans">
    <!-- Navigation -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <a href="#" class="text-green-soft-500 font-bold text-2xl">TravelEase</a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8">
                    <a href="#" class="text-green-soft-500 hover:text-green-soft-600 font-medium">Home</a>
                    <a href="#packages" class="text-gray-600 hover:text-green-soft-500 font-medium">Packages</a>
                    <a href="#vehicles" class="text-gray-600 hover:text-green-soft-500 font-medium">Vehicles</a>
                    <a href="#booking" class="text-gray-600 hover:text-green-soft-500 font-medium">Book Now</a>
                    <a href="#contact" class="text-gray-600 hover:text-green-soft-500 font-medium">Contact</a>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="login.html"
                        class="bg-green-soft-500 hover:bg-green-soft-600 text-white px-4 py-2 rounded-md transition duration-300">Login</a>

                    <!-- Mobile Menu Button -->
                    <button class="md:hidden text-gray-600 focus:outline-none" id="menuButton">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="md:hidden hidden" id="mobileMenu">
                <div class="flex flex-col space-y-4 mt-4 pb-4">
                    <a href="#" class="text-green-soft-500 hover:text-green-soft-600 font-medium">Home</a>
                    <a href="#packages" class="text-gray-600 hover:text-green-soft-500 font-medium">Packages</a>
                    <a href="#vehicles" class="text-gray-600 hover:text-green-soft-500 font-medium">Vehicles</a>
                    <a href="#booking" class="text-gray-600 hover:text-green-soft-500 font-medium">Book Now</a>
                    <a href="#contact" class="text-gray-600 hover:text-green-soft-500 font-medium">Contact</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative bg-green-soft-100 py-20">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-10 md:mb-0">
                    <h1 class="text-4xl md:text-5xl font-bold text-green-soft-600 mb-4">Discover Amazing Places</h1>
                    <p class="text-lg text-gray-700 mb-8">Find and book the perfect travel package for your next
                        adventure. Explore beautiful destinations with our curated travel experiences.</p>
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="#packages"
                            class="bg-green-soft-500 hover:bg-green-soft-600 text-white px-6 py-3 rounded-md text-center font-medium transition duration-300">Explore
                            Packages</a>
                        <a href="#booking"
                            class="border-2 border-green-soft-500 text-green-soft-500 hover:bg-green-soft-500 hover:text-white px-6 py-3 rounded-md text-center font-medium transition duration-300">Book
                            Now</a>
                    </div>
                </div>
                <div class="md:w-1/2">
                    <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80"
                        alt="Travel Destination" class="rounded-lg shadow-xl w-full h-auto">
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Packages Section -->
    <section id="packages" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-green-soft-600 mb-2">Featured Travel Packages</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Explore our handpicked selection of travel packages designed
                    to give you the best experience.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Package 1 -->
                <div
                    class="bg-green-soft-50 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition duration-300">
                    <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80"
                        alt="Beach Resort" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <span
                            class="bg-green-soft-200 text-green-soft-700 text-xs font-semibold px-2 py-1 rounded-full">POPULAR</span>
                        <h3 class="text-xl font-bold text-green-soft-600 mt-2">Bali Beach Retreat</h3>
                        <p class="text-gray-600 mt-2">5 days of relaxation at pristine beaches with luxury
                            accommodations and guided tours.</p>
                        <div class="flex items-center mt-4">
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star-half-alt text-yellow-400"></i>
                            <span class="text-gray-600 ml-2">(128 reviews)</span>
                        </div>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-green-soft-600 font-bold text-xl">$1,299</span>
                            <a href="#booking"
                                class="bg-green-soft-500 hover:bg-green-soft-600 text-white px-4 py-2 rounded-md transition duration-300">Book
                                Now</a>
                        </div>
                    </div>
                </div>

                <!-- Package 2 -->
                <div
                    class="bg-green-soft-50 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition duration-300">
                    <img src="https://images.unsplash.com/photo-1501785888041-af3ef285b470?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80"
                        alt="Mountain Adventure" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <span
                            class="bg-green-soft-200 text-green-soft-700 text-xs font-semibold px-2 py-1 rounded-full">ADVENTURE</span>
                        <h3 class="text-xl font-bold text-green-soft-600 mt-2">Mountain Explorer</h3>
                        <p class="text-gray-600 mt-2">7 days of hiking, camping, and exploring breathtaking mountain
                            landscapes.</p>
                        <div class="flex items-center mt-4">
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <span class="text-gray-600 ml-2">(95 reviews)</span>
                        </div>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-green-soft-600 font-bold text-xl">$1,599</span>
                            <a href="#booking"
                                class="bg-green-soft-500 hover:bg-green-soft-600 text-white px-4 py-2 rounded-md transition duration-300">Book
                                Now</a>
                        </div>
                    </div>
                </div>

                <!-- Package 3 -->
                <div
                    class="bg-green-soft-50 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition duration-300">
                    <img src="https://images.unsplash.com/photo-1519922639192-e73293ca430e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80"
                        alt="City Tour" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <span
                            class="bg-green-soft-200 text-green-soft-700 text-xs font-semibold px-2 py-1 rounded-full">CULTURAL</span>
                        <h3 class="text-xl font-bold text-green-soft-600 mt-2">Tokyo City Explorer</h3>
                        <p class="text-gray-600 mt-2">4 days exploring the vibrant culture, cuisine, and attractions of
                            Tokyo.</p>
                        <div class="flex items-center mt-4">
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="far fa-star text-yellow-400"></i>
                            <span class="text-gray-600 ml-2">(76 reviews)</span>
                        </div>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-green-soft-600 font-bold text-xl">$1,099</span>
                            <a href="#booking"
                                class="bg-green-soft-500 hover:bg-green-soft-600 text-white px-4 py-2 rounded-md transition duration-300">Book
                                Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-10">
                <a href="#"
                    class="border-2 border-green-soft-500 text-green-soft-500 hover:bg-green-soft-500 hover:text-white px-6 py-3 rounded-md inline-block font-medium transition duration-300">View
                    All Packages</a>
            </div>
        </div>
    </section>

    <!-- Vehicle Selection Section -->
    <section id="vehicles" class="py-16 bg-green-soft-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-green-soft-600 mb-2">Choose Your Vehicle</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Select from our range of comfortable and reliable vehicles
                    for your journey.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Vehicle 1 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition duration-300">
                    <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80"
                        alt="Luxury Sedan" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-green-soft-600">Luxury Sedan</h3>
                        <div class="flex flex-wrap mt-4">
                            <span
                                class="bg-green-soft-100 text-green-soft-600 text-xs font-medium px-2 py-1 rounded-full mr-2 mb-2">4
                                Passengers</span>
                            <span
                                class="bg-green-soft-100 text-green-soft-600 text-xs font-medium px-2 py-1 rounded-full mr-2 mb-2">2
                                Luggage</span>
                            <span
                                class="bg-green-soft-100 text-green-soft-600 text-xs font-medium px-2 py-1 rounded-full mr-2 mb-2">Air
                                Conditioning</span>
                            <span
                                class="bg-green-soft-100 text-green-soft-600 text-xs font-medium px-2 py-1 rounded-full mr-2 mb-2">Automatic</span>
                        </div>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-green-soft-600 font-bold text-xl">$75/day</span>
                            <a href="#booking"
                                class="bg-green-soft-500 hover:bg-green-soft-600 text-white px-4 py-2 rounded-md transition duration-300">Select</a>
                        </div>
                    </div>
                </div>

                <!-- Vehicle 2 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition duration-300">
                    <img src="https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80"
                        alt="SUV" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-green-soft-600">Family SUV</h3>
                        <div class="flex flex-wrap mt-4">
                            <span
                                class="bg-green-soft-100 text-green-soft-600 text-xs font-medium px-2 py-1 rounded-full mr-2 mb-2">7
                                Passengers</span>
                            <span
                                class="bg-green-soft-100 text-green-soft-600 text-xs font-medium px-2 py-1 rounded-full mr-2 mb-2">4
                                Luggage</span>
                            <span
                                class="bg-green-soft-100 text-green-soft-600 text-xs font-medium px-2 py-1 rounded-full mr-2 mb-2">Air
                                Conditioning</span>
                            <span
                                class="bg-green-soft-100 text-green-soft-600 text-xs font-medium px-2 py-1 rounded-full mr-2 mb-2">Automatic</span>
                        </div>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-green-soft-600 font-bold text-xl">$120/day</span>
                            <a href="#booking"
                                class="bg-green-soft-500 hover:bg-green-soft-600 text-white px-4 py-2 rounded-md transition duration-300">Select</a>
                        </div>
                    </div>
                </div>

                <!-- Vehicle 3 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition duration-300">
                    <img src="https://images.unsplash.com/photo-1494976388531-d1058494cdd8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80"
                        alt="Luxury Car" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-green-soft-600">Premium Sports Car</h3>
                        <div class="flex flex-wrap mt-4">
                            <span
                                class="bg-green-soft-100 text-green-soft-600 text-xs font-medium px-2 py-1 rounded-full mr-2 mb-2">2
                                Passengers</span>
                            <span
                                class="bg-green-soft-100 text-green-soft-600 text-xs font-medium px-2 py-1 rounded-full mr-2 mb-2">2
                                Luggage</span>
                            <span
                                class="bg-green-soft-100 text-green-soft-600 text-xs font-medium px-2 py-1 rounded-full mr-2 mb-2">Air
                                Conditioning</span>
                            <span
                                class="bg-green-soft-100 text-green-soft-600 text-xs font-medium px-2 py-1 rounded-full mr-2 mb-2">Automatic</span>
                        </div>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-green-soft-600 font-bold text-xl">$250/day</span>
                            <a href="#booking"
                                class="bg-green-soft-500 hover:bg-green-soft-600 text-white px-4 py-2 rounded-md transition duration-300">Select</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Booking Form Section -->
    <section id="booking" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-green-soft-600 mb-2">Book Your Trip</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Fill out the form below to book your perfect travel
                    experience.</p>
            </div>

            <div class="max-w-4xl mx-auto bg-green-soft-50 rounded-lg shadow-md p-8">
                <form action="#" method="POST">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-gray-700 font-medium mb-2">Full Name</label>
                            <input type="text" id="name" name="name"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-soft-500"
                                required>
                        </div>

                        <div>
                            <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                            <input type="email" id="email" name="email"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-soft-500"
                                required>
                        </div>

                        <div>
                            <label for="phone" class="block text-gray-700 font-medium mb-2">Phone Number</label>
                            <input type="tel" id="phone" name="phone"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-soft-500"
                                required>
                        </div>

                        <div>
                            <label for="package" class="block text-gray-700 font-medium mb-2">Select Package</label>
                            <select id="package" name="package"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-soft-500"
                                required>
                                <option value="">Choose a package</option>
                                <option value="bali">Bali Beach Retreat</option>
                                <option value="mountain">Mountain Explorer</option>
                                <option value="tokyo">Tokyo City Explorer</option>
                            </select>
                        </div>

                        <div>
                            <label for="vehicle" class="block text-gray-700 font-medium mb-2">Select Vehicle</label>
                            <select id="vehicle" name="vehicle"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-soft-500"
                                required>
                                <option value="">Choose a vehicle</option>
                                <option value="sedan">Luxury Sedan</option>
                                <option value="suv">Family SUV</option>
                                <option value="sports">Premium Sports Car</option>
                            </select>
                        </div>

                        <div>
                            <label for="date" class="block text-gray-700 font-medium mb-2">Travel Date</label>
                            <input type="date" id="date" name="date"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-soft-500"
                                required>
                        </div>

                        <div>
                            <label for="guests" class="block text-gray-700 font-medium mb-2">Number of
                                Guests</label>
                            <input type="number" id="guests" name="guests" min="1" max="10"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-soft-500"
                                required>
                        </div>

                        <div>
                            <label for="duration" class="block text-gray-700 font-medium mb-2">Duration (Days)</label>
                            <input type="number" id="duration" name="duration" min="1" max="30"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-soft-500"
                                required>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="message" class="block text-gray-700 font-medium mb-2">Special Requests</label>
                        <textarea id="message" name="message" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-soft-500"></textarea>
                    </div>

                    <div class="mt-8">
                        <button type="submit"
                            class="w-full bg-green-soft-500 hover:bg-green-soft-600 text-white py-3 rounded-md font-medium transition duration-300">Book
                            Now</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-16 bg-green-soft-100">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-green-soft-600 mb-2">What Our Customers Say</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Read testimonials from our satisfied customers who have
                    enjoyed our travel services.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Customer"
                            class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="font-bold text-green-soft-600">Sarah Johnson</h4>
                            <p class="text-gray-600 text-sm">Bali Beach Retreat</p>
                        </div>
                    </div>
                    <div class="mb-4">
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                    </div>
                    <p class="text-gray-700">"The Bali Beach Retreat was absolutely amazing! The accommodations were
                        luxurious, and the guided tours were informative and fun. I'll definitely book with TravelEase
                        again!"</p>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="Customer"
                            class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="font-bold text-green-soft-600">Michael Chen</h4>
                            <p class="text-gray-600 text-sm">Mountain Explorer</p>
                        </div>
                    </div>
                    <div class="mb-4">
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star-half-alt text-yellow-400"></i>
                    </div>
                    <p class="text-gray-700">"The Mountain Explorer package exceeded my expectations. The guides were
                        knowledgeable, and the camping equipment was top-notch. The views were breathtaking, and I made
                        memories that will last a lifetime."</p>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Customer"
                            class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="font-bold text-green-soft-600">Emily Rodriguez</h4>
                            <p class="text-gray-600 text-sm">Tokyo City Explorer</p>
                        </div>
                    </div>
                    <div class="mb-4">
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="far fa-star text-yellow-400"></i>
                    </div>
                    <p class="text-gray-700">"Tokyo City Explorer was a perfect introduction to Japanese culture. The
                        itinerary was well-planned, and our guide was incredibly knowledgeable. The hotel was centrally
                        located, making it easy to explore on our own time."</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-green-soft-600 mb-2">Contact Us</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Have questions or need assistance? Reach out to our friendly
                    team.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <div class="bg-green-soft-50 p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-bold text-green-soft-600 mb-4">Get in Touch</h3>
                        <form action="#" method="POST">
                            <div class="mb-4">
                                <label for="contact-name" class="block text-gray-700 font-medium mb-2">Your
                                    Name</label>
                                <input type="text" id="contact-name" name="contact-name"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-soft-500"
                                    required>
                            </div>

                            <div class="mb-4">
                                <label for="contact-email" class="block text-gray-700 font-medium mb-2">Email
                                    Address</label>
                                <input type="email" id="contact-email" name="contact-email"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-soft-500"
                                    required>
                            </div>

                            <div class="mb-4">
                                <label for="contact-subject"
                                    class="block text-gray-700 font-medium mb-2">Subject</label>
                                <input type="text" id="contact-subject" name="contact-subject"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-soft-500"
                                    required>
                            </div>

                            <div class="mb-4">
                                <label for="contact-message"
                                    class="block text-gray-700 font-medium mb-2">Message</label>
                                <textarea id="contact-message" name="contact-message" rows="4"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-soft-500"
                                    required></textarea>
                            </div>

                            <button type="submit"
                                class="bg-green-soft-500 hover:bg-green-soft-600 text-white px-6 py-3 rounded-md font-medium transition duration-300">Send
                                Message</button>
                        </form>
                    </div>
                </div>

                <div>
                    <div class="bg-green-soft-50 p-6 rounded-lg shadow-md h-full">
                        <h3 class="text-xl font-bold text-green-soft-600 mb-4">Contact Information</h3>

                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="bg-green-soft-200 p-3 rounded-full mr-4">
                                    <i class="fas fa-map-marker-alt text-green-soft-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-700">Address</h4>
                                    <p class="text-gray-600">123 Travel Street, Suite 456<br>Adventure City, AC 12345
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="bg-green-soft-200 p-3 rounded-full mr-4">
                                    <i class="fas fa-phone text-green-soft-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-700">Phone</h4>
                                    <p class="text-gray-600">+1 (555) 123-4567</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="bg-green-soft-200 p-3 rounded-full mr-4">
                                    <i class="fas fa-envelope text-green-soft-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-700">Email</h4>
                                    <p class="text-gray-600">info@travelease.com</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="bg-green-soft-200 p-3 rounded-full mr-4">
                                    <i class="fas fa-clock text-green-soft-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-700">Business Hours</h4>
                                    <p class="text-gray-600">Monday - Friday: 9:00 AM - 6:00 PM<br>Saturday: 10:00 AM -
                                        4:00 PM<br>Sunday: Closed</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h4 class="font-bold text-gray-700 mb-2">Follow Us</h4>
                            <div class="flex space-x-4">
                                <a href="#"
                                    class="bg-green-soft-200 p-3 rounded-full text-green-soft-600 hover:bg-green-soft-300 transition duration-300">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#"
                                    class="bg-green-soft-200 p-3 rounded-full text-green-soft-600 hover:bg-green-soft-300 transition duration-300">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#"
                                    class="bg-green-soft-200 p-3 rounded-full text-green-soft-600 hover:bg-green-soft-300 transition duration-300">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#"
                                    class="bg-green-soft-200 p-3 rounded-full text-green-soft-600 hover:bg-green-soft-300 transition duration-300">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-green-soft-600 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">TravelEase</h3>
                    <p class="mb-4">Your trusted partner for unforgettable travel experiences. We provide
                        high-quality travel packages and services to make your journey memorable.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-white hover:text-green-soft-200 transition duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-white hover:text-green-soft-200 transition duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-white hover:text-green-soft-200 transition duration-300">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-white hover:text-green-soft-200 transition duration-300">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#"
                                class="text-white hover:text-green-soft-200 transition duration-300">Home</a></li>
                        <li><a href="#packages"
                                class="text-white hover:text-green-soft-200 transition duration-300">Packages</a></li>
                        <li><a href="#vehicles"
                                class="text-white hover:text-green-soft-200 transition duration-300">Vehicles</a></li>
                        <li><a href="#booking"
                                class="text-white hover:text-green-soft-200 transition duration-300">Book Now</a></li>
                        <li><a href="#contact"
                                class="text-white hover:text-green-soft-200 transition duration-300">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4">Popular Destinations</h3>
                    <ul class="space-y-2">
                        <li><a href="#"
                                class="text-white hover:text-green-soft-200 transition duration-300">Bali,
                                Indonesia</a></li>
                        <li><a href="#"
                                class="text-white hover:text-green-soft-200 transition duration-300">Tokyo, Japan</a>
                        </li>
                        <li><a href="#"
                                class="text-white hover:text-green-soft-200 transition duration-300">Paris, France</a>
                        </li>
                        <li><a href="#" class="text-white hover:text-green-soft-200 transition duration-300">New
                                York, USA</a></li>
                        <li><a href="#"
                                class="text-white hover:text-green-soft-200 transition duration-300">Sydney,
                                Australia</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4">Newsletter</h3>
                    <p class="mb-4">Subscribe to our newsletter to receive the latest updates and offers.</p>
                    <form action="#" method="POST">
                        <div class="flex">
                            <input type="email" placeholder="Your email address"
                                class="px-4 py-2 w-full rounded-l-md focus:outline-none text-gray-800">
                            <button type="submit"
                                class="bg-green-soft-800 hover:bg-green-soft-900 px-4 py-2 rounded-r-md transition duration-300">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="border-t border-green-soft-500 mt-8 pt-8 text-center">
                <p>&copy; 2025 TravelEase. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript for Mobile Menu Toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.getElementById('menuButton');
            const mobileMenu = document.getElementById('mobileMenu');

            menuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        });
    </script>
</body>

</html>
