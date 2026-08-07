<button {{ $attributes->merge(['type' => 'button', 'class' => 'editorial-button editorial-button-secondary inline-flex items-center px-4 py-2 font-semibold text-xs uppercase tracking-widest']) }}>
    {{ $slot }}
</button>
