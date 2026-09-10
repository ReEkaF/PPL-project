@props([
    'title' => null,
    'subtitle' => null,
    'headerAction' => null,
    'footer' => null,
    'noPadding' => false,
])

<div {{ $attributes->merge(['class' => 'bg-white rounded-xl border border-slate-200/80 shadow-sm overflow-hidden']) }}>
    @if($title || $headerAction || isset($header))
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between gap-4">
            @if(isset($header))
                {{ $header }}
            @else
                <div>
                    @if($title)
                        <h3 class="text-base font-semibold text-slate-900">{{ $title }}</h3>
                    @endif
                    @if($subtitle)
                        <p class="text-xs text-slate-500 mt-0.5">{{ $subtitle }}</p>
                    @endif
                </div>
                @if($headerAction)
                    <div class="flex items-center gap-2">
                        {{ $headerAction }}
                    </div>
                @endif
            @endif
        </div>
    @endif

    <div class="{{ $noPadding ? '' : 'p-5' }}">
        {{ $slot }}
    </div>

    @if($footer || isset($footerSlot))
        <div class="px-5 py-3 bg-slate-50/70 border-t border-slate-100">
            {{ $footer ?? $footerSlot }}
        </div>
    @endif
</div>
