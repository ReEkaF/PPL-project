<x-siswa-layout>
    <div class="max-w-6xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div>
            <h1 class="text-xl font-bold text-slate-900">Materi Pelajaran</h1>
            <p class="text-sm text-slate-500 mt-0.5">Klik mata pelajaran untuk melihat daftar materinya.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 items-start">

            {{-- LEFT: Per Mata Pelajaran (accordion, sticky) --}}
            <div class="lg:col-span-1">
                <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
                    <div class="px-4 py-3 border-b border-slate-100 bg-slate-50">
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Mata Pelajaran</p>
                    </div>

                    {{-- Scrollable accordion list --}}
                    <div class="overflow-y-auto" style="max-height: 70vh;">
                        @foreach ($kelas_mata_pelajaran as $idx => $item)
                            @php
                                $materiMapel = $materi->where('kelas_mata_pelajaran_id', $item->id_kelas_mata_pelajaran);
                                $count = $materiMapel->count();
                            @endphp
                            <div x-data="{ open: {{ $idx === 0 ? 'true' : 'false' }} }"
                                class="border-b border-slate-100 last:border-0">

                                {{-- Subject Toggle --}}
                                <button type="button" @click="open = !open"
                                    class="w-full flex items-center justify-between px-4 py-3.5 hover:bg-slate-50 transition text-left">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-lg bg-brand-50 text-brand-700 flex items-center justify-center shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-slate-800 truncate">{{ $item->mataPelajaran->nama_matpel }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 shrink-0">
                                        @if ($count > 0)
                                            <span class="text-xs font-bold text-brand-700 bg-brand-50 border border-brand-200 px-2 py-0.5 rounded-full">{{ $count }}</span>
                                        @endif
                                        <svg class="w-4 h-4 text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
                                        </svg>
                                    </div>
                                </button>

                                {{-- Materi items for this subject --}}
                                <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-150"
                                    x-transition:enter-start="opacity-0 -translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    class="bg-slate-50/60">
                                    @forelse ($materiMapel as $m)
                                        <a href="{{ route('siswa.dashboard.lms.detail.materi', ['id' => $m->id_materi]) }}"
                                            class="flex items-center gap-2.5 px-4 pl-[3.25rem] py-2.5 hover:bg-brand-50 transition group border-t border-slate-100/80">
                                            <svg class="w-3.5 h-3.5 text-brand-300 group-hover:text-brand-600 shrink-0 transition" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                            </svg>
                                            <span class="text-sm text-slate-700 group-hover:text-brand-800 transition truncate">{{ $m->judul_materi }}</span>
                                        </a>
                                    @empty
                                        <p class="px-4 pl-[3.25rem] py-2.5 text-sm text-slate-400 border-t border-slate-100">Belum ada materi.</p>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- RIGHT: Materi Terbaru (scrollable feed) --}}
            <div class="lg:col-span-2">
                <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
                    <div class="px-5 py-3 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Materi Terbaru</p>
                        <span class="text-xs text-slate-400">{{ $materi_baru->count() }} item</span>
                    </div>

                    {{-- Scrollable list --}}
                    <div class="overflow-y-auto divide-y divide-slate-100" style="max-height: 70vh;">
                        @forelse ($materi_baru_date as $date)
                            {{-- Date header --}}
                            <div class="px-5 py-2 bg-slate-50/70 sticky top-0 z-10 border-b border-slate-100">
                                <span class="text-xs font-semibold text-slate-500">{{ $date }}</span>
                            </div>

                            @foreach ($materi_baru as $mb)
                                @if ($mb->updated_at->format('d F Y') == $date)
                                    <a href="{{ route('siswa.dashboard.lms.detail.materi', ['id' => $mb->id_materi]) }}"
                                        class="group flex items-start gap-3 px-5 py-3.5 hover:bg-brand-50/50 transition">

                                        {{-- Icon --}}
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 mt-0.5
                                            {{ $mb->status == 0 ? 'bg-slate-100 text-slate-400' : 'bg-brand-50 text-brand-700' }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>

                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-slate-800 group-hover:text-brand-800 transition truncate">
                                                {{ $mb->judul_materi }}
                                            </p>
                                            <div class="flex items-center gap-2 mt-0.5">
                                                <span class="text-xs text-slate-400">{{ $mb->kelasMataPelajaran->mataPelajaran->nama_matpel }}</span>
                                                <span class="text-slate-300">·</span>
                                                <span class="text-xs text-slate-400">{{ $mb->kelasMataPelajaran->kelas->nama_kelas }}</span>
                                                @if ($mb->status == 0)
                                                    <span class="text-xs text-slate-400 italic">· Tidak aktif</span>
                                                @endif
                                            </div>
                                        </div>

                                        <svg class="w-4 h-4 text-slate-300 group-hover:text-slate-400 shrink-0 mt-1.5 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                @endif
                            @endforeach
                        @empty
                            <div class="flex flex-col items-center justify-center py-16 text-center">
                                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-slate-500">Belum ada materi tersedia.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-siswa-layout>
