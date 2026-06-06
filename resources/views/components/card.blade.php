@props(['padding' => 'default', 'rounded' => 'default'])

@php
    $paddingClass = [
        'none' => '',
        'small' => 'p-4 sm:p-5',
        'default' => 'p-5 sm:p-6 lg:p-8',
        'large' => 'p-8 lg:p-10',
    ][$padding] ?? 'p-5 sm:p-6 lg:p-8';

    $roundedClass = [
        'default' => 'rounded-2xl lg:rounded-3xl',
        'large' => 'rounded-[24px] lg:rounded-[32px]',
        'small' => 'rounded-xl',
    ][$rounded] ?? 'rounded-2xl lg:rounded-3xl';
@endphp

<div {{ $attributes->merge(['class' => "bg-white border border-gray-100 shadow-sm $roundedClass $paddingClass"]) }}>
    {{ $slot }}
</div>
