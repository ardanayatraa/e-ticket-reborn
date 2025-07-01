{{-- resources/views/ketersediaan/create.blade.php --}}
<x-app-layout>
    <div>
        <div class="mx-auto sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-4">
                <h2 class="text-lg font-semibold border py-4 pl-6 pr-8 text-green-800 flex items-center gap-2">
                    Tambah Ketersediaan
                </h2>
            </div>
            {{-- Form Card --}}
            <div class="bg-white border dark:bg-gray-800 sm:rounded-lg p-6">
                <form action="{{ route('ketersediaan.store') }}" method="POST" class="space-y-6">
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
                                @foreach ($pesanan as $p)
                                    <option value="{{ $p->pemesanan_id }}"
                                        {{ old('pemesanan_id') == $p->pemesanan_id ? 'selected' : '' }}>
                                        {{ $p->pemesanan_id }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Mobil --}}
                        <div>
                            <label for="mobil_id" class="block font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Mobil
                            </label>
                            <select id="mobil_id" name="mobil_id" required
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition">
                                <option value="">-- Pilih Mobil --</option>
                                @foreach ($mobils as $m)
                                    <option value="{{ $m->mobil_id }}"
                                        {{ old('mobil_id') == $m->mobil_id ? 'selected' : '' }}>
                                        {{ $m->nama_kendaraan }} – {{ $m->nomor_kendaraan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Sopir --}}
                        <div>
                            <label for="sopir_id" class="block font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Sopir
                            </label>
                            <select id="sopir_id" name="sopir_id" required
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition">
                                <option value="">-- Pilih Sopir --</option>
                                @foreach ($sopirs as $s)
                                    <option value="{{ $s->sopir_id }}"
                                        {{ old('sopir_id') == $s->sopir_id ? 'selected' : '' }}>
                                        {{ $s->nama_sopir }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tanggal Keberangkatan --}}
                        <div>
                            <label for="tanggal_keberangkatan"
                                class="block font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tanggal Keberangkatan
                            </label>
                            <input id="tanggal_keberangkatan" name="tanggal_keberangkatan" type="date"
                                value="{{ old('tanggal_keberangkatan') }}" required
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition" />
                        </div>

                        {{-- Status Ketersediaan --}}
                        <div class="md:col-span-2">
                            <label for="status_ketersediaan"
                                class="block font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Status Ketersediaan
                            </label>
                            <select id="status_ketersediaan" name="status_ketersediaan" required
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition">
                                <option value="">-- Pilih Status --</option>
                                <option value="tersedia"
                                    {{ old('status_ketersediaan') == 'tersedia' ? 'selected' : '' }}>
                                    Tersedia
                                </option>
                                <option value="tidak tersedia"
                                    {{ old('status_ketersediaan') == 'tidak tersedia' ? 'selected' : '' }}>
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
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
