<x-app-guru-layout>
    <div class="px-3 py-5 mx-4 my-6 bg-white rounded-lg shadow xl:p-6">
        {{-- Breadcrumb --}}
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'route' => route('guru.dashboard')],
                ['label' => 'LMS', 'route' => route('guru.dashboard.lms')],
                ['label' => 'Materi', 'route' => route('guru.dashboard.lms.materi')],
                ['label' => $materi->judul_materi]
            ];
        @endphp
        <x-breadcrumb :breadcrumbs="$breadcrumbs" />

        {{-- Main Content --}}
        <div class="flex flex-col gap-6 px-3 mt-8">
            {{-- Header --}}
            <div class="flex gap-3 m-auto md:w-1/2">
                <div class="w-1/12">
                    <svg class="w-10 h-10 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M8 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1h2a2 2 0 0 1 2 2v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h2Zm6 1h-4v2H9a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2h-1V4Zm-6 8a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1 3a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z" clip-rule="evenodd"/>
                    </svg>
                </div>

                <div class="flex justify-between w-full pb-2 border-b-2 border-gray-300">
                    <div>
                        <h4 class="text-2xl font-semibold text-gray-700">{{ $materi->judul_materi }}</h4>
                        <span class="text-sm">{{ $materi->kelasMataPelajaran->guru->nama_guru }} . {{ $materi->created_at->format('d F Y') }}</span>
                    </div>

                   <div>
                        <button type="button" id="topik-menu-button-2" aria-expanded="false" data-dropdown-toggle="dropdown-3">
                            <span class="sr-only">Open three dots</span>
                            <svg class="w-8 h-8 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M12 6h.01M12 12h.01M12 18h.01"/>
                            </svg>
                        </button>

                        {{-- Three dots Modal --}}
                        <div class="z-10 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow" id="dropdown-3">
                            <ul class="py-1" role="none">
                                <li>
                                    <a href="{{ route('guru.dashboard.lms.materi.edit', ['id' => $materi->id_materi]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                                </li>
                                <li>
                                    <button data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="z-10 block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" type="button">Hapus</button>
                                </li>
                            </ul>
                        </div>

                        {{-- Delete Button Modal --}}
                        <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-800 bg-opacity-50">
                            <div class="relative w-full max-w-md max-h-full p-4">
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                    <div class="p-4 text-center md:p-5">
                                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-400 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Apakah kamu yakin ingin menghapus?</h3>
                                        <form action="{{ route('guru.dashboard.lms.materi.destroy', ['id' => $materi->id_materi]) }}" method="post" class="inline-flex">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" name="delete" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                Hapus
                                            </button>
                                        </form>
                                        <button data-modal-hide="popup-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Batal</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                   </div>
                </div>
            </div>

            {{-- Content --}}
            <div class="flex gap-3 m-auto md:w-1/2">
                <div class="w-1/12"></div>

                <div class="w-full">
                    <div class="mb-4">
                        {!! $materi->deskripsi !!}
                    </div>

                    @if (count($file_materi))
                        <div class="flex gap-4 card-container">
                            @foreach ($file_materi as $item)
                                <div class="h-20 p-3 border border-gray-400 rounded-md fw-1/2">
                                    <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="flex items-center justify-center w-full h-full gap-2">
                                        @if (pathinfo($item->file_path, PATHINFO_EXTENSION) == 'pdf')
                                            <svg class="w-10 h-10 text-red-500" aria-hidden="true" xmlns="http://www.w3.org/
                                            2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M3 3a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h18a2 2 0 0 0 2-2V9l-6-6H3Zm6 2h6v2H9V5Zm0 3h6v2H9V8Zm0 3h6v2H9v-2Zm0 3h4v2H9v-2Zm11 8H3V5h6v4h8v2h4v10Zm-2-8h-4V7h4v2Z">
                                                </path>
                                            </svg>
                                        @elseif (pathinfo($item->file_path, PATHINFO_EXTENSION) == 'docx' || pathinfo($item->file_path, PATHINFO_EXTENSION) == 'doc')
                                            <svg class="w-10 h-10 text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/
                                            2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M3 3a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h18a2 2 0 0 0 2-2V9l-6-6H3Zm6 2h6v2H9V5Zm0 3h6v2H9V8Zm0 3h6v2H9v-2Zm0 3h4v2H9v-2Zm11 8H3V5h6v4h8v2h4v10Zm-2-8h-4V7h4v2Z">
                                                </path>
                                            </svg>
                                        @elseif (pathinfo($item->file_path, PATHINFO_EXTENSION) == 'pptx' || pathinfo($item->file_path, PATHINFO_EXTENSION) == 'ppt')
                                            <svg class="w-10 h-10 text-red-500" aria-hidden="true" xmlns="http://www.w3.org/
                                            2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M3 3a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h18a2 2 0 0 0 2-2V9l-6-6H3Zm6 2h6v2H9V5Zm0 3h6v2H9V8Zm0 3h6v2H9v-2Zm0 3h4v2H9v-2Zm11 8H3V5h6v4h8v2h4v10Zm-2-8h-4V7h4v2Z">
                                                </path>
                                            </svg>
                                        @elseif (pathinfo($item->file_path, PATHINFO_EXTENSION) == 'xlsx')
                                            <svg class="w-10 h-10 text-green-500" aria-hidden="true" xmlns="http://www.w3.org/
                                            2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M3 3a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h18a2 2 0 0 0 2-2V9l-6-6H3Zm6 2h6v2H9V5Zm0 3h6v2H9V8Zm0 3h6v2H9v-2Zm0 3h4v2H9v-2Zm11 8H3V5h6v4h8v2h4v10Zm-2-8h-4V7h4v2Z">
                                                </path>
                                            </svg>
                                        @else
                                            <svg class="w-10 h-10 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/
                                            2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M3 3a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h18a2 2 0 0 0 2-2V9l-6-6H3Zm6 2h6v2H9V5Zm0 3h6v2H9V8Zm0 3h6v2H9v-2Zm0 3h4v2H9v-2Zm11 8H3V5h6v4h8v2h4v10Zm-2-8h-4V7h4v2Z">
                                                </path>
                                            </svg>
                                        @endif
                                        <span class="text-sm">{{ $item->original_name }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-guru-layout>
