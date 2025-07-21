<x-app-layout>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            Tambah Pengaturan Poin
                        </h2>
                        <a href="{{ route('point-settings.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-200">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                    </div>

                    @if (session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('point-settings.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama Season Point -->
                            <div class="space-y-3">
                                <label for="nama_season_point" class="block text-sm font-semibold text-gray-800">
                                    Nama Season Point <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="nama_season_point" name="nama_season_point"
                                    value="{{ old('nama_season_point') }}"
                                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm"
                                    placeholder="Contoh: Low Season, High Season" required>
                                @error('nama_season_point')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Minimum Transaksi -->
                            <div class="space-y-3">
                                <label for="minimum_transaksi" class="block text-sm font-semibold text-gray-800">
                                    Minimum Transaksi <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm font-medium">Rp</span>
                                    </div>
                                    <input type="number" id="minimum_transaksi" name="minimum_transaksi"
                                        value="{{ old('minimum_transaksi') }}"
                                        class="pl-12 block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm"
                                        placeholder="500000" min="10000" required>
                                </div>
                                <p class="text-xs text-gray-600 mt-1">
                                    Minimum transaksi untuk mendapatkan point
                                </p>
                                @error('minimum_transaksi')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jumlah Point Diperoleh -->
                            <div class="space-y-3">
                                <label for="jumlah_point_diperoleh" class="block text-sm font-semibold text-gray-800">
                                    Jumlah Point Diperoleh <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="jumlah_point_diperoleh" name="jumlah_point_diperoleh"
                                    value="{{ old('jumlah_point_diperoleh') }}"
                                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm"
                                    placeholder="5" min="1" required>
                                <p class="text-xs text-gray-600 mt-1">
                                    Jumlah point yang didapat per batch transaksi
                                </p>
                                @error('jumlah_point_diperoleh')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Harga Satuan Point -->
                            <div class="space-y-3">
                                <label for="harga_satuan_point" class="block text-sm font-semibold text-gray-800">
                                    Harga Satuan Point <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm font-medium">Rp</span>
                                    </div>
                                    <input type="number" id="harga_satuan_point" name="harga_satuan_point"
                                        value="{{ old('harga_satuan_point') }}"
                                        class="pl-12 block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm"
                                        placeholder="10000" min="1000" required>
                                </div>
                                <p class="text-xs text-gray-600 mt-1">
                                    Nilai konversi per point untuk diskon
                                </p>
                                @error('harga_satuan_point')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Status Aktif -->
                        <div class="mt-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" 
                                    {{ old('is_active', true) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Aktifkan pengaturan ini</span>
                            </label>
                        </div>

                        <!-- Preview Section -->
                        <div class="mt-8 p-6 bg-gray-50 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Preview Perhitungan</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                                <div class="space-y-2">
                                    <p class="text-gray-700 font-medium">Contoh Transaksi:</p>
                                    <div id="preview-calculation" class="text-teal-600">
                                        Masukkan data untuk melihat preview
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <p class="text-gray-700 font-medium">Contoh Diskon:</p>
                                    <div id="preview-discount" class="text-teal-600">
                                        Masukkan data untuk melihat preview
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('point-settings.index') }}"
                                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-200">
                                Batal
                            </a>
                            <button type="submit"
                                class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-200">
                                <i class="fas fa-save mr-2"></i>Simpan Pengaturan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updatePreview() {
            const namaSeason = document.getElementById('nama_season_point').value;
            const minTransaksi = parseInt(document.getElementById('minimum_transaksi').value) || 0;
            const jumlahPoint = parseInt(document.getElementById('jumlah_point_diperoleh').value) || 0;
            const hargaSatuan = parseInt(document.getElementById('harga_satuan_point').value) || 0;

            const calculationDiv = document.getElementById('preview-calculation');
            const discountDiv = document.getElementById('preview-discount');

            if (minTransaksi > 0 && jumlahPoint > 0) {
                calculationDiv.innerHTML = `
                    <p><strong>Setiap transaksi minimal Rp ${minTransaksi.toLocaleString('id-ID')}:</strong></p>
                    <p>Point yang didapat: <strong>${jumlahPoint} point</strong></p>
                `;
            } else {
                calculationDiv.innerHTML = 'Masukkan data untuk melihat preview';
            }

            if (jumlahPoint > 0 && hargaSatuan > 0) {
                discountDiv.innerHTML = `
                    <p><strong>Penggunaan Point:</strong></p>
                    <p>• ${jumlahPoint} point = <strong>Rp ${hargaSatuan.toLocaleString('id-ID')}</strong></p>
                    <p>• ${jumlahPoint * 2} point = <strong>Rp ${(hargaSatuan * 2).toLocaleString('id-ID')}</strong></p>
                    <p>• ${jumlahPoint * 5} point = <strong>Rp ${(hargaSatuan * 5).toLocaleString('id-ID')}</strong></p>
                `;
            } else {
                discountDiv.innerHTML = 'Masukkan data untuk melihat preview';
            }
        }

        // Add event listeners
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = ['nama_season_point', 'minimum_transaksi', 'jumlah_point_diperoleh', 'harga_satuan_point'];
            inputs.forEach(id => {
                const input = document.getElementById(id);
                if (input) {
                    input.addEventListener('input', updatePreview);
                    input.addEventListener('change', updatePreview);
                }
            });
            
            // Initial update
            updatePreview();
        });
    </script>
</x-app-layout> 