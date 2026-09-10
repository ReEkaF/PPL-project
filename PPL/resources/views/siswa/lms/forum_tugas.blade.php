<x-siswa-layout>
    <div class="max-w-6xl mx-auto space-y-5">

        {{-- Header --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('siswa.dashboard.lms') }}"
                class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-900 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-xl font-bold text-slate-900">{{ $mataPelajaran->nama_matpel }}</h1>
                <p class="text-sm text-slate-500">{{ $guru->nama_guru }} · {{ $hari->nama_hari }}, {{ substr($waktu_mulai,0,5) }}–{{ substr($waktu_selesai,0,5) }} WIB</p>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="flex gap-1 bg-slate-100 p-1 rounded-xl w-fit">
            @php
                $tabs = [
                    ['route' => 'siswa.dashboard.lms.forum',        'label' => 'Forum',   'param' => $id],
                    ['route' => 'siswa.dashboard.lms.forum.tugas',  'label' => 'Tugas',   'param' => $id],
                    ['route' => 'siswa.dashboard.lms.forum.anggota','label' => 'Anggota', 'param' => $id],
                ];
            @endphp
            @foreach ($tabs as $tab)
                @php $isActive = request()->routeIs($tab['route']) || request()->routeIs(str_replace('dashboard.', '', $tab['route'])); @endphp
                <a href="{{ route($tab['route'], $tab['param']) }}"
                    class="px-4 py-2 text-sm font-medium rounded-lg transition-colors
                    {{ $isActive ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                    {{ $tab['label'] }}
                </a>
            @endforeach
        </div>

        {{-- Main 2-col layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- Left: Topics & Tasks List (2/3) --}}
            <div class="lg:col-span-2 space-y-4">

                {{-- Tugas & Materi Tanpa Topik (Jika Ada) --}}
                @if ($tugasTanpaTopik->isNotEmpty() || $materiTanpaTopik->isNotEmpty())
                    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
                        <div class="px-4 py-3 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <span class="w-6 h-6 rounded-md bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                    </svg>
                                </span>
                                <h2 class="text-sm font-bold text-slate-800">Materi & Tugas Umum</h2>
                            </div>
                            <span class="text-xs text-slate-400 font-medium">
                                {{ $tugasTanpaTopik->count() + $materiTanpaTopik->count() }} item
                            </span>
                        </div>

                        <div class="p-3 space-y-2.5">
                            {{-- Tugas Tanpa Topik --}}
                            @foreach ($tugasTanpaTopik as $tugas)
                                <a href="{{ route('siswa.dashboard.lms.detail.tugas', $tugas->id_tugas) }}"
                                    class="group block bg-white border border-slate-200 rounded-lg p-3 hover:shadow-md hover:border-slate-300 transition-all">
                                    <div class="flex items-start gap-3">
                                        <div class="w-9 h-9 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2 mb-0.5">
                                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-amber-100 text-amber-700">Tugas</span>
                                                @if ($tugas->deadline)
                                                    <span class="text-xs text-slate-400 flex items-center gap-1">
                                                        <svg class="w-3 h-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        Tenggat: {{ \Carbon\Carbon::parse($tugas->deadline)->translatedFormat('d M Y, H:i') }} WIB
                                                    </span>
                                                @else
                                                    <span class="text-xs text-slate-400">Tidak ada tenggat</span>
                                                @endif
                                            </div>
                                            <p class="font-semibold text-slate-800 text-sm group-hover:text-brand-800 transition-colors">{{ $tugas->judul }}</p>
                                        </div>
                                        <svg class="w-4 h-4 text-slate-300 group-hover:text-slate-500 group-hover:translate-x-1 transition-all shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </div>
                                </a>
                            @endforeach

                            {{-- Materi Tanpa Topik --}}
                            @foreach ($materiTanpaTopik as $materi)
                                <a href="{{ route('siswa.dashboard.lms.detail.materi', $materi->id_materi) }}"
                                    class="group block bg-white border border-slate-200 rounded-lg p-3 hover:shadow-md hover:border-slate-300 transition-all">
                                    <div class="flex items-start gap-3">
                                        <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-700 flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2 mb-0.5">
                                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-brand-100 text-brand-700">Materi</span>
                                                <span class="text-xs text-slate-400">{{ $materi->created_at ? $materi->created_at->translatedFormat('d M Y') : '' }}</span>
                                            </div>
                                            <p class="font-semibold text-slate-800 text-sm group-hover:text-brand-800 transition-colors">{{ $materi->judul_materi }}</p>
                                        </div>
                                        <svg class="w-4 h-4 text-slate-300 group-hover:text-slate-500 group-hover:translate-x-1 transition-all shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Daftar Berdasarkan Topik --}}
                @forelse ($listTopik as $topik)
                    @php
                        $tugasCount = $topik->tugas ? $topik->tugas->count() : 0;
                        $materiCount = $topik->materi ? $topik->materi->count() : 0;
                    @endphp
                    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
                        {{-- Topik Header --}}
                        <div class="px-4 py-3 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <span class="w-6 h-6 rounded-md bg-brand-100 text-brand-700 flex items-center justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                    </svg>
                                </span>
                                <h2 class="text-sm font-bold text-slate-800">{{ $topik->judul_topik }}</h2>
                            </div>
                            <div class="flex items-center gap-1.5">
                                @if ($tugasCount > 0)
                                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-amber-100 text-amber-700">
                                        {{ $tugasCount }} Tugas
                                    </span>
                                @endif
                                @if ($materiCount > 0)
                                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-brand-100 text-brand-700">
                                        {{ $materiCount }} Materi
                                    </span>
                                @endif
                                @if ($tugasCount === 0 && $materiCount === 0)
                                    <span class="text-xs text-slate-400">Kosong</span>
                                @endif
                            </div>
                        </div>

                        {{-- Item List in Topik --}}
                        <div class="p-3 space-y-2.5">
                            {{-- Tugas List --}}
                            @if ($topik->tugas && $topik->tugas->isNotEmpty())
                                @foreach ($topik->tugas as $tugas)
                                    <a href="{{ route('siswa.dashboard.lms.detail.tugas', $tugas->id_tugas) }}"
                                        class="group block bg-white border border-slate-200 rounded-lg p-3 hover:shadow-md hover:border-slate-300 transition-all">
                                        <div class="flex items-start gap-3">
                                            <div class="w-9 h-9 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center gap-2 mb-0.5">
                                                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-amber-100 text-amber-700">Tugas</span>
                                                    @if ($tugas->deadline)
                                                        <span class="text-xs text-slate-400 flex items-center gap-1">
                                                            <svg class="w-3 h-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                            Tenggat: {{ \Carbon\Carbon::parse($tugas->deadline)->translatedFormat('d M Y, H:i') }} WIB
                                                        </span>
                                                    @else
                                                        <span class="text-xs text-slate-400">Tidak ada tenggat</span>
                                                    @endif
                                                </div>
                                                <p class="font-semibold text-slate-800 text-sm group-hover:text-brand-800 transition-colors">{{ $tugas->judul }}</p>
                                            </div>
                                            <svg class="w-4 h-4 text-slate-300 group-hover:text-slate-500 group-hover:translate-x-1 transition-all shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </div>
                                    </a>
                                @endforeach
                            @endif

                            {{-- Materi List --}}
                            @if ($topik->materi && $topik->materi->isNotEmpty())
                                @foreach ($topik->materi as $materi)
                                    <a href="{{ route('siswa.dashboard.lms.detail.materi', $materi->id_materi) }}"
                                        class="group block bg-white border border-slate-200 rounded-lg p-3 hover:shadow-md hover:border-slate-300 transition-all">
                                        <div class="flex items-start gap-3">
                                            <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-700 flex items-center justify-center shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center gap-2 mb-0.5">
                                                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-brand-100 text-brand-700">Materi</span>
                                                    <span class="text-xs text-slate-400">{{ $materi->created_at ? $materi->created_at->translatedFormat('d M Y') : '' }}</span>
                                                </div>
                                                <p class="font-semibold text-slate-800 text-sm group-hover:text-brand-800 transition-colors">{{ $materi->judul_materi }}</p>
                                            </div>
                                            <svg class="w-4 h-4 text-slate-300 group-hover:text-slate-500 group-hover:translate-x-1 transition-all shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </div>
                                    </a>
                                @endforeach
                            @endif

                            @if ($tugasCount === 0 && $materiCount === 0)
                                <p class="text-xs text-slate-400 py-3 text-center">Belum ada materi atau tugas pada topik ini.</p>
                            @endif
                        </div>
                    </div>
                @empty
                    @if ($tugasTanpaTopik->isEmpty() && $materiTanpaTopik->isEmpty())
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-10 text-center">
                            <p class="text-slate-500 text-sm">Belum ada tugas atau materi di kelas ini.</p>
                        </div>
                    @endif
                @endforelse

            </div>

            {{-- Right Sidebar (1/3) --}}
            <div class="space-y-4">

                {{-- Instructor Card --}}
                <div class="bg-white border border-slate-200 rounded-xl p-4">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Pengajar</p>
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-brand-100 text-brand-800 flex items-center justify-center font-bold text-sm shrink-0">
                            {{ strtoupper(substr($guru->nama_guru, 0, 2)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-slate-800 text-sm">{{ $guru->nama_guru }}</p>
                            <p class="text-xs text-slate-500">{{ $mataPelajaran->nama_matpel }}</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-slate-100 flex items-center gap-2 text-xs text-slate-500">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ $hari->nama_hari }}, {{ substr($waktu_mulai,0,5) }}–{{ substr($waktu_selesai,0,5) }} WIB</span>
                    </div>
                </div>

                {{-- Summary Card --}}
                <div class="bg-white border border-slate-200 rounded-xl p-4">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Ringkasan Pembelajaran</p>
                    @php
                        $totalTopikCount = $listTopik->count();
                        $totalTugasCount = $tugasTanpaTopik->count() + $listTopik->sum(fn($top) => $top->tugas ? $top->tugas->count() : 0);
                        $totalMateriCount = $materiTanpaTopik->count() + $listTopik->sum(fn($top) => $top->materi ? $top->materi->count() : 0);
                    @endphp
                    <div class="grid grid-cols-3 gap-2 text-center">
                        <div class="p-2.5 bg-slate-50 rounded-lg border border-slate-100">
                            <span class="block text-base font-bold text-slate-800">{{ $totalTopikCount }}</span>
                            <span class="text-[11px] text-slate-500 font-medium">Topik</span>
                        </div>
                        <div class="p-2.5 bg-amber-50/70 rounded-lg border border-amber-100">
                            <span class="block text-base font-bold text-amber-700">{{ $totalTugasCount }}</span>
                            <span class="text-[11px] text-amber-700 font-medium">Tugas</span>
                        </div>
                        <div class="p-2.5 bg-brand-50/70 rounded-lg border border-brand-100">
                            <span class="block text-base font-bold text-brand-800">{{ $totalMateriCount }}</span>
                            <span class="text-[11px] text-brand-700 font-medium">Materi</span>
                        </div>
                    </div>
                    @if (isset($kelas->nama_kelas))
                        <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                            <span class="text-slate-400">Kelas</span>
                            <span class="font-semibold text-slate-700">{{ $kelas->nama_kelas }}</span>
                        </div>
                    @endif
                </div>

            </div>

        </div>

    </div>
</x-siswa-layout>
