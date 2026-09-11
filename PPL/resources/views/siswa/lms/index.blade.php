<x-siswa-layout>
    <div class="max-w-6xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div>
            <h1 class="text-xl font-bold text-slate-900">Learning Management System</h1>
            <p class="text-sm text-slate-500 mt-0.5">Pilih mata pelajaran untuk mengakses materi, tugas, dan forum kelas.</p>
        </div>

        {{-- Mata Pelajaran Grid --}}
        @if ($mataPelajaranList->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($mataPelajaranList as $kmp)
                    <a href="{{ route('siswa.dashboard.lms.forum', $kmp->id_kelas_mata_pelajaran) }}"
                        class="group bg-white border border-slate-200 hover:border-slate-300 rounded-xl p-5 shadow-sm hover:shadow transition-all flex flex-col gap-4">
                        {{-- Icon + Subject --}}
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-[#06466C]/10 text-[#06466C] flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-slate-900 group-hover:text-[#06466C] transition-colors leading-tight truncate">
                                    {{ $kmp->mataPelajaran->nama_matpel }}
                                </h3>
                                <p class="text-xs text-slate-500 mt-0.5 truncate">{{ $kmp->guru->nama_guru }}</p>
                            </div>
                        </div>

                        {{-- Schedule Info --}}
                        <div class="flex items-center gap-2 text-xs text-slate-500 bg-slate-50 rounded-lg px-3 py-2">
                            <svg class="w-3.5 h-3.5 shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="truncate">{{ $kmp->hari->nama_hari }}, {{ substr($kmp->waktu_mulai,0,5) }}–{{ substr($kmp->waktu_selesai,0,5) }} WIB</span>
                        </div>

                        <div class="flex items-center justify-between text-xs text-slate-400 pt-1">
                            <span class="group-hover:text-[#06466C] transition-colors font-medium">Buka ruang belajar</span>
                            <svg class="w-4 h-4 group-hover:translate-x-0.5 group-hover:text-[#06466C] transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-12 text-center">
                <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <p class="font-semibold text-slate-700">Belum Ada Mata Pelajaran</p>
                <p class="text-sm text-slate-400 mt-1">Kamu belum terdaftar dalam kelas manapun.</p>
            </div>
        @endif
    </div>
</x-siswa-layout>
