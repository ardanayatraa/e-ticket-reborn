@php
    use Carbon\Carbon;
    // tanggal hari ini
    $today = Carbon::today()->toDateString();

    // cek apakah ada Tiket hari ini untuk sopir ini
    $existsToday = \App\Models\Ketersediaan::where('sopir_id', $rowId)
        ->whereDate('tanggal_keberangkatan', $today)
        ->exists();
@endphp

<div class="flex space-x-2">
    {{-- Edit --}}
    <a href="{{ route('sopir.edit', $rowId) }}"
        class="px-2 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm">
        Edit
    </a>

    {{-- Hapus --}}
    <button type="button" onclick="openDeleteModal('{{ $rowId }}')"
        class="px-2 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm">
        Hapus
    </button>

    {{-- Download Tiket Hari Ini --}}
    @if ($existsToday)
        <button type="button" wire:click="downloadTicket({{ $rowId }}, '{{ $today }}')"
            class="px-2 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-sm">
            Download Tiket {{ Carbon::parse($today)->format('d M Y') }}
        </button>
    @else
        <button disabled class="px-2 py-1 bg-gray-400 text-white rounded text-sm cursor-not-allowed">
            Tidak Ada Tiket Hari Ini
        </button>
    @endif
</div>

{{-- Modal Hapus --}}
<div id="delete-modal-{{ $rowId }}"
    class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-40 z-50"
    onclick="closeDeleteModal('{{ $rowId }}')">
    <div class="bg-white rounded p-6 shadow-lg transform scale-75 opacity-0 transition"
        onclick="event.stopPropagation()">
        <h3 class="font-semibold mb-4">Konfirmasi Hapus</h3>
        <div class="flex justify-end space-x-2">
            <button onclick="closeDeleteModal('{{ $rowId }}')"
                class="px-4 py-2 bg-gray-200 rounded">Batal</button>
            <form action="{{ route('sopir.destroy', $rowId) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Delete modal
    function openDeleteModal(id) {
        const m = document.getElementById('delete-modal-' + id),
            d = m.children[0];
        m.classList.remove('hidden');
        setTimeout(() => {
            d.classList.replace('scale-75', 'scale-100');
            d.classList.replace('opacity-0', 'opacity-100');
        }, 10);
    }

    function closeDeleteModal(id) {
        const m = document.getElementById('delete-modal-' + id),
            d = m.children[0];
        d.classList.replace('scale-100', 'scale-75');
        d.classList.replace('opacity-100', 'opacity-0');
        d.addEventListener('transitionend', () => m.classList.add('hidden'), {
            once: true
        });
    }
</script>
