{{-- resources/views/mobil/edit.blade.php --}}
<x-app-layout>
    <div class="py-8">
        <div class="mx-auto sm:px-6 lg:px-8 w-full">
            {{-- Header --}}
            <div class="mb-4">
                <h2 class="text-lg font-semibold border-b-2 border-green-300 py-4 pl-6 text-green-800">
                    Edit Mobil: {{ $mobil->nama_kendaraan }}
                </h2>
            </div>

            {{-- Form Card --}}
            <div class="bg-white border dark:bg-gray-800 sm:rounded-lg p-6 shadow">
                <form action="{{ route('mobil.update', $mobil) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="p-4 bg-green-50 border border-green-200 rounded-lg text-green-800">
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Fields --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Sopir --}}
                        <div>
                            <label for="sopir_id" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Sopir <span class="text-red-500">*</span>
                            </label>
                            <select id="sopir_id" name="sopir_id" required
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                               focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition">
                                <option value="">-- Pilih Sopir --</option>
                                @foreach ($sopirs as $s)
                                    <option value="{{ $s->sopir_id }}"
                                        {{ old('sopir_id', $mobil->sopir_id) == $s->sopir_id ? 'selected' : '' }}>
                                        {{ $s->nama_sopir }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Nama Kendaraan --}}
                        <div>
                            <label for="nama_kendaraan" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Nama Kendaraan <span class="text-red-500">*</span>
                            </label>
                            <input id="nama_kendaraan" name="nama_kendaraan" type="text"
                                value="{{ old('nama_kendaraan', $mobil->nama_kendaraan) }}" required
                                placeholder="Misal: Toyota Avanza"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                              focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition" />
                        </div>

                        {{-- Nomor Kendaraan --}}
                        <div>
                            <label for="nomor_kendaraan"
                                class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Nomor Kendaraan <span class="text-red-500">*</span>
                            </label>
                            <input id="nomor_kendaraan" name="nomor_kendaraan" type="text"
                                value="{{ old('nomor_kendaraan', $mobil->nomor_kendaraan) }}" required
                                placeholder="Contoh: AB 1234 CD"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                              focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition" />
                        </div>

                        {{-- Jumlah Tempat Duduk --}}
                        <div>
                            <label for="jumlah_tempat_duduk"
                                class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Jumlah Tempat Duduk <span class="text-red-500">*</span>
                            </label>
                            <input id="jumlah_tempat_duduk" name="jumlah_tempat_duduk" type="number" min="1"
                                value="{{ old('jumlah_tempat_duduk', $mobil->jumlah_tempat_duduk) }}" required
                                placeholder="Misal: 4"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                              focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition" />
                        </div>

                        {{-- Status Ketersediaan --}}
                        <div class="md:col-span-2">
                            <label for="status_ketersediaan"
                                class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Status Ketersediaan <span class="text-red-500">*</span>
                            </label>
                            <select id="status_ketersediaan" name="status_ketersediaan" required
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                               focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition">
                                <option value="">-- Pilih Status --</option>
                                <option value="tersedia"
                                    {{ old('status_ketersediaan', $mobil->status_ketersediaan) == 'tersedia' ? 'selected' : '' }}>
                                    Tersedia
                                </option>
                                <option value="tidak tersedia"
                                    {{ old('status_ketersediaan', $mobil->status_ketersediaan) == 'tidak tersedia' ? 'selected' : '' }}>
                                    Tidak tersedia
                                </option>
                            </select>
                        </div>
                    </div>

                    {{-- Foto & Preview --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                        <div>
                            <label for="foto" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Ganti Foto (opsional)
                            </label>
                            <input id="foto" name="foto" type="file" accept="image/*"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                              focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition" />
                        </div>
                        <div>
                            <p class="mb-1 font-medium text-gray-700 dark:text-gray-300">Preview</p>
                            <img id="preview-foto" src="{{ $mobil->foto ? Storage::url($mobil->foto) : '#' }}"
                                alt="Preview Foto"
                                class="{{ $mobil->foto ? '' : 'hidden' }} w-full h-auto max-w-xs object-cover rounded-md border" />
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-end gap-4">
                        <a href="{{ route('mobil.index') }}"
                            class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition shadow">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Preview Script --}}
    <script>
        document.getElementById('foto').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const img = document.getElementById('preview-foto');
            if (!file) {
                img.src = '#';
                img.classList.add('hidden');
                return;
            }
            const reader = new FileReader();
            reader.onload = ev => {
                img.src = ev.target.result;
                img.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        });
    </script>
</x-app-layout>
