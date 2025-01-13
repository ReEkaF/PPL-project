@props(['id', 'active' => false])

@php
    $classes = $active ?? false ? 'py-2 space-y-2' : ' hidden';
@endphp

<ul {{ $attributes->merge(['class' => $classes, 'id' => $id]) }}>
    {{ $slot }}
</ul>
