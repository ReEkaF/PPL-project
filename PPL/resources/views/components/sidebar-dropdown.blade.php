@props(['label', 'id', 'active' => false])

<button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 button-dropdown {{ $active ? 'bg-gray-100 dark:bg-gray-700' : '' }}" aria-controls="{{ $id }}" data-collapse-toggle="{{ $id }}">
    {{ $slot }}

    <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>{{ $label }}</span>

    <div class="dropdown-chevron">
    @if ($active)
        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m16 14-4-4-4 4"/>
        </svg>
    @else
        <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd"></path>
        </svg>
    @endif
    </div>
</button>
