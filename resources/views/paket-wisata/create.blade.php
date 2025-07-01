{{-- resources/views/paket-wisata/create.blade.php --}}
<x-app-layout>
    <div class="py-8">
        <div class="mx-auto sm:px-6 lg:px-8 w-full">
            {{-- Header --}}
            <div class="mb-4">
                <h2 class="text-lg font-semibold bg-white border-b-2 border-green-300 py-4 pl-6 text-green-800">
                    Tambah Paket Wisata
                </h2>
            </div>

            {{-- Form Card --}}
            <div class="bg-white border dark:bg-gray-800 sm:rounded-lg p-6 shadow">
                <form action="{{ route('paket-wisata.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

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
                            <input id="judul" name="judul" type="text" value="{{ old('judul') }}" required
                                placeholder="Masukkan judul paket"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition" />
                        </div>

                        {{-- Tempat --}}
                        <div>
                            <label for="tempat" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Tempat<span class="text-red-500">*</span>
                            </label>
                            <input id="tempat" name="tempat" type="text" value="{{ old('tempat') }}" required
                                placeholder="Masukkan lokasi wisata"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition" />
                        </div>

                        {{-- Durasi --}}
                        <div>
                            <label for="durasi" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Durasi (hari)<span class="text-red-500">*</span>
                            </label>
                            <input id="durasi" name="durasi" type="number" value="{{ old('durasi') }}" required
                                min="1" placeholder="Contoh: 3"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition" />
                        </div>

                        {{-- Harga --}}
                        <div>
                            <label for="harga" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Harga (Rp)<span class="text-red-500">*</span>
                            </label>
                            <input id="harga" name="harga" type="number" value="{{ old('harga') }}" required
                                step="0.01" placeholder="Masukkan harga paket"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition" />
                        </div>


                        {{-- Deskripsi --}}
                        <div class="md:col-span-2">
                            <label for="deskripsi" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Deskripsi<span class="text-red-500">*</span>
                            </label>
                            <textarea id="deskripsi" name="deskripsi" rows="4" required placeholder="Masukkan deskripsi paket"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition">{{ old('deskripsi') }}</textarea>
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
                            <img id="preview" src="#" alt="Preview Foto Paket"
                                class="mt-4 w-40 h-40 object-cover rounded-lg hidden border" />
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
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Preview script --}}
    <script>
        document.getElementById('foto').addEventListener('change', function(e) {
            const file = this.files[0];
            if (!file) return;

            const preview = document.getElementById('preview');
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        });
    </script>
</x-app-layout>
