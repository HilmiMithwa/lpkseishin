@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-bold text-[#222222] focus:outline-none focus:border-[#d62828] focus:ring-1 focus:ring-[#d62828] transition disabled:bg-gray-50 disabled:text-gray-500 disabled:border-gray-100 disabled:shadow-none shadow-sm']) }}>
