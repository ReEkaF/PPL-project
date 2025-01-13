@props(['breadcrumbs'])
<nav class="relative flex" aria-label="Breadcrumb">
    <div class="flex overflow-x-auto whitespace-nowrap no-scrollbar w-full">
        <ol class="inline-flex px-3 space-x-2 text-sm">
            @foreach ($breadcrumbs as $breadcrumb)
                @if ($loop->last)
                <li class="flex items-center min-w-fit">
                    <span class="font-semibold text-gray-800 truncate">{{ $breadcrumb['label'] }}</span>
                </li>
                @else
                <li class="flex items-center min-w-fit">
                    <a href="{{ $breadcrumb['route'] }}" class="text-gray-400 hover:text-gray-700 truncate">
                        {{ $breadcrumb['label'] }}
                    </a>
                    <div class="flex justify-center ml-2">
                        <svg class="flex w-4 h-4 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
                        </svg>
                    </div>
                </li>
                @endif
            @endforeach
        </ol>
    </div>
</nav>

<style>
/* Hide scrollbar for Chrome, Safari and Opera */
.no-scrollbar::-webkit-scrollbar {
    display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
.no-scrollbar {
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
}
</style>
