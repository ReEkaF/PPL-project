<x-siswa-layout>
    <div class="px-3 py-5 mx-4 my-6 bg-white rounded-lg shadow xl:p-6">
        {{-- Breadcrumb --}}
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'route' => route('siswa.dashboard')],
                ['label' => 'LMS', 'route' => route('siswa.dashboard.lms')],
                ['label' => 'Materi', 'route' => route('siswa.dashboard.lms.materi')],
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
                                @php
                                    $file_name = explode('/', $item->file_path);
                                    $file_name = end($file_name);
                                    $file_name = substr($file_name, 11);
                                @endphp
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
                                        <span class="text-sm">{{ $file_name }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-siswa-layout>
