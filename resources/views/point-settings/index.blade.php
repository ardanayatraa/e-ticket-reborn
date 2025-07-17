<x-app-layout>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div>
                        <h2 class="font-semibold mb-4 text-xl text-gray-800 leading-tight">
                            Pengaturan Sistem Poin
                        </h2>
                    </div>

                    @php
                        // Calculate preview values
                        $pointsPerTransaction =
                            $settings->where('key', 'points_per_transaction')->first()->value ?? 500000;
                        $pointsEarned = $settings->where('key', 'points_earned_per_transaction')->first()->value ?? 5;
                        $pointsForDiscount = $settings->where('key', 'points_for_discount')->first()->value ?? 10;
                        $discountPerPoints = $settings->where('key', 'discount_per_points')->first()->value ?? 10000;

                        // Calculate earned points for 1M transaction
                        $transactionAmount = 1000000;
                        $earnedPoints = floor($transactionAmount / $pointsPerTransaction) * $pointsEarned;

                        // Function to calculate discount
                        function calculateDiscount($points, $pointsForDiscount, $discountPerPoints)
                        {
                            return floor($points / $pointsForDiscount) * $discountPerPoints;
                        }

                        $discount10 = calculateDiscount(10, $pointsForDiscount, $discountPerPoints);
                        $discount20 = calculateDiscount(20, $pointsForDiscount, $discountPerPoints);
                        $discount50 = calculateDiscount(50, $pointsForDiscount, $discountPerPoints);
                    @endphp

                    <form action="{{ route('point-settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Rupiah per Poin -->
                            <div class="space-y-3">
                                <label for="points_per_transaction" class="block text-sm font-semibold text-gray-800">
                                    Minimal Transaksi untuk Poin
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm font-medium">Rp</span>
                                    </div>
                                    <input type="number" id="points_per_transaction" name="points_per_transaction"
                                        value="{{ $pointsPerTransaction }}"
                                        class="pl-12 block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm"
                                        placeholder="500000" min="10000" onchange="updatePreview()"
                                        oninput="updatePreview()">
                                </div>
                                <p class="text-xs text-gray-600 mt-1" id="desc-transaction">
                                    Setiap Rp {{ number_format($pointsPerTransaction, 0, ',', '.') }} =
                                    {{ $pointsEarned }} poin
                                </p>
                                @error('points_per_transaction')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Poin yang Didapat -->
                            <div class="space-y-3">
                                <label for="points_earned_per_transaction"
                                    class="block text-sm font-semibold text-gray-800">
                                    Poin per Transaksi
                                </label>
                                <input type="number" id="points_earned_per_transaction"
                                    name="points_earned_per_transaction" value="{{ $pointsEarned }}"
                                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm"
                                    placeholder="5" min="1" onchange="updatePreview()" oninput="updatePreview()">
                                <p class="text-xs text-gray-600 mt-1">
                                    Jumlah poin yang didapat jika mencapai minimal transaksi
                                </p>
                                @error('points_earned_per_transaction')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Poin untuk Diskon -->
                            <div class="space-y-3">
                                <label for="points_for_discount" class="block text-sm font-semibold text-gray-800">
                                    Minimal Poin untuk Diskon
                                </label>
                                <input type="number" id="points_for_discount" name="points_for_discount"
                                    value="{{ $pointsForDiscount }}"
                                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm"
                                    placeholder="10" min="1" onchange="updatePreview()"
                                    oninput="updatePreview()">
                                <p class="text-xs text-gray-600 mt-1">
                                    Minimal poin yang dibutuhkan untuk mendapatkan diskon
                                </p>
                                @error('points_for_discount')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Diskon per Poin -->
                            <div class="space-y-3">
                                <label for="discount_per_points" class="block text-sm font-semibold text-gray-800">
                                    Nilai Diskon per Batch
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm font-medium">Rp</span>
                                    </div>
                                    <input type="number" id="discount_per_points" name="discount_per_points"
                                        value="{{ $discountPerPoints }}"
                                        class="pl-12 block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm"
                                        placeholder="10000" min="1000" onchange="updatePreview()"
                                        oninput="updatePreview()">
                                </div>
                                <p class="text-xs text-gray-600 mt-1" id="desc-discount">
                                    Diskon Rp {{ number_format($discountPerPoints, 0, ',', '.') }} untuk setiap
                                    {{ $pointsForDiscount }} poin
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
                                <!-- Earning Points -->
                                <div class="space-y-2">
                                    <p class="text-gray-700 font-medium">Contoh Transaksi Rp 1.000.000:</p>
                                    <p class="text-teal-600 font-semibold">
                                        Poin yang didapat: <span id="preview-earned">{{ $earnedPoints }} poin</span>
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        Perhitungan: 1.000.000 ÷ <span
                                            id="calc-per-transaction">{{ number_format($pointsPerTransaction, 0, ',', '.') }}</span>
                                        × <span id="calc-earned">{{ $pointsEarned }}</span> = <span
                                            id="preview-earned-calc">{{ $earnedPoints }} poin</span>
                                    </p>
                                </div>

                                <!-- Using Points -->
                                <div class="space-y-2">
                                    <p class="text-gray-700 font-medium">Contoh Penggunaan Poin:</p>
                                    <div class="space-y-1">
                                        <p class="text-teal-600 font-semibold">
                                            • 10 poin → Diskon: <span id="preview-discount-10">Rp
                                                {{ number_format($discount10, 0, ',', '.') }}</span>
                                        </p>
                                        <p class="text-teal-600 font-semibold">
                                            • 20 poin → Diskon: <span id="preview-discount-20">Rp
                                                {{ number_format($discount20, 0, ',', '.') }}</span>
                                        </p>
                                        <p class="text-teal-600 font-semibold">
                                            • 50 poin → Diskon: <span id="preview-discount-50">Rp
                                                {{ number_format($discount50, 0, ',', '.') }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Info -->
                            <div class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                                <h4 class="text-sm font-semibold text-blue-900 mb-2">💡 Penjelasan Sistem:</h4>
                                <div class="text-xs text-blue-800 space-y-1">
                                    <p>• Customer harus transaksi minimal <span id="info-min-transaction">Rp
                                            {{ number_format($pointsPerTransaction, 0, ',', '.') }}</span> untuk
                                        mendapat <span id="info-points-earned">{{ $pointsEarned }}</span> poin</p>
                                    <p>• Untuk tukar diskon, customer butuh minimal <span
                                            id="info-min-points">{{ $pointsForDiscount }}</span> poin</p>
                                    <p>• Setiap <span id="info-points-batch">{{ $pointsForDiscount }}</span> poin =
                                        diskon <span id="info-discount-value">Rp
                                            {{ number_format($discountPerPoints, 0, ',', '.') }}</span></p>
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
        // Simple and reliable preview update function
        function updatePreview() {
            try {
                // Get input values with fallbacks
                const pointsPerTransaction = parseInt(document.getElementById('points_per_transaction')?.value) || 500000;
                const pointsEarned = parseInt(document.getElementById('points_earned_per_transaction')?.value) || 5;
                const pointsForDiscount = parseInt(document.getElementById('points_for_discount')?.value) || 10;
                const discountPerPoints = parseInt(document.getElementById('discount_per_points')?.value) || 10000;

                // Calculate earned points for 1M transaction
                const transactionAmount = 1000000;
                const earnedPoints = Math.floor(transactionAmount / pointsPerTransaction) * pointsEarned;

                // Calculate discounts for different point amounts
                function calculateDiscount(points) {
                    return Math.floor(points / pointsForDiscount) * discountPerPoints;
                }

                const discount10 = calculateDiscount(10);
                const discount20 = calculateDiscount(20);
                const discount50 = calculateDiscount(50);

                // Helper function to safely update element
                function updateElement(id, value) {
                    const element = document.getElementById(id);
                    if (element) {
                        element.textContent = value;
                    }
                }

                // Update preview elements
                updateElement('preview-earned', earnedPoints + ' poin');
                updateElement('preview-earned-calc', earnedPoints + ' poin');
                updateElement('calc-per-transaction', pointsPerTransaction.toLocaleString('id-ID'));
                updateElement('calc-earned', pointsEarned.toString());
                updateElement('preview-discount-10', 'Rp ' + discount10.toLocaleString('id-ID'));
                updateElement('preview-discount-20', 'Rp ' + discount20.toLocaleString('id-ID'));
                updateElement('preview-discount-50', 'Rp ' + discount50.toLocaleString('id-ID'));

                // Update descriptions
                updateElement('desc-transaction',
                    `Setiap Rp ${pointsPerTransaction.toLocaleString('id-ID')} = ${pointsEarned} poin`);
                updateElement('desc-discount',
                    `Diskon Rp ${discountPerPoints.toLocaleString('id-ID')} untuk setiap ${pointsForDiscount} poin`);

                // Update info section
                updateElement('info-min-transaction', `Rp ${pointsPerTransaction.toLocaleString('id-ID')}`);
                updateElement('info-points-earned', pointsEarned.toString());
                updateElement('info-min-points', pointsForDiscount.toString());
                updateElement('info-points-batch', pointsForDiscount.toString());
                updateElement('info-discount-value', `Rp ${discountPerPoints.toLocaleString('id-ID')}`);

            } catch (error) {
                console.error('Error updating preview:', error);
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Run initial update
            setTimeout(updatePreview, 100);

            // Add backup event listeners (in case inline events don't work)
            const inputIds = ['points_per_transaction', 'points_earned_per_transaction', 'points_for_discount',
                'discount_per_points'
            ];

            inputIds.forEach(id => {
                const input = document.getElementById(id);
                if (input) {
                    input.addEventListener('input', updatePreview);
                    input.addEventListener('change', updatePreview);
                }
            });
        });

        // Also run on window load as backup
        window.addEventListener('load', updatePreview);
    </script>
</x-app-layout>
