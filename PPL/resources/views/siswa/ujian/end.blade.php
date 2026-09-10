<x-siswa-layout>
    <div class="max-w-xl mx-auto py-8">
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm text-center space-y-6">

            {{-- Success Checkmark Icon --}}
            <div class="w-16 h-16 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-200 flex items-center justify-center mx-auto shadow-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <div>
                <h1 class="text-2xl font-bold text-slate-900">Ujian Telah Selesai!</h1>
                <p class="text-sm text-slate-500 mt-1">Jawaban kamu berhasil disimpan dan dinilai secara otomatis oleh sistem.</p>
            </div>

            {{-- Score & Results Summary --}}
            <div class="p-6 bg-slate-50 border border-slate-200/80 rounded-2xl space-y-4">
                <div>
                    <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Skor Akhir Perolehan</p>
                    <div class="text-4xl font-extrabold text-brand-700 mt-1">
                        {{ $nilai }}
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-200/80 grid grid-cols-2 gap-3 text-left">
                    <div class="p-3 bg-white border border-slate-100 rounded-xl">
                        <p class="text-[11px] font-medium text-slate-400">Total Soal</p>
                        <p class="text-sm font-bold text-slate-800 mt-0.5">{{ $jumlahSoal }} Butir</p>
                    </div>
                    <div class="p-3 bg-white border border-slate-100 rounded-xl">
                        <p class="text-[11px] font-medium text-slate-400">Jawaban Benar</p>
                        <p class="text-sm font-bold text-emerald-600 mt-0.5">{{ (int) $jawabanBenar }} Butir</p>
                    </div>
                </div>

                <div class="text-xs text-slate-500 text-left pt-2 space-y-1">
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-400">Judul Ujian:</span>
                        <span class="font-semibold text-slate-700 text-right">{{ $ujian->judul }}</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span class="text-slate-400">Waktu Selesai:</span>
                        <span class="font-semibold text-slate-700 text-right">{{ now()->translatedFormat('d F Y, H:i') }} WIB</span>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row gap-3 pt-2">
                <a href="{{ route('siswa.ujian.index') }}"
                    class="flex-1 py-2.5 px-4 bg-brand-800 hover:bg-brand-900 text-white text-sm font-semibold rounded-xl transition shadow-sm text-center">
                    Lihat Daftar Ujian
                </a>
                <a href="{{ route('siswa.dashboard') }}"
                    class="flex-1 py-2.5 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition text-center">
                    Kembali ke Dashboard
                </a>
            </div>

        </div>
    </div>
</x-siswa-layout>
