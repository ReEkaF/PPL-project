<x-siswa-layout>
    <div class="max-w-5xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-slate-900">Tugas</h1>
                <p class="text-sm text-slate-500 mt-0.5">Pantau dan kerjakan tugas dari semua mata pelajaran.</p>
            </div>
        </div>

        {{-- Tracking Tabs --}}
        <div class="flex gap-1 bg-slate-100 p-1 rounded-xl w-fit">
            @php
                $tabs = [
                    ['route' => 'siswa.dashboard.lms.tracking.tugas.ditugaskan',     'label' => 'Ditugaskan'],
                    ['route' => 'siswa.dashboard.lms.tracking.tugas.belum_diserahkan','label' => 'Belum Diserahkan'],
                    ['route' => 'siswa.dashboard.lms.tracking.tugas.diserahkan',     'label' => 'Selesai'],
                ];
            @endphp
            @foreach ($tabs as $tab)
                <a href="{{ route($tab['route']) }}"
                    class="px-4 py-2 text-sm font-medium rounded-lg text-slate-500 hover:text-slate-700 transition-colors">
                    {{ $tab['label'] }}
                </a>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left: Upcoming Tasks per Mapel --}}
            <div class="space-y-3">
                <h2 class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Tugas Mendatang</h2>

                @foreach ($mataPelajaranList as $mapel)
                    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
                        {{-- Mapel header --}}
                        <div class="px-4 py-3 bg-slate-50 border-b border-slate-100 flex items-center gap-2">
                            <div class="w-6 h-6 rounded-md bg-amber-50 text-amber-700 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <span class="text-sm font-semibold text-slate-800">{{ $mapel->mataPelajaran->nama_matpel }}</span>
                        </div>

                        {{-- Tasks --}}
                        <div class="divide-y divide-slate-50">
                            @forelse ($mapel->tugas as $tugas)
                                <a href="{{ route('siswa.dashboard.lms.detail.tugas', $tugas->id_tugas) }}"
                                    class="flex items-start gap-2.5 px-4 py-3 hover:bg-slate-50 transition group">
                                    <svg class="w-3.5 h-3.5 text-red-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-slate-700 group-hover:text-brand-800 transition truncate">{{ $tugas->judul }}</p>
                                        <p class="text-xs text-slate-400 mt-0.5">{{ \Carbon\Carbon::parse($tugas->deadline)->translatedFormat('d M Y') }}</p>
                                    </div>
                                </a>
                            @empty
                                <p class="px-4 py-3 text-sm text-slate-400 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Tidak ada tugas
                                </p>
                            @endforelse
                        </div>

                        <div class="px-4 py-2 border-t border-slate-100">
                            <a href="{{ route('siswa.dashboard.lms.tracking.tugas.ditugaskan') }}"
                                class="text-xs text-brand-700 hover:text-brand-900 font-medium hover:underline transition">
                                Lihat semua →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Right: Latest Tasks Feed --}}
            <div class="lg:col-span-2 space-y-2">
                <h2 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-3">Tugas Terbaru</h2>

                @forelse ($allTasks as $date => $tasks)
                    {{-- Date separator --}}
                    <div class="flex items-center gap-3 pt-2 first:pt-0">
                        <span class="text-xs font-semibold text-slate-400 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}
                        </span>
                        <div class="flex-1 h-px bg-slate-100"></div>
                    </div>

                    @foreach ($tasks as $task)
                        <a href="{{ route('siswa.dashboard.lms.detail.tugas', $task->id_tugas) }}"
                            class="group flex items-start gap-3 bg-white border border-slate-200 rounded-xl px-4 py-3.5 hover:shadow-md hover:border-slate-300 transition-all">

                            {{-- Icon --}}
                            <div class="w-9 h-9 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                </svg>
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-0.5">
                                    <span class="text-xs font-medium text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full">Tugas Baru</span>
                                </div>
                                <p class="font-semibold text-slate-800 group-hover:text-brand-800 transition-colors">{{ $task->judul }}</p>
                                <div class="flex items-center gap-3 mt-1 text-xs text-slate-500">
                                    <span>{{ $task->kelasMataPelajaran->mataPelajaran->nama_matpel }}</span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3 h-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($task->deadline)->format('d M Y, H:i') }}
                                    </span>
                                </div>
                            </div>

                            <svg class="w-4 h-4 text-slate-300 group-hover:text-slate-500 group-hover:translate-x-1 transition-all shrink-0 mt-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @endforeach
                @empty
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-10 text-center">
                        <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="font-semibold text-slate-600">Tidak ada tugas baru</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-siswa-layout>
