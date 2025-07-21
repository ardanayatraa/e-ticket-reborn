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
                    class="space-y-6" id="paket-form">
                    @csrf

                    {{-- Flash Messages --}}
                    @if (session('success'))
                        <div class="p-4 bg-green-50 border border-green-200 rounded-lg text-green-800">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="p-4 bg-red-50 border border-red-200 rounded-lg text-red-800">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="p-4 bg-red-50 border border-red-200 rounded-lg text-red-800">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium">Terdapat kesalahan pada form:</h3>
                                    <ul class="list-disc list-inside text-sm mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
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
                                    Judul <span class="text-red-500">*</span>
                                </label>
                                <input id="judul" name="judul" type="text" value="{{ old('judul') }}"
                                    placeholder="Masukkan judul paket" required maxlength="255"
                                    class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                           focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition
                                           @error('judul') border-red-500 @enderror" />
                                @error('judul')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tempat --}}
                            <div>
                                <label for="tempat" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Tempat
                                </label>
                                <input id="tempat" name="tempat" type="text" value="{{ old('tempat') }}"
                                    placeholder="Masukkan lokasi wisata" maxlength="255"
                                    class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                           focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition
                                           @error('tempat') border-red-500 @enderror" />
                                @error('tempat')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Durasi --}}
                            <div>
                                <label for="durasi" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Durasi (hari) <span class="text-red-500">*</span>
                                </label>
                                <input id="durasi" name="durasi" type="number" value="{{ old('durasi') }}"
                                    min="1" max="365" placeholder="Contoh: 3" required
                                    class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                           focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition
                                           @error('durasi') border-red-500 @enderror" />
                                @error('durasi')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Harga --}}
                            <div>
                                <label for="harga" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Harga (Rp) <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                        Rp
                                    </span>
                                    <input id="harga" name="harga" type="number" value="{{ old('harga') }}"
                                        min="0" step="1000" placeholder="0" required
                                        class="block w-full pl-10 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                               focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition
                                               @error('harga') border-red-500 @enderror" />
                                </div>
                                @error('harga')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Deskripsi --}}
                            <div class="md:col-span-2">
                                <label for="deskripsi" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Deskripsi <span class="text-red-500">*</span>
                                </label>
                                <textarea id="deskripsi" name="deskripsi" rows="4" placeholder="Masukkan deskripsi paket" required
                                    class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 
                                           focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition
                                           @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
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

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
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
                                        class="flex items-center p-3 border-2 rounded-lg cursor-pointer transition-all
                                               hover:border-gray-400 dark:hover:border-gray-600
                                               border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800
                                               has-[:checked]:border-green-500 has-[:checked]:bg-green-50 dark:has-[:checked]:bg-green-900/20">

                                        <input type="checkbox" id="include_{{ $field }}"
                                            name="include[{{ $field }}]" value="1"
                                            {{ old("include.$field") ? 'checked' : '' }}
                                            class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500 mr-3">

                                        <span class="text-xl mr-2">{{ $data['icon'] }}</span>
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
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition
                                           @error('foto') border-red-500 @enderror">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                            fill="none" viewBox="0 0 48 48">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600 justify-center">
                                            <label for="foto"
                                                class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                                <span>Upload foto</span>
                                                <input id="foto" name="foto" type="file" accept="image/jpeg,image/png,image/jpg,image/gif"
                                                    class="sr-only">
                                            </label>
                                            <p class="pl-1">atau drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF max 2MB</p>
                                    </div>
                                </div>
                                @error('foto')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <img id="preview" src="#" alt="Preview Foto Paket"
                                    class="mt-4 w-full h-48 object-cover rounded-lg hidden border" />
                            </div>

                            {{-- Gallery --}}
                            <div>
                                <label for="gallery" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Gallery Foto (Multiple)
                                </label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition
                                           @error('gallery.*') border-red-500 @enderror">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                            fill="none" viewBox="0 0 48 48">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600 justify-center">
                                            <label for="gallery"
                                                class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                                <span>Upload gallery</span>
                                                <input id="gallery" name="gallery[]" type="file"
                                                    accept="image/jpeg,image/png,image/jpg,image/gif" multiple class="sr-only">
                                            </label>
                                            <p class="pl-1">atau drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">Multiple files, max 2MB each</p>
                                    </div>
                                </div>
                                @error('gallery.*')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <div id="gallery-preview" class="mt-4 grid grid-cols-3 gap-2"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-end gap-4 pt-6 border-t">
                        <a href="{{ route('paket-wisata.index') }}"
                            class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition duration-200 ease-in-out">
                            Batal
                        </a>
                        <button type="submit" id="submit-btn"
                            class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition duration-200 ease-in-out shadow
                                   disabled:opacity-50 disabled:cursor-not-allowed">
                            <span id="submit-text">Simpan Paket Wisata</span>
                            <span id="submit-loading" class="hidden">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Menyimpan...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Enhanced Preview Scripts --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // File size validation
            const maxFileSize = 2 * 1024 * 1024; // 2MB in bytes
            
            function validateFileSize(file, fieldName) {
                if (file.size > maxFileSize) {
                    alert(`File ${file.name} terlalu besar. Maksimal ukuran file adalah 2MB.`);
                    return false;
                }
                return true;
            }

            function validateFileType(file, fieldName) {
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                if (!allowedTypes.includes(file.type)) {
                    alert(`File ${file.name} tidak valid. Hanya file JPG, PNG, dan GIF yang diperbolehkan.`);
                    return false;
                }
                return true;
            }

            // Preview foto utama
            document.getElementById('foto').addEventListener('change', function(e) {
                const file = this.files[0];
                const preview = document.getElementById('preview');
                
                if (!file) {
                    preview.classList.add('hidden');
                    return;
                }

                if (!validateFileType(file, 'foto') || !validateFileSize(file, 'foto')) {
                    this.value = '';
                    preview.classList.add('hidden');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            });

            // Preview gallery dengan validasi
            document.getElementById('gallery').addEventListener('change', function(e) {
                const files = Array.from(this.files);
                const previewContainer = document.getElementById('gallery-preview');
                previewContainer.innerHTML = '';

                let validFiles = [];

                files.forEach((file, index) => {
                    if (validateFileType(file, 'gallery') && validateFileSize(file, 'gallery')) {
                        validFiles.push(file);
                        
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const div = document.createElement('div');
                            div.className = 'relative group';
                            div.innerHTML = `
                                <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg border shadow-sm">
                                <button type="button" onclick="removeGalleryImage(this, ${index})"
                                    class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center 
                                           hover:bg-red-600 transition-colors opacity-0 group-hover:opacity-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                                <div class="absolute bottom-1 left-1 bg-black bg-opacity-50 text-white text-xs px-1 rounded">
                                    ${file.name.length > 15 ? file.name.substring(0, 15) + '...' : file.name}
                                </div>
                            `;
                            previewContainer.appendChild(div);
                        };
                        reader.readAsDataURL(file);
                    }
                });

                // Update file input dengan file yang valid saja
                if (validFiles.length !== files.length) {
                    const dt = new DataTransfer();
                    validFiles.forEach(file => dt.items.add(file));
                    this.files = dt.files;
                }
            });

            // Form submission dengan loading state
            document.getElementById('paket-form').addEventListener('submit', function(e) {
                const submitBtn = document.getElementById('submit-btn');
                const submitText = document.getElementById('submit-text');
                const submitLoading = document.getElementById('submit-loading');
                
                // Disable button dan show loading
                submitBtn.disabled = true;
                submitText.classList.add('hidden');
                submitLoading.classList.remove('hidden');
                
                // Validasi form sebelum submit
                const requiredFields = ['judul', 'deskripsi', 'harga', 'durasi'];
                let isValid = true;
                
                requiredFields.forEach(field => {
                    const input = document.getElementById(field);
                    if (!input.value.trim()) {
                        isValid = false;
                        input.classList.add('border-red-500');
                    } else {
                        input.classList.remove('border-red-500');
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    submitBtn.disabled = false;
                    submitText.classList.remove('hidden');
                    submitLoading.classList.add('hidden');
                    alert('Mohon lengkapi semua field yang wajib diisi.');
                }
            });

            // Format harga dengan thousand separator
            document.getElementById('harga').addEventListener('input', function(e) {
                let value = this.value.replace(/\D/g, '');
                if (value) {
                    // Format with thousand separator for display
                    this.dataset.rawValue = value;
                }
            });

            // Auto-resize textarea
            document.getElementById('deskripsi').addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = Math.min(this.scrollHeight, 200) + 'px';
            });
        });

        // Global function untuk remove gallery image
        function removeGalleryImage(button, index) {
            const container = button.closest('.relative');
            container.remove();
            
            // Update file input
            const galleryInput = document.getElementById('gallery');
            const dt = new DataTransfer();
            const files = Array.from(galleryInput.files);
            
            files.forEach((file, i) => {
                if (i !== index) {
                    dt.items.add(file);
                }
            });
            
            galleryInput.files = dt.files;
        }

        // Drag and drop functionality
        ['foto', 'gallery'].forEach(inputId => {
            const input = document.getElementById(inputId);
            const dropZone = input.closest('.border-dashed');
            
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, highlight, false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, unhighlight, false);
            });
            
            function highlight() {
                dropZone.classList.add('border-green-500', 'bg-green-50');
            }
            
            function unhighlight() {
                dropZone.classList.remove('border-green-500', 'bg-green-50');
            }
            
            dropZone.addEventListener('drop', handleDrop, false);
            
            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                input.files = files;
                input.dispatchEvent(new Event('change'));
            }
        });
    </script>
</x-app-layout>