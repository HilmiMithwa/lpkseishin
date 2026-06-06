@props(['links'])

<nav class="flex flex-wrap items-center gap-1.5 text-xs sm:text-sm font-karla text-left">
    @foreach ($links as $label => $url)
        @if (!$loop->last)
            <a href="{{ $url }}" class="text-gray-500 hover:text-gray-700 font-medium transition">{{ $label }}</a>
            <svg class="w-3 h-3 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        @else
            <span class="text-[#d62828] font-semibold">{{ $label }}</span>
        @endif
    @endforeach
</nav>
