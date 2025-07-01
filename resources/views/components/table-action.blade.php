{{-- resources/views/components/table-action.blade.php --}}
<div class="flex space-x-2">
    @isset($editUrl)
        <a href="{{ $editUrl }}" class="px-2 py-1 bg-blue-600 hover:bg-blue-700 text-white  rounded text-sm transition">
            Edit
        </a>
    @endisset

    @isset($deleteUrl)
        <button type="button" onclick="openModal('delete-modal-{{ $rowId }}')"
            class="px-2 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm transition">
            Hapus
        </button>
    @endisset
    @isset($downloadId)
        <button type="button" wire:click="downloadTicket({{ $downloadId }})"
            class="px-2 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-sm transition">
            Download
        </button>
    @endisset
</div>

{{-- Modal Overlay (klik backdrop untuk tutup) --}}
<div id="delete-modal-{{ $rowId }}"
    class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-40 backdrop-blur-sm"
    onclick="closeModal('delete-modal-{{ $rowId }}')">
    <div class="modal-dialog relative bg-white rounded-2xl shadow-2xl p-6 w-11/12 max-w-md
                transform scale-75 opacity-0 transition-transform transition-opacity duration-300 ease-out"
        onclick="event.stopPropagation()">
        {{-- Tombol close di pojok --}}
        <button type="button" onclick="closeModal('delete-modal-{{ $rowId }}')"
            class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl leading-none">
            &times;
        </button>

        <h3 class="text-2xl font-semibold mb-2 text-gray-800">Konfirmasi Hapus</h3>
        <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus data ini?</p>

        <div class="flex justify-end space-x-3">
            <button type="button" onclick="closeModal('delete-modal-{{ $rowId }}')"
                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition">
                Batal
            </button>

            <form action="{{ $deleteUrl }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>

{{-- JS untuk animasi buka/tutup --}}
<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        const dialog = modal.querySelector('.modal-dialog');
        modal.classList.remove('hidden');
        setTimeout(() => {
            dialog.classList.remove('scale-75', 'opacity-0');
            dialog.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        const dialog = modal.querySelector('.modal-dialog');
        dialog.classList.remove('scale-100', 'opacity-100');
        dialog.classList.add('scale-75', 'opacity-0');
        dialog.addEventListener('transitionend', () => {
            modal.classList.add('hidden');
        }, {
            once: true
        });
    }
</script>
