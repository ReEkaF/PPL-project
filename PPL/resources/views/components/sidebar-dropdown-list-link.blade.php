@props(['active' => false])

@php
$classes = ($active ?? false)
            ? 'flex items-center p-2 text-base text-gray-900 rounded-lg pl-11 group bg-gray-100'
            : 'flex items-center p-2 text-base text-gray-700 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} class="">{{ $slot }}</a>
