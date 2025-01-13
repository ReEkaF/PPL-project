@if ($paginator instanceof Illuminate\Pagination\LengthAwarePaginator && $paginator->hasPages())
    <style>
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 400;
            src: url('../fonts/poppins-v15-latin-regular.eot');
            /* IE9 Compat Modes */
            src: local(''),
                url('../fonts/poppins-v15-latin-regular.eot?#iefix') format('embedded-opentype'),
                /* IE6-IE8 */
                url('../fonts/poppins-v15-latin-regular.woff2') format('woff2'),
                /* Super Modern Browsers */
                url('../fonts/poppins-v15-latin-regular.woff') format('woff'),
                /* Modern Browsers */
                url('../fonts/poppins-v15-latin-regular.ttf') format('truetype'),
                /* Safari, Android, iOS */
                url('../fonts/poppins-v15-latin-regular.svg#Poppins') format('svg');
            /* Legacy iOS */
        }

        nav ul li {
            font-family: 'Poppins' !important;
        }

        #prev-btn {
            @media (max-width: 640px) {
                margin-right: 1rem;
            }
        }

        .visiblePageNum {
            @media (max-width: 640px) {
                display: none;
            }
        }
    </style>
    <nav aria-label="Page navigation example"
        class="mt-6 py-4 px-16 flex w-min-[96] bg-white rounded-lg {{ $marginX ?? 'mx-4' }}
        ">
        <ul class="flex items-center -space-x-px h-10 text-base">
            <li>
                <a href="{{ $paginator->onFirstPage() ? '' : $paginator->previousPageUrl() }}" id="prev-btn"
                    class="px-4 bg-[#D9D9D9] text-black font-semibold h-[4rem] font-['Poppins'] mx-[0.3rem] py-2 {{ $paginator->onFirstPage() ? 'hidden' : '' }}">
                    Previous
                </a>
            </li>
            @foreach (range(1, $paginator->lastPage()) as $pages)
                @if ($paginator->currentPage() == $pages)
                    <li>
                        <a aria-current="page"
                            class="px-4 bg-[#D9D9D9] text-[#4285F4] font-semibold h-[4rem] font-['Poppins'] mx-[0.3rem] py-2 visiblePageNum">
                            {{ $pages }}</a>
                    </li>
                @else
                    <li>
                        <a href="{{ $paginator->url($pages) }}"
                            class="px-4 bg-[#D9D9D9] text-black font-semibold h-[4rem] font-['Poppins'] mx-[0.3rem] py-2 visiblePageNum">
                            {{ $pages }}</a>
                    </li>
                @endif
            @endforeach

            <li>
                <a href="{{ $paginator->onLastPage() ? '' : $paginator->nextPageUrl() }}"
                    class="px-4 bg-[#D9D9D9] text-black font-semibold h-[4rem] font-['Poppins'] mx-[0.3rem] py-2 {{ $paginator->onLastPage() ? 'hidden' : '' }}">
                    Next
                </a>
            </li>
        </ul>
    </nav>
@endif
