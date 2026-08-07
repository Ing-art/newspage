@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'editorial-input-error text-sm space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
