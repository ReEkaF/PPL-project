<x-app-guru-layout>
    <div class="max-w-6xl mx-auto space-y-6" x-data="{ search: '' }">

        {{-- Page Header --}}
        <div>
            <a href="{{ route('guru.dashboard.lms.tugas.periksa') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-700 hover:text-brand-800 transition-colors mb-2">
                <i class="fa-solid fa-arrow-left text-[11px]"></i>
                <span>Kembali ke Daftar Periksa Tugas</span>
            </a>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="flex flex-wrap items-center gap-2">
                        <h1 class="text-xl font-bold text-slate-900">{{ $tugas->judul }}</h1>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-brand-50 text-brand-700 border border-brand-200/60">
                            Kelas {{ $kelas->nama_kelas ?? '-' }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 mt-1 flex items-center gap-2">
                        <i class="fa-regular fa-clock text-slate-400"></i>
                        <span>Tenggat: {{ \Carbon\Carbon::parse($tugas->deadline)->translatedFormat('l, d F Y, H:i') }} WIB</span>
                    </p>
                </div>
            </div>
        </div>

        {{-- KPI Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-users text-base"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Total Siswa</p>
                    <p class="text-lg font-bold text-slate-900">{{ $siswaList->count() }} Siswa</p>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-file-arrow-up text-base"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Sudah Menyerahkan</p>
                    <p class="text-lg font-bold text-blue-700">{{ $diserahkan }} Siswa</p>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-user-clock text-base"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Belum Menyerahkan</p>
                    <p class="text-lg font-bold text-amber-700">{{ $belumDiserahkan }} Siswa</p>
                </div>
            </div>
        </div>

        {{-- Submissions Table Card --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            
            <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="font-bold text-slate-900 text-base">Daftar Pengumpulan Siswa</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Kelola dan input nilai hasil pengerjaan tugas</p>
                </div>

                <div class="relative w-full sm:w-64">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" x-model="search"
                        placeholder="Cari nama siswa..."
                        class="w-full pl-9 pr-4 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all text-slate-800 placeholder-slate-400">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-100 text-slate-500 uppercase tracking-wider text-[11px] font-semibold">
                            <th class="py-3.5 px-4 w-12 text-center">No</th>
                            <th class="py-3.5 px-4">Nama Siswa</th>
                            <th class="py-3.5 px-4">Status Pengumpulan</th>
                            <th class="py-3.5 px-4">Waktu Penyerahan</th>
                            <th class="py-3.5 px-4 text-center">Nilai</th>
                            <th class="py-3.5 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($siswaList as $index => $siswa)
                            @php
                                $pengumpulan = $pengumpulanTugas->firstWhere('siswa_id', $siswa->id_siswa);
                                $isSubmitted = !is_null($pengumpulan);
                                $isLate = $pengumpulan && str_contains(strtolower($pengumpulan->status ?? ''), 'terlambat');
                                $isGraded = $pengumpulan && !is_null($pengumpulan->nilai);
                            @endphp
                            <tr class="hover:bg-slate-50/70 transition-colors"
                                x-show="!search || '{{ strtolower($siswa->nama_siswa) }}'.includes(search.toLowerCase())">
                                
                                <td class="py-3 px-4 text-center text-slate-400 font-medium">
                                    {{ $index + 1 }}
                                </td>

                                <td class="py-3 px-4">
                                    <div class="font-semibold text-slate-900">{{ $siswa->nama_siswa }}</div>
                                    <div class="text-[11px] text-slate-400 font-mono">{{ $siswa->nisn ?? '-' }}</div>
                                </td>

                                <td class="py-3 px-4">
                                    @if ($isSubmitted)
                                        @if ($isLate)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                                <i class="fa-regular fa-clock text-[9px]"></i> Terlambat
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <i class="fa-solid fa-check text-[9px]"></i> Tepat Waktu
                                            </span>
                                        @endif
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-medium bg-slate-100 text-slate-500">
                                            Belum Menyerahkan
                                        </span>
                                    @endif
                                </td>

                                <td class="py-3 px-4 text-slate-500 text-[11px]">
                                    @if ($pengumpulan && !empty($pengumpulan->tanggal_pengumpulan))
                                        {{ \Carbon\Carbon::parse($pengumpulan->tanggal_pengumpulan)->format('d/m/Y, H:i') }} WIB
                                    @else
                                        <span class="text-slate-300">-</span>
                                    @endif
                                </td>

                                <td class="py-3 px-4 text-center">
                                    @if ($isGraded)
                                        <span class="font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-200 text-xs">
                                            {{ $pengumpulan->nilai }} / 100
                                        </span>
                                    @elseif ($isSubmitted)
                                        <span class="text-amber-700 bg-amber-50 px-2.5 py-1 rounded-lg border border-amber-200 font-semibold text-[11px]">
                                            Perlu Dinilai
                                        </span>
                                    @else
                                        <span class="text-slate-300">-</span>
                                    @endif
                                </td>

                                <td class="py-3 px-4 text-center">
                                    @if ($isSubmitted)
                                        <a href="{{ route('guru.dashboard.lms.tugas.siswa.detail', $pengumpulan->id_pengumpulan_tugas) }}"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-brand-50 text-brand-700 hover:bg-brand-100 font-semibold transition-colors">
                                            <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                            <span>Koreksi</span>
                                        </a>
                                    @else
                                        <span class="text-slate-300 text-xs italic">Menunggu</span>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</x-app-guru-layout>
