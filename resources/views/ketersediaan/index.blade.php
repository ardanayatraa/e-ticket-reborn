<x-app-layout>
    <div class="py-8">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-center justify-between mb-6">
                        <h1 class="text-2xl font-semibold text-gray-800">Manajemen Ketersediaan</h1>
                        <a href="{{ route('ketersediaan.create') }}"
                            class="inline-flex items-center hidden px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md transition">
                            + Tambah Ketersediaan
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        @livewire('table.ketersediaan-table')
                        <div class="min-w-full bg-white rounded-md shadow-inner">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
