<x-app-layout>
    <div class="py-8">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Dashboard</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
                    <h3 class="text-gray-500 text-sm font-medium">Total Transaksi</h3>
                    <p class="mt-2 text-3xl font-bold text-indigo-600">{{ $totalTransaksi }}</p>
                </div>

                <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
                    <h3 class="text-gray-500 text-sm font-medium">Total Omzet [Bulan Ini]</h3>
                    <p class="mt-2 text-3xl font-bold text-green-600">Rp{{ number_format($totalOmzet, 0, ',', '.') }}</p>
                </div>

                <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
                    <h3 class="text-gray-500 text-sm font-medium">Total Pelanggan</h3>
                    <p class="mt-2 text-3xl font-bold text-blue-600">{{ $totalPelanggan }}</p>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
                    <h3 class="text-gray-500 text-sm font-medium">Jumlah Paket Wisata</h3>
                    <p class="mt-2 text-3xl font-bold text-purple-600">{{ $totalPaket }}</p>
                </div>

                <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
                    <h3 class="text-gray-500 text-sm font-medium">Jumlah Mobil</h3>
                    <p class="mt-2 text-3xl font-bold text-yellow-600">{{ $totalMobil }}</p>
                </div>

                <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
                    <h3 class="text-gray-500 text-sm font-medium">Jumlah Pemesanan</h3>
                    <p class="mt-2 text-3xl font-bold text-pink-600">{{ $totalPemesanan }}</p>
                </div>
            </div>


        </div>
    </div>
</x-app-layout>
