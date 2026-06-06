@props(['type' => 'default'])

@php
    $classes = [
        'success' => 'bg-emerald-100 text-emerald-800 border border-emerald-200',
        'warning' => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
        'danger' => 'bg-red-100 text-red-800 border border-red-200',
        'info' => 'bg-blue-100 text-blue-800 border border-blue-200',
        'default' => 'bg-gray-100 text-gray-800 border border-gray-200',
    ][$type] ?? 'bg-gray-100 text-gray-800 border border-gray-200';
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center justify-center px-3 py-1 rounded-full text-[10px] sm:text-[11px] font-bold tracking-wider uppercase shadow-sm $classes"]) }}>
    {{ $slot }}
</span>
