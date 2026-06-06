<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-6 py-2.5 rounded-xl border border-[#d62828] text-[#d62828] font-bold text-sm hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500/50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors']) }}>
    {{ $slot }}
</button>
