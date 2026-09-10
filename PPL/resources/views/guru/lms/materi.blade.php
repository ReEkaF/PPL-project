<x-app-guru-layout>
    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-900">Materi Pembelajaran</h1>
                <p class="text-sm text-slate-500 mt-0.5">
                    Kelola modul pembelajaran, materi bacaan, dan dokumen pendukung ajar di setiap rombel.
                </p>
            </div>
            <a href="{{ route('guru.lms.materi.create-view') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold bg-brand-800 text-white hover:bg-brand-900 transition-colors shadow-sm self-start sm:self-auto">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Tambah Materi Baru</span>
            </a>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between gap-3 text-xs">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        {{-- 2 Columns Layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left Column (2 cols): Materi per Kelas --}}
            <div class="lg:col-span-2 space-y-5">
                <div class="flex items-center justify-between">
                    <h2 class="font-bold text-slate-900 text-base flex items-center gap-2">
                        <i class="fa-solid fa-chalkboard text-brand-700"></i>
                        Materi per Rombel / Kelas
                    </h2>
                    <span class="text-xs text-slate-500">{{ $kelas_mata_pelajaran->count() }} Rombel Aktif</span>
                </div>

                @if ($kelas_mata_pelajaran->isNotEmpty())
                    <div class="space-y-4">
                        @foreach ($kelas_mata_pelajaran as $item)
                            @php
                                $materiKelas = $materi->where('kelas_mata_pelajaran_id', $item->id_kelas_mata_pelajaran);
                            @endphp
                            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                                {{-- Card Header --}}
                                <div class="bg-slate-50 px-5 py-3.5 border-b border-slate-100 flex items-center justify-between">
                                    <div class="flex items-center gap-2.5">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-brand-50 text-brand-700 border border-brand-200/60">
                                            {{ $item->kelas->nama_kelas ?? 'Kelas' }}
                                        </span>
                                        <h3 class="font-bold text-slate-800 text-sm">
                                            {{ $item->mataPelajaran->nama_matpel ?? 'Mata Pelajaran' }}
                                        </h3>
                                    </div>
                                    <a href="{{ route('guru.dashboard.lms.materi.create', ['id' => $item->id_kelas_mata_pelajaran]) }}"
                                        class="inline-flex items-center gap-1 text-xs font-semibold text-brand-700 hover:text-brand-800 transition-colors">
                                        <i class="fa-solid fa-plus text-[10px]"></i>
                                        <span>Tambah Modul</span>
                                    </a>
                                </div>

                                {{-- Card Body: List of Materi --}}
                                <div class="p-5">
                                    @if ($materiKelas->isNotEmpty())
                                        <div class="divide-y divide-slate-100">
                                            @foreach ($materiKelas as $m)
                                                <div class="py-3 first:pt-0 last:pb-0 flex items-center justify-between gap-4">
                                                    <div class="flex items-start gap-3">
                                                        <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 mt-0.5">
                                                            <i class="fa-regular fa-file-lines text-xs"></i>
                                                        </div>
                                                        <div>
                                                            <a href="{{ route('guru.dashboard.lms.materi.detail', ['id' => $m->id_materi]) }}"
                                                                class="font-semibold text-slate-900 text-xs hover:text-brand-700 transition-colors">
                                                                {{ $m->judul_materi }}
                                                            </a>
                                                            <p class="text-[11px] text-slate-400 mt-0.5">
                                                                @if (!empty($m->topik))
                                                                    <span>Topik: {{ $m->topik->judul_topik }} • </span>
                                                                @endif
                                                                {{ \Carbon\Carbon::parse($m->updated_at)->format('d M Y') }}
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="flex items-center gap-2 shrink-0">
                                                        @if ($m->status == 1)
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                                Terbit
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-amber-50 text-amber-700 border border-amber-200">
                                                                Draft
                                                            </span>
                                                        @endif
                                                        <a href="{{ route('guru.dashboard.lms.materi.detail', ['id' => $m->id_materi]) }}"
                                                            class="p-1.5 text-slate-400 hover:text-brand-700 transition-colors" title="Lihat Detail">
                                                            <i class="fa-solid fa-chevron-right text-xs"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-xs text-slate-400 italic text-center py-2">Belum ada materi pembelajaran untuk kelas ini.</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center text-xs text-slate-500">
                        Tidak ada rombel aktif yang ditemukan.
                    </div>
                @endif
            </div>

            {{-- Right Column (1 col): Materi Terbaru Feed --}}
            <div class="space-y-4">
                <h2 class="font-bold text-slate-900 text-base flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-brand-700"></i>
                    Aktivitas Materi Terkini
                </h2>

                @if ($materi_baru->isNotEmpty())
                    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-4">
                        @foreach ($materi_baru->take(6) as $mb)
                            <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-700 flex items-center justify-center shrink-0 mt-0.5">
                                    <i class="fa-solid fa-book-open text-xs"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <a href="{{ route('guru.dashboard.lms.materi.detail', ['id' => $mb->id_materi]) }}"
                                        class="text-xs font-semibold text-slate-800 hover:text-brand-700 truncate block transition-colors">
                                        {{ $mb->judul_materi }}
                                    </a>
                                    <p class="text-[10px] text-slate-400 mt-0.5">
                                        {{ $mb->kelasMataPelajaran->kelas->nama_kelas ?? 'Kelas' }} • {{ \Carbon\Carbon::parse($mb->updated_at)->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 text-center text-xs text-slate-400">
                        Belum ada riwayat aktivitas materi terbaru.
                    </div>
                @endif
            </div>

        </div>

    </div>
</x-app-guru-layout>
