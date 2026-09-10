@props([
    'variant' => 'neutral',
    'size' => 'md',
])

@php
$sizeClasses = [
    'sm' => 'px-2 py-0.5 text-xs',
    'md' => 'px-2.5 py-1 text-xs',
    'lg' => 'px-3 py-1 text-sm',
][$size] ?? 'px-2.5 py-1 text-xs';

$variantClasses = [
    'success' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
    'warning' => 'bg-amber-50 text-amber-700 border border-amber-200',
    'danger' => 'bg-rose-50 text-rose-700 border border-rose-200',
    'info' => 'bg-sky-50 text-sky-700 border border-sky-200',
    'brand' => 'bg-brand-50 text-brand-800 border border-brand-200',
    'neutral' => 'bg-slate-100 text-slate-700 border border-slate-200',
][$variant] ?? 'bg-slate-100 text-slate-700 border border-slate-200';
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center font-medium rounded-full {$sizeClasses} {$variantClasses}"]) }}>
    {{ $slot }}
</span>
