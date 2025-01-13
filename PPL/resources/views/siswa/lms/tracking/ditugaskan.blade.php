<x-siswa-layout>
    <div class="px-4 py-6 bg-white rounded-lg shadow-md">
        {{-- Breadcrumb --}}
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'route' => route('siswa.dashboard')],
                ['label' => 'LMS', 'route' => route('siswa.dashboard.lms')],
                ['label' => 'Tracking Tugas'],
            ];
        @endphp
        <x-breadcrumb :breadcrumbs="$breadcrumbs" />

        {{-- Main Content --}}
        <div class="px-4 mt-6">
            {{-- Tabs --}}
            <div class="flex gap-2 mb-6">
                <x-nav-button-lms route="siswa.dashboard.lms.tracking.tugas.ditugaskan" label="Ditugaskan" />
                <x-nav-button-lms route="siswa.dashboard.lms.tracking.tugas.belum_diserahkan" label="Belum Diserahkan" />
                <x-nav-button-lms route="siswa.dashboard.lms.tracking.tugas.diserahkan" label="Selesai" />
            </div>

            {{-- Filter Mata Pelajaran --}}
            <div class="max-w-3xl mx-auto mb-6">
                <form method="GET" action="{{ route('siswa.dashboard.lms.tracking.tugas.ditugaskan') }}"
                    class="flex items-center space-x-4">
                    <select name="mata_pelajaran" onchange="this.form.submit()"
                        class="form-select w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="">Semua Mata Pelajaran</option>
                        @foreach ($mataPelajaranList as $id => $nama)
                            <option value="{{ $id }}" {{ $selectedMataPelajaran == $id ? 'selected' : '' }}>
                                {{ $nama }}
                            </option>
                        @endforeach
                    </select>

                </form>
            </div>

            <div class="space-y-4 max-w-3xl mx-auto">
                @forelse ($kelasMataPelajaran as $mataPelajaran)
                    <div class="rounded-lg shadow-sm border border-black">
                        <div class="flex items-center justify-between p-4 cursor-pointer toggle-section">
                            <h2 class="text-lg font-semibold text-gray-800">
                                {{ $mataPelajaran->mataPelajaran->nama_matpel }}
                            </h2>
                            <button class="toggle-arrow" type="button">
                                <svg width="20" height="20" viewBox="0 0 12 6" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M11.5327 1.52796C11.8243 1.23376 11.8222 0.758893 11.528 0.467309C11.2338 0.175726 10.7589 0.177844 10.4673 0.472041L8.72 2.23501C8.01086 2.9505 7.52282 3.44131 7.1093 3.77341C6.7076 4.096 6.44958 4.20668 6.2185 4.23613C6.07341 4.25462 5.92659 4.25462 5.7815 4.23613C5.55042 4.20668 5.2924 4.09601 4.89071 3.77341C4.47718 3.44131 3.98914 2.95051 3.28 2.23501L1.53269 0.472042C1.24111 0.177845 0.766238 0.175726 0.472041 0.46731C0.177844 0.758894 0.175726 1.23376 0.467309 1.52796L2.24609 3.32269C2.91604 3.99866 3.46359 4.55114 3.95146 4.94294C4.45879 5.35037 4.97373 5.64531 5.59184 5.72409C5.86287 5.75864 6.13714 5.75864 6.40816 5.72409C7.02628 5.64531 7.54122 5.35037 8.04854 4.94294C8.53641 4.55114 9.08396 3.99867 9.7539 3.32269L11.5327 1.52796Z"
                                        fill="#2D264B" />
                                </svg>
                            </button>
                        </div>

                        <div class="task-list px-4 pb-4">
                            @if ($mataPelajaran->tugas->count() > 0)
                                <ul class="space-y-2">
                                    @foreach ($mataPelajaran->tugas as $tugas)
                                        <li class="bg-white p-3 rounded-md">
                                            <a href="{{ route('siswa.dashboard.lms.detail.tugas', $tugas->id_tugas) }}">
                                                <div class="flex justify-between items-center">
                                                    <span class="font-medium text-gray-700">{{ $tugas->judul }}
                                                    </span>
                                                    <span
                                                        class="font-medium text-xs text-red-600">{{ $tugas->deadline->translatedFormat('l, d F Y h:i A') }}</span>
                                                    </span>
                                                </div>
                                            </a>
                                            <hr class="border border-gray-500 mt-2">
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-gray-500 italic">Yeay, tidak ada tugas!</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center font-bold py-6 text-gray-500">
                        Yeay tidak ada tugas!
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleSections = document.querySelectorAll('.toggle-section');

            toggleSections.forEach(section => {
                const taskList = section.nextElementSibling;
                const arrow = section.querySelector('.toggle-arrow svg');

                section.addEventListener('click', function() {
                    taskList.classList.toggle('hidden');

                    if (taskList.classList.contains('hidden')) {
                        arrow.innerHTML =
                            '<path d="M5.7815 1.76387C5.92659 1.74538 6.07341 1.74538 6.2185 1.76387C6.44958 1.79332 6.7076 1.904 7.10929 2.22659C7.52282 2.55869 8.01086 3.0495 8.72 3.76499L10.4673 5.52796C10.7589 5.82216 11.2338 5.82427 11.528 5.53269C11.8222 5.24111 11.8243 4.76624 11.5327 4.47204L9.7539 2.6773C9.08396 2.00133 8.53641 1.44886 8.04854 1.05706C7.54122 0.649628 7.02628 0.354695 6.40816 0.275909C6.13714 0.241364 5.86286 0.241364 5.59184 0.275909C4.97372 0.354695 4.45878 0.649628 3.95146 1.05706C3.46358 1.44886 2.91604 2.00134 2.24609 2.67732L0.467309 4.47204C0.175726 4.76624 0.177844 5.24111 0.472041 5.53269C0.766238 5.82427 1.24111 5.82216 1.53269 5.52796L3.28 3.76499C3.98914 3.0495 4.47718 2.55869 4.89071 2.22659C5.2924 1.904 5.55042 1.79332 5.7815 1.76387Z" fill="#2D264B"/>';
                    } else {
                        arrow.innerHTML =
                            '<path d="M11.5327 1.52796C11.8243 1.23376 11.8222 0.758893 11.528 0.467309C11.2338 0.175726 10.7589 0.177844 10.4673 0.472041L8.72 2.23501C8.01086 2.9505 7.52282 3.44131 7.1093 3.77341C6.7076 4.096 6.44958 4.20668 6.2185 4.23613C6.07341 4.25462 5.92659 4.25462 5.7815 4.23613C5.55042 4.20668 5.2924 4.09601 4.89071 3.77341C4.47718 3.44131 3.98914 2.95051 3.28 2.23501L1.53269 0.472042C1.24111 0.177845 0.766238 0.175726 0.472041 0.46731C0.177844 0.758894 0.175726 1.23376 0.467309 1.52796L2.24609 3.32269C2.91604 3.99866 3.46359 4.55114 3.95146 4.94294C4.45879 5.35037 4.97373 5.64531 5.59184 5.72409C5.86287 5.75864 6.13714 5.75864 6.40816 5.72409C7.02628 5.64531 7.54122 5.35037 8.04854 4.94294C8.53641 4.55114 9.08396 3.99867 9.7539 3.32269L11.5327 1.52796Z" fill="#2D264B"/>';
                    }
                });
            });
        });
    </script>

</x-siswa-layout>
