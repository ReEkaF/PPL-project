<x-siswa-layout>
    <div class="space-y-6">
        {{-- Header Card --}}
        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-2xl bg-brand-50 text-brand-800 flex items-center justify-center shrink-0 text-xl border border-brand-100">
                    <i class="fa-solid fa-address-card"></i>
                </div>
                <div class="space-y-1">
                    <h1 class="text-xl sm:text-2xl font-black text-slate-900">Ekskul Saya</h1>
                    <p class="text-xs sm:text-sm text-slate-500">
                        Pantau status pendaftaran, keanggotaan aktif, dan rekap penilaian kegiatan ekstrakurikuler kamu.
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2.5 shrink-0">
                <a href="{{ route('siswa.ekstrakurikuler.pendaftaran') }}"
                    class="px-4 py-2 bg-brand-800 hover:bg-brand-900 text-white rounded-xl text-xs font-bold shadow-sm transition-colors inline-flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i>
                    <span>Daftar Ekskul Baru</span>
                </a>
                <a href="{{ route('siswa.ekstrakurikuler.index') }}"
                    class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition-colors inline-flex items-center gap-2">
                    <i class="fa-solid fa-compass"></i>
                    <span>Katalog Ekskul</span>
                </a>
            </div>
        </div>

        {{-- Success Alert --}}
        @if (session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        {{-- KPI Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            {{-- Diterima / Aktif --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500">Keanggotaan Aktif</p>
                    <p class="text-2xl font-black text-slate-900">{{ $totalDiterima }}</p>
                </div>
            </div>

            {{-- Menunggu --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500">Menunggu Konfirmasi</p>
                    <p class="text-2xl font-black text-slate-900">{{ $totalMenunggu }}</p>
                </div>
            </div>

            {{-- Ditolak --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500">Pendaftaran Ditolak</p>
                    <p class="text-2xl font-black text-slate-900">{{ $totalDitolak }}</p>
                </div>
            </div>
        </div>

        {{-- Daftar Riwayat Pendaftaran & Keanggotaan --}}
        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm space-y-5">
            <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-brand-800"></i>
                        <span>Status Pendaftaran Ekstrakurikuler</span>
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar kegiatan yang telah kamu ajukan</p>
                </div>
            </div>

            @if ($registrasiList->isEmpty())
                <div class="p-10 text-center bg-slate-50 rounded-2xl border border-slate-100">
                    <div class="w-14 h-14 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3 text-2xl">
                        <i class="fa-solid fa-file-circle-xmark"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-800">Kamu belum terdaftar di ekstrakurikuler manapun</h3>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                        Ayo pilih ekstrakurikuler yang kamu minati untuk mengasah bakat dan menjalin pertemanan baru!
                    </p>
                    <a href="{{ route('siswa.ekstrakurikuler.pendaftaran') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-brand-800 text-white text-xs font-bold rounded-xl hover:bg-brand-900 transition-colors">
                        <i class="fa-solid fa-plus"></i>
                        <span>Daftar Sekarang</span>
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($registrasiList as $item)
                        @php
                            $ekstra = $item->ekstrakurikuler;
                        @endphp
                        <div class="p-5 rounded-2xl border border-slate-200/80 bg-white hover:border-slate-300 transition-all flex flex-col justify-between gap-4">
                            <div class="space-y-3">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <h3 class="text-base font-bold text-slate-900">
                                            {{ $ekstra->nama_ekstrakurikuler ?? 'Ekstrakurikuler' }}
                                        </h3>
                                        <p class="text-xs text-slate-500 flex items-center gap-1.5 mt-0.5">
                                            <i class="fa-solid fa-user-tie text-slate-400 text-[11px]"></i>
                                            <span>Pembina: {{ $ekstra->pembinaEkstra->nama_guru ?? 'Belum ditentukan' }}</span>
                                        </p>
                                    </div>

                                    {{-- Status Badge --}}
                                    @if ($item->status === 'diterima')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 shrink-0">
                                            <i class="fa-solid fa-circle-check text-[11px]"></i>
                                            <span>Aktif / Diterima</span>
                                        </span>
                                    @elseif ($item->status === 'menunggu')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 shrink-0">
                                            <i class="fa-solid fa-clock text-[11px]"></i>
                                            <span>Menunggu Verifikasi</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800 shrink-0">
                                            <i class="fa-solid fa-circle-xmark text-[11px]"></i>
                                            <span>Ditolak</span>
                                        </span>
                                    @endif
                                </div>

                                <div class="p-3 bg-slate-50 rounded-xl space-y-1.5 text-xs text-slate-600">
                                    <div class="flex justify-between">
                                        <span class="text-slate-400">Tanggal Pengajuan:</span>
                                        <span class="font-medium text-slate-700">
                                            {{ \Carbon\Carbon::parse($item->tgl_registrasi)->translatedFormat('d F Y') }}
                                        </span>
                                    </div>
                                    @if ($item->alasan)
                                        <div class="flex flex-col gap-0.5 pt-1 border-t border-slate-200/60">
                                            <span class="text-slate-400 text-[11px]">Alasan Memilih:</span>
                                            <span class="font-normal text-slate-600 italic">"{{ $item->alasan }}"</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                                @if ($ekstra)
                                    <a href="{{ route('siswa.ekstrakurikuler.detail', $ekstra->id_ekstrakurikuler) }}"
                                        class="text-xs font-semibold text-brand-800 hover:text-brand-900 transition-colors inline-flex items-center gap-1">
                                        <span>Lihat Profil Ekskul</span>
                                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                    </a>
                                @endif

                                @if ($item->status === 'ditolak')
                                    <a href="{{ route('siswa.ekstrakurikuler.pendaftaran', ['pilih' => $item->id_ekstrakurikuler]) }}"
                                        class="text-xs font-bold text-brand-800 hover:underline">
                                        Daftar Ulang
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Seksi Nilai & Evaluasi Ekstrakurikuler --}}
        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm space-y-5">
            <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-award text-amber-500"></i>
                        <span>Nilai & Evaluasi Ekstrakurikuler</span>
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Catatan penilaian dari Pembina untuk rapor ekstrakurikuler</p>
                </div>
            </div>

            @if ($penilaianList->isEmpty())
                <div class="p-8 text-center bg-slate-50 rounded-2xl border border-slate-100">
                    <i class="fa-solid fa-clipboard-question text-slate-300 text-3xl mb-2"></i>
                    <p class="text-xs sm:text-sm font-semibold text-slate-700">Belum ada evaluasi nilai yang diterbitkan</p>
                    <p class="text-xs text-slate-400 mt-1">Nilai ekstrakurikuler akan diberikan oleh pembina pada akhir semester/tahun ajaran.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-600">
                        <thead class="bg-slate-50 text-slate-700 font-bold uppercase text-[10px] tracking-wider border-y border-slate-200">
                            <tr>
                                <th class="py-3 px-4">Ekstrakurikuler</th>
                                <th class="py-3 px-4">Tahun Ajaran</th>
                                <th class="py-3 px-4 text-center">Predikat / Nilai</th>
                                <th class="py-3 px-4">Tanggal Penilaian</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium">
                            @foreach ($penilaianList as $nilai)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="py-3.5 px-4 font-bold text-slate-900">
                                        {{ $nilai->ekstrakurikuler->nama_ekstrakurikuler ?? '-' }}
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-600">
                                        {{ $nilai->tahunAjaran->tahun_ajaran ?? '-' }} ({{ $nilai->tahunAjaran->semester ?? '-' }})
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl font-black text-sm bg-brand-50 text-brand-800 border border-brand-200">
                                            {{ $nilai->penilaian ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-400">
                                        {{ $nilai->tgl_penilaian ? \Carbon\Carbon::parse($nilai->tgl_penilaian)->translatedFormat('d M Y') : '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-siswa-layout>
