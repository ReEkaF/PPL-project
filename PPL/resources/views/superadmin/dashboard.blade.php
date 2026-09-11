<x-admin-layout>
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
                            <span class="text-slate-800 font-medium">Superadmin</span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Pusat Kendali Superadmin</h1>
                <p class="text-xs text-slate-500">
                    Pusat manajemen hak akses pengguna, pemeliharaan akun civitas akademika, dan integrasi otentikasi multi-peran.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('superadmin.profile') }}" class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-medium text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 rounded-lg transition-colors shadow-sm">
                    <i class="fa-solid fa-gear text-slate-400 text-xs"></i>
                    <span>Pengaturan Akun</span>
                </a>
            </div>
        </div>

        {{-- Greeting / Status Panel (Flat Light Panel) --}}
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="space-y-2">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-brand-50 text-brand-800 border border-brand-200/60">
                            <i class="fa-solid fa-shield-halved text-brand-700"></i>
                            Hak akses tingkat tertinggi
                        </span>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-[11px] font-medium bg-slate-100 text-slate-600 border border-slate-200">
                            Sistem Siap Operasi
                        </span>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">
                        Ringkasan Pengguna & Direktori Civitas
                    </h2>
                    <p class="text-xs md:text-sm text-slate-500 max-w-2xl leading-relaxed">
                        Pantau seluruh entitas akun sekolah dari dewan guru, peserta didik, tenaga kependidikan akademik & perpustakaan, hingga kepengurusan ekstrakurikuler.
                    </p>
                </div>

                <div class="shrink-0 bg-slate-50 rounded-lg p-4 border border-slate-200 text-left sm:text-right min-w-[210px] space-y-1">
                    <p class="text-[11px] text-slate-500 font-medium">Administrator utama</p>
                    <p class="text-sm font-bold text-slate-900">Super Administrator</p>
                    <p class="text-xs text-slate-500 pt-1 flex items-center sm:justify-end gap-1.5 font-mono">
                        <i class="fa-solid fa-server text-[11px]"></i>
                        SMPN 2 Kamal Sistem
                    </p>
                </div>
            </div>
        </div>

        {{-- 4 Standard Metric KPI Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Tenaga Pendidik (Guru) --}}
            <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500">Tenaga pendidik</span>
                    <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-800 border border-brand-100/50 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-chalkboard-user"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-2xl font-bold text-slate-900 font-mono">{{ $stats['totalGuru'] ?? 0 }}</p>
                    <p class="text-xs text-slate-500 mt-1">Guru pengajar aktif terdata</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100">
                    <a href="{{ route('superadmin.keloladataguru') }}" class="text-xs font-medium text-brand-800 hover:text-brand-900 inline-flex items-center gap-1 transition-colors">
                        <span>Kelola data guru</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>

            {{-- Peserta Didik (Siswa) --}}
            <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500">Peserta didik</span>
                    <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-800 border border-brand-100/50 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-2xl font-bold text-slate-900 font-mono">{{ $stats['totalSiswa'] ?? 0 }}</p>
                    <p class="text-xs text-slate-500 mt-1">Siswa terdaftar di sistem</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100">
                    <a href="{{ route('superadmin.keloladatasiswa') }}" class="text-xs font-medium text-brand-800 hover:text-brand-900 inline-flex items-center gap-1 transition-colors">
                        <span>Kelola data siswa</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>

            {{-- Staf Kependidikan --}}
            <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500">Staf kependidikan</span>
                    <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-800 border border-brand-100/50 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-id-card-clip"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-2xl font-bold text-slate-900 font-mono">{{ ($stats['totalStaffAkademik'] ?? 0) + ($stats['totalStaffPerpus'] ?? 0) }}</p>
                    <p class="text-xs text-slate-500 mt-1 font-mono text-[11px]">{{ $stats['totalStaffAkademik'] ?? 0 }} Akademik • {{ $stats['totalStaffPerpus'] ?? 0 }} Perpus</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100">
                    <a href="{{ route('superadmin.kelola_staff_akademik') }}" class="text-xs font-medium text-brand-800 hover:text-brand-900 inline-flex items-center gap-1 transition-colors">
                        <span>Kelola staf sekolah</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>

            {{-- Pembina & Pengurus Ekstra --}}
            <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500">Pembina & pengurus</span>
                    <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-800 border border-brand-100/50 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-award"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-2xl font-bold text-slate-900 font-mono">{{ ($stats['totalPembina'] ?? 0) + ($stats['totalPengurus'] ?? 0) }}</p>
                    <p class="text-xs text-slate-500 mt-1 font-mono text-[11px]">{{ $stats['totalPembina'] ?? 0 }} Pembina • {{ $stats['totalPengurus'] ?? 0 }} Pengurus</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100">
                    <a href="{{ route('superadmin.kelola_pembina_ekstrakurikuler') }}" class="text-xs font-medium text-brand-800 hover:text-brand-900 inline-flex items-center gap-1 transition-colors">
                        <span>Kelola organisasi</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Navigasi Akses Cepat Kelola Akun --}}
        <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm space-y-4">
            <div>
                <h2 class="text-sm font-bold text-slate-900">Direktori Akses Pengelolaan Akun</h2>
                <p class="text-xs text-slate-500">Pilih modul pengguna untuk memperbarui data induk, hak akses, atau mereset kata sandi</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                {{-- Card Guru --}}
                <a href="{{ route('superadmin.keloladataguru') }}" class="group p-4 border border-slate-200 rounded-xl hover:border-brand-300 hover:bg-slate-50 transition-all flex items-start gap-3.5 bg-white">
                    <div class="w-10 h-10 rounded-lg bg-brand-50 text-brand-800 border border-brand-100/50 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-chalkboard-user text-base"></i>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-slate-900 group-hover:text-brand-800 transition-colors">Kelola Data Guru</div>
                        <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Data NIP, akun, kata sandi, dan penetapan peran pengajar.</p>
                    </div>
                </a>

                {{-- Card Siswa --}}
                <a href="{{ route('superadmin.keloladatasiswa') }}" class="group p-4 border border-slate-200 rounded-xl hover:border-brand-300 hover:bg-slate-50 transition-all flex items-start gap-3.5 bg-white">
                    <div class="w-10 h-10 rounded-lg bg-brand-50 text-brand-800 border border-brand-100/50 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-user-graduate text-base"></i>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-slate-900 group-hover:text-brand-800 transition-colors">Kelola Data Siswa</div>
                        <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Data NISN, kelas, kontak wali, dan reset kata sandi siswa.</p>
                    </div>
                </a>

                {{-- Card Staff Akademik --}}
                <a href="{{ route('superadmin.kelola_staff_akademik') }}" class="group p-4 border border-slate-200 rounded-xl hover:border-brand-300 hover:bg-slate-50 transition-all flex items-start gap-3.5 bg-white">
                    <div class="w-10 h-10 rounded-lg bg-brand-50 text-brand-800 border border-brand-100/50 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-graduation-cap text-base"></i>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-slate-900 group-hover:text-brand-800 transition-colors">Staff Akademik</div>
                        <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Hak akses penjadwalan, kelas, rombel, dan e-rapor.</p>
                    </div>
                </a>

                {{-- Card Staff Perpus --}}
                <a href="{{ route('superadmin.kelola_staff_perpus') }}" class="group p-4 border border-slate-200 rounded-xl hover:border-brand-300 hover:bg-slate-50 transition-all flex items-start gap-3.5 bg-white">
                    <div class="w-10 h-10 rounded-lg bg-brand-50 text-brand-800 border border-brand-100/50 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-book-bookmark text-base"></i>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-slate-900 group-hover:text-brand-800 transition-colors">Staff Perpustakaan</div>
                        <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Hak sirkulasi buku, katalog, denda, dan laporan perpus.</p>
                    </div>
                </a>

                {{-- Card Pembina Ekstra --}}
                <a href="{{ route('superadmin.kelola_pembina_ekstrakurikuler') }}" class="group p-4 border border-slate-200 rounded-xl hover:border-brand-300 hover:bg-slate-50 transition-all flex items-start gap-3.5 bg-white">
                    <div class="w-10 h-10 rounded-lg bg-brand-50 text-brand-800 border border-brand-100/50 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-award text-base"></i>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-slate-900 group-hover:text-brand-800 transition-colors">Pembina Ekstra</div>
                        <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Penugasan guru pendamping dan penilaian kegiatan ekskul.</p>
                    </div>
                </a>

                {{-- Card Pengurus Ekstra --}}
                <a href="{{ route('superadmin.keloladatapengurus') }}" class="group p-4 border border-slate-200 rounded-xl hover:border-brand-300 hover:bg-slate-50 transition-all flex items-start gap-3.5 bg-white">
                    <div class="w-10 h-10 rounded-lg bg-brand-50 text-brand-800 border border-brand-100/50 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-users text-base"></i>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-slate-900 group-hover:text-brand-800 transition-colors">Pengurus Ekstra</div>
                        <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Registrasi siswa pengurus dan inventaris perlengkapan.</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-admin-layout>