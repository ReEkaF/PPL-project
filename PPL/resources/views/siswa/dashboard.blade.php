<x-siswa-layout>
    <div class="max-w-6xl mx-auto space-y-6">

        {{-- Hero Welcome Panel (Option A: Clean Flat Light Theme) --}}
        <div class="bg-white border border-slate-200 rounded-xl p-6 sm:p-7">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-start sm:items-center gap-4">
                    {{-- Student Avatar --}}
                    <div class="relative shrink-0">
                        <img class="w-16 h-16 sm:w-18 sm:h-18 rounded-xl object-cover border border-slate-200 bg-slate-100"
                            src="{{ $user->foto_siswa ? asset('images/siswa/' . $user->foto_siswa) : 'https://cdn.pixabay.com/photo/2018/11/13/21/43/avatar-3814049_640.png' }}"
                            alt="{{ $user->nama_siswa }}">
                    </div>

                    {{-- Welcome Text --}}
                    <div class="space-y-1">
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md bg-brand-50 border border-brand-200 text-xs font-semibold text-brand-800 mb-1">
                            <span>Portal Peserta Didik</span>
                        </div>
                        <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
                            Selamat Datang, {{ $user->nama_siswa }}
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-500">
                            Kelas {{ $kelasSiswa->nama_kelas ?? 'Reguler' }} · NISN {{ $user->nisn }} · {{ $tanggalHariIni }}
                        </p>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-wrap items-center gap-2.5 shrink-0">
                    <a href="{{ route('siswa.absensi.index') }}"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-brand-800 hover:bg-brand-900 text-white rounded-lg font-semibold text-xs transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                        <span>Scan Presensi QR</span>
                    </a>
                    <a href="{{ route('lihat-jadwal-siswa') }}"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 rounded-lg font-semibold text-xs border border-slate-300 transition-colors">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>Jadwal Lengkap</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- 4 Stat Metric Cards (Standardized per design.md) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Card 1: Presensi --}}
            <a href="{{ route('siswa.absensi.index') }}"
                class="bg-white border border-slate-200 rounded-xl p-5 flex flex-col justify-between hover:border-brand-700 transition group">
                <div class="flex items-center justify-between gap-2 mb-2">
                    <span class="text-xs font-medium text-slate-500">Tingkat kehadiran</span>
                    <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-800 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 tabular-nums">{{ $persenKehadiran }}%</div>
                    <p class="text-xs text-slate-500 mt-1">
                        {{ $hadirCount }} hadir dari {{ $totalPertemuan }} pertemuan
                    </p>
                </div>
                <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <span>Lihat presensi</span>
                    <span class="text-brand-800 font-semibold">→</span>
                </div>
            </a>

            {{-- Card 2: Tugas LMS --}}
            <a href="{{ route('siswa.dashboard.lms.tracking.tugas.ditugaskan') }}"
                class="bg-white border border-slate-200 rounded-xl p-5 flex flex-col justify-between hover:border-brand-700 transition group">
                <div class="flex items-center justify-between gap-2 mb-2">
                    <span class="text-xs font-medium text-slate-500">Tugas belum diserahkan</span>
                    <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-800 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 tabular-nums">{{ $pendingTugasCount }}</div>
                    <p class="text-xs text-slate-500 mt-1">
                        {{ $selesaiTugasCount }} dari {{ $allTugas->count() }} tugas selesai
                    </p>
                </div>
                <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <span>Buka daftar tugas</span>
                    <span class="text-brand-800 font-semibold">→</span>
                </div>
            </a>

            {{-- Card 3: Ujian / CBT --}}
            <a href="{{ route('siswa.ujian.index') }}"
                class="bg-white border border-slate-200 rounded-xl p-5 flex flex-col justify-between hover:border-brand-700 transition group">
                <div class="flex items-center justify-between gap-2 mb-2">
                    <span class="text-xs font-medium text-slate-500">Ujian aktif</span>
                    <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-800 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 tabular-nums">{{ $pendingUjianCount }}</div>
                    <p class="text-xs text-slate-500 mt-1">
                        {{ $selesaiUjianCount }} dari {{ $allUjians->count() }} ujian selesai
                    </p>
                </div>
                <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <span>Buka modul CBT</span>
                    <span class="text-brand-800 font-semibold">→</span>
                </div>
            </a>

            {{-- Card 4: Perpustakaan --}}
            <a href="{{ route('siswa.perpustakaan.riwayat') }}"
                class="bg-white border border-slate-200 rounded-xl p-5 flex flex-col justify-between hover:border-brand-700 transition group">
                <div class="flex items-center justify-between gap-2 mb-2">
                    <span class="text-xs font-medium text-slate-500">Buku dipinjam</span>
                    <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-800 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 tabular-nums">{{ $sedangDipinjamCount }}</div>
                    <p class="text-xs text-slate-500 mt-1">
                        {{ $transaksiBuku->count() }} total riwayat peminjaman
                    </p>
                </div>
                <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <span>Riwayat transaksi</span>
                    <span class="text-brand-800 font-semibold">→</span>
                </div>
            </a>
        </div>

        {{-- Main Two-Column Layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left Column (2 Cols): Jadwal, Tugas, Ujian --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Section 1: Jadwal Hari Ini --}}
                <div class="bg-white border border-slate-200 rounded-xl p-5">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                        <div>
                            <h2 class="text-base font-bold text-slate-900">
                                Jadwal Pelajaran Hari Ini
                            </h2>
                            <p class="text-xs text-slate-500 mt-0.5">
                                Hari {{ $todayName }} · Kelas {{ $kelasSiswa->nama_kelas ?? '' }}
                            </p>
                        </div>
                        <a href="{{ route('lihat-jadwal-siswa') }}"
                            class="text-xs font-semibold text-brand-800 hover:underline">
                            Lihat Semua →
                        </a>
                    </div>

                    @if ($jadwalHariIni->isNotEmpty())
                        <div class="space-y-2.5">
                            @foreach ($jadwalHariIni as $idx => $item)
                                <div class="p-3.5 rounded-lg border border-slate-200 hover:border-brand-700 transition flex items-center justify-between gap-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-md bg-brand-50 text-brand-800 flex items-center justify-center shrink-0 font-bold text-xs">
                                            <span>#{{ $idx + 1 }}</span>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-slate-900">
                                                {{ $item->mataPelajaran->nama_matpel ?? 'Mata Pelajaran' }}
                                            </h3>
                                            <p class="text-xs text-slate-500 mt-0.5">
                                                {{ $item->guru->nama_guru ?? 'Guru Pengajar' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-700">
                                            {{ $item->waktu_mulai }} – {{ $item->waktu_selesai }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- Weekend / No Class Fallback --}}
                        <div class="bg-slate-50 rounded-lg p-6 text-center border border-dashed border-slate-200">
                            <h3 class="text-sm font-bold text-slate-800">Tidak Ada Jam Pelajaran Hari Ini</h3>
                            <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                                Hari {{ $todayName }} adalah hari libur sekolah. Gunakan waktu luang untuk mengulang materi atau menyelesaikan penugasan.
                            </p>
                            @if ($previewJadwal->isNotEmpty())
                                <div class="mt-4 pt-3 border-t border-slate-200 text-left">
                                    <p class="text-xs font-semibold text-slate-600 mb-2">Mata pelajaran kelas kamu:</p>
                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                                        @foreach ($previewJadwal as $kmp)
                                            <div class="p-2 rounded-md bg-white border border-slate-200 text-xs">
                                                <p class="font-bold text-slate-800 truncate">{{ $kmp->mataPelajaran->nama_matpel ?? 'Matpel' }}</p>
                                                <p class="text-[11px] text-slate-500 mt-0.5">{{ $kmp->hari->nama_hari ?? '' }} · {{ $kmp->waktu_mulai }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                {{-- Section 2: Tugas yang Belum Diserahkan --}}
                <div class="bg-white border border-slate-200 rounded-xl p-5">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                        <div>
                            <h2 class="text-base font-bold text-slate-900">
                                Tugas Perlu Diserahkan
                            </h2>
                            <p class="text-xs text-slate-500 mt-0.5">
                                Penugasan dari guru yang belum kamu kumpulkan
                            </p>
                        </div>
                        <span class="px-2 py-0.5 text-xs font-medium rounded-md {{ $pendingTugasCount > 0 ? 'bg-amber-50 text-amber-800 border border-amber-200' : 'bg-slate-100 text-slate-600' }}">
                            {{ $pendingTugasCount }} tugas
                        </span>
                    </div>

                    @if ($pendingTugasList->isNotEmpty())
                        <div class="space-y-3">
                            @foreach ($pendingTugasList->take(3) as $tugas)
                                @php
                                    $mapel = $tugas->kelasMataPelajaran?->mataPelajaran?->nama_matpel ?? 'Umum';
                                @endphp
                                <div class="p-4 rounded-lg border border-slate-200 hover:border-brand-700 transition flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-0.5 text-[11px] font-medium rounded bg-brand-50 text-brand-800 border border-brand-200">
                                                {{ $mapel }}
                                            </span>
                                            <span class="text-xs text-slate-500">
                                                Dibuat: {{ \Carbon\Carbon::parse($tugas->created_at)->isoFormat('D MMM Y') }}
                                            </span>
                                        </div>
                                        <h3 class="text-sm font-bold text-slate-900">
                                            {{ $tugas->judul_tugas }}
                                        </h3>
                                        @if ($tugas->deskripsi_tugas)
                                            <p class="text-xs text-slate-600 line-clamp-1">
                                                {{ Str::limit(strip_tags($tugas->deskripsi_tugas), 80) }}
                                            </p>
                                        @endif
                                    </div>
                                    <a href="{{ route('siswa.dashboard.lms.detail.tugas', $tugas->id_tugas) }}"
                                        class="inline-flex items-center justify-center gap-1.5 px-3.5 py-1.5 bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold rounded-lg shrink-0 transition-colors">
                                        <span>Buka & Kerjakan</span>
                                        <span>→</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        @if ($pendingTugasCount > 3)
                            <div class="mt-3 text-center">
                                <a href="{{ route('siswa.dashboard.lms.tracking.tugas.ditugaskan') }}"
                                    class="text-xs font-semibold text-brand-800 hover:underline">
                                    Lihat {{ $pendingTugasCount - 3 }} tugas lainnya →
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="bg-emerald-50/70 rounded-lg p-5 text-center border border-emerald-200">
                            <h3 class="text-sm font-bold text-emerald-800">Semua tugas telah diselesaikan</h3>
                            <p class="text-xs text-emerald-700 mt-0.5">
                                Tidak ada tanggungan tugas sekolah saat ini. Pertahankan prestasimu.
                            </p>
                        </div>
                    @endif
                </div>

                {{-- Section 3: Ujian & CBT Terjadwal --}}
                <div class="bg-white border border-slate-200 rounded-xl p-5">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                        <div>
                            <h2 class="text-base font-bold text-slate-900">
                                Ujian & Asesmen Terjadwal
                            </h2>
                            <p class="text-xs text-slate-500 mt-0.5">
                                Asesmen CBT yang siap kamu kerjakan
                            </p>
                        </div>
                        <a href="{{ route('siswa.ujian.index') }}"
                            class="text-xs font-semibold text-brand-800 hover:underline">
                            Semua Ujian →
                        </a>
                    </div>

                    @if ($pendingUjians->isNotEmpty())
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach ($pendingUjians->take(2) as $ujian)
                                @php
                                    $mapel = $ujian->kelasMataPelajaran?->mataPelajaran?->nama_matpel ?? 'Ujian';
                                @endphp
                                <div class="p-4 rounded-lg border border-slate-200 hover:border-brand-700 transition flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between gap-2 mb-2">
                                            <span class="px-2 py-0.5 text-[11px] font-medium rounded bg-brand-50 text-brand-800 border border-brand-200">
                                                {{ $mapel }}
                                            </span>
                                            <span class="inline-flex items-center gap-1 text-[11px] font-medium text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded">
                                                Aktif
                                            </span>
                                        </div>
                                        <h3 class="text-sm font-bold text-slate-900 line-clamp-1">
                                            {{ $ujian->judul }}
                                        </h3>
                                        <div class="flex items-center gap-3 mt-2 text-xs text-slate-500">
                                            <span>Durasi: 60 Menit</span>
                                            <span>Jumlah: {{ $ujian->soalUjian->count() }} Soal</span>
                                        </div>
                                    </div>
                                    <div class="mt-4 pt-3 border-t border-slate-100">
                                        <a href="{{ route('siswa.ujian.start', $ujian->id_ujian) }}"
                                            class="block w-full py-1.5 bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold rounded-lg text-center transition-colors">
                                            Mulai Sekarang
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-slate-50 rounded-lg p-5 text-center border border-dashed border-slate-200">
                            <p class="text-xs text-slate-500 font-medium">
                                Tidak ada ujian CBT yang aktif saat ini. Seluruh asesmen terjadwal telah diselesaikan.
                            </p>
                        </div>
                    @endif
                </div>

            </div>

            {{-- Right Column (1 Col): Quick Shortcuts, Attendance Breakdown, Library --}}
            <div class="space-y-6">

                {{-- Card: Pintasan Cepat --}}
                <div class="bg-white border border-slate-200 rounded-xl p-5">
                    <h2 class="text-sm font-bold text-slate-900 mb-3">
                        Menu Cepat Siswa
                    </h2>

                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('siswa.dashboard.lms') }}"
                            class="p-2.5 rounded-lg border border-slate-200 hover:bg-brand-50/50 hover:border-brand-700 transition flex flex-col items-center text-center group">
                            <div class="w-8 h-8 rounded-md bg-brand-50 text-brand-800 flex items-center justify-center mb-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-slate-700 group-hover:text-brand-800">LMS Beranda</span>
                        </a>

                        <a href="{{ route('siswa.dashboard.lms.materi') }}"
                            class="p-2.5 rounded-lg border border-slate-200 hover:bg-brand-50/50 hover:border-brand-700 transition flex flex-col items-center text-center group">
                            <div class="w-8 h-8 rounded-md bg-brand-50 text-brand-800 flex items-center justify-center mb-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-slate-700 group-hover:text-brand-800">Materi Kelas</span>
                        </a>

                        <a href="{{ route('siswa.ujian.index') }}"
                            class="p-2.5 rounded-lg border border-slate-200 hover:bg-brand-50/50 hover:border-brand-700 transition flex flex-col items-center text-center group">
                            <div class="w-8 h-8 rounded-md bg-brand-50 text-brand-800 flex items-center justify-center mb-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-slate-700 group-hover:text-brand-800">CBT Online</span>
                        </a>

                        <a href="{{ route('dashboard.perpustakaan') }}"
                            class="p-2.5 rounded-lg border border-slate-200 hover:bg-brand-50/50 hover:border-brand-700 transition flex flex-col items-center text-center group">
                            <div class="w-8 h-8 rounded-md bg-brand-50 text-brand-800 flex items-center justify-center mb-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-slate-700 group-hover:text-brand-800">Perpustakaan</span>
                        </a>
                    </div>
                </div>

                {{-- Card: Breakdown Presensi --}}
                <div class="bg-white border border-slate-200 rounded-xl p-5">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-sm font-bold text-slate-900">
                            Rekapitulasi Absensi
                        </h2>
                        <a href="{{ route('siswa.absensi.index') }}" class="text-xs text-brand-800 font-semibold hover:underline">
                            Detail
                        </a>
                    </div>

                    <div class="grid grid-cols-4 gap-2 text-center">
                        <div class="p-2 rounded-lg bg-emerald-50 border border-emerald-200">
                            <p class="text-base font-bold text-emerald-800 tabular-nums">{{ $hadirCount }}</p>
                            <p class="text-[11px] font-medium text-emerald-700 mt-0.5">Hadir</p>
                        </div>
                        <div class="p-2 rounded-lg bg-sky-50 border border-sky-200">
                            <p class="text-base font-bold text-sky-800 tabular-nums">{{ $izinCount }}</p>
                            <p class="text-[11px] font-medium text-sky-700 mt-0.5">Izin</p>
                        </div>
                        <div class="p-2 rounded-lg bg-amber-50 border border-amber-200">
                            <p class="text-base font-bold text-amber-800 tabular-nums">{{ $sakitCount }}</p>
                            <p class="text-[11px] font-medium text-amber-700 mt-0.5">Sakit</p>
                        </div>
                        <div class="p-2 rounded-lg bg-rose-50 border border-rose-200">
                            <p class="text-base font-bold text-rose-800 tabular-nums">{{ $alpaCount }}</p>
                            <p class="text-[11px] font-medium text-rose-700 mt-0.5">Alpa</p>
                        </div>
                    </div>

                    {{-- Progress Bar --}}
                    <div class="mt-4">
                        <div class="flex items-center justify-between text-xs text-slate-500 mb-1.5">
                            <span>Persentase kehadiran</span>
                            <span class="font-bold text-slate-900 tabular-nums">{{ $persenKehadiran }}%</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full rounded-full bg-brand-800 transition-all" style="width: {{ $persenKehadiran }}%"></div>
                        </div>
                    </div>
                </div>

                {{-- Card: Buku Perpustakaan Terakhir --}}
                <div class="bg-white border border-slate-200 rounded-xl p-5">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-sm font-bold text-slate-900">
                            Peminjaman Buku
                        </h2>
                        <a href="{{ route('dashboard.perpustakaan') }}" class="text-xs text-brand-800 font-semibold hover:underline">
                            Katalog
                        </a>
                    </div>

                    @if ($transaksiBuku->isNotEmpty())
                        <div class="space-y-2.5">
                            @foreach ($transaksiBuku->take(2) as $tb)
                                <div class="p-2.5 rounded-lg border border-slate-200 bg-slate-50/50 flex items-center gap-3">
                                    <div class="w-10 h-12 rounded bg-slate-100 overflow-hidden shrink-0 flex items-center justify-center border border-slate-200">
                                        @if ($tb->foto_buku)
                                            <img src="{{ asset('images/buku/' . $tb->foto_buku) }}" alt="{{ $tb->judul_buku }}" class="w-full h-full object-cover">
                                        @else
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs font-bold text-slate-900 truncate">{{ $tb->judul_buku }}</p>
                                        <p class="text-[11px] text-slate-500 truncate">{{ $tb->author_buku }}</p>
                                        <div class="mt-1">
                                            @if ($tb->status_pengembalian == 0)
                                                <span class="inline-flex items-center text-[10px] font-medium text-amber-800 bg-amber-50 px-1.5 py-0.5 rounded border border-amber-200">
                                                    Sedang Dipinjam
                                                </span>
                                            @else
                                                <span class="inline-flex items-center text-[10px] font-medium text-emerald-800 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200">
                                                    Dikembalikan
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 bg-slate-50 rounded-lg border border-dashed border-slate-200">
                            <p class="text-xs text-slate-500 font-medium">Belum ada riwayat peminjaman buku.</p>
                            <a href="{{ route('dashboard.perpustakaan') }}"
                                class="inline-flex items-center gap-1 text-xs font-semibold text-brand-800 hover:underline mt-1">
                                Jelajahi Katalog Perpustakaan →
                            </a>
                        </div>
                    @endif
                </div>

            </div>

        </div>

    </div>
</x-siswa-layout>
