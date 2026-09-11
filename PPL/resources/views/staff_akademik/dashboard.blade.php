<x-staffakademik-layout>
    <div class="space-y-6 pb-10">

        {{-- Header & Breadcrumbs --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="space-y-1">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2 text-xs">
                        <li class="inline-flex items-center">
                            <span class="text-slate-500 flex items-center gap-1.5">
                                <i class="fa-solid fa-house text-[11px]"></i>
                                <span>Dashboard</span>
                            </span>
                        </li>
                        <li class="flex items-center text-slate-400">
                            <i class="fa-solid fa-chevron-right text-[10px] mx-1"></i>
                            <span class="text-slate-800 font-medium">Staff Akademik</span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Portal Manajemen Akademik</h1>
                <p class="text-xs text-slate-500">
                    Pusat operasional data pembelajaran, rombongan belajar, alokasi jadwal pelajaran, dan pengesahan prestasi sekolah.
                </p>
            </div>
        </div>

        {{-- Greeting / Info Banner (Flat Light Panel) --}}
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="space-y-2">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-brand-50 text-brand-800 border border-brand-200/60">
                            <i class="fa-solid fa-graduation-cap text-brand-700"></i>
                            Administrasi kurikulum
                        </span>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-[11px] font-medium bg-slate-100 text-slate-600 border border-slate-200">
                            Tahun ajaran aktif: 2024/2025
                        </span>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">
                        Selamat Datang, {{ $staff->nama_staff_akademik ?? 'Staff Akademik' }}
                    </h2>
                    <p class="text-xs md:text-sm text-slate-500 max-w-2xl leading-relaxed">
                        Kelola data rombongan belajar, susunan jadwal mingguan, pantau kelengkapan pengisian rapor, serta verifikasi laporan prestasi siswa secara terintegrasi.
                    </p>
                </div>

                <div class="shrink-0 bg-slate-50 rounded-lg p-4 border border-slate-200 text-left sm:text-right min-w-[210px] space-y-1">
                    <p class="text-[11px] text-slate-500 font-medium">Operator akademik</p>
                    <p class="text-sm font-bold text-slate-900">{{ $staff->nama_staff_akademik ?? 'Staff Akademik' }}</p>
                    <p class="text-xs text-slate-500 pt-1 flex items-center sm:justify-end gap-1.5 font-mono">
                        <i class="fa-solid fa-id-badge text-[11px]"></i>
                        {{ $staff->email ?? 'akademik@smpn2kamal.sch.id' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- 4 Standard KPI Stat Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Total Rombel / Kelas --}}
            <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500">Rombongan belajar</span>
                    <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-800 border border-brand-100/50 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-door-open"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-2xl font-bold text-slate-900 font-mono">{{ $totalKelas }}</p>
                    <p class="text-xs text-slate-500 mt-1">Kelas aktif terdaftar di sistem</p>
                </div>
            </div>

            {{-- Total Mata Pelajaran --}}
            <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500">Mata pelajaran</span>
                    <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-800 border border-brand-100/50 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-2xl font-bold text-slate-900 font-mono">{{ $totalMapel }}</p>
                    <p class="text-xs text-slate-500 mt-1">Mata pelajaran dalam kurikulum</p>
                </div>
            </div>

            {{-- Total Siswa --}}
            <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500">Siswa terdaftar</span>
                    <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-800 border border-brand-100/50 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-2xl font-bold text-slate-900 font-mono">{{ $totalSiswa }}</p>
                    <p class="text-xs text-slate-500 mt-1">Total peserta didik aktif</p>
                </div>
            </div>

            {{-- Total Prestasi --}}
            <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500">Prestasi tercatat</span>
                    <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-800 border border-brand-100/50 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-trophy"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="flex items-baseline gap-2">
                        <p class="text-2xl font-bold text-slate-900 font-mono">{{ $totalPrestasi }}</p>
                        @if ($pengajuanPending > 0)
                            <span class="text-xs font-medium text-amber-700 bg-amber-50 border border-amber-200 px-1.5 py-0.5 rounded">
                                {{ $pengajuanPending }} menanti
                            </span>
                        @endif
                    </div>
                    <p class="text-xs text-slate-500 mt-1">Penghargaan akademik & non-akademik</p>
                </div>
            </div>
        </div>

        {{-- Modul Manajemen Cepat --}}
        <div class="space-y-3">
            <div>
                <h2 class="text-sm font-bold text-slate-900">Modul Manajemen Akademik</h2>
                <p class="text-xs text-slate-500">Pilih layanan operasional akademik yang ingin dikelola</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Modul 1: Jadwal Pelajaran (Primary) --}}
                <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-lg bg-brand-50 text-brand-800 border border-brand-100/50 flex items-center justify-center text-base">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-900 text-sm">
                                Jadwal Pelajaran
                            </h3>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                Atur dan susun alokasi jam belajar mingguan untuk setiap rombel serta ekspor jadwal ke format PDF/Excel.
                            </p>
                        </div>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] font-medium text-slate-600 bg-slate-100 px-2 py-0.5 rounded">
                            Jadwal mingguan
                        </span>
                        <a href="{{ route('staff_akademik.jadwal.index') }}"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-brand-800 hover:bg-brand-900 text-white transition-colors">
                            <span>Kelola Jadwal</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>

                {{-- Modul 2: Rombongan Belajar & Siswa --}}
                <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-lg bg-brand-50 text-brand-800 border border-brand-100/50 flex items-center justify-center text-base">
                            <i class="fa-solid fa-users-rectangle"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-900 text-sm">
                                Rombel & Data Siswa
                            </h3>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                Kelola penetapan rombel kelas, pembagian wali kelas, dan pendaftaran anggota siswa per kelas.
                            </p>
                        </div>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] font-medium text-slate-600 bg-slate-100 px-2 py-0.5 rounded">
                            {{ $totalKelas }} Kelas
                        </span>
                        <a href="{{ route('staff_akademik.kelas.daftar') }}"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 transition-colors">
                            <span>Daftar Kelas</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>

                {{-- Modul 3: Mata Pelajaran & Guru --}}
                <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-lg bg-brand-50 text-brand-800 border border-brand-100/50 flex items-center justify-center text-base">
                            <i class="fa-solid fa-chalkboard-user"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-900 text-sm">
                                Guru Pengampu Mapel
                            </h3>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                Konfigurasi master kurikulum, mata pelajaran aktif, dan penugasan guru pengampu tiap mata pelajaran.
                            </p>
                        </div>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] font-medium text-slate-600 bg-slate-100 px-2 py-0.5 rounded">
                            {{ $totalMapel }} Mapel
                        </span>
                        <a href="{{ route('staff_akademik.guru-mata-pelajaran.index') }}"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 transition-colors">
                            <span>Atur Pengampu</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2 Kolom Ringkasan Data --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pt-1">
            {{-- Kolom 1: Daftar Rombel Kelas --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-door-open text-brand-800 text-xs"></i>
                        <h3 class="font-semibold text-slate-800 text-xs">Rombongan Belajar Aktif</h3>
                    </div>
                    <a href="{{ route('staff_akademik.kelas.daftar') }}" class="text-xs font-medium text-brand-800 hover:text-brand-900 transition-colors flex items-center gap-1">
                        Lihat semua
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </a>
                </div>
                <div class="divide-y divide-slate-100 text-xs">
                    @forelse ($daftarKelas as $itemKelas)
                        <div class="px-4 py-3 flex items-center justify-between hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-xs">
                                    {{ substr($itemKelas->nama_kelas, 0, 2) }}
                                </div>
                                <div>
                                    <p class="font-medium text-slate-900">{{ $itemKelas->nama_kelas }}</p>
                                    <p class="text-[11px] text-slate-400">SMPN 2 Kamal</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="px-2 py-0.5 rounded bg-slate-100 border border-slate-200 text-xs font-mono text-slate-700">
                                    {{ $itemKelas->siswa_count }} Siswa
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-slate-400 text-xs">
                            Belum ada data rombongan belajar.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Kolom 2: Prestasi & Pengajuan Siswa --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-trophy text-brand-800 text-xs"></i>
                        <h3 class="font-semibold text-slate-800 text-xs">Prestasi & Pengajuan Siswa</h3>
                    </div>
                    <a href="{{ route('staff_akademik.prestasi.index') }}" class="text-xs font-medium text-brand-800 hover:text-brand-900 transition-colors flex items-center gap-1">
                        Lihat semua
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </a>
                </div>
                <div class="divide-y divide-slate-100 text-xs">
                    @forelse ($prestasiTerbaru as $itemPrestasi)
                        <div class="px-4 py-3 flex items-center justify-between hover:bg-slate-50 transition-colors">
                            <div>
                                <p class="font-medium text-slate-900">{{ $itemPrestasi->nama_prestasi }}</p>
                                <p class="text-[11px] text-slate-400">
                                    {{ $itemPrestasi->siswa->nama_siswa ?? 'Siswa' }}
                                </p>
                            </div>
                            <div class="text-right">
                                @if (in_array(strtolower($itemPrestasi->status_prestasi ?? ''), ['disetujui', 'diterima', 'approved']))
                                    <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Disetujui
                                    </span>
                                @elseif (in_array(strtolower($itemPrestasi->status_prestasi ?? ''), ['menunggu', 'pending']))
                                    <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-amber-50 text-amber-700 border border-amber-200">
                                        Menunggu
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                        {{ $itemPrestasi->status_prestasi ?? 'Tersimpan' }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-slate-400 text-xs">
                            Belum ada catatan prestasi siswa.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</x-staffakademik-layout>

