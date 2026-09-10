@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
])

@php
$baseClasses = 'inline-flex items-center justify-center font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none cursor-pointer';

$sizeClasses = [
    'sm' => 'px-3 py-1.5 text-xs gap-1.5',
    'md' => 'px-4 py-2 text-sm gap-2',
    'lg' => 'px-5 py-2.5 text-base gap-2.5',
][$size] ?? 'px-4 py-2 text-sm gap-2';

$variantClasses = [
    'primary' => 'bg-brand-800 hover:bg-brand-900 text-white focus:ring-brand-700 shadow-sm',
    'secondary' => 'bg-white hover:bg-slate-100 text-slate-700 border border-slate-300 focus:ring-slate-400 shadow-sm',
    'accent' => 'bg-accent-600 hover:bg-accent-700 text-white focus:ring-accent-500 shadow-sm',
    'danger' => 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500 shadow-sm',
    'outline' => 'border border-brand-700 text-brand-800 hover:bg-brand-50 focus:ring-brand-600',
    'ghost' => 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 focus:ring-slate-300',
][$variant] ?? 'bg-brand-800 hover:bg-brand-900 text-white focus:ring-brand-700 shadow-sm';

$classes = "{$baseClasses} {$sizeClasses} {$variantClasses}";
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
