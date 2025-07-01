<x-app-layout>
    <div class="py-8">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-center justify-between mb-6">
                        <h1 class="text-2xl font-semibold text-gray-800">Manajemen Transaksi</h1>

                    </div>

                    <div class="overflow-x-auto">
                        @livewire('table.transaksi-table')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
