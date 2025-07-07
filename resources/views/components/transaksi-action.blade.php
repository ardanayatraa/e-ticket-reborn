<div class="flex space-x-2">
    @isset($editUrl)
        <a href="{{ $editUrl }}"
            class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-medium transition">
            Edit
        </a>
    @endisset

    @isset($confirmUrl)
        <button type="button" onclick="openUpdateModal({{ $rowId }})"
            class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded-md text-sm font-medium transition">
            Update Transaksi
        </button>
    @endisset

    @isset($deleteUrl)
        <button type="button" onclick="openDeleteModal({{ $rowId }})"
            class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded-md text-sm font-medium transition">
            Hapus
        </button>
    @endisset
</div>

@if (isset($confirmUrl))
    {{-- Update Transaksi Modal --}}
    <div id="update-modal-{{ $rowId }}" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl">
                <form action="{{ $confirmUrl }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Header --}}
                    <div class="bg-green-600 px-6 py-4 rounded-t-lg">
                        <div class="flex items-center justify-between">
                            <h3 class="text-white text-xl font-semibold">Update Transaksi #{{ $rowId }}</h3>
                            <button type="button" onclick="closeUpdateModal({{ $rowId }})"
                                class="text-white hover:text-gray-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="p-6 space-y-4">
                        {{-- Info Paket --}}
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-gray-800 mb-2">Informasi Paket</h4>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600">Harga Paket:</span>
                                    <span class="font-medium">Rp
                                        {{ number_format($hargaPaket ?? 0, 0, ',', '.') }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Current Data:</span>
                                    <span class="font-medium">
                                        Deposit: {{ $deposit ?? 'NULL' }} |
                                        Owe: {{ $oweToMe ?? 'NULL' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- Jenis Pembayaran --}}
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-medium mb-1">Jenis Pembayaran</label>
                                <select name="jenis_pembayaran" required
                                    class="w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="midtrans" selected>Midtrans</option>
                                    <option value="cash">Cash</option>
                                    <option value="debit">Debit</option>
                                </select>
                            </div>

                            {{-- Deposit --}}
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Deposit</label>
                                <input type="number" name="deposit" step="1" required
                                    value="{{ is_null($deposit) ? '' : $deposit }}"
                                    class="w-full border-gray-300 rounded-md shadow-sm"
                                    onchange="calculateOwe({{ $rowId }})">
                            </div>

                            {{-- Additional Charge --}}
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Additional Charge</label>
                                <input type="number" name="additional_charge" step="1"
                                    value="{{ $additionalCharge ?? 0 }}"
                                    class="w-full border-gray-300 rounded-md shadow-sm"
                                    onchange="calculateOwe({{ $rowId }})">
                            </div>

                            {{-- Pay To Provider --}}
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Pay To Provider</label>
                                <input type="number" name="pay_to_provider" step="1"
                                    value="{{ is_null($payToProvider) ? '' : $payToProvider }}"
                                    class="w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            {{-- Owe To Me (Calculated) --}}
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Owe To Me (Auto)</label>
                                <input type="number" name="owe_to_me" step="1" readonly
                                    value="{{ is_null($oweToMe) ? '' : $oweToMe }}"
                                    class="w-full border-gray-300 rounded-md shadow-sm bg-gray-50"
                                    id="owe-to-me-{{ $rowId }}">
                            </div>
                        </div>

                        {{-- Include Facilities --}}
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="font-medium text-gray-700 mb-3">Include (Centang yang termasuk paket)</h4>
                            <div class="grid grid-cols-2 gap-2">
                                @php
                                    $facilities = [
                                        'bensin' => 'Bensin',
                                        'parkir' => 'Parkir',
                                        'sopir' => 'Sopir',
                                        'makan_siang' => 'Makan Siang',
                                        'makan_malam' => 'Makan Malam',
                                        'tiket_masuk' => 'Tiket Masuk',
                                    ];
                                @endphp

                                @foreach ($facilities as $field => $label)
                                    @php
                                        $checked = false;
                                        // Priority: 1. include_data from transaction, 2. paket include data
                                        if (isset($includeData[$field])) {
                                            $checked = (bool) $includeData[$field];
                                        } elseif (isset($paketWisata->include->$field)) {
                                            $checked = (bool) $paketWisata->include->$field;
                                        }
                                    @endphp

                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="include[{{ $field }}]" value="1"
                                            {{ $checked ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                                        <span class="text-gray-800">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Note --}}
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Note</label>
                            <textarea name="note" rows="3" class="w-full border-gray-300 rounded-md shadow-sm"
                                placeholder="Catatan tambahan...">{{ $note ?? '' }}</textarea>
                        </div>

                        {{-- Hidden Data --}}
                        <input type="hidden" id="harga-paket-{{ $rowId }}" value="{{ $hargaPaket ?? 0 }}">
                    </div>

                    {{-- Footer --}}
                    <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3 rounded-b-lg">
                        <button type="button" onclick="closeUpdateModal({{ $rowId }})"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                            Update Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

@if (isset($deleteUrl))
    {{-- Delete Modal --}}
    <div id="delete-modal-{{ $rowId }}" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Hapus Transaksi</h3>
                <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus transaksi ini?</p>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeDeleteModal({{ $rowId }})"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition">
                        Batal
                    </button>
                    <form action="{{ $deleteUrl }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

<script>
    // Simple modal functions
    function openUpdateModal(rowId) {
        document.getElementById('update-modal-' + rowId).classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeUpdateModal(rowId) {
        document.getElementById('update-modal-' + rowId).classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function openDeleteModal(rowId) {
        document.getElementById('delete-modal-' + rowId).classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal(rowId) {
        document.getElementById('delete-modal-' + rowId).classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Calculate Owe To Me only when called
    function calculateOwe(rowId) {
        const hargaPaket = parseInt(document.getElementById('harga-paket-' + rowId).value) || 0;
        const deposit = parseInt(document.querySelector('#update-modal-' + rowId + ' input[name="deposit"]').value) ||
        0;
        const additional = parseInt(document.querySelector('#update-modal-' + rowId +
            ' input[name="additional_charge"]').value) || 0;

        const total = hargaPaket + additional;
        const owe = Math.max(total - deposit, 0);

        document.getElementById('owe-to-me-' + rowId).value = owe;
    }

    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('fixed')) {
            const modal = e.target;
            if (modal.id.includes('update-modal-')) {
                const rowId = modal.id.replace('update-modal-', '');
                closeUpdateModal(rowId);
            } else if (modal.id.includes('delete-modal-')) {
                const rowId = modal.id.replace('delete-modal-', '');
                closeDeleteModal(rowId);
            }
        }
    });
</script>
