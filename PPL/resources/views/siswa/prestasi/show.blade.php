<x-siswa-layout>
    <div class="max-w-4xl mx-auto space-y-6">

        {{-- Top Navigation / Back --}}
        <div class="flex items-center justify-between">
            <a href="{{ route('siswa.prestasi') }}"
                class="inline-flex items-center gap-2 px-3.5 py-2 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-semibold rounded-xl transition shadow-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Daftar Prestasi
            </a>

            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Data Resmi Staff Akademik
            </span>
        </div>

        {{-- Achievement Detail Card --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-xs space-y-6">

            {{-- Header with Trophy Icon --}}
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 border border-amber-200/80 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs uppercase font-bold text-amber-700 tracking-wider">Prestasi Siswa</p>
                    <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 mt-1 leading-snug">
                        {{ $prestasi->nama_prestasi }}
                    </h1>
                    <p class="text-xs text-slate-400 mt-1">
                        Tercatat pada {{ $prestasi->created_at ? $prestasi->created_at->translatedFormat('d F Y, H:i') : 'Arsip Sekolah' }} WIB
                    </p>
                </div>
            </div>

            {{-- Description Section --}}
            <div class="p-4 sm:p-5 bg-slate-50 border border-slate-200/70 rounded-xl space-y-2">
                <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500">
                    Keterangan & Deskripsi Capaian
                </h2>
                <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-line">
                    {{ $prestasi->deskripsi_prestasi }}
                </p>
            </div>

            {{-- Proof / Certificate Section --}}
            <div class="space-y-3 pt-2">
                <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500">
                    Berkas Piagam / Bukti Digital
                </h2>

                @if ($prestasi->bukti_prestasi)
                    @php
                        $isImage = in_array(strtolower(pathinfo($prestasi->bukti_prestasi, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'webp', 'svg']);
                    @endphp

                    @if ($isImage)
                        <div class="border border-slate-200 rounded-2xl overflow-hidden bg-slate-50 p-2">
                            <img src="{{ asset('storage/' . $prestasi->bukti_prestasi) }}"
                                alt="Piagam Prestasi"
                                class="w-full max-h-[500px] object-contain rounded-xl mx-auto">
                        </div>
                        <div class="text-right">
                            <a href="{{ asset('storage/' . $prestasi->bukti_prestasi) }}" target="_blank"
                                class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-700 hover:text-brand-900 underline">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                                Buka Gambar Ukuran Penuh
                            </a>
                        </div>
                    @else
                        <div class="p-4 bg-white border border-slate-200 rounded-xl flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center font-bold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800">Berkas Piagam Prestasi</p>
                                    <p class="text-xs text-slate-400">Format dokumen (PDF / Arsip)</p>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $prestasi->bukti_prestasi) }}" target="_blank"
                                class="px-4 py-2 bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold rounded-lg transition shadow-xs">
                                Unduh / Buka Dokumen
                            </a>
                        </div>
                    @endif
                @else
                    <div class="p-4 bg-slate-50 border border-dashed border-slate-200 rounded-xl text-center">
                        <p class="text-xs text-slate-500">
                            Salinan fisik piagam atau medali telah disimpan dalam arsip Staff Akademik sekolah.
                        </p>
                    </div>
                @endif
            </div>

        </div>

    </div>
</x-siswa-layout>