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

<body class="bg-gray-100 text-gray-800 font-sans">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 bg-green-soft-700">
                <div class="flex items-center justify-center h-16 bg-green-soft-800">
                    <span class="text-white font-bold text-xl">E-Ticket Admin</span>
                </div>
                <div class="flex flex-col flex-grow overflow-y-auto">
                    <nav class="flex-1 px-2 py-4 space-y-1">
                        <a href="#dashboard"
                            class="flex items-center px-4 py-3 text-white bg-green-soft-600 rounded-md group">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="#packages"
                            class="flex items-center px-4 py-3 text-green-soft-100 hover:bg-green-soft-600 hover:text-white rounded-md group transition duration-300">
                            <i class="fas fa-box mr-3"></i>
                            <span>Packages</span>
                        </a>
                        <a href="#vehicles"
                            class="flex items-center px-4 py-3 text-green-soft-100 hover:bg-green-soft-600 hover:text-white rounded-md group transition duration-300">
                            <i class="fas fa-car mr-3"></i>
                            <span>Vehicles</span>
                        </a>
                        <a href="#bookings"
                            class="flex items-center px-4 py-3 text-green-soft-100 hover:bg-green-soft-600 hover:text-white rounded-md group transition duration-300">
                            <i class="fas fa-calendar-check mr-3"></i>
                            <span>Bookings</span>
                        </a>
                        <a href="#payments"
                            class="flex items-center px-4 py-3 text-green-soft-100 hover:bg-green-soft-600 hover:text-white rounded-md group transition duration-300">
                            <i class="fas fa-credit-card mr-3"></i>
                            <span>Payments</span>
                        </a>
                        <a href="#e-tickets"
                            class="flex items-center px-4 py-3 text-green-soft-100 hover:bg-green-soft-600 hover:text-white rounded-md group transition duration-300">
                            <i class="fas fa-ticket-alt mr-3"></i>
                            <span>E-Tickets</span>
                        </a>
                        <a href="#reports"
                            class="flex items-center px-4 py-3 text-green-soft-100 hover:bg-green-soft-600 hover:text-white rounded-md group transition duration-300">
                            <i class="fas fa-chart-bar mr-3"></i>
                            <span>Reports</span>
                        </a>
                        <a href="#users"
                            class="flex items-center px-4 py-3 text-green-soft-100 hover:bg-green-soft-600 hover:text-white rounded-md group transition duration-300">
                            <i class="fas fa-users mr-3"></i>
                            <span>Users</span>
                        </a>
                        <a href="#settings"
                            class="flex items-center px-4 py-3 text-green-soft-100 hover:bg-green-soft-600 hover:text-white rounded-md group transition duration-300">
                            <i class="fas fa-cog mr-3"></i>
                            <span>Settings</span>
                        </a>
                    </nav>
                    <div class="p-4 border-t border-green-soft-600">
                        <a href="login.html"
                            class="flex items-center text-green-soft-100 hover:text-white transition duration-300">
                            <i class="fas fa-sign-out-alt mr-3"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile sidebar -->
        <div class="md:hidden fixed inset-0 z-40 flex" id="mobileSidebar" style="display: none;">
            <div class="fixed inset-0 bg-gray-600 bg-opacity-75" id="sidebarOverlay"></div>
            <div class="relative flex-1 flex flex-col max-w-xs w-full bg-green-soft-700">
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button id="closeSidebarButton"
                        class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <span class="sr-only">Close sidebar</span>
                        <i class="fas fa-times text-white text-xl"></i>
                    </button>
                </div>
                <div class="flex items-center justify-center h-16 bg-green-soft-800">
                    <span class="text-white font-bold text-xl">E-Ticket </span>
                </div>
                <div class="flex-1 h-0 overflow-y-auto">
                    <nav class="px-2 py-4 space-y-1">
                        <a href="#dashboard"
                            class="flex items-center px-4 py-3 text-white bg-green-soft-600 rounded-md group">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="#packages"
                            class="flex items-center px-4 py-3 text-green-soft-100 hover:bg-green-soft-600 hover:text-white rounded-md group transition duration-300">
                            <i class="fas fa-box mr-3"></i>
                            <span>Packages</span>
                        </a>
                        <a href="#vehicles"
                            class="flex items-center px-4 py-3 text-green-soft-100 hover:bg-green-soft-600 hover:text-white rounded-md group transition duration-300">
                            <i class="fas fa-car mr-3"></i>
                            <span>Vehicles</span>
                        </a>
                        <a href="#bookings"
                            class="flex items-center px-4 py-3 text-green-soft-100 hover:bg-green-soft-600 hover:text-white rounded-md group transition duration-300">
                            <i class="fas fa-calendar-check mr-3"></i>
                            <span>Bookings</span>
                        </a>
                        <a href="#payments"
                            class="flex items-center px-4 py-3 text-green-soft-100 hover:bg-green-soft-600 hover:text-white rounded-md group transition duration-300">
                            <i class="fas fa-credit-card mr-3"></i>
                            <span>Payments</span>
                        </a>
                        <a href="#e-tickets"
                            class="flex items-center px-4 py-3 text-green-soft-100 hover:bg-green-soft-600 hover:text-white rounded-md group transition duration-300">
                            <i class="fas fa-ticket-alt mr-3"></i>
                            <span>E-Tickets</span>
                        </a>
                        <a href="#reports"
                            class="flex items-center px-4 py-3 text-green-soft-100 hover:bg-green-soft-600 hover:text-white rounded-md group transition duration-300">
                            <i class="fas fa-chart-bar mr-3"></i>
                            <span>Reports</span>
                        </a>
                        <a href="#users"
                            class="flex items-center px-4 py-3 text-green-soft-100 hover:bg-green-soft-600 hover:text-white rounded-md group transition duration-300">
                            <i class="fas fa-users mr-3"></i>
                            <span>Users</span>
                        </a>
                        <a href="#settings"
                            class="flex items-center px-4 py-3 text-green-soft-100 hover:bg-green-soft-600 hover:text-white rounded-md group transition duration-300">
                            <i class="fas fa-cog mr-3"></i>
                            <span>Settings</span>
                        </a>
                    </nav>
                </div>
                <div class="p-4 border-t border-green-soft-600">
                    <a href="login.html"
                        class="flex items-center text-green-soft-100 hover:text-white transition duration-300">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col w-0 flex-1 overflow-hidden">
            <!-- Top Navigation -->
            <div class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow">
                <button id="openSidebarButton"
                    class="md:hidden px-4 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-soft-500">
                    <span class="sr-only">Open sidebar</span>
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <div class="flex-1 px-4 flex justify-between">
                    <div class="flex-1 flex items-center">
                        <div class="max-w-2xl w-full">

                        </div>
                    </div>
                    <div class="ml-4 flex items-center md:ml-6">
                        <!-- Notification dropdown -->
                        <div class="relative">

                        </div>

                        <!-- Profile dropdown -->
                        <div class="ml-3 relative">
                            <div>
                                <button
                                    class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-soft-500">
                                    <span class="sr-only">Open user menu</span>
                                    <img class="h-8 w-8 rounded-full"
                                        src="https://randomuser.me/api/portraits/men/32.jpg" alt="User profile">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <main class="flex-1 relative overflow-y-auto focus:outline-none" id="dashboard">
                <div class="">
                    <div class="w-full mx-auto px-4 sm:px-6 md:px-8">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </div>
    <!-- Adds the Core Table Scripts -->
    @rappasoftTableScripts

    <!-- Adds any relevant Third-Party Scripts (e.g. Flatpickr) -->
    @rappasoftTableThirdPartyScripts
    <!-- JavaScript for Mobile Menu Toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const openSidebarButton = document.getElementById('openSidebarButton');
            const closeSidebarButton = document.getElementById('closeSidebarButton');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const mobileSidebar = document.getElementById('mobileSidebar');

            openSidebarButton.addEventListener('click', function() {
                mobileSidebar.style.display = 'flex';
            });

            closeSidebarButton.addEventListener('click', function() {
                mobileSidebar.style.display = 'none';
            });

            sidebarOverlay.addEventListener('click', function() {
                mobileSidebar.style.display = 'none';
            });
        });
    </script>
    @stack('modals')

    @livewireScripts
</body>

</html>
