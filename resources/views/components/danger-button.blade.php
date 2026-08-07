<button {{ $attributes->merge(['type' => 'submit', 'class' => 'editorial-button editorial-button-danger inline-flex items-center px-4 py-2 font-semibold text-xs uppercase tracking-widest']) }}>
    {{ $slot }}
</button>
