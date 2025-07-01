{{-- resources/views/exclude/create.blade.php --}}
<x-app-layout>
    <div>
        <div class="mx-auto sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-4">
                <h2 class="text-lg font-semibold border py-4 pl-6 pr-8 text-green-800 flex items-center gap-2">
                    Tambah Exclude
                </h2>
            </div>
            {{-- Form Card --}}
            <div class="bg-white border dark:bg-gray-800 sm:rounded-lg p-6">
                <form action="{{ route('exclude.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Pemesanan --}}
                        <div>
                            <label for="pemesanan_id" class="block font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Pemesanan
                            </label>
                            <select id="pemesanan_id" name="pemesanan_id" required
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition">
                                <option value="">-- Pilih Pemesanan --</option>
                                @foreach ($pemesanan as $p)
                                    <option value="{{ $p->pemesanan_id }}"
                                        {{ old('pemesanan_id') == $p->pemesanan_id ? 'selected' : '' }}>
                                        {{ $p->pemesanan_id }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Bensin --}}
                        <div>
                            <label for="bensin" class="block font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Bensin
                            </label>
                            <input id="bensin" name="bensin" type="text" value="{{ old('bensin') }}"
                                placeholder="Misal: Rp100.000"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition" />
                        </div>

                        {{-- Parkir --}}
                        <div>
                            <label for="parkir" class="block font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Parkir
                            </label>
                            <input id="parkir" name="parkir" type="text" value="{{ old('parkir') }}"
                                placeholder="Misal: Rp50.000"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition" />
                        </div>

                        {{-- sopir --}}
                        <div>
                            <label for="sopir" class="block font-medium text-gray-700 dark:text-gray-300 mb-2">
                                sopir
                            </label>
                            <input id="sopir" name="sopir" type="text" value="{{ old('sopir') }}"
                                placeholder="Misal: Rp200.000"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition" />
                        </div>

                        {{-- Makan Siang --}}
                        <div>
                            <label for="makan_siang" class="block font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Makan Siang
                            </label>
                            <input id="makan_siang" name="makan_siang" type="text" value="{{ old('makan_siang') }}"
                                placeholder="Misal: Rp75.000"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition" />
                        </div>

                        {{-- Makan Malam --}}
                        <div>
                            <label for="makan_malam" class="block font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Makan Malam
                            </label>
                            <input id="makan_malam" name="makan_malam" type="text" value="{{ old('makan_malam') }}"
                                placeholder="Misal: Rp75.000"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition" />
                        </div>

                        {{-- Tiket Masuk --}}
                        <div>
                            <label for="tiket_masuk" class="block font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tiket Masuk
                            </label>
                            <input id="tiket_masuk" name="tiket_masuk" type="text" value="{{ old('tiket_masuk') }}"
                                placeholder="Misal: Rp50.000"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition" />
                        </div>
                    </div>

                    {{-- Status Ketersediaan --}}
                    <div class="flex items-center">
                        <input id="status_ketersediaan" name="status_ketersediaan" type="checkbox"
                            class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded"
                            {{ old('status_ketersediaan') ? 'checked' : '' }} />
                        <label for="status_ketersediaan"
                            class="ml-2 block font-medium text-gray-700 dark:text-gray-300">
                            Status Ketersediaan
                        </label>
                    </div>

                    {{-- Buttons --}}
                    <div class="mt-6 flex justify-end gap-4">
                        <a href="{{ route('exclude.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
