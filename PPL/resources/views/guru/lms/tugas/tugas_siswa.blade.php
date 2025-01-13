<x-app-guru-layout>
    <div class="px-3 py-5 mx-4 my-6 bg-white rounded-lg shadow">
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'route' => route('guru.dashboard')],
                ['label' => 'LMS', 'route' => route('guru.dashboard.lms')],
                [
                    'label' => 'Kelas ' . $kelas->nama_kelas,
                    'route' => route('guru.dashboard.lms.forum.tugas', $KelasMataPelajaranId),
                ],
                ['label' => 'Pengumpulan ' . $tugas->judul],
            ];
        @endphp

        <x-breadcrumb :breadcrumbs="$breadcrumbs" />

        <div class="mt-8 px-3 flex flex-col md:flex-row gap-x-4">
            <!-- Kolom Kanan (lebih besar) -->
            <div class="basis-2/3 w-full  rounded-lg overflow-y-auto order-1 md:order-2 md:pl-4">
                <h2 class="text-lg font-semibold mb-4">Pengumpulan Tugas</h2>
                <div class="py-2 ">
                    <p class="mb-4 font-medium">Diserahkan: {{ $diserahkan }} / {{ $belumDiserahkan }}</p>
                    <div class="flex gap-4 flex-wrap">
                        @foreach ($pengumpulanTugas as $pengumpulan)
                            <a href="{{ route('guru.dashboard.lms.tugas.siswa.detail', $pengumpulan->id_pengumpulan_tugas) }}"
                                class="border px-3 py-2 rounded-lg hover:bg-gray-100">
                                <p class="text-sm">{{ $pengumpulan->siswa->nama_siswa }}</p>
                                <p class="text-xs text-gray-600 mt-3">{{ $pengumpulan->pengumpulanTugasFile->count() }}
                                    Lampiran file</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Kolom Kiri (lebih kecil) -->
            <div class="basis-1/3 w-full mt-6 md:mt-0 rounded-lg overflow-auto order-2 md:order-1">
                <h2 class="text-lg font-semibold mb-4">Daftar Siswa</h2>
                <div class="space-y-2 py-2 ">
                    @foreach ($siswaList as $siswa)
                        @php
                            $pengumpulan = $pengumpulanTugas->firstWhere('siswa_id', $siswa->id_siswa);
                        @endphp
                        @if ($pengumpulan)
                            <a href="{{ route('guru.dashboard.lms.tugas.siswa.detail', $pengumpulan->id_pengumpulan_tugas) }}"
                                class="flex items-center justify-between">
                                <div class="text-sm">{{ $siswa->nama_siswa }}</div>
                                @if ($pengumpulan->nilai !== null)
                                    <span
                                        class="bg-green-300 text-gray-700 rounded-2xl py-1 px-2 text-[10px]">{{ $pengumpulan->nilai }}/100</span>
                                @else
                                    <span class="bg-red-300 text-gray-700 rounded-2xl py-1 px-2 text-[10px]">Belum
                                        Dinilai</span>
                                @endif
                            </a>
                        @else
                            <div class="flex items-center justify-between">
                                <div class="text-sm">{{ $siswa->nama_siswa }}</div>
                                <span class="bg-gray-200 text-gray-700 rounded-2xl py-1 px-2 text-[10px]">Belum
                                    Diserahkan</span>
                            </div>
                        @endif
                        <hr class="mb-4">
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-guru-layout>
