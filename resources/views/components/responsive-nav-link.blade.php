@props(['active'])

@php
$classes = ($active ?? false)
            ? 'editorial-responsive-link is-active block w-full ps-3 pe-4 py-2 text-start text-base font-medium'
            : 'editorial-responsive-link block w-full ps-3 pe-4 py-2 text-start text-base font-medium';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
