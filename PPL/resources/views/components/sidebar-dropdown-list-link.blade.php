@props(['active' => false])

@php
$classes = ($active ?? false)
            ? 'flex items-center p-2.5 text-sm font-medium text-brand-800 bg-brand-50 rounded-lg pl-11 group'
            : 'flex items-center p-2.5 text-sm font-medium text-slate-600 transition-colors rounded-lg pl-11 group hover:bg-slate-100 hover:text-slate-900';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
