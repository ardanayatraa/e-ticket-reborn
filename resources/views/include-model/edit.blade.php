<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    {{-- Pemesanan --}}
    <div class="col-span-2">
        <label for="pemesanan_id" class="block font-medium text-gray-700 dark:text-gray-300 mb-2">
            Pemesanan
        </label>
        <select id="pemesanan_id" name="pemesanan_id" disabled
            class="block w-full bg-gray-100 border border-gray-300 rounded-lg p-2">
            <option>
                #{{ $includeModel->pemesanan_id }} -
                {{ $includeModel->pemesanan->paketWisata->judul }} -
                {{ $includeModel->pemesanan->pelanggan->nama_pemesan }}
            </option>
        </select>
    </div>

    @php
        $fields = [
            'bensin' => 'Bensin',
            'parkir' => 'Parkir',
            'sopir' => 'Sopir',
            'makan_siang' => 'Makan Siang',
            'makan_malam' => 'Makan Malam',
            'tiket_masuk' => 'Tiket Masuk',
        ];
    @endphp

    @foreach ($fields as $field => $label)
        <div class="flex items-center space-x-2">
            <input id="{{ $field }}" name="{{ $field }}" type="checkbox"
                class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded"
                {{ old($field, $includeModel->$field) ? 'checked' : '' }}>
            <label for="{{ $field }}" class="block font-medium text-gray-700 dark:text-gray-300">
                {{ $label }}
            </label>
        </div>
    @endforeach
</div>
