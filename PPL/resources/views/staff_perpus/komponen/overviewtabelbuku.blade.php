@php
    $totalbook = 0;
    foreach ($buku as $bk) {
        $totalbook += 1;
    }
@endphp
<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Nama Buku
                </th>
                <th scope="col" class="px-6 py-3">
                    (Total {{ $totalbook }})
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($buku10 as $bt)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $bt->judul_buku }}
                    </th>
                    <td class="px-6 py-4">

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="flex py-5 px-6">
        <a href="{{ route('staff_perpus.buku.daftarbuku') }}"
            class="uppercase text-sm font-semibold inline-flex items-center rounded-lg text-blue-600 hover:text-blue-700 dark:hover:text-blue-500  hover:bg-gray-100 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 px-3 py-2">
            More...
            <svg class="w-2.5 h-2.5 ms-1.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 9 4-4-4-4" />
            </svg>
        </a>
    </div>
</div>
