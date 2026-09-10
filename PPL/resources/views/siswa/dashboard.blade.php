<x-siswa-layout>
    <div class="max-w-6xl mx-auto space-y-6">

        {{-- Hero Welcome Banner --}}
        <div class="relative overflow-hidden bg-gradient-to-r from-brand-900 via-brand-800 to-slate-900 rounded-2xl p-6 sm:p-8 text-white shadow-sm">
            {{-- Decorative Background SVG --}}
            <div class="absolute -right-10 -bottom-10 opacity-10 pointer-events-none">
                <svg class="w-72 h-72" viewBox="0 0 200 200" fill="currentColor">
                    <path d="M45.7,-57.8C59.9,-47.9,72.6,-34.5,77.3,-18.8C82, -3.1, 78.8, 14.9, 70.3, 29.8C61.8, 44.7, 48, 56.6, 32.7, 64.3C17.4, 72, 0.6, 75.5, -16.4, 73.1C-33.4, 70.7, -50.6, 62.4, -62.3, 48.8C-74, 35.2, -80.2, 16.3, -78.4, -1.8C-76.6, -19.9, -66.8, -37.2, -53.4, -47.4C-40, -57.6, -23, -60.7, -4.9, -54.8C13.2, -48.9, 31.5, -67.7, 45.7, -57.8Z" transform="translate(100 100)" />
                </svg>
            </div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-start sm:items-center gap-4">
                    {{-- Student Avatar --}}
                    <div class="relative shrink-0">
                        <img class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl object-cover ring-4 ring-white/20 shadow-md bg-white/10"
                            src="{{ $user->foto_siswa ? asset('images/siswa/' . $user->foto_siswa) : 'https://cdn.pixabay.com/photo/2018/11/13/21/43/avatar-3814049_640.png' }}"
                            alt="{{ $user->nama_siswa }}">
                        <span class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-2 border-brand-900 rounded-full" title="Akun Aktif"></span>
                    </div>

                    {{-- Welcome Text & Pills --}}
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-sm text-xs font-medium text-brand-100 mb-2 border border-white/10">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>{{ $tanggalHariIni }}</span>
                        </div>
                        <h1 class="text-xl sm:text-2xl font-bold tracking-tight">
                            Selamat Datang, {{ $user->nama_siswa }}! 👋
                        </h1>
                        <p class="text-sm text-brand-100/90 mt-1">
                            Semangat belajar! Pantau jadwal pelajaran, tugas harian, presensi, dan asesmen CBT kamu di sini.
                        </p>

                        {{-- Metadata badges --}}
                        <div class="flex flex-wrap items-center gap-2 mt-3">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-lg bg-white/15 text-xs font-medium backdrop-blur-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                Kelas {{ $kelasSiswa->nama_kelas ?? 'Reguler' }}
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-lg bg-white/15 text-xs font-medium backdrop-blur-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                </svg>
                                NISN: {{ $user->nisn }}
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-lg bg-white/15 text-xs font-medium backdrop-blur-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $tahunAjaran ? 'T.A. ' . $tahunAjaran->tahun_mulai . '/' . $tahunAjaran->tahun_selesai . ' (Sem ' . $tahunAjaran->semester . ')' : 'Semester Aktif' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-row md:flex-col items-center sm:items-stretch gap-2 shrink-0">
                    <a href="{{ route('siswa.absensi.index') }}"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-100 text-slate-900 rounded-xl font-semibold text-xs transition shadow-sm">
                        <svg class="w-4 h-4 text-brand-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                        <span>Scan Presensi QR</span>
                    </a>
                    <a href="{{ route('lihat-jadwal-siswa') }}"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white/10 hover:bg-white/20 text-white rounded-xl font-semibold text-xs backdrop-blur-sm transition border border-white/15">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>Jadwal Lengkap</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- 4 KPI Metric Summary Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Card 1: Presensi --}}
            <a href="{{ route('siswa.absensi.index') }}"
                class="bg-white border border-slate-200 rounded-xl p-4 flex flex-col justify-between hover:shadow-md hover:border-emerald-200 transition-all group">
                <div class="flex items-center justify-between gap-2 mb-3">
                    <span class="text-xs font-semibold text-slate-500">Kehadiran Siswa</span>
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl font-extrabold text-slate-900">{{ $persenKehadiran }}%</span>
                        <span class="text-xs text-slate-400 font-medium">rata-rata</span>
                    </div>
                    <p class="text-xs text-slate-500 mt-1">
                        {{ $hadirCount }} hadir dari {{ $totalPertemuan }} pertemuan
                    </p>
                </div>
                <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between text-xs">
                    @if ($presensiHariIni)
                        <span class="inline-flex items-center gap-1 text-emerald-700 font-medium">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Hari ini: {{ $presensiHariIni->status_absensi }}
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 text-amber-600 font-medium">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            Belum presensi hari ini
                        </span>
                    @endif
                    <span class="text-brand-700 font-semibold group-hover:translate-x-0.5 transition-transform">Detail →</span>
                </div>
            </a>

            {{-- Card 2: Tugas LMS --}}
            <a href="{{ route('siswa.dashboard.lms.tracking.tugas.ditugaskan') }}"
                class="bg-white border border-slate-200 rounded-xl p-4 flex flex-col justify-between hover:shadow-md hover:border-amber-200 transition-all group">
                <div class="flex items-center justify-between gap-2 mb-3">
                    <span class="text-xs font-semibold text-slate-500">Tugas LMS</span>
                    <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl font-extrabold text-amber-700">{{ $pendingTugasCount }}</span>
                        <span class="text-xs text-slate-400 font-medium">belum diserahkan</span>
                    </div>
                    <p class="text-xs text-slate-500 mt-1">
                        {{ $selesaiTugasCount }} dari {{ $allTugas->count() }} tugas selesai
                    </p>
                </div>
                <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-slate-400">Tugas aktif</span>
                    <span class="text-brand-700 font-semibold group-hover:translate-x-0.5 transition-transform">Buka Tugas →</span>
                </div>
            </a>

            {{-- Card 3: Ujian / CBT --}}
            <a href="{{ route('siswa.ujian.index') }}"
                class="bg-white border border-slate-200 rounded-xl p-4 flex flex-col justify-between hover:shadow-md hover:border-brand-200 transition-all group">
                <div class="flex items-center justify-between gap-2 mb-3">
                    <span class="text-xs font-semibold text-slate-500">Ujian & CBT</span>
                    <div class="w-9 h-9 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl font-extrabold text-brand-800">{{ $pendingUjianCount }}</span>
                        <span class="text-xs text-slate-400 font-medium">siap dikerjakan</span>
                    </div>
                    <p class="text-xs text-slate-500 mt-1">
                        {{ $selesaiUjianCount }} dari {{ $allUjians->count() }} ujian selesai
                    </p>
                </div>
                <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-slate-400">Asesmen online</span>
                    <span class="text-brand-700 font-semibold group-hover:translate-x-0.5 transition-transform">Mulai CBT →</span>
                </div>
            </a>

            {{-- Card 4: Perpustakaan --}}
            <a href="{{ route('siswa.perpustakaan.riwayat') }}"
                class="bg-white border border-slate-200 rounded-xl p-4 flex flex-col justify-between hover:shadow-md hover:border-blue-200 transition-all group">
                <div class="flex items-center justify-between gap-2 mb-3">
                    <span class="text-xs font-semibold text-slate-500">Perpustakaan</span>
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl font-extrabold text-blue-700">{{ $sedangDipinjamCount }}</span>
                        <span class="text-xs text-slate-400 font-medium">buku dipinjam</span>
                    </div>
                    <p class="text-xs text-slate-500 mt-1">
                        {{ $transaksiBuku->count() }} total riwayat transaksi
                    </p>
                </div>
                <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-slate-400">Sirkulasi buku</span>
                    <span class="text-brand-700 font-semibold group-hover:translate-x-0.5 transition-transform">Katalog →</span>
                </div>
            </a>
        </div>

        {{-- Main Two-Column Layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left Column (2 Cols): Jadwal, Tugas, Ujian --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Section 1: Jadwal Hari Ini --}}
                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-700 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-base font-bold text-slate-900 leading-none">
                                    Jadwal Pelajaran Hari Ini
                                </h2>
                                <p class="text-xs text-slate-400 mt-1">
                                    Hari {{ $todayName }} · Kelas {{ $kelasSiswa->nama_kelas ?? '' }}
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('lihat-jadwal-siswa') }}"
                            class="text-xs font-semibold text-brand-700 hover:text-brand-800 transition">
                            Lihat Semua →
                        </a>
                    </div>

                    @if ($jadwalHariIni->isNotEmpty())
                        <div class="space-y-3">
                            @foreach ($jadwalHariIni as $idx => $item)
                                <div class="p-3.5 rounded-xl border border-slate-200/80 hover:border-brand-300 hover:bg-slate-50/60 transition flex items-center justify-between gap-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-800 flex flex-col items-center justify-center shrink-0 font-bold text-xs">
                                            <span>#{{ $idx + 1 }}</span>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-slate-900">
                                                {{ $item->mataPelajaran->nama_matpel ?? 'Mata Pelajaran' }}
                                            </h3>
                                            <p class="text-xs text-slate-500 mt-0.5 flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                                {{ $item->guru->nama_guru ?? 'Guru Pengajar' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-bold bg-slate-100 text-slate-700">
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $item->waktu_mulai }} - {{ $item->waktu_selesai }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- Weekend / No Class Fallback --}}
                        <div class="bg-slate-50 rounded-xl p-6 text-center border border-dashed border-slate-200">
                            <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2.5">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-slate-800">Tidak Ada Jam Pelajaran Hari Ini</h3>
                            <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                                Hari {{ $todayName }} adalah hari libur sekolah. Kamu bisa menggunakan waktu ini untuk mereview materi atau menyelesaikan tugas yang ada.
                            </p>
                            @if ($previewJadwal->isNotEmpty())
                                <div class="mt-4 pt-3 border-t border-slate-200/60 text-left">
                                    <p class="text-xs font-semibold text-slate-500 mb-2">Mata Pelajaran Kelas Kamu:</p>
                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                                        @foreach ($previewJadwal as $kmp)
                                            <div class="p-2 rounded-lg bg-white border border-slate-200 text-xs">
                                                <p class="font-bold text-slate-800 truncate">{{ $kmp->mataPelajaran->nama_matpel ?? 'Matpel' }}</p>
                                                <p class="text-[11px] text-slate-400 mt-0.5">{{ $kmp->hari->nama_hari ?? '' }} · {{ $kmp->waktu_mulai }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                {{-- Section 2: Tugas yang Belum Diserahkan --}}
                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-base font-bold text-slate-900 leading-none">
                                    Tugas Perlu Diserahkan
                                </h2>
                                <p class="text-xs text-slate-400 mt-1">
                                    Tugas dari guru yang belum kamu kumpulkan
                                </p>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 text-xs font-bold rounded-full {{ $pendingTugasCount > 0 ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-600' }}">
                            {{ $pendingTugasCount }} Tugas
                        </span>
                    </div>

                    @if ($pendingTugasList->isNotEmpty())
                        <div class="space-y-3">
                            @foreach ($pendingTugasList->take(3) as $tugas)
                                @php
                                    $mapel = $tugas->kelasMataPelajaran?->mataPelajaran?->nama_matpel ?? 'Umum';
                                @endphp
                                <div class="p-4 rounded-xl border border-slate-200 hover:border-amber-300 hover:bg-amber-50/20 transition flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-0.5 text-[11px] font-bold rounded bg-brand-50 text-brand-700 border border-brand-200/50">
                                                {{ $mapel }}
                                            </span>
                                            <span class="text-xs text-slate-400">
                                                Dibuat: {{ \Carbon\Carbon::parse($tugas->created_at)->isoFormat('D MMM Y') }}
                                            </span>
                                        </div>
                                        <h3 class="text-sm font-bold text-slate-900">
                                            {{ $tugas->judul_tugas }}
                                        </h3>
                                        @if ($tugas->deskripsi_tugas)
                                            <p class="text-xs text-slate-500 line-clamp-1">
                                                {{ Str::limit(strip_tags($tugas->deskripsi_tugas), 80) }}
                                            </p>
                                        @endif
                                    </div>
                                    <a href="{{ route('siswa.dashboard.lms.detail.tugas', $tugas->id_tugas) }}"
                                        class="inline-flex items-center justify-center gap-1.5 px-3.5 py-1.5 bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold rounded-lg shrink-0 transition shadow-sm">
                                        <span>Buka & Kerjakan</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        @if ($pendingTugasCount > 3)
                            <div class="mt-3 text-center">
                                <a href="{{ route('siswa.dashboard.lms.tracking.tugas.ditugaskan') }}"
                                    class="text-xs font-semibold text-brand-700 hover:text-brand-800 transition">
                                    Lihat {{ $pendingTugasCount - 3 }} tugas lainnya →
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="bg-emerald-50/60 rounded-xl p-5 text-center border border-emerald-100">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-emerald-800">Semua Tugas Telah Selesai! 🎉</h3>
                            <p class="text-xs text-emerald-600 mt-0.5">
                                Hebat, tidak ada tanggungan tugas sekolah saat ini. Pertahankan prestasimu!
                            </p>
                        </div>
                    @endif
                </div>

                {{-- Section 3: Ujian & CBT Siap Dikerjakan --}}
                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-700 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-base font-bold text-slate-900 leading-none">
                                    Ujian & Asesmen Terjadwal
                                </h2>
                                <p class="text-xs text-slate-400 mt-1">
                                    Asesmen CBT yang siap kamu kerjakan
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('siswa.ujian.index') }}"
                            class="text-xs font-semibold text-brand-700 hover:text-brand-800 transition">
                            Semua Ujian →
                        </a>
                    </div>

                    @if ($pendingUjians->isNotEmpty())
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach ($pendingUjians->take(2) as $ujian)
                                @php
                                    $mapel = $ujian->kelasMataPelajaran?->mataPelajaran?->nama_matpel ?? 'Ujian';
                                @endphp
                                <div class="p-4 rounded-xl border border-slate-200 hover:border-brand-300 hover:shadow-sm transition flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between gap-2 mb-2">
                                            <span class="px-2 py-0.5 text-[11px] font-bold rounded bg-brand-50 text-brand-700 border border-brand-200/50">
                                                {{ $mapel }}
                                            </span>
                                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-brand-600 bg-brand-50 px-2 py-0.5 rounded-full">
                                                <span class="w-1.5 h-1.5 rounded-full bg-brand-500"></span>
                                                Aktif
                                            </span>
                                        </div>
                                        <h3 class="text-sm font-bold text-slate-900 line-clamp-1">
                                            {{ $ujian->judul }}
                                        </h3>
                                        <div class="flex items-center gap-3 mt-2 text-xs text-slate-400">
                                            <span>⏱️ 60 Menit</span>
                                            <span>📝 {{ $ujian->soalUjian->count() }} Soal</span>
                                        </div>
                                    </div>
                                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center gap-2">
                                        <a href="{{ route('siswa.ujian.start', $ujian->id_ujian) }}"
                                            class="flex-1 py-1.5 bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold rounded-lg text-center transition shadow-sm">
                                            Mulai Sekarang
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-slate-50 rounded-xl p-5 text-center border border-dashed border-slate-200">
                            <p class="text-xs text-slate-500 font-medium">
                                Tidak ada ujian CBT yang aktif saat ini. Seluruh asesmen terjadwal telah diselesaikan.
                            </p>
                        </div>
                    @endif
                </div>

            </div>

            {{-- Right Column (1 Col): Quick Shortcuts, Attendance Breakdown, Library --}}
            <div class="space-y-6">

                {{-- Card: Pintasan Cepat (Quick Shortcuts) --}}
                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                    <h2 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-brand-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <span>Menu Cepat Siswa</span>
                    </h2>
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('siswa.dashboard.lms') }}"
                            class="p-2.5 rounded-xl border border-slate-100 bg-slate-50/70 hover:bg-brand-50 hover:border-brand-200 transition group flex flex-col items-center text-center">
                            <div class="w-8 h-8 rounded-lg bg-white shadow-xs text-brand-700 flex items-center justify-center mb-1.5 group-hover:scale-110 transition-transform">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-slate-700 group-hover:text-brand-800">LMS Beranda</span>
                        </a>

                        <a href="{{ route('siswa.dashboard.lms.materi') }}"
                            class="p-2.5 rounded-xl border border-slate-100 bg-slate-50/70 hover:bg-brand-50 hover:border-brand-200 transition group flex flex-col items-center text-center">
                            <div class="w-8 h-8 rounded-lg bg-white shadow-xs text-brand-700 flex items-center justify-center mb-1.5 group-hover:scale-110 transition-transform">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-slate-700 group-hover:text-brand-800">Materi Kelas</span>
                        </a>

                        <a href="{{ route('siswa.ujian.index') }}"
                            class="p-2.5 rounded-xl border border-slate-100 bg-slate-50/70 hover:bg-brand-50 hover:border-brand-200 transition group flex flex-col items-center text-center">
                            <div class="w-8 h-8 rounded-lg bg-white shadow-xs text-brand-700 flex items-center justify-center mb-1.5 group-hover:scale-110 transition-transform">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-slate-700 group-hover:text-brand-800">CBT Online</span>
                        </a>

                        <a href="{{ route('dashboard.perpustakaan') }}"
                            class="p-2.5 rounded-xl border border-slate-100 bg-slate-50/70 hover:bg-brand-50 hover:border-brand-200 transition group flex flex-col items-center text-center">
                            <div class="w-8 h-8 rounded-lg bg-white shadow-xs text-brand-700 flex items-center justify-center mb-1.5 group-hover:scale-110 transition-transform">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-slate-700 group-hover:text-brand-800">Perpustakaan</span>
                        </a>

                        <a href="{{ route('siswaprofil.show') }}"
                            class="p-2.5 rounded-xl border border-slate-100 bg-slate-50/70 hover:bg-brand-50 hover:border-brand-200 transition group flex flex-col items-center text-center">
                            <div class="w-8 h-8 rounded-lg bg-white shadow-xs text-brand-700 flex items-center justify-center mb-1.5 group-hover:scale-110 transition-transform">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-slate-700 group-hover:text-brand-800">Profil Saya</span>
                        </a>
                    </div>
                </div>

                {{-- Card: Breakdown Presensi --}}
                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Rekapitulasi Absensi</span>
                        </h2>
                        <a href="{{ route('siswa.absensi.index') }}" class="text-xs text-brand-700 font-semibold hover:underline">
                            Detail
                        </a>
                    </div>

                    <div class="grid grid-cols-4 gap-2 text-center">
                        <div class="p-2.5 rounded-xl bg-emerald-50 border border-emerald-100">
                            <p class="text-base font-extrabold text-emerald-700">{{ $hadirCount }}</p>
                            <p class="text-[11px] font-medium text-emerald-600 mt-0.5">Hadir</p>
                        </div>
                        <div class="p-2.5 rounded-xl bg-blue-50 border border-blue-100">
                            <p class="text-base font-extrabold text-blue-700">{{ $izinCount }}</p>
                            <p class="text-[11px] font-medium text-blue-600 mt-0.5">Izin</p>
                        </div>
                        <div class="p-2.5 rounded-xl bg-amber-50 border border-amber-100">
                            <p class="text-base font-extrabold text-amber-700">{{ $sakitCount }}</p>
                            <p class="text-[11px] font-medium text-amber-600 mt-0.5">Sakit</p>
                        </div>
                        <div class="p-2.5 rounded-xl bg-rose-50 border border-rose-100">
                            <p class="text-base font-extrabold text-rose-700">{{ $alpaCount }}</p>
                            <p class="text-[11px] font-medium text-rose-600 mt-0.5">Alpa</p>
                        </div>
                    </div>

                    {{-- Progress Bar --}}
                    <div class="mt-4">
                        <div class="flex items-center justify-between text-xs text-slate-500 mb-1.5">
                            <span>Persentase Kehadiran</span>
                            <span class="font-bold text-slate-800">{{ $persenKehadiran }}%</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full rounded-full bg-emerald-500 transition-all" style="width: {{ $persenKehadiran }}%"></div>
                        </div>
                    </div>
                </div>

                {{-- Card: Buku Perpustakaan Terakhir --}}
                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span>Peminjaman Buku</span>
                        </h2>
                        <a href="{{ route('dashboard.perpustakaan') }}" class="text-xs text-brand-700 font-semibold hover:underline">
                            Katalog
                        </a>
                    </div>

                    @if ($transaksiBuku->isNotEmpty())
                        <div class="space-y-2.5">
                            @foreach ($transaksiBuku->take(2) as $tb)
                                <div class="p-2.5 rounded-xl border border-slate-100 bg-slate-50/60 flex items-center gap-3">
                                    <div class="w-10 h-12 rounded bg-slate-200 overflow-hidden shrink-0 flex items-center justify-center">
                                        @if ($tb->foto_buku)
                                            <img src="{{ asset('images/buku/' . $tb->foto_buku) }}" alt="{{ $tb->judul_buku }}" class="w-full h-full object-cover">
                                        @else
                                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs font-bold text-slate-900 truncate">{{ $tb->judul_buku }}</p>
                                        <p class="text-[11px] text-slate-400 truncate">{{ $tb->author_buku }}</p>
                                        <div class="mt-1">
                                            @if ($tb->status_pengembalian == 0)
                                                <span class="inline-flex items-center gap-1 text-[10px] font-semibold text-amber-700 bg-amber-50 px-1.5 py-0.5 rounded">
                                                    Sedang Dipinjam
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 text-[10px] font-semibold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded">
                                                    Dikembalikan
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                            <p class="text-xs text-slate-500 font-medium">Belum ada riwayat peminjaman buku.</p>
                            <a href="{{ route('dashboard.perpustakaan') }}"
                                class="inline-flex items-center gap-1 text-xs font-semibold text-brand-700 hover:underline mt-1">
                                Jelajahi Buku Perpustakaan →
                            </a>
                        </div>
                    @endif
                </div>

            </div>

        </div>

    </div>
</x-siswa-layout>
