<x-app-guru-layout>
    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-900">Ruang Kelas LMS</h1>
                <p class="text-sm text-slate-500 mt-0.5">
                    Pilih rombel untuk mengelola modul pembelajaran, penugasan siswa, dan forum interaksi kelas.
                </p>
            </div>
            <div class="flex items-center gap-2 self-start sm:self-auto">
                <a href="{{ route('guru.lms.materi.create-view') }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold bg-brand-800 text-white hover:bg-brand-900 transition-colors shadow-sm">
                    <i class="fa-solid fa-plus text-[11px]"></i>
                    <span>Tambah Materi</span>
                </a>
                <a href="{{ route('guru.dashboard.lms.tugas.periksa') }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors shadow-sm">
                    <i class="fa-solid fa-list-check text-slate-500 text-[11px]"></i>
                    <span>Periksa Tugas</span>
                </a>
            </div>
        </div>

        {{-- Main Grid of Classes --}}
        @if ($kelasGuru->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach ($kelasGuru as $kelas)
                    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md hover:border-brand-300 transition-all flex flex-col justify-between gap-4 group">
                        
                        <div class="space-y-3">
                            {{-- Top Badges --}}
                            <div class="flex items-center justify-between gap-2">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-brand-50 text-brand-700 border border-brand-200/60">
                                    <i class="fa-solid fa-chalkboard text-[10px]"></i>
                                    Kelas {{ $kelas->kelas->nama_kelas ?? '-' }}
                                </span>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600">
                                    <i class="fa-regular fa-clock text-[10px]"></i>
                                    {{ $kelas->hari->nama_hari ?? 'Hari' }}
                                </span>
                            </div>

                            {{-- Title & Info --}}
                            <div>
                                <a href="{{ route('guru.dashboard.lms.forum', $kelas->id_kelas_mata_pelajaran) }}" class="block">
                                    <h3 class="font-bold text-slate-900 text-base group-hover:text-brand-700 transition-colors">
                                        {{ $kelas->mataPelajaran->nama_matpel ?? 'Mata Pelajaran' }}
                                    </h3>
                                </a>
                                <p class="text-xs text-slate-500 mt-1 flex items-center gap-1.5">
                                    <i class="fa-regular fa-calendar-check text-slate-400"></i>
                                    <span>Pukul {{ date('H:i', strtotime($kelas->waktu_mulai)) }} - {{ date('H:i', strtotime($kelas->waktu_selesai)) }} WIB</span>
                                </p>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="pt-3 border-t border-slate-100 flex items-center gap-2">
                            <a href="{{ route('guru.dashboard.lms.forum', $kelas->id_kelas_mata_pelajaran) }}"
                                class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 px-3 rounded-xl text-xs font-semibold bg-brand-50 text-brand-700 hover:bg-brand-100 transition-colors">
                                <i class="fa-solid fa-comments text-[11px]"></i>
                                <span>Forum Kelas</span>
                            </a>
                            <a href="{{ route('guru.dashboard.lms.forum.tugas', $kelas->id_kelas_mata_pelajaran) }}"
                                class="inline-flex items-center justify-center p-2 w-9 h-9 rounded-xl text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors"
                                title="Tugas Kelas">
                                <i class="fa-solid fa-list-check text-xs"></i>
                            </a>
                            <a href="{{ route('guru.dashboard.lms.forum.anggota', $kelas->id_kelas_mata_pelajaran) }}"
                                class="inline-flex items-center justify-center p-2 w-9 h-9 rounded-xl text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors"
                                title="Anggota Kelas">
                                <i class="fa-solid fa-users text-xs"></i>
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white border border-slate-200 rounded-2xl p-12 text-center shadow-sm">
                <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-graduation-cap text-2xl"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800">Belum Ada Rombel LMS</h3>
                <p class="text-sm text-slate-400 max-w-md mx-auto mt-1">
                    Anda belum memiliki rombongan belajar aktif yang dialokasikan untuk kegiatan pembelajaran LMS.
                </p>
            </div>
        @endif

    </div>
</x-app-guru-layout>
