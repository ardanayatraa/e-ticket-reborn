{{-- resources/views/admin/edit.blade.php --}}
<x-app-layout>
    <div>
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <h2 class="text-lg font-semibold border py-4 pl-6 pr-8 text-green-800 flex items-center gap-2">
                    Edit Admin: {{ $admin->nama_admin }}
                </h2>
            </div>
            <div class="bg-white dark:bg-gray-800 border sm:rounded-lg p-6">
                <form action="{{ route('admin.update', $admin) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-wrap -mx-3">
                        {{-- Nama Admin --}}
                        <div class="w-full md:w-1/2 px-3 mb-4">
                            <label for="nama_admin"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Nama Admin
                            </label>
                            <input type="text" id="nama_admin" name="nama_admin"
                                value="{{ old('nama_admin', $admin->nama_admin) }}" required
                                placeholder="Masukkan nama lengkap"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition" />
                            @error('nama_admin')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="w-full md:w-1/2 px-3 mb-4">
                            <label for="email"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Email
                            </label>
                            <input type="email" id="email" name="email"
                                value="{{ old('email', $admin->email) }}" required placeholder="contoh@domain.com"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition" />
                            @error('email')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tipe User --}}
                        <div class="w-full md:w-1/2 px-3 mb-4">
                            <label for="type"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Tipe User
                            </label>
                            <select id="type" name="type"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition">
                                <option value="admin" {{ old('type', $admin->type) === 'admin' ? 'selected' : '' }}>
                                    Admin
                                </option>
                                <option value="owner" {{ old('type', $admin->type) === 'owner' ? 'selected' : '' }}>
                                    Owner
                                </option>
                            </select>
                            @error('type')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="w-full md:w-1/2 px-3 mb-4">
                            <label for="password"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Password
                                <span class="text-sm text-gray-500">(kosongkan jika tidak diubah)</span>
                            </label>
                            <input type="password" id="password" name="password" placeholder="Minimal 6 karakter"
                                class="block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg p-2 transition" />
                            @error('password')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end mt-6 space-x-3">
                        <a href="{{ route('admin.index') }}"
                            class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
