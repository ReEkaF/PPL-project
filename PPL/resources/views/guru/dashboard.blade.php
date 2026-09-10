<x-app-guru-layout>
    <div class="max-w-7xl mx-auto space-y-6">

        {{-- 1. Hero Greeting Banner --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-brand-900 via-brand-800 to-brand-950 p-6 md:p-8 text-white shadow-lg">
            {{-- Decorative glow circles --}}
            <div class="absolute -right-10 -top-10 h-64 w-64 rounded-full bg-white/5 blur-2xl pointer-events-none"></div>
            <div class="absolute right-32 -bottom-10 h-48 w-48 rounded-full bg-brand-500/10 blur-xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="space-y-2">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white/15 text-white backdrop-blur-sm">
                            <i class="fa-solid fa-graduation-cap text-amber-400"></i>
                            Portal Pendidik SMPN 2 Kamal
                        </span>
                        @if ($kelasWali)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-200 border border-emerald-400/30">
                                <i class="fa-solid fa-user-check text-emerald-400"></i>
                                Wali Kelas {{ $kelasWali->nama_kelas }}
                            </span>
                        @endif
                        @if ($guru->role_guru === 'pembina')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/20 text-amber-200 border border-amber-400/30">
                                <i class="fa-solid fa-award text-amber-400"></i>
                                Pembina Ekskul
                            </span>
                        @endif
                    </div>
                    <h1 class="text-2xl md:text-3xl font-bold tracking-tight">
                        Selamat Datang, {{ $guru->nama_guru }}!
                    </h1>
                    <p class="text-sm md:text-base text-brand-100/90 max-w-2xl leading-relaxed">
                        Pantau jadwal mengajar hari ini, kelola materi pembelajaran, dan periksa penugasan siswa dengan mudah.
                    </p>
                </div>

                {{-- Date Info Box --}}
                <div class="shrink-0 bg-white/10 backdrop-blur-md rounded-xl p-4 border border-white/15 text-center sm:text-right min-w-[200px]">
                    <p class="text-xs uppercase tracking-wider text-brand-200 font-medium">Hari Ini</p>
                    <p class="text-lg md:text-xl font-bold text-white mt-0.5">
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </p>
                    <p class="text-xs text-brand-200/80 mt-1 flex items-center justify-center sm:justify-end gap-1.5">
                        <i class="fa-regular fa-clock text-[10px]"></i>
                        Tahun Ajaran Aktif
                    </p>
                </div>
            </div>
        </div>

        {{-- 2. KPI / Metrics Summary Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-5">

            {{-- Card 1: Mengajar Hari Ini --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500 uppercase tracking-wider">Jadwal Hari Ini</span>
                    <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center">
                        <i class="fa-solid fa-calendar-day text-base"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-2xl md:text-3xl font-bold text-slate-900">{{ $jadwalHariIni->count() }}</p>
                    <p class="text-xs text-slate-500 mt-1">
                        @if ($jadwalHariIni->count() > 0)
                            Kelas dijadwalkan hari <span class="font-medium text-brand-700">{{ $namaHariIni }}</span>
                        @else
                            Tidak ada jam mengajar hari ini
                        @endif
                    </p>
                </div>
            </div>

            {{-- Card 2: Total Kelas Diampu --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500 uppercase tracking-wider">Kelas Diampu</span>
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center">
                        <i class="fa-solid fa-chalkboard-user text-base"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-2xl md:text-3xl font-bold text-slate-900">{{ $totalKelas }}</p>
                    <p class="text-xs text-slate-500 mt-1">
                        {{ $totalJadwalSeminggu }} sesi mengajar per minggu
                    </p>
                </div>
            </div>

            {{-- Card 3: Materi Diterbitkan --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500 uppercase tracking-wider">Materi Aktif</span>
                    <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center">
                        <i class="fa-solid fa-book-open text-base"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-2xl md:text-3xl font-bold text-slate-900">{{ $totalMateri }}</p>
                    <p class="text-xs text-slate-500 mt-1">
                        Total bahan ajar LMS terpublikasi
                    </p>
                </div>
            </div>

            {{-- Card 4: Tugas Perlu Dinilai --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500 uppercase tracking-wider">Perlu Dinilai</span>
                    <div class="w-10 h-10 rounded-xl {{ $tugasPerluDinilai > 0 ? 'bg-amber-50 text-amber-600' : 'bg-emerald-50 text-emerald-600' }} flex items-center justify-center">
                        <i class="fa-solid {{ $tugasPerluDinilai > 0 ? 'fa-clipboard-question' : 'fa-clipboard-check' }} text-base"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="flex items-baseline gap-2">
                        <p class="text-2xl md:text-3xl font-bold {{ $tugasPerluDinilai > 0 ? 'text-amber-600' : 'text-slate-900' }}">
                            {{ $tugasPerluDinilai }}
                        </p>
                        <span class="text-xs font-medium text-slate-400">pengumpulan</span>
                    </div>
                    <p class="text-xs text-slate-500 mt-1">
                        @if ($tugasPerluDinilai > 0)
                            <span class="text-amber-600 font-medium">Menunggu penilaian guru</span>
                        @else
                            Semua tugas sudah diperiksa
                        @endif
                    </p>
                </div>
            </div>

        </div>

        {{-- 3. Main Dashboard Body: 2 Columns --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left Column (2 Cols on lg): Jadwal Hari Ini & Tugas Terbaru --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Jadwal Mengajar Hari Ini Section --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-700 flex items-center justify-center">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                            </div>
                            <div>
                                <h2 class="font-bold text-slate-900 text-base">Jadwal Mengajar Hari Ini</h2>
                                <p class="text-xs text-slate-500">Hari {{ $namaHariIni }} - Urut sesuai jam mulai</p>
                            </div>
                        </div>
                        <a href="{{ route('lihat-jadwal-guru') }}" class="text-xs font-semibold text-brand-700 hover:text-brand-800 transition-colors flex items-center gap-1">
                            Lihat Semua
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </a>
                    </div>

                    <div class="p-5">
                        @if ($jadwalHariIni->isNotEmpty())
                            <div class="divide-y divide-slate-100">
                                @foreach ($jadwalHariIni as $jadwal)
                                    <div class="py-3.5 first:pt-0 last:pb-0 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                        <div class="flex items-start gap-3.5">
                                            <div class="shrink-0 w-16 px-2 py-1.5 rounded-xl bg-slate-100 text-slate-700 text-center">
                                                <p class="text-xs font-bold">{{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }}</p>
                                                <p class="text-[10px] text-slate-500">{{ \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }}</p>
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <h3 class="font-semibold text-slate-900 text-sm">
                                                        {{ $jadwal->mataPelajaran->nama_matpel ?? 'Mata Pelajaran' }}
                                                    </h3>
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-brand-50 text-brand-700 border border-brand-200/60">
                                                        {{ $jadwal->kelas->nama_kelas ?? 'Kelas' }}
                                                    </span>
                                                </div>
                                                <p class="text-xs text-slate-500 mt-0.5 flex items-center gap-2">
                                                    <span><i class="fa-solid fa-location-dot text-slate-400 mr-1"></i> Ruang Kelas {{ $jadwal->kelas->nama_kelas ?? '-' }}</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2 shrink-0">
                                            <a href="{{ route('guru.absensi.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-brand-50 text-brand-700 hover:bg-brand-100 transition-colors">
                                                <i class="fa-solid fa-clipboard-user text-[11px]"></i>
                                                Presensi
                                            </a>
                                            <a href="{{ route('guru.dashboard.lms') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">
                                                <i class="fa-solid fa-graduation-cap text-[11px]"></i>
                                                LMS
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 px-4">
                                <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                    <i class="fa-solid fa-calendar-check text-xl"></i>
                                </div>
                                <h3 class="text-sm font-bold text-slate-800">Tidak Ada Jadwal Mengajar Hari Ini</h3>
                                <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1">
                                    Hari {{ $namaHariIni }} tidak memiliki jadwal tatap muka. Anda dapat menyiapkan materi atau memeriksa penugasan siswa.
                                </p>
                                <a href="{{ route('lihat-jadwal-guru') }}" class="inline-flex items-center gap-1.5 mt-4 px-4 py-2 rounded-xl text-xs font-semibold bg-brand-700 text-white hover:bg-brand-800 transition-colors shadow-sm">
                                    <i class="fa-solid fa-calendar-days"></i>
                                    Lihat Jadwal Mingguan
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Tugas Siswa Terbaru --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center">
                                <i class="fa-solid fa-list-check"></i>
                            </div>
                            <div>
                                <h2 class="font-bold text-slate-900 text-base">Penugasan Terkini</h2>
                                <p class="text-xs text-slate-500">Tugas aktif & jumlah pengumpulan siswa</p>
                            </div>
                        </div>
                        <a href="{{ route('guru.dashboard.lms.tugas.periksa') }}" class="text-xs font-semibold text-brand-700 hover:text-brand-800 transition-colors flex items-center gap-1">
                            Kelola Semua Tugas
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </a>
                    </div>

                    <div class="p-5">
                        @if ($tugasTerbaru->isNotEmpty())
                            <div class="divide-y divide-slate-100">
                                @foreach ($tugasTerbaru as $tugas)
                                    <div class="py-3.5 first:pt-0 last:pb-0 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <h3 class="font-semibold text-slate-900 text-sm hover:text-brand-700 transition-colors">
                                                    {{ $tugas->judul }}
                                                </h3>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium bg-slate-100 text-slate-700">
                                                    {{ $tugas->kelasMataPelajaran->kelas->nama_kelas ?? 'Kelas' }}
                                                </span>
                                            </div>
                                            <p class="text-xs text-slate-500 mt-1 flex flex-wrap items-center gap-3">
                                                <span>
                                                    <i class="fa-regular fa-clock text-slate-400 mr-1"></i>
                                                    Deadline: {{ \Carbon\Carbon::parse($tugas->deadline)->format('d M Y, H:i') }}
                                                </span>
                                                <span class="text-slate-300">•</span>
                                                <span class="font-medium text-brand-700">
                                                    <i class="fa-solid fa-users text-slate-400 mr-1"></i>
                                                    {{ $tugas->total_pengumpulan }} Siswa Mengumpulkan
                                                </span>
                                            </p>
                                        </div>
                                        <div class="shrink-0">
                                            <a href="{{ route('guru.dashboard.lms.tugas.periksa') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-brand-700 text-white hover:bg-brand-800 transition-colors shadow-sm">
                                                <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                                                Periksa Nilai
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-6 px-4">
                                <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2">
                                    <i class="fa-solid fa-clipboard-list text-lg"></i>
                                </div>
                                <p class="text-xs text-slate-500">Belum ada tugas yang dibuat untuk kelas yang diampu.</p>
                                <a href="{{ route('guru.dashboard.lms.tugas.periksa') }}" class="inline-flex items-center gap-1.5 mt-3 px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-brand-50 text-brand-700 hover:bg-brand-100 transition-colors">
                                    <i class="fa-solid fa-plus"></i>
                                    Buat Tugas Baru
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            {{-- Right Column (1 Col on lg): Quick Actions & Special Panels --}}
            <div class="space-y-6">

                {{-- Quick Actions Card --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-4">
                    <h2 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                        <i class="fa-solid fa-bolt text-amber-500"></i>
                        Aksi Cepat Pendidik
                    </h2>
                    <div class="grid grid-cols-1 gap-2">
                        <a href="{{ route('guru.absensi.index') }}" class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 hover:border-brand-300 hover:bg-brand-50/50 transition group">
                            <div class="w-9 h-9 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-brand-700 group-hover:text-white transition">
                                <i class="fa-solid fa-clipboard-user text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-slate-800 group-hover:text-brand-900">Isi Presensi Siswa</p>
                                <p class="text-[11px] text-slate-400">Catat kehadiran kelas hari ini</p>
                            </div>
                            <i class="fa-solid fa-chevron-right text-slate-300 text-xs group-hover:text-brand-600 group-hover:translate-x-0.5 transition"></i>
                        </a>

                        <a href="{{ route('guru.lms.materi.create-view') }}" class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 hover:border-brand-300 hover:bg-brand-50/50 transition group">
                            <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-brand-700 group-hover:text-white transition">
                                <i class="fa-solid fa-cloud-arrow-up text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-slate-800 group-hover:text-brand-900">Upload Materi Baru</p>
                                <p class="text-[11px] text-slate-400">Bagikan modul atau bahan ajar</p>
                            </div>
                            <i class="fa-solid fa-chevron-right text-slate-300 text-xs group-hover:text-brand-600 group-hover:translate-x-0.5 transition"></i>
                        </a>

                        <a href="{{ route('guru.dashboard.ujian.create_ujian') }}" class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 hover:border-brand-300 hover:bg-brand-50/50 transition group">
                            <div class="w-9 h-9 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center group-hover:bg-brand-700 group-hover:text-white transition">
                                <i class="fa-solid fa-file-circle-plus text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-slate-800 group-hover:text-brand-900">Buat Ujian / CBT</p>
                                <p class="text-[11px] text-slate-400">Jadwalkan kuis atau ulangan</p>
                            </div>
                            <i class="fa-solid fa-chevron-right text-slate-300 text-xs group-hover:text-brand-600 group-hover:translate-x-0.5 transition"></i>
                        </a>
                    </div>
                </div>

                {{-- Wali Kelas Box (If applicable) --}}
                @if ($kelasWali)
                    <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-2xl border border-emerald-200/80 p-5 shadow-sm space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-600 text-white">
                                <i class="fa-solid fa-user-shield text-[10px]"></i>
                                Wali Kelas
                            </span>
                            <span class="text-xs font-medium text-emerald-700">{{ $jumlahSiswaWali }} Siswa</span>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Kelas {{ $kelasWali->nama_kelas }}</h3>
                            <p class="text-xs text-slate-600 mt-0.5">
                                Pantau data siswa perwalian, kehadiran, dan koordinasi dengan orang tua.
                            </p>
                        </div>
                        <a href="{{ route('guru.daftarSiswaWali') }}" class="inline-flex items-center justify-center gap-2 w-full px-4 py-2 rounded-xl text-xs font-semibold bg-emerald-700 text-white hover:bg-emerald-800 transition-colors shadow-sm">
                            <i class="fa-solid fa-users-viewfinder"></i>
                            Buka Daftar Siswa Wali
                        </a>
                    </div>
                @endif

                {{-- Pembina Ekstrakurikuler Box (If applicable) --}}
                @if (($guru->role_guru === 'pembina' || $guru->ekstrakurikuler()->exists()) && $ekskulBinaan->isNotEmpty())
                    <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl border border-amber-200/80 p-5 shadow-sm space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-600 text-white">
                                <i class="fa-solid fa-award text-[10px]"></i>
                                Pembina Ekskul
                            </span>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">
                                {{ $ekskulBinaan->pluck('nama_ekstrakurikuler')->implode(', ') }}
                            </h3>
                            <p class="text-xs text-slate-600 mt-0.5">
                                Akses penilaian nilai rapor siswa, evaluasi data anggota, dan pengelolaan perlengkapan.
                            </p>
                        </div>
                        <a href="{{ route('pembina.index') }}" class="inline-flex items-center justify-center gap-2 w-full px-4 py-2 rounded-xl text-xs font-semibold bg-amber-700 text-white hover:bg-amber-800 transition-colors shadow-sm">
                            <i class="fa-solid fa-people-group"></i>
                            Buka Portal Ekstrakurikuler
                        </a>
                    </div>
                @endif

                {{-- Materi Terakhir Diunggah --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-3">
                    <div class="flex items-center justify-between">
                        <h2 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                            <i class="fa-solid fa-book text-brand-700"></i>
                            Materi Terakhir
                        </h2>
                        <a href="{{ route('guru.dashboard.lms.materi') }}" class="text-[11px] font-semibold text-brand-700 hover:text-brand-800">
                            Semua
                        </a>
                    </div>

                    @if ($materiTerbaru->isNotEmpty())
                        <div class="space-y-2.5">
                            @foreach ($materiTerbaru as $materi)
                                <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100 flex items-start gap-2.5">
                                    <div class="w-7 h-7 rounded-lg bg-brand-50 text-brand-700 flex items-center justify-center shrink-0 mt-0.5">
                                        <i class="fa-regular fa-file-lines text-xs"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-semibold text-slate-800 truncate">{{ $materi->judul_materi }}</p>
                                        <p class="text-[10px] text-slate-400 mt-0.5 truncate">
                                            {{ $materi->kelasMataPelajaran->kelas->nama_kelas ?? 'Kelas' }} • {{ \Carbon\Carbon::parse($materi->created_at)->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-slate-400 py-3 text-center">Belum ada materi pembelajaran yang diunggah.</p>
                    @endif
                </div>

            </div>

        </div>

    </div>
</x-app-guru-layout>
