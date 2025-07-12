<x-app-layout>
    <div class="py-8">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-800">Manajemen Laporan Transaksi</h1>
                            <p class="text-sm text-gray-600 mt-1">
                                Menampilkan transaksi dengan status 'paid' dan 'confirmed'. 
                                Data diupdate secara otomatis setiap 30 detik.
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500">Last updated: {{ now()->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        @livewire('table.transaksi-laporan-table')
                    </div>

                    @if(session('success'))
                        <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                        </div>
                    @endif

                    @if(session('message'))
                        <div class="mt-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
                            <i class="fas fa-info-circle mr-2"></i>{{ session('message') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
