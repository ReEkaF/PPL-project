{{--
    Shared layout for tracking tugas pages.
    Props:
    - $activeRoute   : current route name for tab highlight
    - $formRoute     : route for the filter form action
    - $kelasMataPelajaran : collection
    - $mataPelajaranList  : array [id => name]
    - $selectedMataPelajaran : selected filter value
    - $emptyMessage  : message when no tasks
    - $detailRoute   : route name for task detail link
    - $showNilai     : bool – show nilai/status column (diserahkan page)
--}}

<x-siswa-layout>
    <div class="max-w-4xl mx-auto space-y-5">

        {{-- Header --}}
        <div>
            <h1 class="text-xl font-bold text-slate-900">Tracking Tugas</h1>
            <p class="text-sm text-slate-500 mt-0.5">Pantau status pengumpulan tugas per mata pelajaran.</p>
        </div>

        {{-- Tabs --}}
        <div class="flex gap-1 bg-slate-100 p-1 rounded-xl w-fit">
            @php
                $tabs = [
                    ['route' => 'siswa.dashboard.lms.tracking.tugas.ditugaskan',     'label' => 'Ditugaskan'],
                    ['route' => 'siswa.dashboard.lms.tracking.tugas.belum_diserahkan','label' => 'Belum Diserahkan'],
                    ['route' => 'siswa.dashboard.lms.tracking.tugas.diserahkan',     'label' => 'Selesai'],
                ];
            @endphp
            @foreach ($tabs as $tab)
                @php $isActive = request()->routeIs($tab['route']); @endphp
                <a href="{{ route($tab['route']) }}"
                    class="px-4 py-2 text-sm font-medium rounded-lg transition-colors
                    {{ $isActive ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                    {{ $tab['label'] }}
                </a>
            @endforeach
        </div>

        {{-- Filter --}}
        <form method="GET" action="{{ route($formRoute) }}" class="flex items-center gap-3">
            <div class="relative flex-1 max-w-xs">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <select name="mata_pelajaran" onchange="this.form.submit()"
                    class="w-full pl-9 pr-3 py-2 text-sm border border-slate-200 bg-white rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400 appearance-none">
                    <option value="">Semua Mata Pelajaran</option>
                    @foreach ($mataPelajaranList as $id => $nama)
                        <option value="{{ $id }}" {{ $selectedMataPelajaran == $id ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>
            </div>
        </form>

        {{-- Task List --}}
        <div class="space-y-3">
            @forelse ($kelasMataPelajaran as $mapel)
                @php $hasTugas = $mapel->tugas->count() > 0; @endphp
                <div class="bg-white border border-slate-200 rounded-xl overflow-hidden" x-data="{ open: true }">
                    {{-- Subject Header --}}
                    <button type="button" @click="open = !open"
                        class="w-full flex items-center justify-between px-5 py-3.5 hover:bg-slate-50 transition text-left">
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-lg bg-brand-50 text-brand-700 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <span class="font-semibold text-slate-800 text-sm">{{ $mapel->mataPelajaran->nama_matpel }}</span>
                            <span class="text-xs text-slate-400 font-medium">{{ $mapel->tugas->count() }} tugas</span>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>

                    {{-- Task Items --}}
                    <div x-show="open" x-cloak class="border-t border-slate-100">
                        @if ($hasTugas)
                            @foreach ($mapel->tugas as $tugas)
                                <a href="{{ route($detailRoute, $tugas->id_tugas) }}"
                                    class="flex items-center gap-4 px-5 py-3.5 hover:bg-slate-50 transition border-b border-slate-50 last:border-0 group">

                                    {{-- Bullet / icon --}}
                                    <div class="w-6 h-6 rounded-full bg-amber-50 border border-amber-200 flex items-center justify-center shrink-0">
                                        <svg class="w-3 h-3 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3 4a2 2 0 012-2h10a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V4zm9 4a1 1 0 10-2 0v3H7a1 1 0 100 2h3v3a1 1 0 102 0v-3h3a1 1 0 100-2h-3V8z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>

                                    {{-- Title --}}
                                    <span class="flex-1 text-sm font-medium text-slate-700 group-hover:text-brand-800 transition truncate">
                                        {{ $tugas->judul }}
                                    </span>

                                    {{-- Right side: deadline OR nilai --}}
                                    @if (!empty($showNilai) && $showNilai && $tugas->pengumpulanTugas->count() > 0)
                                        @php $pengumpulan = $tugas->pengumpulanTugas->first(); @endphp
                                        <div class="flex items-center gap-2 shrink-0">
                                            @if ($pengumpulan->nilai)
                                                <span class="text-xs font-bold text-brand-800 bg-brand-50 border border-brand-200 px-2.5 py-1 rounded-lg">
                                                    {{ $pengumpulan->nilai }}/100
                                                </span>
                                            @else
                                                <span class="text-xs text-slate-400 italic">Belum dinilai</span>
                                            @endif
                                            @if ($pengumpulan->status === 'terlambat diserahkan')
                                                <span class="text-xs text-red-500 font-medium">Terlambat</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-xs text-slate-400 shrink-0 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $tugas->deadline->translatedFormat('d M Y') }}
                                        </span>
                                    @endif

                                    <svg class="w-4 h-4 text-slate-300 group-hover:text-slate-500 shrink-0 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            @endforeach
                        @else
                            <div class="px-5 py-4 text-sm text-slate-400 flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Tidak ada tugas saat ini.
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-10 text-center">
                    <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="font-semibold text-slate-600">{{ $emptyMessage }}</p>
                </div>
            @endforelse
        </div>
    </div>
</x-siswa-layout>
