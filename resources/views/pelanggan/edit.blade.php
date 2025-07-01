<x-app-layout>
    <div>
        <div class="mx-auto sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-4">
                <h2 class="text-lg font-semibold border py-4 pl-6 pr-8 text-green-800 flex items-center gap-2">
                    Edit Pelanggan: {{ $pelanggan->nama_pemesan }}
                </h2>
            </div>

            {{-- Form Card --}}
            <div class="bg-white border dark:bg-gray-800 sm:rounded-lg p-6">
                <form action="{{ route('pelanggan.update', $pelanggan) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nama Pemesan --}}
                        <div>
                            <label for="nama_pemesan" class="block font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nama Pemesan
                            </label>
                            <input type="text" id="nama_pemesan" name="nama_pemesan"
                                value="{{ old('nama_pemesan', $pelanggan->nama_pemesan) }}" required
                                placeholder="Masukkan nama lengkap"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition">
                        </div>

                        {{-- Alamat --}}
                        <div>
                            <label for="alamat" class="block font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Alamat
                            </label>
                            <input type="text" id="alamat" name="alamat"
                                value="{{ old('alamat', $pelanggan->alamat) }}" required
                                placeholder="Masukkan alamat lengkap"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition">
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Email
                            </label>
                            <input type="email" id="email" name="email"
                                value="{{ old('email', $pelanggan->email) }}" required placeholder="contoh@domain.com"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition">
                        </div>

                        {{-- Nomor WhatsApp --}}
                        <div>
                            <label for="nomor_whatsapp" class="block font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nomor WhatsApp
                            </label>
                            <input type="text" id="nomor_whatsapp" name="nomor_whatsapp"
                                value="{{ old('nomor_whatsapp', $pelanggan->nomor_whatsapp) }}" required
                                placeholder="08xxxxxxxxxx"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition">
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="mt-6 flex justify-end gap-4">
                        <a href="{{ route('pelanggan.index') }}"
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
