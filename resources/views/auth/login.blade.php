<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login -Bali Om Tours</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-teal-500 to-emerald-500 py-8 px-6 text-center">
                <div class="flex justify-center mb-4">
                    <div class="bg-white p-2 rounded-full">

                    </div>
                </div>
                <h2 class="text-2xl font-bold text-white">Bali Om Tours</h2>
                <p class="text-teal-100 mt-1">Masuk ke akun Anda</p>
            </div>

            <div class="p-6">
                <!-- Login Form -->
                <form action="/login" method="POST" class="space-y-6">
                    <!-- Tambahkan @csrf jika ini Blade template -->
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div>
                        <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" id="email" name="email" required
                                class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                placeholder="Masukkan email Anda">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" id="password" name="password" required
                                class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                placeholder="Masukkan password Anda">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <button type="button" id="togglePassword" class="text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-teal-600 text-white py-2 px-4 rounded-md hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition">
                        Masuk
                    </button>
                </form>


            </div>
        </div>

        <p class="mt-8 text-center">
            <a href="LandingPage.html" class="text-sm text-gray-600 hover:text-teal-600">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Beranda
            </a>
        </p>
    </div>

    <script>
        // Toggle Password Visibility (opsional)
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        togglePassword.addEventListener('click', () => {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            togglePassword.querySelector('i').classList.toggle('fa-eye');
            togglePassword.querySelector('i').classList.toggle('fa-eye-slash');
        });
    </script>
</body>

</html>
