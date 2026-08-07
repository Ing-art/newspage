@props(['value'])

<label {{ $attributes->merge(['class' => 'editorial-label block font-medium text-sm']) }}>
    {{ $value ?? $slot }}
</label>
