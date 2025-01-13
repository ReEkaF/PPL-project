<x-siswa-layout>
    <div class="px-3 py-5 mx-4 my-6 bg-white rounded-lg shadow xl:p-6">
        {{-- Breadcrumb --}}
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'route' => route('siswa.dashboard')],
                ['label' => 'LMS', 'route' => route('siswa.dashboard.lms')],
                ['label' => 'Materi'],
            ];
        @endphp

        <x-breadcrumb :breadcrumbs="$breadcrumbs" />

        {{-- Main Content --}}
        <div class="flex flex-col justify-between gap-6 px-3 md:flex-row">
            {{-- Materi Pelajaran --}}
            <div class="flex flex-col gap-4 mt-6 basis-1/2">
                <h2 class="mb-2 text-2xl font-semibold text-gray-800">Materi Pelajaran</h2>

                @foreach ($kelas_mata_pelajaran as $item)
                    {{-- Content --}}
                    <div class="p-4 border-2 border-gray-500 rounded-xl card">
                        <h4 class="mb-3 text-xl font-semibold">
                            {{ $item->mataPelajaran->nama_matpel }}</h4>
                        <ul class="space-y-2 text-sm">
                            @foreach ($materi as $m)
                                @if ($m->kelas_mata_pelajaran_id == $item->id_kelas_mata_pelajaran)
                                    <li><a href="{{ route('siswa.dashboard.lms.detail.materi', ['id' => $m->id_materi]) }}"
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
                    {{-- Content --}}
                    <div class="flex flex-col gap-4 content-materi">
                        {{-- Tanggal --}}
                        <div class="materi-date">
                            <span class="text-lg font-semibold">{{ $date }}</span>
                        </div>
                        @foreach ($materi_baru as $mb)
                            @if ($mb->updated_at->format('d F Y') == $date)
                                {{-- Materi --}}
                                <div
                                    class="px-3 py-4 border-2 border-gray-500 md:px-4 rounded-xl card {{ $mb->status == 0 ? 'bg-gray-200' : '' }}">
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
                                            <a href="{{ route('siswa.dashboard.lms.detail.materi', ['id' => $mb->id_materi]) }}"
                                                class="text-base font-semibold text-gray-900 underline">Materi Baru:
                                                {{ $mb->judul_materi }}</a>
                                            <span
                                                class="text-sm">{{ $mb->kelasMataPelajaran->mataPelajaran->nama_matpel }}
                                                {{ $mb->kelasMataPelajaran->kelas->nama_kelas }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-siswa-layout>
