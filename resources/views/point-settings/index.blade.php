<x-app-layout>
   

    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div>
        <h2 class="font-semibold mb-4 text-xl text-gray-800 leading-tight">
          Pengaturan Sistem Poin
        </h2>
    </div>
                    <form action="{{ route('point-settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Poin per Transaksi -->
                            <div class="space-y-3">
                                <label for="points_per_transaction" class="block text-sm font-semibold text-gray-800">
                                    Rupiah per Poin
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm font-medium">Rp</span>
                                    </div>
                                    <input type="number" 
                                           id="points_per_transaction" 
                                           name="points_per_transaction" 
                                           value="{{ $settings->where('key', 'points_per_transaction')->first()->value ?? 500000 }}"
                                           class="pl-12 block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm"
                                           placeholder="500000">
                                </div>
                                <p class="text-xs text-gray-600 mt-1">
                                    Setiap Rp X = {{ $settings->where('key', 'points_earned_per_transaction')->first()->value ?? 5 }} poin
                                </p>
                                @error('points_per_transaction')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Poin yang Didapat -->
                            <div class="space-y-3">
                                <label for="points_earned_per_transaction" class="block text-sm font-semibold text-gray-800">
                                    Poin per Transaksi
                                </label>
                                <input type="number" 
                                       id="points_earned_per_transaction" 
                                       name="points_earned_per_transaction" 
                                       value="{{ $settings->where('key', 'points_earned_per_transaction')->first()->value ?? 5 }}"
                                       class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm"
                                       placeholder="5">
                                <p class="text-xs text-gray-600 mt-1">
                                    Jumlah poin yang didapat per transaksi
                                </p>
                                @error('points_earned_per_transaction')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Poin untuk Diskon -->
                            <div class="space-y-3">
                                <label for="points_for_discount" class="block text-sm font-semibold text-gray-800">
                                    Poin untuk Diskon
                                </label>
                                <input type="number" 
                                       id="points_for_discount" 
                                       name="points_for_discount" 
                                       value="{{ $settings->where('key', 'points_for_discount')->first()->value ?? 10 }}"
                                       class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm"
                                       placeholder="10">
                                <p class="text-xs text-gray-600 mt-1">
                                    Jumlah poin yang dibutuhkan untuk mendapatkan diskon
                                </p>
                                @error('points_for_discount')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Diskon per Poin -->
                            <div class="space-y-3">
                                <label for="discount_per_points" class="block text-sm font-semibold text-gray-800">
                                    Diskon per Poin
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm font-medium">Rp</span>
                                    </div>
                                    <input type="number" 
                                           id="discount_per_points" 
                                           name="discount_per_points" 
                                           value="{{ $settings->where('key', 'discount_per_points')->first()->value ?? 10000 }}"
                                           class="pl-12 block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm"
                                           placeholder="10000">
                                </div>
                                <p class="text-xs text-gray-600 mt-1">
                                    Diskon rupiah untuk {{ $settings->where('key', 'points_for_discount')->first()->value ?? 10 }} poin
                                </p>
                                @error('discount_per_points')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Preview Perhitungan -->
                        <div class="mt-8 p-6 bg-gray-50 rounded-lg border border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Preview Perhitungan</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                                <div class="space-y-1">
                                    <p class="text-gray-700 font-medium">Contoh Transaksi Rp 1.000.000:</p>
                                    <p class="text-teal-600 font-semibold">Poin yang didapat: <span id="preview-earned">-</span></p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-gray-700 font-medium">Contoh Penggunaan 10 Poin:</p>
                                    <p class="text-teal-600 font-semibold">Diskon yang didapat: <span id="preview-discount">-</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
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
        // Live preview calculation
        function updatePreview() {
            const pointsPerTransaction = parseInt(document.getElementById('points_per_transaction').value) || 500000;
            const pointsEarned = parseInt(document.getElementById('points_earned_per_transaction').value) || 5;
            const pointsForDiscount = parseInt(document.getElementById('points_for_discount').value) || 10;
            const discountPerPoints = parseInt(document.getElementById('discount_per_points').value) || 10000;

            // Calculate points earned for 1M transaction
            const transactionAmount = 1000000;
            const earnedPoints = Math.floor(transactionAmount / pointsPerTransaction) * pointsEarned;
            
            // Calculate discount for 10 points
            const discountAmount = (pointsForDiscount / pointsForDiscount) * discountPerPoints;

            document.getElementById('preview-earned').textContent = earnedPoints + ' poin';
            document.getElementById('preview-discount').textContent = 'Rp ' + discountAmount.toLocaleString('id-ID');
        }

        // Update preview when inputs change
        document.getElementById('points_per_transaction').addEventListener('input', updatePreview);
        document.getElementById('points_earned_per_transaction').addEventListener('input', updatePreview);
        document.getElementById('points_for_discount').addEventListener('input', updatePreview);
        document.getElementById('discount_per_points').addEventListener('input', updatePreview);

        // Initial preview
        updatePreview();
    </script>
</x-app-layout>