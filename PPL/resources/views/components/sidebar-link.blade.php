@props(['active' => false])

@php
$classes = ($active ?? false)
            ? 'flex items-center p-2 text-base text-gray-900 rounded-lg group dark:text-gray-200 bg-gray-100 dark:bg-gray-700'
            : 'flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:text-gray-200 dark:hover:bg-gray-700';
@endphp

<a  {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
