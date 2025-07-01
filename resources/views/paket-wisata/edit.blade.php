{{-- resources/views/paket-wisata/edit.blade.php --}}
<x-app-layout>
    <div class="py-8">
        <div class="mx-auto sm:px-6 lg:px-8 w-full">
            {{-- Header --}}
            <div class="mb-4">
                <h2 class="text-lg font-semibold border-b-2 border-green-300 py-4 pl-6 text-green-800">
                    Edit Paket Wisata: {{ $paketwisata->judul }}
                </h2>
            </div>

            {{-- Form Card --}}
            <div class="bg-white border dark:bg-gray-800 sm:rounded-lg p-6 shadow">
                <form action="{{ route('paket-wisata.update', $paketwisata) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-6">
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
                        {{-- Judul --}}
                        <div>
                            <label for="judul" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Judul<span class="text-red-500">*</span>
                            </label>
                            <input id="judul" name="judul" type="text"
                                value="{{ old('judul', $paketwisata->judul) }}" required
                                placeholder="Masukkan judul paket"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                          focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition" />
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <label for="deskripsi" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Deskripsi<span class="text-red-500">*</span>
                            </label>
                            <textarea id="deskripsi" name="deskripsi" rows="4" required placeholder="Masukkan deskripsi paket"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
               focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition">{{ old('deskripsi', $paketwisata->deskripsi) }}</textarea>
                        </div>


                        {{-- Tempat --}}
                        <div>
                            <label for="tempat" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Tempat<span class="text-red-500">*</span>
                            </label>
                            <input id="tempat" name="tempat" type="text"
                                value="{{ old('tempat', $paketwisata->tempat) }}" required
                                placeholder="Masukkan lokasi wisata"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                          focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition" />
                        </div>

                        {{-- Durasi --}}
                        <div>
                            <label for="durasi" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Durasi (hari)<span class="text-red-500">*</span>
                            </label>
                            <input id="durasi" name="durasi" type="number" min="1"
                                value="{{ old('durasi', $paketwisata->durasi) }}" required placeholder="Contoh: 3"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                          focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition" />
                        </div>

                        {{-- Harga --}}
                        <div>
                            <label for="harga" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Harga (Rp)<span class="text-red-500">*</span>
                            </label>
                            <input id="harga" name="harga" type="number" step="0.01"
                                value="{{ old('harga', $paketwisata->harga) }}" required
                                placeholder="Masukkan harga paket"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                          focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition" />
                        </div>

                        {{-- Foto --}}
                        <div class="md:col-span-2">
                            <label for="foto" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Foto Paket (opsional)
                            </label>
                            <input id="foto" name="foto" type="file" accept="image/*"
                                class="block w-full text-gray-700 dark:text-gray-200" />
                            @error('foto')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror

                            {{-- Existing preview --}}
                            @if ($paketwisata->foto)
                                <div class="mt-4">
                                    <p class="text-sm text-gray-600 mb-1">Foto saat ini:</p>
                                    <img src="{{ asset('storage/' . $paketwisata->foto) }}"
                                        class="w-40 h-40 object-cover rounded-lg border" alt="Foto paket saat ini">
                                </div>
                            @endif

                            {{-- New preview --}}
                            <div class="mt-4">
                                <p id="preview-label" class="text-sm text-gray-600 mb-1 hidden">Preview baru:</p>
                                <img id="preview" src="#" alt="Preview Foto Paket"
                                    class="w-40 h-40 object-cover rounded-lg border hidden" />
                            </div>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-end gap-4">
                        <a href="{{ route('paket-wisata.index') }}"
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

    {{-- Preview script --}}
    <script>
        const fileInput = document.getElementById('foto');
        const previewImg = document.getElementById('preview');
        const previewLabel = document.getElementById('preview-label');

        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (!file) return;

            previewImg.src = URL.createObjectURL(file);
            previewImg.classList.remove('hidden');
            previewLabel.classList.remove('hidden');
        });
    </script>
</x-app-layout>
