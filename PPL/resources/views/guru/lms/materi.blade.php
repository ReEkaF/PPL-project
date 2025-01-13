<x-app-guru-layout>
    <div class="px-3 py-5 mx-4 my-6 bg-white rounded-lg shadow xl:p-6">
        {{-- Breadcrumb --}}
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'route' => route('guru.dashboard')],
                ['label' => 'LMS', 'route' => route('guru.dashboard.lms')],
                ['label' => 'Materi'],
            ];
        @endphp

        <x-breadcrumb :breadcrumbs="$breadcrumbs" />

        {{-- Add button --}}
        <div class="px-3 mt-5 mb-3">
            <a href="{{ route('guru.dashboard.lms.materi.create_view') }}"
                class="px-3 py-2 text-white bg-blue-500 rounded-full">
                <svg class="inline-block w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 12h14m-7 7V5" />
                </svg>
                <span class="text-sm">Tambah Materi</span>
            </a>
        </div>

        @if (session('success'))
            <div id="alert-3"
                class="flex items-center p-4 my-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                role="alert">
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div class="text-sm font-medium ms-3">
                    {{ session('success') }}
                </div>
                <button type="button"
                    class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                    data-dismiss-target="#alert-3" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        @endif



        {{-- Main Content --}}
        <div class="flex flex-col justify-between gap-6 px-3 md:flex-row">
            {{-- Materi Pelajaran --}}
            <div class="flex flex-col gap-4 mt-6 basis-1/2">
                <h2 class="mb-2 text-2xl font-semibold text-gray-800">Materi Pelajaran</h2>

                @foreach ($kelas_mata_pelajaran as $item)
                    {{-- Content --}}
                    <div class="p-4 border-2 border-gray-500 rounded-xl card">
                        <h4 class="mb-3 text-xl font-semibold">
                            {{ $item->mataPelajaran->nama_matpel . ' ' . $item->kelas->nama_kelas }}</h4>
                        <ul class="space-y-2 text-sm">
                            @foreach ($materi as $m)
                                @if ($m->kelas_mata_pelajaran_id == $item->id_kelas_mata_pelajaran)
                                    <li><a href="{{ route('guru.dashboard.lms.materi.detail', ['id' => $m->id_materi]) }}"
                                            class="text-gray-700 underline hover:text-gray-900">{{ $m->judul_materi }}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>

            {{-- Materi Terbaru --}}
            <div class="flex flex-col order-first gap-4 mt-6 md:order-last basis-1/2">
                <h2 class="mb-2 text-2xl font-semibold text-gray-800">Materi Terbaru</h2>

                @foreach ($materi_baru_date as $date)
                    <div class="flex flex-col gap-4 content-materi">
                        {{-- Tanggal --}}
                        <div class="flex items-center justify-between cursor-pointer" onclick="toggleTasks('{{ $date }}')">
                            <h3 class="mb-2 text-lg font-medium text-gray-800">
                                {{ $date }}
                            </h3>
                            <span id="arrow-{{ $date }}" class="pr-1 text-gray-500">
                                <svg width="20" height="10" viewBox="0 0 12 6" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M11.5327 1.52796C11.8243 1.23376 11.8222 0.758893 11.528 0.467309C11.2338 0.175726 10.7589 0.177844 10.4673 0.472041L8.72 2.23501C8.01086 2.9505 7.52282 3.44131 7.1093 3.77341C6.7076 4.096 6.44958 4.20668 6.2185 4.23613C6.07341 4.25462 5.92659 4.25462 5.7815 4.23613C5.55042 4.20668 5.2924 4.09601 4.89071 3.77341C4.47718 3.44131 3.98914 2.95051 3.28 2.23501L1.53269 0.472042C1.24111 0.177845 0.766238 0.175726 0.472041 0.46731C0.177844 0.758894 0.175726 1.23376 0.467309 1.52796L2.24609 3.32269C2.91604 3.99866 3.46359 4.55114 3.95146 4.94294C4.45879 5.35037 4.97373 5.64531 5.59184 5.72409C5.86287 5.75864 6.13714 5.75864 6.40816 5.72409C7.02628 5.64531 7.54122 5.35037 8.04854 4.94294C8.53641 4.55114 9.08396 3.99867 9.7539 3.32269L11.5327 1.52796Z"
                                        fill="#2D264B" />
                                </svg>
                            </span>
                        </div>

                        {{-- Materi --}}
                        <div id="tasks-{{ $date }}" class="flex flex-col gap-4 tasks-list">
                            @foreach ($materi_baru as $mb)
                                @if ($mb->updated_at->format('d F Y') == $date)
                                    <div class="px-3 py-4 border-2 border-gray-500 md:px-4 rounded-xl card {{ $mb->status == 0 ? 'bg-gray-200' : '' }}">
                                        <div class="flex gap-2 align-items-center">
                                            <div class="flex flex-col justify-center">
                                                <svg class="w-10 h-10 text-gray-800 dark:text-white" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd"
                                                        d="M8 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1h2a2 2 0 0 1 2 2v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h2Zm6 1h-4v2H9a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2h-1V4Zm-6 8a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1 3a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>

                                            <div class="flex flex-col">
                                                @if ($mb->status == 0)
                                                    <a href="{{ route('guru.dashboard.lms.materi.create', ['id' => $mb->kelas_mata_pelajaran_id]) }}"
                                                        class="text-base font-semibold text-gray-900 underline">Materi Baru:
                                                        {{ $mb->judul_materi }}</a>
                                                @else
                                                    <a href="{{ route('guru.dashboard.lms.materi.detail', ['id' => $mb->id_materi]) }}"
                                                        class="text-base font-semibold text-gray-900 underline">Materi Baru:
                                                        {{ $mb->judul_materi }}</a>
                                                @endif
                                                <span
                                                    class="text-sm">{{ $mb->kelasMataPelajaran->mataPelajaran->nama_matpel }}
                                                    {{ $mb->kelasMataPelajaran->kelas->nama_kelas }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        function toggleTasks(date) {
            const taskList = document.getElementById('tasks-' + date);
            const arrow = document.getElementById('arrow-' + date);

            if (taskList.classList.contains('hidden')) {
                taskList.classList.remove('hidden');
                arrow.innerHTML =
                    '<svg width="20" height="10" viewBox="0 0 12 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.5327 1.52796C11.8243 1.23376 11.8222 0.758893 11.528 0.467309C11.2338 0.175726 10.7589 0.177844 10.4673 0.472041L8.72 2.23501C8.01086 2.9505 7.52282 3.44131 7.1093 3.77341C6.7076 4.096 6.44958 4.20668 6.2185 4.23613C6.07341 4.25462 5.92659 4.25462 5.7815 4.23613C5.55042 4.20668 5.2924 4.09601 4.89071 3.77341C4.47718 3.44131 3.98914 2.95051 3.28 2.23501L1.53269 0.472042C1.24111 0.177845 0.766238 0.175726 0.472041 0.46731C0.177844 0.758894 0.175726 1.23376 0.467309 1.52796L2.24609 3.32269C2.91604 3.99866 3.46359 4.55114 3.95146 4.94294C4.45879 5.35037 4.97373 5.64531 5.59184 5.72409C5.86287 5.75864 6.13714 5.75864 6.40816 5.72409C7.02628 5.64531 7.54122 5.35037 8.04854 4.94294C8.53641 4.55114 9.08396 3.99867 9.7539 3.32269L11.5327 1.52796Z" fill="#2D264B"/></svg>';
            } else {
                taskList.classList.add('hidden');
                arrow.innerHTML =
                    '<svg width="20" height="10" viewBox="0 0 12 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.7815 1.76387C5.92659 1.74538 6.07341 1.74538 6.2185 1.76387C6.44958 1.79332 6.7076 1.904 7.10929 2.22659C7.52282 2.55869 8.01086 3.0495 8.72 3.76499L10.4673 5.52796C10.7589 5.82216 11.2338 5.82427 11.528 5.53269C11.8222 5.24111 11.8243 4.76624 11.5327 4.47204L9.7539 2.6773C9.08396 2.00133 8.53641 1.44886 8.04854 1.05706C7.54122 0.649628 7.02628 0.354695 6.40816 0.275909C6.13714 0.241364 5.86286 0.241364 5.59184 0.275909C4.97372 0.354695 4.45878 0.649628 3.95146 1.05706C3.46358 1.44886 2.91604 2.00134 2.24609 2.67732L0.467309 4.47204C0.175726 4.76624 0.177844 5.24111 0.472041 5.53269C0.766238 5.82427 1.24111 5.82216 1.53269 5.52796L3.28 3.76499C3.98914 3.0495 4.47718 2.55869 4.89071 2.22659C5.2924 1.904 5.55042 1.79332 5.7815 1.76387Z" fill="#2D264B"/></svg>';
            }
        }
    </script>
</x-app-guru-layout>
