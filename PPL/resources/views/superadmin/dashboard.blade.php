<x-admin-layout>
    <div class="space-y-6">
        <!-- Header Banner Institusi -->
        <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-sky-50 border border-sky-200/70 text-xs font-semibold text-sky-800 mb-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Sistem Terpusat SMP Negeri 2 Kamal
                    </div>
                    <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Pusat Kendali Superadmin</h1>
                    <p class="text-sm text-slate-500 mt-1">Kelola direktori pengguna, otentikasi multi-peran, dan hak akses civitas akademika.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('superadmin.profile') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Pengaturan Akun</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Metric Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
            <!-- Guru -->
            <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm hover:border-sky-300 transition-colors">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Tenaga Pendidik</span>
                    <span class="w-9 h-9 rounded-lg bg-sky-50 text-sky-700 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                        </svg>
                    </span>
                </div>
                <div class="mt-3">
                    <span class="text-3xl font-bold text-slate-900">{{ $stats['totalGuru'] ?? 0 }}</span>
                    <p class="text-xs text-slate-500 mt-1">Guru pengajar aktif terdata</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100">
                    <a href="{{ route('superadmin.keloladataguru') }}" class="text-xs font-medium text-sky-700 hover:text-sky-900 inline-flex items-center gap-1">
                        Kelola data guru &rarr;
                    </a>
                </div>
            </div>

            <!-- Siswa -->
            <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm hover:border-sky-300 transition-colors">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Peserta Didik</span>
                    <span class="w-9 h-9 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </span>
                </div>
                <div class="mt-3">
                    <span class="text-3xl font-bold text-slate-900">{{ $stats['totalSiswa'] ?? 0 }}</span>
                    <p class="text-xs text-slate-500 mt-1">Siswa terdaftar di sistem</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100">
                    <a href="{{ route('superadmin.keloladatasiswa') }}" class="text-xs font-medium text-emerald-700 hover:text-emerald-900 inline-flex items-center gap-1">
                        Kelola data siswa &rarr;
                    </a>
                </div>
            </div>

            <!-- Tenaga Kependidikan -->
            <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm hover:border-sky-300 transition-colors">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Staf Kependidikan</span>
                    <span class="w-9 h-9 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </span>
                </div>
                <div class="mt-3">
                    <span class="text-3xl font-bold text-slate-900">{{ ($stats['totalStaffAkademik'] ?? 0) + ($stats['totalStaffPerpus'] ?? 0) }}</span>
                    <p class="text-xs text-slate-500 mt-1">{{ $stats['totalStaffAkademik'] ?? 0 }} Akademik • {{ $stats['totalStaffPerpus'] ?? 0 }} Perpustakaan</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100">
                    <a href="{{ route('superadmin.kelola_staff_akademik') }}" class="text-xs font-medium text-amber-700 hover:text-amber-900 inline-flex items-center gap-1">
                        Kelola staf sekolah &rarr;
                    </a>
                </div>
            </div>

            <!-- Ekstrakurikuler -->
            <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm hover:border-sky-300 transition-colors">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Pembina & Pengurus</span>
                    <span class="w-9 h-9 rounded-lg bg-violet-50 text-violet-700 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </span>
                </div>
                <div class="mt-3">
                    <span class="text-3xl font-bold text-slate-900">{{ ($stats['totalPembina'] ?? 0) + ($stats['totalPengurus'] ?? 0) }}</span>
                    <p class="text-xs text-slate-500 mt-1">{{ $stats['totalPembina'] ?? 0 }} Pembina • {{ $stats['totalPengurus'] ?? 0 }} Pengurus</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100">
                    <a href="{{ route('superadmin.kelola_pembina_ekstrakurikuler') }}" class="text-xs font-medium text-violet-700 hover:text-violet-900 inline-flex items-center gap-1">
                        Kelola organisasi &rarr;
                    </a>
                </div>
            </div>
        </div>

        <!-- Navigasi Akses Cepat Kelola Akun -->
        <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
            <h2 class="text-base font-semibold text-slate-900 mb-1">Akses Cepat Pengelolaan Akun</h2>
            <p class="text-xs text-slate-500 mb-5">Pilih modul untuk menambah, memperbarui, atau mereset kredensial pengguna.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Guru -->
                <a href="{{ route('superadmin.keloladataguru') }}" class="group p-4 border border-slate-200 rounded-lg hover:border-sky-400 hover:bg-sky-50/30 transition-all flex items-start gap-3">
                    <div class="p-2.5 rounded-lg bg-sky-100/70 text-sky-800 group-hover:bg-sky-700 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-slate-800 group-hover:text-sky-900">Kelola Data Guru</div>
                        <p class="text-xs text-slate-500 mt-1">Data NIP, akun, password, dan penetapan peran pengajar.</p>
                    </div>
                </a>

                <!-- Siswa -->
                <a href="{{ route('superadmin.keloladatasiswa') }}" class="group p-4 border border-slate-200 rounded-lg hover:border-emerald-400 hover:bg-emerald-50/30 transition-all flex items-start gap-3">
                    <div class="p-2.5 rounded-lg bg-emerald-100/70 text-emerald-800 group-hover:bg-emerald-700 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-slate-800 group-hover:text-emerald-900">Kelola Data Siswa</div>
                        <p class="text-xs text-slate-500 mt-1">Data NISN, kelas, kontak wali, dan reset password siswa.</p>
                    </div>
                </a>

                <!-- Staff Akademik -->
                <a href="{{ route('superadmin.kelola_staff_akademik') }}" class="group p-4 border border-slate-200 rounded-lg hover:border-indigo-400 hover:bg-indigo-50/30 transition-all flex items-start gap-3">
                    <div class="p-2.5 rounded-lg bg-indigo-100/70 text-indigo-800 group-hover:bg-indigo-700 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-slate-800 group-hover:text-indigo-900">Staff Akademik</div>
                        <p class="text-xs text-slate-500 mt-1">Hak akses penjadwalan, kelas, rombel, dan e-rapor.</p>
                    </div>
                </a>

                <!-- Staff Perpus -->
                <a href="{{ route('superadmin.kelola_staff_perpus') }}" class="group p-4 border border-slate-200 rounded-lg hover:border-amber-400 hover:bg-amber-50/30 transition-all flex items-start gap-3">
                    <div class="p-2.5 rounded-lg bg-amber-100/70 text-amber-800 group-hover:bg-amber-700 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-slate-800 group-hover:text-amber-900">Staff Perpustakaan</div>
                        <p class="text-xs text-slate-500 mt-1">Hak sirkulasi buku, katalog, denda, dan laporan perpus.</p>
                    </div>
                </a>

                <!-- Pembina Ekstra -->
                <a href="{{ route('superadmin.kelola_pembina_ekstrakurikuler') }}" class="group p-4 border border-slate-200 rounded-lg hover:border-purple-400 hover:bg-purple-50/30 transition-all flex items-start gap-3">
                    <div class="p-2.5 rounded-lg bg-purple-100/70 text-purple-800 group-hover:bg-purple-700 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-slate-800 group-hover:text-purple-900">Pembina Ekstra</div>
                        <p class="text-xs text-slate-500 mt-1">Penugasan guru pendamping dan penilaian kegiatan ekskul.</p>
                    </div>
                </a>

                <!-- Pengurus Ekstra -->
                <a href="{{ route('superadmin.keloladatapengurus') }}" class="group p-4 border border-slate-200 rounded-lg hover:border-rose-400 hover:bg-rose-50/30 transition-all flex items-start gap-3">
                    <div class="p-2.5 rounded-lg bg-rose-100/70 text-rose-800 group-hover:bg-rose-700 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-slate-800 group-hover:text-rose-900">Pengurus Ekstra</div>
                        <p class="text-xs text-slate-500 mt-1">Registrasi siswa pengurus dan inventaris perlengkapan.</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-admin-layout>