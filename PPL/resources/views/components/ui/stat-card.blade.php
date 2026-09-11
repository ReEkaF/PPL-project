@props([
    'title',
    'value',
    'icon' => null,
    'description' => null,
    'badge' => null,
    'badgeVariant' => 'success',
])

<div {{ $attributes->merge(['class' => 'bg-white p-5 rounded-xl border border-slate-200 relative overflow-hidden transition-colors']) }}>
    <div class="flex items-start justify-between gap-3">
        <div>
            <p class="text-xs font-medium text-slate-500">{{ $title }}</p>
            <h4 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1 tabular-nums tracking-tight">{{ $value }}</h4>
            @if($description || $badge)
                <div class="flex items-center gap-2 mt-2">
                    @if($badge)
                        <x-ui.badge :variant="$badgeVariant" size="sm">{{ $badge }}</x-ui.badge>
                    @endif
                    @if($description)
                        <span class="text-xs text-slate-500">{{ $description }}</span>
                    @endif
                </div>
            @endif
        </div>
        @if($icon || isset($iconSlot))
            <div class="w-10 h-10 rounded-lg bg-brand-50 text-brand-800 flex items-center justify-center shrink-0">
                {{ $iconSlot ?? $icon }}
            </div>
        @endif
    </div>
</div>
