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

                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                Pengaturan Sistem Poin
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">
                                <i class="fas fa-info-circle mr-1"></i>
                                Hanya satu pengaturan poin yang dapat aktif pada satu waktu
                            </p>
                        </div>
                        <a href="{{ route('point-settings.create') }}"
                            class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-200">
                            <i class="fas fa-plus mr-2"></i>Tambah Pengaturan
                        </a>
                    </div>

                    <!-- Point Settings Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Season
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Min. Transaksi
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Point Diperoleh
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Harga Satuan Point
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @forelse($settings as $setting)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            <div class="text-sm leading-5 font-medium text-gray-900">
                                                {{ $setting->nama_season_point }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            <div class="text-sm leading-5 text-gray-900">
                                                Rp {{ number_format($setting->minimum_transaksi, 0, ',', '.') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            <div class="text-sm leading-5 text-gray-900">
                                                {{ $setting->jumlah_point_diperoleh }} point
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            <div class="text-sm leading-5 text-gray-900">
                                                Rp {{ number_format($setting->harga_satuan_point, 0, ',', '.') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            @if($setting->is_active)
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">
                                                    Nonaktif
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('point-settings.edit', $setting->point_id) }}"
                                                    class="text-indigo-600 hover:text-indigo-900">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('point-settings.toggle-active', $setting->point_id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="text-yellow-600 hover:text-yellow-900">
                                                        @if($setting->is_active)
                                                            <i class="fas fa-pause" title="Nonaktifkan"></i>
                                                        @else
                                                            <i class="fas fa-play" title="Aktifkan"></i>
                                                        @endif
                                                    </button>
                                                </form>
                                                <form action="{{ route('point-settings.destroy', $setting->point_id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengaturan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-center text-gray-500">
                                            Tidak ada pengaturan poin yang tersedia
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Preview Section -->
                    <div class="mt-8 p-6 bg-gray-50 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Preview Perhitungan Poin</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Transaction Amount Input -->
                            <div>
                                <label for="transaction_amount" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jumlah Transaksi
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm font-medium">Rp</span>
                                    </div>
                                    <input type="number" id="transaction_amount" 
                                        class="pl-12 block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm"
                                        placeholder="1000000" min="10000" onchange="updatePreview()" oninput="updatePreview()">
                                </div>
                            </div>

                            <!-- Preview Results -->
                            <div id="preview-results" class="space-y-3">
                                <div class="text-sm text-gray-600">
                                    Masukkan jumlah transaksi untuk melihat preview
                                </div>
                            </div>
                        </div>

                        <!-- Discount Preview -->
                        <div id="discount-preview" class="mt-6 hidden">
                            <h4 class="text-md font-semibold text-gray-800 mb-3">Preview Diskon Point</h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="discount-grid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updatePreview() {
            const transactionAmount = document.getElementById('transaction_amount').value;
            
            if (!transactionAmount || transactionAmount < 10000) {
                document.getElementById('preview-results').innerHTML = '<div class="text-sm text-gray-600">Masukkan jumlah transaksi minimal Rp 10.000</div>';
                document.getElementById('discount-preview').classList.add('hidden');
                return;
            }

            fetch('{{ route("point-settings.preview") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    transaction_amount: transactionAmount
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const resultsDiv = document.getElementById('preview-results');
                    resultsDiv.innerHTML = `
                        <div class="space-y-2">
                            <div class="text-sm">
                                <span class="font-medium">Season:</span> ${data.setting.nama_season_point}
                            </div>
                            <div class="text-sm">
                                <span class="font-medium">Point yang didapat:</span> ${data.earned_points} point
                            </div>
                            <div class="text-sm">
                                <span class="font-medium">Min. transaksi:</span> Rp ${new Intl.NumberFormat('id-ID').format(data.setting.minimum_transaksi)}
                            </div>
                            <div class="text-sm">
                                <span class="font-medium">Point per batch:</span> ${data.setting.jumlah_point_diperoleh} point
                            </div>
                            <div class="text-sm">
                                <span class="font-medium">Nilai diskon per batch:</span> Rp ${new Intl.NumberFormat('id-ID').format(data.setting.harga_satuan_point)}
                            </div>
                        </div>
                    `;

                    // Update discount preview
                    const discountGrid = document.getElementById('discount-grid');
                    discountGrid.innerHTML = '';
                    
                    data.discounts.forEach(discount => {
                        discountGrid.innerHTML += `
                            <div class="bg-white p-3 rounded border text-center">
                                <div class="text-lg font-semibold text-teal-600">${discount.points} Point</div>
                                <div class="text-sm text-gray-600">= ${discount.formatted_discount}</div>
                            </div>
                        `;
                    });

                    document.getElementById('discount-preview').classList.remove('hidden');
                } else {
                    document.getElementById('preview-results').innerHTML = `<div class="text-sm text-red-600">${data.message}</div>`;
                    document.getElementById('discount-preview').classList.add('hidden');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('preview-results').innerHTML = '<div class="text-sm text-red-600">Terjadi kesalahan saat menghitung preview</div>';
                document.getElementById('discount-preview').classList.add('hidden');
            });
        }
    </script>
</x-app-layout>
