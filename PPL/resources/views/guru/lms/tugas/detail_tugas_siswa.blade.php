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
                [
                    'label' => 'Pengumpulan ' . $tugas->judul,
                    'route' => route('guru.dashboard.lms.tugas.siswa', $tugas->id_tugas),
                ],
                ['label' => 'Tugas ' . $pengumpulan->siswa->nama_siswa],
            ];
        @endphp

        <x-breadcrumb :breadcrumbs="$breadcrumbs" />

        @if (session()->has('success'))
            <x-alert-notification :color="'blue'">
                {{ session('success') }}
            </x-alert-notification>
        @endif

        <div class="mt-8 px-3 flex flex-col md:flex-row gap-x-4">
            <!-- Kolom Kanan (lebih besar) -->
            <div class="basis-2/3 w-full  rounded-lg overflow-y-auto order-1 md:order-2 md:pl-6">
                <h2 class="text-lg font-semibold mb-4">Pengumpulan Tugas {{ $pengumpulan->siswa->nama_siswa }}</h2>
                <div class="py-2 ">
                    <div class="flex items-center justify-between ">
                        <p>Lampiran Fila Tugas</p>
                        @if ($pengumpulan->nilai !== null)
                            <span
                                class="bg-green-300 text-gray-700 rounded-2xl py-1 px-2   text-xs">{{ $pengumpulan->nilai }}
                                / 100</span>
                        @else
                            <div class="flex items-center gap-x-2">
                                <span class="bg-red-200 text-gray-600 py-1 px-2 rounded-2xl text-xs">Belum
                                    Dinilai
                                </span>
                                @if ($pengumpulan->status == 'terlambat diserahkan')
                                    <span class=" text-xs text-gray-600  py-1 px-2 bg-red-200 rounded-lg">terlambat diserahkan</span>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div>
                        @if ($pengumpulan->pengumpulanTugasFile->count() > 0)
                            <div class="mt-5">
                                @foreach ($pengumpulan->pengumpulanTugasFile as $file)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg mt-4">
                                        <div class="flex items-center space-x-3">
                                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                            <span class="text-sm text-gray-600">{{ $file->original_name }}</span>
                                        </div>
                                        <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                                            class="text-indigo-600 hover:text-indigo-800">
                                            Lihat
                                        </a>
                                    </div>
                                @endforeach

                            </div>
                        @else
                            <p class=" text-gray-600 mt-6 border border-dashed py-2 px-1 text-sm">Tidak ada lampiran
                                yang diunggah.</p>
                        @endif
                    </div>

                    <div class="mt-8 px-3">
                        <h2 class="text-lg font-semibold mb-4">Penilaian</h2>
                        <form
                            action="{{ route('guru.dashboard.lms.tugas.siswa.update', $pengumpulan->id_pengumpulan_tugas) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="nilai" class="block text-sm font-medium text-gray-700">Nilai</label>
                                <input type="number" name="nilai" max="100" id="nilai"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    value="{{ $pengumpulan->nilai }}">
                            </div>
                            <div class="mb-4">
                                <label for="komentar" class="block text-sm font-medium text-gray-700">Komentar</label>
                                <textarea name="komentar" id="komentar" rows="3"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ $pengumpulan->komentar }}</textarea>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Kolom Kiri (lebih kecil) -->
            <div class="basis-1/3 w-full mt-6 md:mt-0 rounded-lg overflow-auto order-2 md:order-1">
                <h2 class="text-lg font-semibold mb-4">Daftar Siswa</h2>
                <ul class="space-y-2 py-2 ">
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
                </ul>
            </div>
        </div>
    </div>
</x-app-guru-layout>
