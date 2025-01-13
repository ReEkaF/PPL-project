<x-app-guru-layout>
    <div class="px-3 py-5 mx-4 my-6 bg-white rounded-lg shadow xl:p-6">
        {{-- Breadcrumb --}}
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'route' => route('guru.dashboard')],
                ['label' => 'LMS', 'route' => route('guru.dashboard.lms')],
                ['label' => 'Tugas', 'route' => '#'],
            ];
        @endphp

        <x-breadcrumb :breadcrumbs="$breadcrumbs" />

        {{-- Main Content --}}
        <div class="flex flex-col gap-4 mt-4 md:flex-row">
            <!-- Left Side - Mata Pelajaran dan Kelas -->
            <div class="flex-1 lg:max-w-[40%]">
                <div class="p-4 bg-white">
                    <h2 class="mb-4 text-xl font-bold">Kelas dan Mata Pelajaran yang Diampu</h2>

                    @foreach ($mataPelajaranGrup as $mapelId => $mapel)
                        @foreach ($mapel['kelas'] as $kelas)
                            <div class="p-4 mb-6 border border-black rounded-xl">
                                <div class="pl-4 mt-4">
                                    <h4 class="font-medium">
                                        <h3 class="text-lg font-medium">{{ $mapel['mata_pelajaran'] }} {{ $kelas['nama_kelas'] }}</h3>

                                    </h4>

                                    @if ($kelas['tugas']->count() > 0)
                                        @foreach ($kelas['tugas'] as $tugas)
                                            <div class="mt-2">
                                                <p class="text-gray-600">Tenggat:
                                                    {{ Carbon\Carbon::parse($tugas->deadline)->translatedFormat('l, d F Y') }}
                                                </p>
                                                <a href="{{ route('guru.dashboard.lms.detail.tugas', $tugas->id_tugas) }}"
                                                    class="text-blue-500 underline">
                                                    {{ $tugas->judul }}
                                                </a>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-sm text-gray-500">Tidak ada tugas</p>
                                    @endif

                                    <div class="flex gap-2 mt-3">
                                        <span class="text-gray-300">|</span>
                                        <a href="" class="text-sm text-blue-500">
                                            Lihat Semua
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>

            <!-- Right Side - Tugas Terbaru -->
            <div class="flex-1">
                <div class="p-4 bg-white rounded-lg">
                    <h2 class="mb-4 text-xl font-bold">Tugas Terbaru</h2>

                    @foreach ($allTasks as $date => $tasks)
                        <div class="mb-4">
                            <div class="flex items-center justify-between cursor-pointer"
                                onclick="toggleTasks('{{ $date }}')">
                                <h3 class="mb-2 text-lg font-medium text-gray-800">
                                    {{ \Carbon\Carbon::parse($date)->format('d F Y') }}
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

                            <div id="tasks-{{ $date }}" class="tasks-list">
                                @foreach ($tasks as $task)
                                    <a href="{{ route('guru.dashboard.lms.detail.tugas', $task->id_tugas) }}">
                                        <div
                                            class="flex items-center gap-4 p-4 mb-4 transition-colors border border-black rounded-xl hover:bg-gray-100">
                                            <div class="flex-shrink-0">
                                                <svg width="28" height="36" viewBox="0 0 28 36" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M1.05254 6.87192C0.583496 8.31548 0.583496 10.0992 0.583496 13.6667V27.8258C0.583496 31.5003 0.583496 33.3375 1.23891 34.3092C2.0396 35.4962 3.43508 36.138 4.8574 35.9734C6.02166 35.8387 7.41659 34.6431 10.2064 32.2518C11.4345 31.1991 12.0486 30.6728 12.7231 30.4345C13.5494 30.1425 14.4509 30.1425 15.2773 30.4345C15.9517 30.6728 16.5658 31.1991 17.7938 32.2517C20.5837 34.643 21.9787 35.8387 23.1429 35.9734C24.5652 36.138 25.9607 35.4962 26.7614 34.3092C27.4168 33.3375 27.4168 31.5003 27.4168 27.8258V13.6667C27.4168 10.0992 27.4168 8.31548 26.9478 6.87192C25.9998 3.95439 23.7124 1.667 20.7949 0.719042C19.3513 0.25 17.5676 0.25 14.0002 0.25C10.4327 0.25 8.64898 0.25 7.20542 0.719042C4.28789 1.667 2.0005 3.95439 1.05254 6.87192ZM8.25016 10.3125C7.45625 10.3125 6.81266 10.9561 6.81266 11.75C6.81266 12.5439 7.45625 13.1875 8.25016 13.1875H19.7502C20.5441 13.1875 21.1877 12.5439 21.1877 11.75C21.1877 10.9561 20.5441 10.3125 19.7502 10.3125H8.25016Z"
                                                        fill="#2D264B" />
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="text-base font-medium text-gray-800">{{ $task->judul }}
                                                </h4>
                                                <p class="text-sm text-gray-500">
                                                    {{ $task->kelasMataPelajaran->mataPelajaran->nama_matpel }} -
                                                    {{ $task->kelasMataPelajaran->kelas->nama_kelas }}
                                                </p>
                                                <p class="mt-1 text-xs font-semibold text-gray-900">
                                                    Tenggat:
                                                    {{ \Carbon\Carbon::parse($task->deadline)->format('d F Y, H:i') }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
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
