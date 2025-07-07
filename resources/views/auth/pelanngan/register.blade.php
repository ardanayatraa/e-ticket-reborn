<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pelanggan - BALI OM TOURS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center py-8">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <!-- Logo -->
            <div class="text-center mb-8">
                <img src="{{ asset('assets/img/baliomtour.png') }}" alt="Logo Bali Om" class="h-12 mx-auto mb-4">
                <h2 class="text-2xl font-bold text-gray-800">Daftar Pelanggan</h2>
                <p class="text-gray-600 mt-2">Buat akun baru Anda</p>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <ul class="text-red-600 text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Register Form -->
            <form method="POST" action="{{ route('pelanggan.register') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="nama_pemesan" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" id="nama_pemesan" name="nama_pemesan" value="{{ old('nama_pemesan') }}"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                </div>

                <div>
                    <label for="nomor_whatsapp" class="block text-sm font-medium text-gray-700 mb-2">Nomor
                        WhatsApp</label>
                    <input type="text" id="nomor_whatsapp" name="nomor_whatsapp" value="{{ old('nomor_whatsapp') }}"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                        placeholder="08xxxxxxxxxx">
                </div>

                <div>
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                    <textarea id="alamat" name="alamat" rows="3" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">{{ old('alamat') }}</textarea>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi
                        Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-teal-500 to-teal-600 text-white font-bold py-3 px-4 rounded-lg hover:shadow-lg transition-all duration-200">
                    <i class="fas fa-user-plus mr-2"></i>
                    Daftar
                </button>
            </form>

            <!-- Login Link -->
            <div class="text-center mt-6">
                <p class="text-gray-600">
                    Sudah punya akun?
                    <a href="{{ route('pelanggan.login') }}" class="text-teal-600 hover:text-teal-700 font-medium">
                        Masuk di sini
                    </a>
                </p>
            </div>

            <!-- Back to Home -->
            <div class="text-center mt-4">
                <a href="/" class="text-gray-500 hover:text-gray-700 text-sm">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</body>

</html>
