<x-siswa-layout>
    <div class="max-w-6xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-900">Prestasi & Penghargaan</h1>
                <p class="text-sm text-slate-500 mt-0.5">
                    Rekam jejak prestasi akademik dan non-akademik resmi yang dicatat oleh Staff Akademik sekolah.
                </p>
            </div>

            {{-- Metric Badge --}}
            <div class="flex items-center gap-3">
                <div class="px-4 py-2 bg-amber-50 border border-amber-200 rounded-xl flex items-center gap-2.5 shadow-xs">
                    <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center font-bold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase font-semibold text-amber-700 leading-tight">Total Prestasi</p>
                        <p class="text-base font-bold text-amber-900 leading-tight">{{ $totalPrestasi }} Prestasi</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Search & Filter Bar --}}
        <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <form action="{{ route('siswa.prestasi') }}" method="GET" class="flex-1 flex items-center gap-2">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                        placeholder="Cari nama prestasi, kompetensi, atau penghargaan..."
                        class="w-full pl-9 pr-4 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-slate-800 placeholder-slate-400 transition-colors">
                </div>
                <button type="submit"
                    class="px-4 py-2 bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold rounded-lg transition shadow-xs">
                    Cari
                </button>
                @if (!empty($search))
                    <a href="{{ route('siswa.prestasi') }}"
                        class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-lg transition">
                        Reset
                    </a>
                @endif
            </form>

            <div class="text-xs text-slate-500 flex items-center gap-1.5 shrink-0">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>Dikelola resmi oleh <strong>Staff Akademik</strong></span>
            </div>
        </div>

        {{-- Prestasi List --}}
        @if ($prestasi->isEmpty())
            <div class="bg-white border border-slate-200 rounded-2xl p-12 text-center shadow-xs">
                <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center mx-auto mb-3.5 border border-amber-100">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-slate-800">
                    @if (!empty($search))
                        Prestasi Tidak Ditemukan
                    @else
                        Belum Ada Catatan Prestasi
                    @endif
                </h3>
                <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto mt-1.5 leading-relaxed">
                    @if (!empty($search))
                        Tidak ditemukan data prestasi dengan kata kunci <em>"{{ $search }}"</em>. Coba gunakan kata kunci lainnya.
                    @else
                        Seluruh prestasi siswa dicatat dan diverifikasi langsung oleh <strong>Staff Akademik</strong>. Jika kamu memiliki sertifikat atau piagam lomba terbaru, serahkan salinannya ke ruang Staff Akademik untuk diinput ke portal.
                    @endif
                </p>

                @if (!empty($search))
                    <a href="{{ route('siswa.prestasi') }}"
                        class="inline-flex items-center gap-1.5 mt-4 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition">
                        Kembali ke Semua Prestasi
                    </a>
                @endif
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($prestasi as $item)
                    <div class="bg-white border border-slate-200 rounded-2xl p-5 hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
                        <div class="space-y-3">
                            {{-- Top Badges --}}
                            <div class="flex items-start justify-between gap-2">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Terverifikasi Akademik
                                </span>

                                @if ($item->bukti_prestasi)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-medium bg-brand-50 text-brand-700 border border-brand-200">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                        </svg>
                                        Piagam Tersedia
                                    </span>
                                @endif
                            </div>

                            {{-- Title --}}
                            <div>
                                <h3 class="text-base font-bold text-slate-900 group-hover:text-brand-800 transition-colors leading-snug">
                                    {{ $item->nama_prestasi }}
                                </h3>
                                <p class="text-xs text-slate-600 mt-1.5 line-clamp-3 leading-relaxed">
                                    {{ $item->deskripsi_prestasi }}
                                </p>
                            </div>
                        </div>

                        {{-- Footer Action --}}
                        <div class="mt-4 pt-3.5 border-t border-slate-100 flex items-center justify-between text-xs">
                            <span class="text-slate-400">
                                Dicatat: {{ $item->created_at ? $item->created_at->translatedFormat('d M Y') : 'Sekolah' }}
                            </span>

                            <a href="{{ route('siswa.prestasi.show', $item->id_prestasi) }}"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-brand-50 text-slate-700 hover:text-brand-700 font-semibold rounded-lg transition-colors">
                                <span>Rincian Piagam</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if ($prestasi->hasPages())
                <div class="pt-2">
                    {{ $prestasi->links() }}
                </div>
            @endif
        @endif

    </div>
</x-siswa-layout>