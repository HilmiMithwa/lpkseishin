@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-bold text-[#666666]']) }}>
    {{ $value ?? $slot }}
</label>
