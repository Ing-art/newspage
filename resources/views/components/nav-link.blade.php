@props(['active'])

@php
$classes = ($active ?? false)
            ? 'editorial-nav-link is-active inline-flex items-center px-1 pt-1 text-sm font-medium leading-5'
            : 'editorial-nav-link inline-flex items-center px-1 pt-1 text-sm font-medium leading-5';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
