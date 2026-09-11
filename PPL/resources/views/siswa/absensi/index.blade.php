<x-siswa-layout>
    <div class="max-w-6xl mx-auto space-y-6">

        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'route' => route('siswa.dashboard')],
                ['label' => 'Absensi Siswa', 'route' => route('siswa.absensi.index')],
            ];
        @endphp

        {{-- Top Navigation & Breadcrumb --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <x-breadcrumb :breadcrumbs="$breadcrumbs" />
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white mt-1">
                    Rekap & Presensi Kehadiran
                </h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                    Pantau rekapitulasi kehadiran belajar, jadwal mingguan, dan riwayat presensi setiap mata pelajaran.
                </p>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('lihat-jadwal-siswa') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-semibold shadow-sm transition">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Jadwal Pelajaran</span>
                </a>
            </div>
        </div>

        {{-- 4 KPI Summary Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Card 1: Persentase Kehadiran --}}
            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center justify-between gap-2 mb-3">
                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Tingkat kehadiran</span>
                    <div class="w-9 h-9 rounded-xl bg-[#06466C]/10 text-[#06466C] dark:bg-[#06466C]/30 dark:text-sky-300 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold font-mono text-slate-900 dark:text-white">{{ $overallStats->persentase }}%</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $overallStats->persentase >= 80 ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-300' : ($overallStats->persentase >= 75 ? 'bg-amber-100 text-amber-800 dark:bg-amber-900/60 dark:text-amber-300' : 'bg-rose-100 text-rose-800 dark:bg-rose-900/60 dark:text-rose-300') }}">
                        {{ $overallStats->status_label }}
                    </span>
                </div>
                <div class="w-full bg-slate-100 dark:bg-slate-700 rounded-full h-1.5 mt-3 overflow-hidden">
                    <div class="h-1.5 rounded-full {{ $overallStats->persentase >= 80 ? 'bg-emerald-500' : ($overallStats->persentase >= 75 ? 'bg-amber-500' : 'bg-rose-500') }}" style="width: {{ min(100, $overallStats->persentase) }}%"></div>
                </div>
            </div>

            {{-- Card 2: Total Hadir --}}
            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center justify-between gap-2 mb-3">
                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Hadir</span>
                    <div class="w-9 h-9 rounded-xl bg-[#06466C]/10 text-[#06466C] dark:bg-[#06466C]/30 dark:text-sky-300 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold font-mono text-slate-900 dark:text-white">{{ $overallStats->hadir }}</span>
                    <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">dari {{ $overallStats->total }} sesi</span>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">
                    Presensi tercatat hadir di kelas
                </p>
            </div>

            {{-- Card 3: Izin & Sakit --}}
            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center justify-between gap-2 mb-3">
                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Izin & sakit</span>
                    <div class="w-9 h-9 rounded-xl bg-[#06466C]/10 text-[#06466C] dark:bg-[#06466C]/30 dark:text-sky-300 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold font-mono text-slate-900 dark:text-white">{{ $overallStats->izin + $overallStats->sakit }}</span>
                    <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">sesi berhalangan</span>
                </div>
                <div class="flex items-center gap-2 mt-2 text-xs text-slate-500 dark:text-slate-400">
                    <span class="inline-flex items-center gap-1 text-slate-600 dark:text-slate-300 font-medium">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>{{ $overallStats->izin }} Izin
                    </span>
                    <span>•</span>
                    <span class="inline-flex items-center gap-1 text-slate-600 dark:text-slate-300 font-medium">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>{{ $overallStats->sakit }} Sakit
                    </span>
                </div>
            </div>

            {{-- Card 4: Alpa / Tanpa Keterangan --}}
            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center justify-between gap-2 mb-3">
                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Tanpa keterangan</span>
                    <div class="w-9 h-9 rounded-xl bg-[#06466C]/10 text-[#06466C] dark:bg-[#06466C]/30 dark:text-sky-300 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold font-mono {{ $overallStats->alpa > 0 ? 'text-rose-600 dark:text-rose-400' : 'text-slate-900 dark:text-white' }}">
                        {{ $overallStats->alpa }}
                    </span>
                    <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">sesi alpa</span>
                </div>
                <p class="text-xs {{ $overallStats->alpa > 0 ? 'text-rose-500 dark:text-rose-400 font-medium' : 'text-slate-500 dark:text-slate-400' }} mt-2">
                    {{ $overallStats->alpa > 0 ? 'Segera konfirmasi ke wali kelas' : 'Disiplin kehadiran sangat baik' }}
                </p>
            </div>
        </div>

        {{-- Active Session Alert Banner (if any) --}}
        @if ($overallStats->active_count > 0)
            <div class="bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 rounded-2xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="w-3 h-3 rounded-full bg-emerald-500 shrink-0"></span>
                    <div>
                        <p class="text-sm font-bold text-emerald-900 dark:text-emerald-200">
                            Ada {{ $overallStats->active_count }} Mata Pelajaran dengan Sesi Presensi Aktif!
                        </p>
                        <p class="text-xs text-emerald-700 dark:text-emerald-300">
                            Sesi absensi dibuka oleh guru pengajar. Buka kartu mapel di bawah untuk melakukan absensi kehadiran.
                        </p>
                    </div>
                </div>
                <div class="shrink-0">
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-emerald-600 text-white rounded-lg text-xs font-semibold shadow-sm">
                        Sesi Aktif
                    </span>
                </div>
            </div>
        @endif

        {{-- Search & Filter Bar --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-4 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            {{-- Tab Hari --}}
            <div class="flex items-center gap-1.5 overflow-x-auto pb-1 md:pb-0 scrollbar-none" id="day-tabs">
                @php
                    $days = ['Semua', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                @endphp
                @foreach ($days as $day)
                    @php
                        $dayCount = $day === 'Semua' 
                            ? $data->count() 
                            : $data->filter(fn($item) => $item->hari && strcasecmp($item->hari->nama_hari, $day) === 0)->count();
                    @endphp
                    @if ($day === 'Semua' || $dayCount > 0)
                        <button type="button"
                            onclick="filterByDay('{{ $day }}', this)"
                            class="day-filter-btn px-3.5 py-1.5 rounded-xl text-xs font-medium transition shrink-0 {{ $day === 'Semua' ? 'bg-slate-900 text-white dark:bg-white dark:text-slate-900 shadow-sm' : 'bg-slate-100 dark:bg-slate-700/60 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' }}"
                            data-day="{{ $day }}">
                            {{ $day }}
                            <span class="ml-1 text-[10px] px-1.5 py-0.2 rounded-full {{ $day === 'Semua' ? 'bg-white/20 text-white dark:bg-slate-900/20 dark:text-slate-900' : 'bg-slate-200 dark:bg-slate-600 text-slate-700 dark:text-slate-300' }}">
                                {{ $dayCount }}
                            </span>
                        </button>
                    @endif
                @endforeach
            </div>

            {{-- Search Input --}}
            <div class="relative w-full md:w-72">
                <input type="text"
                    id="search-input"
                    onkeyup="filterCards()"
                    placeholder="Cari mapel atau guru..."
                    class="w-full pl-9 pr-4 py-2 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </div>

        {{-- Subject Cards Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="subject-cards-container">
            @forelse ($data as $item)
                @php
                    $stats = $item->stats;
                    $mapelName = $item->mataPelajaran->nama_matpel ?? 'Mata Pelajaran';
                    $guruName = $item->guru->nama_guru ?? 'Guru Pengajar';
                    $namaHari = $item->hari->nama_hari ?? 'Senin';
                    $waktu = ($item->waktu_mulai ?? '07:00') . ' - ' . ($item->waktu_selesai ?? '08:30');
                    $isToday = $stats->is_today;
                    $hasActive = $stats->has_active;
                @endphp
                <div class="subject-card bg-white dark:bg-slate-800 border {{ $hasActive ? 'border-emerald-300 dark:border-emerald-700 ring-2 ring-emerald-500/10' : 'border-slate-200 dark:border-slate-700' }} rounded-2xl p-5 shadow-sm hover:shadow-md transition-all flex flex-col justify-between"
                    data-day="{{ $namaHari }}"
                    data-title="{{ strtolower($mapelName) }}"
                    data-guru="{{ strtolower($guruName) }}">

                    {{-- Top Pill Bar --}}
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold {{ $isToday ? 'bg-brand-50 text-brand-700 border border-brand-200 dark:bg-brand-950/40 dark:text-brand-300 dark:border-brand-800' : 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300' }}">
                                    <svg class="w-3.5 h-3.5 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $namaHari }} • {{ $waktu }}
                                </span>
                                @if ($isToday)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-100 text-amber-800 dark:bg-amber-900/60 dark:text-amber-300">
                                        Hari Ini
                                    </span>
                                @endif
                            </div>

                            @if ($hasActive)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-300">
                                    <span class="relative flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                    </span>
                                    Sesi Dibuka
                                </span>
                            @endif
                        </div>

                        {{-- Mapel Info --}}
                        <div class="flex items-start gap-3 mt-1">
                            <div class="w-11 h-11 rounded-xl {{ $hasActive ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300' : 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300' }} flex items-center justify-center font-bold text-sm shrink-0">
                                {{ strtoupper(substr($mapelName, 0, 2)) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-base font-bold text-slate-900 dark:text-white truncate">
                                    {{ $mapelName }}
                                </h3>
                                <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                    <span class="truncate">{{ $guruName }}</span>
                                    <span>•</span>
                                    <span>Kelas {{ $item->kelas->nama_kelas ?? '-' }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Attendance Rate Progress Bar --}}
                        <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-700/60">
                            <div class="flex items-center justify-between text-xs mb-1.5">
                                <span class="font-medium text-slate-600 dark:text-slate-300">Kehadiran Mapel</span>
                                <span class="font-bold text-slate-900 dark:text-white">{{ $stats->persentase }}%</span>
                            </div>
                            <div class="w-full bg-slate-100 dark:bg-slate-700 rounded-full h-2 overflow-hidden">
                                <div class="h-2 rounded-full {{ $stats->persentase >= 80 ? 'bg-emerald-500' : ($stats->persentase >= 75 ? 'bg-amber-500' : 'bg-rose-500') }}"
                                    style="width: {{ min(100, $stats->persentase) }}%"></div>
                            </div>

                            {{-- Mini Stats Chips --}}
                            <div class="flex flex-wrap items-center gap-2 mt-3 text-xs">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 font-medium">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    {{ $stats->hadir }} Hadir
                                </span>
                                @if ($stats->izin > 0)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-purple-50 dark:bg-purple-950/40 text-purple-700 dark:text-purple-300 font-medium">
                                        {{ $stats->izin }} Izin
                                    </span>
                                @endif
                                @if ($stats->sakit > 0)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-300 font-medium">
                                        {{ $stats->sakit }} Sakit
                                    </span>
                                @endif
                                @if ($stats->alpa > 0)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-rose-50 dark:bg-rose-950/40 text-rose-700 dark:text-rose-300 font-medium">
                                        {{ $stats->alpa }} Alpa
                                    </span>
                                @endif
                                <span class="text-slate-400 dark:text-slate-500 text-[11px] ml-auto">
                                    {{ $stats->total }} Pertemuan Tercatat
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Card Footer Action --}}
                    <div class="mt-4 pt-3 flex items-center justify-between gap-2 border-t border-slate-100 dark:border-slate-700/60">
                        <a href="{{ route('siswa.absensi.details', $item->id_kelas_mata_pelajaran) }}"
                            class="inline-flex items-center justify-center gap-1.5 w-full py-2 px-3 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-800 dark:text-slate-200 rounded-xl text-xs font-semibold transition">
                            <span>Lihat Riwayat & Pertemuan</span>
                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-6">
                    <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-400 mx-auto flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold text-slate-800 dark:text-slate-200">Belum Ada Jadwal Mata Pelajaran</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 max-w-sm mx-auto">
                        Kamu belum terdaftar pada jadwal kelas mata pelajaran semester ini. Hubungi wali kelas atau bagian kurikulum.
                    </p>
                </div>
            @endforelse
        </div>

        {{-- Client-side Filter Empty State --}}
        <div id="filter-empty-state" class="hidden py-12 text-center bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-6">
            <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-400 mx-auto flex items-center justify-center mb-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <h3 class="text-sm font-bold text-slate-800 dark:text-slate-200">Tidak Menemukan Mata Pelajaran</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                Coba sesuaikan filter hari atau kata kunci pencarian kamu.
            </p>
        </div>

        {{-- Informative Footnote / Rules Card --}}
        <div class="bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700/60 rounded-2xl p-4 flex items-start gap-3 text-xs text-slate-600 dark:text-slate-400">
            <div class="w-6 h-6 rounded-lg bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0 mt-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="leading-relaxed">
                <strong class="font-semibold text-slate-800 dark:text-slate-200">Ketentuan Presensi & Evaluasi:</strong>
                Presensi kehadiran dicatat secara resmi oleh guru pengajar atau melalui pemindaian QR code saat sesi pembelajaran dibuka. Batas minimal kehadiran untuk mengikuti Ujian Akhir Semester adalah <strong>75%</strong> pada masing-masing mata pelajaran.
            </div>
        </div>

    </div>

    {{-- Interactive Filter & Search Script --}}
    <script>
        let currentDayFilter = 'Semua';

        function filterByDay(day, btnElement) {
            currentDayFilter = day;

            // Update Tab active styling
            document.querySelectorAll('.day-filter-btn').forEach(btn => {
                btn.className = 'day-filter-btn px-3.5 py-1.5 rounded-xl text-xs font-medium transition shrink-0 bg-slate-100 dark:bg-slate-700/60 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700';
            });
            btnElement.className = 'day-filter-btn px-3.5 py-1.5 rounded-xl text-xs font-medium transition shrink-0 bg-slate-900 text-white dark:bg-white dark:text-slate-900 shadow-sm';

            filterCards();
        }

        function filterCards() {
            const query = (document.getElementById('search-input')?.value || '').toLowerCase().trim();
            const cards = document.querySelectorAll('.subject-card');
            let visibleCount = 0;

            cards.forEach(card => {
                const day = card.getAttribute('data-day') || '';
                const title = card.getAttribute('data-title') || '';
                const guru = card.getAttribute('data-guru') || '';

                const matchesDay = currentDayFilter === 'Semua' || day.toLowerCase() === currentDayFilter.toLowerCase();
                const matchesQuery = !query || title.includes(query) || guru.includes(query);

                if (matchesDay && matchesQuery) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            const emptyState = document.getElementById('filter-empty-state');
            if (emptyState) {
                if (visibleCount === 0 && cards.length > 0) {
                    emptyState.classList.remove('hidden');
                } else {
                    emptyState.classList.add('hidden');
                }
            }
        }
    </script>

    {{-- Flash Notifications via SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Perhatian',
                text: '{{ session('error') }}',
                confirmButtonColor: '#3b82f6',
            });
        @endif

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                confirmButtonColor: '#10b981',
            });
        @endif

        @if (session('info'))
            Swal.fire({
                icon: 'info',
                title: 'Informasi',
                text: '{{ session('info') }}',
                confirmButtonColor: '#3b82f6',
            });
        @endif
    </script>
</x-siswa-layout>
