{{-- resources/views/pemesanan/edit.blade.php --}}
<x-app-layout>
    <div>
        <div class="mx-auto sm:px-6 lg:px-8w-full">
            {{-- Header --}}
            <div class="mb-4">
                <h2 class="text-lg font-semibold border py-4 pl-6 pr-8 text-green-800 flex items-center gap-2">
                    Edit Pemesanan: {{ $ketersediaan->terpesan_id }}
                </h2>
            </div>

            {{-- Form Card --}}
            <div class="bg-white border dark:bg-gray-800 sm:rounded-lg p-6">
                <form action="{{ route('pemesanan.update', $ketersediaan) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Pelanggan --}}
                        <div>
                            <label for="pelanggan_id" class="block font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Pelanggan
                            </label>
                            <select id="pelanggan_id" name="pelanggan_id" required
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition">
                                @foreach ($pelanggan as $p)
                                    <option value="{{ $p->pelanggan_id }}"
                                        {{ old('pelanggan_id', $ketersediaan->pelanggan_id) == $p->pelanggan_id ? 'selected' : '' }}>
                                        {{ $p->nama_pemesan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Paket Wisata --}}
                        <div>
                            <label for="paketwisata_id" class="block font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Paket Wisata
                            </label>
                            <select id="paketwisata_id" name="paketwisata_id" required
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition">
                                @foreach ($pakets as $paket)
                                    <option value="{{ $paket->paketwisata_id }}"
                                        {{ old('paketwisata_id', $ketersediaan->paketwisata_id) == $paket->paketwisata_id ? 'selected' : '' }}>
                                        {{ $paket->judul }} ({{ $paket->tempat }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tipe Mobil --}}
                        <div>
                            <label for="mobil_id" class="block font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tipe Mobil
                            </label>
                            <select id="mobil_id" name="mobil_id" required
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition">

                                @foreach ($mobils as $m)
                                    <option value="{{ $m->mobil_id }}"
                                        {{ old('mobil_id', $ketersediaan->mobil_id) == $m->mobil_id ? 'selected' : '' }}>
                                        {{ $m->nama_kendaraan }} – {{ $m->nomor_kendaraan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Jam Mulai --}}
                        <div>
                            <label for="jam_mulai" class="block font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Jam Mulai
                            </label>
                            <input id="jam_mulai" name="jam_mulai" type="time"
                                value="{{ old('jam_mulai', $ketersediaan->jam_mulai) }}" required
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition">
                        </div>

                        {{-- Tanggal Keberangkatan --}}
                        <div>
                            <label for="tanggal_keberangkatan"
                                class="block font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tanggal Keberangkatan
                            </label>
                            <input id="tanggal_keberangkatan" name="tanggal_keberangkatan" type="date"
                                value="{{ old('tanggal_keberangkatan', $ketersediaan->tanggal_keberangkatan) }}" required
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition">
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-end gap-4">
                        <a href="{{ route('pemesanan.index') }}"
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
