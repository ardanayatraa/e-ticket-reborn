<select wire:change="updateStatus({{ $rowId }}, '{{ $field }}', $event.target.value)"
    class="mt-1 block w-full max-w-xs border-gray-300 rounded-md shadow-sm text-sm">
    <option value="unpaid" {{ $current === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
    <option value="paid" {{ $current === 'paid' ? 'selected' : '' }}>Paid</option>
</select>
