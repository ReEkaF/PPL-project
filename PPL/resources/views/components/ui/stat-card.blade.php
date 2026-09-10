@props([
    'title',
    'value',
    'icon' => null,
    'description' => null,
    'badge' => null,
    'badgeVariant' => 'success',
])

<div {{ $attributes->merge(['class' => 'bg-white p-5 rounded-xl border border-slate-200/80 shadow-sm relative overflow-hidden']) }}>
    <div class="flex items-start justify-between">
        <div>
            <p class="text-xs font-medium uppercase tracking-wider text-slate-500">{{ $title }}</p>
            <h4 class="text-2xl font-bold text-slate-900 mt-1.5">{{ $value }}</h4>
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
            <div class="w-11 h-11 rounded-lg bg-brand-50 text-brand-700 flex items-center justify-center shrink-0">
                {{ $iconSlot ?? $icon }}
            </div>
        @endif
    </div>
</div>
