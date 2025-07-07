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
                        <div class="p-4 bg-red-50 border border-red-200 rounded-lg text-red-800">
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Basic Information Section --}}
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 border-b pb-2">
                            Informasi Dasar
                        </h3>

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

                            {{-- Max Duration --}}
                            <div>
                                <label for="max_duration"
                                    class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Durasi Maksimal (jam)<span class="text-red-500">*</span>
                                </label>
                                <input id="max_duration" name="max_duration" type="number"
                                    value="{{ old('max_duration') }}" required min="1" max="9"
                                    placeholder="Maksimal 9 jam"
                                    class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                           focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition" />
                            </div>

                            {{-- Harga --}}
                            <div class="md:col-span-2">
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
                        </div>
                    </div>

                    {{-- Include Section --}}
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 border-b pb-2">
                            Fasilitas yang Termasuk
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Centang fasilitas yang termasuk dalam paket. Yang tidak dicentang akan otomatis masuk ke
                            kategori tidak termasuk.
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            {{-- Include Fields --}}
                            @php
                                $includeFields = [
                                    'bensin' => ['label' => 'Bensin', 'icon' => '⛽'],
                                    'parkir' => ['label' => 'Parkir', 'icon' => '🅿️'],
                                    'sopir' => ['label' => 'Sopir', 'icon' => '👨‍✈️'],
                                    'makan_siang' => ['label' => 'Makan Siang', 'icon' => '🍽️'],
                                    'makan_malam' => ['label' => 'Makan Malam', 'icon' => '🍽️'],
                                    'tiket_masuk' => ['label' => 'Tiket Masuk', 'icon' => '🎫'],
                                ];
                            @endphp

                            @foreach ($includeFields as $field => $data)
                                <div class="relative">
                                    <label for="include_{{ $field }}"
                                        class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition-all
                                               hover:border-gray-400 dark:hover:border-gray-600
                                               border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800
                                               has-[:checked]:border-green-500 has-[:checked]:bg-green-50 dark:has-[:checked]:bg-green-900/20">

                                        <input type="checkbox" id="include_{{ $field }}"
                                            name="include[{{ $field }}]" value="1"
                                            {{ old("include.$field") ? 'checked' : '' }}
                                            class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-500 mr-3">

                                        <span class="text-2xl mr-3">{{ $data['icon'] }}</span>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                            {{ $data['label'] }}
                                        </span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Media Section --}}
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 border-b pb-2">
                            Media
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Foto Utama --}}
                            <div>
                                <label for="foto" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Foto Utama
                                </label>
                                <div
                                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                            fill="none" viewBox="0 0 48 48">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="foto"
                                                class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                                <span>Upload foto</span>
                                                <input id="foto" name="foto" type="file" accept="image/*"
                                                    class="sr-only">
                                            </label>
                                            <p class="pl-1">atau drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                    </div>
                                </div>
                                <img id="preview" src="#" alt="Preview Foto Paket"
                                    class="mt-4 w-full h-48 object-cover rounded-lg hidden border" />
                            </div>

                            {{-- Gallery --}}
                            <div>
                                <label for="gallery" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Gallery Foto (Multiple)
                                </label>
                                <div
                                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                            fill="none" viewBox="0 0 48 48">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="gallery"
                                                class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                                <span>Upload gallery</span>
                                                <input id="gallery" name="gallery[]" type="file"
                                                    accept="image/*" multiple class="sr-only">
                                            </label>
                                            <p class="pl-1">atau drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">Multiple files allowed</p>
                                    </div>
                                </div>
                                <div id="gallery-preview" class="mt-4 grid grid-cols-3 gap-2"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-end gap-4 pt-6 border-t">
                        <a href="{{ route('paket-wisata.index') }}"
                            class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition shadow">
                            Simpan Paket Wisata
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Preview scripts --}}
    <script>
        // Preview foto utama
        document.getElementById('foto').addEventListener('change', function(e) {
            const file = this.files[0];
            if (!file) return;

            const preview = document.getElementById('preview');
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        });

        // Preview gallery
        document.getElementById('gallery').addEventListener('change', function(e) {
            const files = this.files;
            const previewContainer = document.getElementById('gallery-preview');
            previewContainer.innerHTML = '';

            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg border">
                        <button type="button" onclick="this.parentElement.remove()"
                            class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">
                            ×
                        </button>
                    `;
                    previewContainer.appendChild(div);
                }
                reader.readAsDataURL(file);
            });
        });

        // Validate max_duration (now in hours, not related to durasi in days)
        document.getElementById('max_duration').addEventListener('change', function() {
            const maxDuration = parseInt(this.value);

            if (maxDuration < 1 || maxDuration > 9) {
                this.value = Math.max(1, Math.min(9, maxDuration));
                alert('Durasi maksimal harus antara 1-9 jam!');
            }
        });
    </script>
</x-app-layout>
