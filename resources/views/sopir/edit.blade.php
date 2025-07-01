{{-- resources/views/sopir/edit.blade.php --}}
<x-app-layout>
    <div class="py-8">
        <div class="mx-auto sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-4">
                <h2
                    class="text-lg font-semibold border-b-2 border-green-300 py-4 pl-6 text-green-800 flex items-center gap-2">
                    Edit Sopir: {{ $sopir->nama_sopir }}
                </h2>
            </div>

            {{-- Card Form --}}
            <div class="bg-white border dark:bg-gray-800 sm:rounded-lg p-6 shadow">
                <form action="{{ route('sopir.update', $sopir) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- 1. Text fields --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nama_sopir" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Nama Sopir <span class="text-red-500">*</span>
                            </label>
                            <input id="nama_sopir" name="nama_sopir" type="text"
                                value="{{ old('nama_sopir', $sopir->nama_sopir) }}" required
                                placeholder="Masukkan nama lengkap"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                         focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition" />
                        </div>
                        <div>
                            <label for="nomor_ktp" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Nomor KTP <span class="text-red-500">*</span>
                            </label>
                            <input id="nomor_ktp" name="nomor_ktp" type="text"
                                value="{{ old('nomor_ktp', $sopir->nomor_ktp) }}" required
                                placeholder="Masukkan nomor KTP"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                         focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition" />
                        </div>
                        <div>
                            <label for="sim" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                SIM (opsional)
                            </label>
                            <input id="sim" name="sim" type="text" value="{{ old('sim', $sopir->sim) }}"
                                placeholder="Masukkan nomor SIM"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                         focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition" />
                        </div>
                        <div>
                            <label for="umur" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Umur (opsional)
                            </label>
                            <input id="umur" name="umur" type="number" value="{{ old('umur', $sopir->umur) }}"
                                placeholder="Masukkan umur"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                         focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition" />
                        </div>
                        <div class="md:col-span-2">
                            <label for="alamat" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Alamat (opsional)
                            </label>
                            <textarea id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                         focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition">{{ old('alamat', $sopir->alamat) }}</textarea>
                        </div>
                    </div>

                    {{-- 2. Foto + Preview only side-by-side --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                        {{-- Foto Input --}}
                        <div>
                            <label for="foto-edit" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Ganti Foto (opsional)
                            </label>
                            <input id="foto-edit" name="foto" type="file" accept="image/*"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                         focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition" />
                        </div>
                        {{-- Preview --}}
                        <div>
                            <p class="mb-1 font-medium text-gray-700 dark:text-gray-300">Preview</p>
                            <img id="preview-foto-edit" src="{{ $sopir->foto ? Storage::url($sopir->foto) : '#' }}"
                                alt="Preview Foto"
                                class="{{ $sopir->foto ? '' : 'hidden' }} w-full h-auto max-w-xs object-cover rounded-md border" />
                        </div>
                    </div>

                    {{-- 3. Buttons --}}
                    <div class="flex justify-end gap-4">
                        <a href="{{ route('sopir.index') }}"
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
        document.getElementById('foto-edit').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const img = document.getElementById('preview-foto-edit');
            if (!file) {
                img.src = '#';
                img.classList.add('hidden');
                return;
            }
            const reader = new FileReader();
            reader.onload = function(ev) {
                img.src = ev.target.result;
                img.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        });
    </script>
</x-app-layout>
