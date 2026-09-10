<x-app-guru-layout>
    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-900">Manajemen Ujian / CBT</h1>
                <p class="text-sm text-slate-500 mt-0.5">
                    Buat jadwal tes, kelola bank soal ujian, pantau token, dan tinjau pengumpulan nilai siswa.
                </p>
            </div>
            <div class="flex items-center gap-2 self-start sm:self-auto">
                <a href="{{ route('guru.dashboard.ujian.create_ujian') }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold bg-brand-800 text-white hover:bg-brand-900 transition-colors shadow-sm">
                    <i class="fa-solid fa-plus text-[11px]"></i>
                    <span>Buat Ujian Baru</span>
                </a>
                <a href="{{ route('guru.dashboard.ujian.pengumpulan') }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors shadow-sm">
                    <i class="fa-solid fa-square-poll-vertical text-slate-500 text-[11px]"></i>
                    <span>Hasil Siswa</span>
                </a>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between gap-3 text-xs">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        {{-- Table Card --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-slate-900 text-base">Daftar Paket Ujian</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Kelola paket tes, waktu pengerjaan, dan butir soal</p>
                </div>
                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600">
                    {{ $ujian->total() }} Paket Ujian
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-100 text-slate-500 uppercase tracking-wider text-[11px] font-semibold">
                            <th class="py-3.5 px-4 w-12 text-center">No</th>
                            <th class="py-3.5 px-4">Judul & Detail Ujian</th>
                            <th class="py-3.5 px-4">Kelas / Mapel</th>
                            <th class="py-3.5 px-4">Jadwal & Durasi</th>
                            <th class="py-3.5 px-4 text-center">Token Ujian</th>
                            <th class="py-3.5 px-4 text-center">Aksi Soal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($ujian as $index => $item)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                {{-- No --}}
                                <td class="py-3.5 px-4 text-center text-slate-400 font-medium">
                                    {{ $ujian->firstItem() + $index }}
                                </td>

                                {{-- Judul & Deskripsi --}}
                                <td class="py-3.5 px-4">
                                    <div class="font-bold text-slate-900 text-sm hover:text-brand-700 transition-colors">
                                        {{ $item->judul }}
                                    </div>
                                    @if ($item->deskripsi)
                                        <p class="text-[11px] text-slate-500 line-clamp-1 mt-0.5">{{ $item->deskripsi }}</p>
                                    @endif
                                    @if ($item->topik)
                                        <span class="inline-flex items-center gap-1 text-[10px] text-slate-400 mt-1">
                                            <i class="fa-solid fa-tag text-[9px]"></i>
                                            Topik: {{ $item->topik->judul_topik }}
                                        </span>
                                    @endif
                                </td>

                                {{-- Kelas / Mapel --}}
                                <td class="py-3.5 px-4">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-brand-50 text-brand-700 border border-brand-200/60 mb-1">
                                        Kelas {{ $item->kelasMataPelajaran->kelas->nama_kelas ?? '-' }}
                                    </span>
                                    <p class="text-[11px] text-slate-600 font-medium">
                                        {{ $item->kelasMataPelajaran->mataPelajaran->nama_matpel ?? '-' }}
                                    </p>
                                </td>

                                {{-- Jadwal & Durasi --}}
                                <td class="py-3.5 px-4 text-slate-600">
                                    @if ($item->waktu_mulai && $item->waktu_selesai)
                                        <p class="font-semibold text-slate-800">
                                            {{ \Carbon\Carbon::parse($item->waktu_mulai)->format('d M Y, H:i') }} WIB
                                        </p>
                                        <p class="text-[11px] text-slate-400 mt-0.5">
                                            Durasi: {{ $item->durasi_menit ?? 60 }} Menit
                                        </p>
                                    @else
                                        <p class="text-slate-500">
                                            Dibuat: {{ \Carbon\Carbon::parse($item->tanggal_dibuat ?? $item->created_at)->format('d M Y') }}
                                        </p>
                                        <p class="text-[11px] text-slate-400 mt-0.5">
                                            Durasi: {{ $item->durasi_menit ?? 60 }} Menit
                                        </p>
                                    @endif
                                </td>

                                {{-- Token Ujian --}}
                                <td class="py-3.5 px-4 text-center">
                                    @if ($item->token_ujian)
                                        <span class="inline-block px-2.5 py-1 rounded-lg bg-amber-50 text-amber-800 border border-amber-200/80 font-mono font-bold tracking-wider text-xs">
                                            {{ $item->token_ujian }}
                                        </span>
                                    @else
                                        <span class="text-slate-300 italic text-[11px]">Tanpa Token</span>
                                    @endif
                                </td>

                                {{-- Aksi Soal --}}
                                <td class="py-3.5 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="{{ route('guru.ujian.soal_ujian', $item->id_ujian) }}"
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 font-semibold transition-colors text-[11px]"
                                            title="Buka Bank Soal">
                                            <i class="fa-solid fa-list-ol text-[10px]"></i>
                                            <span>Soal</span>
                                        </a>
                                        <a href="{{ route('guru.ujian.add.soal', $item->id_ujian) }}"
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-brand-50 text-brand-700 hover:bg-brand-100 font-semibold transition-colors text-[11px]"
                                            title="Tambah Butir Soal">
                                            <i class="fa-solid fa-plus text-[10px]"></i>
                                            <span>Tambah</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-400 text-xs">
                                    Belum ada paket ujian yang dibuat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Footer --}}
            @if ($ujian->hasPages())
                <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $ujian->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-guru-layout>
