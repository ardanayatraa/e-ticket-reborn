@if($isMember)
    <div class="flex items-center space-x-2">
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
            <i class="fas fa-crown mr-1"></i>MEMBER
        </span>
        <span class="text-sm text-gray-600">
            <i class="fas fa-star mr-1 text-yellow-500"></i>{{ $points }} poin
        </span>
        @if($memberSince)
            <span class="text-xs text-gray-500">
                sejak {{ \Carbon\Carbon::parse($memberSince)->format('d/m/Y') }}
            </span>
        @endif
    </div>
@else
    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
        <i class="fas fa-user mr-1"></i>REGULAR
    </span>
@endif 