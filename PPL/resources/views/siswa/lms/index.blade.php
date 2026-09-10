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
                @php
                    $palette = [
                        ['bg-brand-50','border-brand-200','text-brand-800','text-brand-600','bg-brand-100'],
                        ['bg-emerald-50','border-emerald-200','text-emerald-800','text-emerald-600','bg-emerald-100'],
                        ['bg-violet-50','border-violet-200','text-violet-800','text-violet-600','bg-violet-100'],
                        ['bg-amber-50','border-amber-200','text-amber-800','text-amber-600','bg-amber-100'],
                        ['bg-rose-50','border-rose-200','text-rose-800','text-rose-600','bg-rose-100'],
                        ['bg-cyan-50','border-cyan-200','text-cyan-800','text-cyan-600','bg-cyan-100'],
                    ];
                @endphp

                @foreach ($mataPelajaranList as $i => $kmp)
                    @php $c = $palette[$i % count($palette)]; @endphp
                    <a href="{{ route('siswa.dashboard.lms.forum', $kmp->id_kelas_mata_pelajaran) }}"
                        class="group bg-white border {{ $c[1] }} rounded-xl p-5 hover:shadow-md transition-all duration-200 hover:-translate-y-0.5 flex flex-col gap-4">
                        {{-- Icon + Subject --}}
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl {{ $c[4] }} {{ $c[2] }} flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-slate-900 group-hover:{{ $c[2] }} transition-colors leading-tight">
                                    {{ $kmp->mataPelajaran->nama_matpel }}
                                </h3>
                                <p class="text-xs text-slate-500 mt-0.5">{{ $kmp->guru->nama_guru }}</p>
                            </div>
                        </div>

                        {{-- Schedule Info --}}
                        <div class="flex items-center gap-2 text-xs text-slate-500 bg-slate-50 rounded-lg px-3 py-2">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>{{ $kmp->hari->nama_hari }}, {{ substr($kmp->waktu_mulai,0,5) }}–{{ substr($kmp->waktu_selesai,0,5) }} WIB</span>
                        </div>

                        <div class="flex items-center justify-between text-xs text-slate-400 pt-1">
                            <span>Lihat kelas</span>
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                <p class="font-semibold text-slate-600">Belum Ada Mata Pelajaran</p>
                <p class="text-sm text-slate-400 mt-1">Kamu belum terdaftar dalam kelas manapun.</p>
            </div>
        @endif
    </div>
</x-siswa-layout>
