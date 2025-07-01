{{-- resources/views/ketersediaan/edit.blade.php --}}
<x-app-layout>
    <div>
        <div class="mx-auto sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-4">
                <h2 class="text-lg font-semibold border py-4 pl-6 pr-8 text-green-800 flex items-center gap-2">
                    Edit Ketersediaan: {{ $ketersediaan->pemesanan_id }}
                </h2>
            </div>
            {{-- Form Card --}}
            <div class="bg-white border dark:bg-gray-800 sm:rounded-lg p-6">
                <form action="{{ route('ketersediaan.update', $ketersediaan) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Show all related fields as disabled --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-2">Pemesanan</label>
                            <input type="text" value="{{ $ketersediaan->pemesanan_id }}" disabled
                                class="block w-full bg-gray-100 border border-gray-300 rounded-lg p-2" />
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-2">Mobil</label>
                            <input type="text"
                                value="{{ $ketersediaan->mobil->nama_kendaraan }} – {{ $ketersediaan->mobil->nomor_kendaraan }}"
                                disabled class="block w-full bg-gray-100 border border-gray-300 rounded-lg p-2" />
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-2">Sopir</label>
                            <input type="text" value="{{ $ketersediaan->sopir->nama_sopir }}" disabled
                                class="block w-full bg-gray-100 border border-gray-300 rounded-lg p-2" />
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal
                                Keberangkatan</label>
                            <input type="date" value="{{ $ketersediaan->tanggal_keberangkatan }}" disabled
                                class="block w-full bg-gray-100 border border-gray-300 rounded-lg p-2" />
                        </div>

                        {{-- Editable status --}}
                        <div class="md:col-span-2">
                            <label for="status_ketersediaan"
                                class="block font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Status Ketersediaan
                            </label>
                            <select id="status_ketersediaan" name="status_ketersediaan" required
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition">
                                <option value="tersedia"
                                    {{ $ketersediaan->status_ketersediaan == 'tersedia' ? 'selected' : '' }}>
                                    Tersedia
                                </option>
                                <option value="tidak tersedia"
                                    {{ $ketersediaan->status_ketersediaan == 'tidak tersedia' ? 'selected' : '' }}>
                                    Tidak tersedia
                                </option>
                            </select>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="mt-6 flex justify-end gap-4">
                        <a href="{{ route('ketersediaan.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
