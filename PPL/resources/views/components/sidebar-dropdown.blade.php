@props(['label', 'id', 'active' => false])

<button type="button"
    class="flex items-center w-full p-2.5 text-sm font-medium transition-colors rounded-lg group hover:bg-slate-100 button-dropdown {{ $active ? 'text-brand-800 bg-brand-50' : 'text-slate-600 hover:text-slate-900' }}"
    aria-controls="{{ $id }}"
    data-collapse-toggle="{{ $id }}">
    {{ $slot }}

    <span class="flex-1 ml-3 text-left whitespace-nowrap text-sm" sidebar-toggle-item>{{ $label }}</span>

    <svg class="w-4 h-4 shrink-0 transition-transform dropdown-chevron {{ $active ? 'rotate-180' : '' }}"
        fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
    </svg>
</button>
