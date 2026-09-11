<x-app-guru-layout>
    <div class="max-w-7xl mx-auto space-y-6">

        {{-- 1. Hero Greeting Panel (Option A: Clean Flat Light Theme) --}}
        <div class="bg-white border border-slate-200 rounded-xl p-6 sm:p-7">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="space-y-1.5">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-xs font-semibold bg-brand-50 text-brand-800 border border-brand-200">
                            Portal Pendidik SMPN 2 Kamal
                        </span>
                        @if ($kelasWali)
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                Wali Kelas {{ $kelasWali->nama_kelas }}
                            </span>
                        @endif
                        @if ($guru->role_guru === 'pembina')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                Pembina Ekstrakurikuler
                            </span>
                        @endif
                    </div>
                    <h1 class="text-2xl md:text-3xl font-bold tracking-tight text-slate-900">
                        Selamat Datang, {{ $guru->nama_guru }}
                    </h1>
                    <p class="text-xs md:text-sm text-slate-500 max-w-2xl leading-relaxed">
                        Pantau jadwal mengajar hari ini, kelola materi pembelajaran, dan periksa penugasan siswa dengan mudah.
                    </p>
                </div>

                {{-- Date Info Box --}}
                <div class="shrink-0 bg-slate-50 border border-slate-200 rounded-lg p-3.5 text-center sm:text-right min-w-[200px]">
                    <p class="text-xs font-medium text-slate-500">Hari ini</p>
                    <p class="text-base md:text-lg font-bold text-slate-900 mt-0.5">
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </p>
                    <p class="text-xs text-slate-500 mt-1">
                        Tahun Ajaran Aktif
                    </p>
                </div>
            </div>
        </div>

        {{-- 2. KPI / Metrics Summary Cards (Standardized per design.md) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-5">

            {{-- Card 1: Mengajar Hari Ini --}}
            <div class="bg-white rounded-xl border border-slate-200 p-5 hover:border-brand-700 transition group">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500">Jadwal hari ini</span>
                    <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-800 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-calendar-day text-sm"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <p class="text-2xl sm:text-3xl font-extrabold text-slate-900 tabular-nums">{{ $jadwalHariIni->count() }}</p>
                    <p class="text-xs text-slate-500 mt-1">
                        @if ($jadwalHariIni->count() > 0)
                            Kelas terjadwal hari {{ $namaHariIni }}
                        @else
                            Tidak ada jam mengajar hari ini
                        @endif
                    </p>
                </div>
            </div>

            {{-- Card 2: Total Kelas Diampu --}}
            <div class="bg-white rounded-xl border border-slate-200 p-5 hover:border-brand-700 transition group">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500">Kelas diampu</span>
                    <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-800 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-chalkboard-user text-sm"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <p class="text-2xl sm:text-3xl font-extrabold text-slate-900 tabular-nums">{{ $totalKelas }}</p>
                    <p class="text-xs text-slate-500 mt-1">
                        {{ $totalJadwalSeminggu }} sesi mengajar per minggu
                    </p>
                </div>
            </div>

            {{-- Card 3: Materi Diterbitkan --}}
            <div class="bg-white rounded-xl border border-slate-200 p-5 hover:border-brand-700 transition group">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500">Materi aktif</span>
                    <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-800 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-book-open text-sm"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <p class="text-2xl sm:text-3xl font-extrabold text-slate-900 tabular-nums">{{ $totalMateri }}</p>
                    <p class="text-xs text-slate-500 mt-1">
                        Total modul LMS terpublikasi
                    </p>
                </div>
            </div>

            {{-- Card 4: Tugas Perlu Dinilai --}}
            <div class="bg-white rounded-xl border border-slate-200 p-5 hover:border-brand-700 transition group">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500">Tugas perlu dinilai</span>
                    <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-800 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-clipboard-check text-sm"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <p class="text-2xl sm:text-3xl font-extrabold text-slate-900 tabular-nums">
                        {{ $tugasPerluDinilai }}
                    </p>
                    <p class="text-xs text-slate-500 mt-1">
                        @if ($tugasPerluDinilai > 0)
                            <span class="text-amber-700 font-medium">Menunggu pemeriksaan</span>
                        @else
                            Seluruh pengumpulan telah dinilai
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
                <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                    <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h2 class="font-bold text-slate-900 text-base">Jadwal Mengajar Hari Ini</h2>
                            <p class="text-xs text-slate-500 mt-0.5">Hari {{ $namaHariIni }} · Berdasarkan jam mulai</p>
                        </div>
                        <a href="{{ route('lihat-jadwal-guru') }}" class="text-xs font-semibold text-brand-800 hover:underline">
                            Lihat Semua →
                        </a>
                    </div>

                    <div class="p-5">
                        @if ($jadwalHariIni->isNotEmpty())
                            <div class="divide-y divide-slate-100">
                                @foreach ($jadwalHariIni as $jadwal)
                                    <div class="py-3.5 first:pt-0 last:pb-0 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                        <div class="flex items-start gap-3.5">
                                            <div class="shrink-0 w-16 px-2 py-1.5 rounded-lg bg-slate-100 text-slate-700 text-center">
                                                <p class="text-xs font-bold tabular-nums">{{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }}</p>
                                                <p class="text-[10px] text-slate-500 tabular-nums">{{ \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }}</p>
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <h3 class="font-semibold text-slate-900 text-sm">
                                                        {{ $jadwal->mataPelajaran->nama_matpel ?? 'Mata Pelajaran' }}
                                                    </h3>
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-brand-50 text-brand-800 border border-brand-200">
                                                        {{ $jadwal->kelas->nama_kelas ?? 'Kelas' }}
                                                    </span>
                                                </div>
                                                <p class="text-xs text-slate-500 mt-0.5">
                                                    Ruang Kelas {{ $jadwal->kelas->nama_kelas ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2 shrink-0">
                                            <a href="{{ route('guru.absensi.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-brand-50 text-brand-800 hover:bg-brand-100 transition-colors">
                                                Presensi
                                            </a>
                                            <a href="{{ route('guru.dashboard.lms') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">
                                                LMS
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 px-4">
                                <h3 class="text-sm font-bold text-slate-800">Tidak Ada Jadwal Mengajar Hari Ini</h3>
                                <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1">
                                    Hari {{ $namaHariIni }} tidak memiliki jadwal tatap muka. Anda dapat menyiapkan materi atau memeriksa penugasan siswa.
                                </p>
                                <a href="{{ route('lihat-jadwal-guru') }}" class="inline-flex items-center gap-1.5 mt-4 px-4 py-2 rounded-lg text-xs font-semibold bg-brand-800 text-white hover:bg-brand-900 transition-colors">
                                    Lihat Jadwal Mingguan
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Penugasan Terkini --}}
                <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                    <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h2 class="font-bold text-slate-900 text-base">Penugasan Terkini</h2>
                            <p class="text-xs text-slate-500 mt-0.5">Tugas aktif dan progres pengumpulan siswa</p>
                        </div>
                        <a href="{{ route('guru.dashboard.lms.tugas.periksa') }}" class="text-xs font-semibold text-brand-800 hover:underline">
                            Kelola Semua Tugas →
                        </a>
                    </div>

                    <div class="p-5">
                        @if ($tugasTerbaru->isNotEmpty())
                            <div class="divide-y divide-slate-100">
                                @foreach ($tugasTerbaru as $tugas)
                                    <div class="py-3.5 first:pt-0 last:pb-0 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <h3 class="font-semibold text-slate-900 text-sm">
                                                    {{ $tugas->judul }}
                                                </h3>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-slate-100 text-slate-700">
                                                    {{ $tugas->kelasMataPelajaran->kelas->nama_kelas ?? 'Kelas' }}
                                                </span>
                                            </div>
                                            <p class="text-xs text-slate-500 mt-1 flex flex-wrap items-center gap-3">
                                                <span>
                                                    Deadline: {{ \Carbon\Carbon::parse($tugas->deadline)->format('d M Y, H:i') }}
                                                </span>
                                                <span class="text-slate-300">•</span>
                                                <span class="font-medium text-slate-700">
                                                    {{ $tugas->total_pengumpulan }} siswa mengumpulkan
                                                </span>
                                            </p>
                                        </div>
                                        <div class="shrink-0">
                                            <a href="{{ route('guru.dashboard.lms.tugas.periksa') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-brand-800 text-white hover:bg-brand-900 transition-colors">
                                                Periksa Nilai
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-6 px-4">
                                <p class="text-xs text-slate-500">Belum ada tugas yang dibuat untuk kelas yang diampu.</p>
                                <a href="{{ route('guru.dashboard.lms.tugas.periksa') }}" class="inline-flex items-center gap-1.5 mt-3 px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-brand-50 text-brand-800 hover:bg-brand-100 transition-colors">
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
                <div class="bg-white rounded-xl border border-slate-200 p-5 space-y-4">
                    <h2 class="font-bold text-slate-900 text-sm">
                        Aksi Cepat Pendidik
                    </h2>
                    <div class="grid grid-cols-1 gap-2">
                        <a href="{{ route('guru.absensi.index') }}" class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:border-brand-700 hover:bg-brand-50/40 transition group">
                            <div class="w-8 h-8 rounded-md bg-brand-50 text-brand-800 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-clipboard-user text-xs"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-slate-800 group-hover:text-brand-800">Isi Presensi Siswa</p>
                                <p class="text-[11px] text-slate-400">Catat kehadiran kelas hari ini</p>
                            </div>
                            <i class="fa-solid fa-chevron-right text-slate-300 text-xs group-hover:text-brand-800 transition"></i>
                        </a>

                        <a href="{{ route('guru.lms.materi.create-view') }}" class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:border-brand-700 hover:bg-brand-50/40 transition group">
                            <div class="w-8 h-8 rounded-md bg-brand-50 text-brand-800 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-cloud-arrow-up text-xs"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-slate-800 group-hover:text-brand-800">Unggah Materi Baru</p>
                                <p class="text-[11px] text-slate-400">Bagikan modul atau bahan ajar</p>
                            </div>
                            <i class="fa-solid fa-chevron-right text-slate-300 text-xs group-hover:text-brand-800 transition"></i>
                        </a>

                        <a href="{{ route('guru.dashboard.ujian.create_ujian') }}" class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:border-brand-700 hover:bg-brand-50/40 transition group">
                            <div class="w-8 h-8 rounded-md bg-brand-50 text-brand-800 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-file-circle-plus text-xs"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-slate-800 group-hover:text-brand-800">Buat Ujian CBT</p>
                                <p class="text-[11px] text-slate-400">Jadwalkan kuis atau ulangan</p>
                            </div>
                            <i class="fa-solid fa-chevron-right text-slate-300 text-xs group-hover:text-brand-800 transition"></i>
                        </a>
                    </div>
                </div>

                {{-- Wali Kelas Box (Standard White Card per design.md) --}}
                @if ($kelasWali)
                    <div class="bg-white rounded-xl border border-slate-200 p-5 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-brand-50 text-brand-800 border border-brand-200">
                                Wali Kelas
                            </span>
                            <span class="text-xs font-medium text-slate-500 tabular-nums">{{ $jumlahSiswaWali }} Siswa</span>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Kelas {{ $kelasWali->nama_kelas }}</h3>
                            <p class="text-xs text-slate-500 mt-0.5">
                                Pantau data siswa perwalian, kehadiran, dan koordinasi dengan orang tua.
                            </p>
                        </div>
                        <a href="{{ route('guru.daftarSiswaWali') }}" class="inline-flex items-center justify-center gap-2 w-full px-4 py-2 rounded-lg text-xs font-semibold bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 transition-colors">
                            Buka Daftar Siswa Wali
                        </a>
                    </div>
                @endif

                {{-- Pembina Ekstrakurikuler Box (Standard White Card per design.md) --}}
                @if (($guru->role_guru === 'pembina' || $guru->ekstrakurikuler()->exists()) && $ekskulBinaan->isNotEmpty())
                    <div class="bg-white rounded-xl border border-slate-200 p-5 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-brand-50 text-brand-800 border border-brand-200">
                                Pembina Ekstrakurikuler
                            </span>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">
                                {{ $ekskulBinaan->pluck('nama_ekstrakurikuler')->implode(', ') }}
                            </h3>
                            <p class="text-xs text-slate-500 mt-0.5">
                                Akses penilaian nilai rapor siswa, evaluasi data anggota, dan pengelolaan perlengkapan.
                            </p>
                        </div>
                        <a href="{{ route('pembina.index') }}" class="inline-flex items-center justify-center gap-2 w-full px-4 py-2 rounded-lg text-xs font-semibold bg-brand-800 text-white hover:bg-brand-900 transition-colors">
                            Buka Portal Ekstrakurikuler
                        </a>
                    </div>
                @endif

                {{-- Materi Terakhir Diunggah --}}
                <div class="bg-white rounded-xl border border-slate-200 p-5 space-y-3">
                    <div class="flex items-center justify-between">
                        <h2 class="font-bold text-slate-900 text-sm">
                            Materi Terakhir
                        </h2>
                        <a href="{{ route('guru.dashboard.lms.materi') }}" class="text-xs font-semibold text-brand-800 hover:underline">
                            Semua
                        </a>
                    </div>

                    @if ($materiTerbaru->isNotEmpty())
                        <div class="space-y-2">
                            @foreach ($materiTerbaru as $materi)
                                <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-100 flex items-start gap-2.5">
                                    <div class="w-7 h-7 rounded-md bg-brand-50 text-brand-800 flex items-center justify-center shrink-0 mt-0.5">
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
