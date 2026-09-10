<x-siswa-layout>
    <div class="max-w-6xl mx-auto space-y-6">

        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'route' => route('siswa.dashboard')],
                ['label' => 'Absensi Siswa', 'route' => route('siswa.absensi.index')],
                ['label' => $detail->mataPelajaran->nama_matpel ?? 'Detail Pertemuan', 'route' => route('siswa.absensi.details', $detail->id_kelas_mata_pelajaran)],
            ];
            $mapelName = $detail->mataPelajaran->nama_matpel ?? 'Mata Pelajaran';
            $guruName = $detail->guru->nama_guru ?? 'Guru Pengajar';
            $kelasName = $detail->kelas->nama_kelas ?? '-';
            $namaHari = $detail->hari->nama_hari ?? '-';
            $jam = ($detail->waktu_mulai ?? '07:00') . ' - ' . ($detail->waktu_selesai ?? '08:30');
        @endphp

        {{-- Top Navigation & Breadcrumb --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <x-breadcrumb :breadcrumbs="$breadcrumbs" />
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white mt-1">
                    Detail Presensi & Riwayat Pertemuan
                </h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                    Riwayat presensi tatap muka dan status kehadiran kamu untuk mata pelajaran ini.
                </p>
            </div>
            <div class="shrink-0">
                <a href="{{ route('siswa.absensi.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-semibold shadow-sm transition">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Kembali ke Rekap</span>
                </a>
            </div>
        </div>

        {{-- Subject Overview Header Card --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-6 shadow-sm">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                {{-- Left: Subject & Teacher Details --}}
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-brand-50 text-brand-700 dark:bg-brand-950/50 dark:text-brand-300 border border-brand-100 dark:border-brand-800 flex items-center justify-center font-extrabold text-lg shrink-0">
                        {{ strtoupper(substr($mapelName, 0, 2)) }}
                    </div>
                    <div>
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300">
                                Kelas {{ $kelasName }}
                            </span>
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-xs font-medium bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $namaHari }}, {{ $jam }} WIB
                            </span>
                        </div>
                        <h2 class="text-xl font-bold text-slate-900 dark:text-white">
                            {{ $mapelName }}
                        </h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 flex items-center gap-1.5">
                            <span>Guru Pengajar:</span>
                            <strong class="font-semibold text-slate-700 dark:text-slate-300">{{ $guruName }}</strong>
                        </p>
                    </div>
                </div>

                {{-- Right: Attendance Performance Stats --}}
                <div class="flex flex-wrap sm:flex-nowrap items-center gap-4 pt-4 lg:pt-0 border-t lg:border-t-0 border-slate-100 dark:border-slate-700">
                    {{-- Percent circular / box --}}
                    <div class="bg-slate-50 dark:bg-slate-900/60 rounded-xl p-3 border border-slate-200 dark:border-slate-700 text-center min-w-[120px]">
                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block mb-0.5">Kehadiran</span>
                        <div class="text-2xl font-extrabold {{ $stats->persentase >= 80 ? 'text-emerald-600 dark:text-emerald-400' : ($stats->persentase >= 75 ? 'text-amber-600 dark:text-amber-400' : 'text-rose-600 dark:text-rose-400') }}">
                            {{ $stats->persentase }}%
                        </div>
                        <span class="inline-flex items-center text-[10px] font-semibold mt-1 px-1.5 py-0.2 rounded-full {{ $stats->is_eligible ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-300' : 'bg-rose-100 text-rose-800 dark:bg-rose-900/60 dark:text-rose-300' }}">
                            {{ $stats->is_eligible ? 'Syarat Ujian Aman' : 'Di Bawah Standar' }}
                        </span>
                    </div>

                    {{-- Metrics grid --}}
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <div class="px-3 py-2 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-100 dark:border-emerald-800/40">
                            <span class="text-emerald-600 dark:text-emerald-400 font-medium block">Hadir</span>
                            <strong class="text-emerald-800 dark:text-emerald-200 font-bold text-sm">{{ $stats->hadir }} Sesi</strong>
                        </div>
                        <div class="px-3 py-2 rounded-xl bg-purple-50 dark:bg-purple-950/40 border border-purple-100 dark:border-purple-800/40">
                            <span class="text-purple-600 dark:text-purple-400 font-medium block">Izin</span>
                            <strong class="text-purple-800 dark:text-purple-200 font-bold text-sm">{{ $stats->izin }} Sesi</strong>
                        </div>
                        <div class="px-3 py-2 rounded-xl bg-amber-50 dark:bg-amber-950/40 border border-amber-100 dark:border-amber-800/40">
                            <span class="text-amber-600 dark:text-amber-400 font-medium block">Sakit</span>
                            <strong class="text-amber-800 dark:text-amber-200 font-bold text-sm">{{ $stats->sakit }} Sesi</strong>
                        </div>
                        <div class="px-3 py-2 rounded-xl bg-rose-50 dark:bg-rose-950/40 border border-rose-100 dark:border-rose-800/40">
                            <span class="text-rose-600 dark:text-rose-400 font-medium block">Alpa</span>
                            <strong class="text-rose-800 dark:text-rose-200 font-bold text-sm">{{ $stats->alpa }} Sesi</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Active Meeting Notice & Quick Action Banner (if an active session exists) --}}
        @if ($stats->active_pertemuan)
            @php
                $activeP = $stats->active_pertemuan;
                $isAlreadyHadir = $stats->active_attendance_status === 'Hadir';
            @endphp
            <div class="bg-gradient-to-r {{ $isAlreadyHadir ? 'from-emerald-50 to-teal-50 border-emerald-300 dark:from-emerald-950/40 dark:to-teal-950/30 dark:border-emerald-800' : 'from-blue-50 via-indigo-50 to-purple-50 border-blue-300 dark:from-blue-950/40 dark:to-indigo-950/30 dark:border-blue-800' }} border rounded-2xl p-5 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-start sm:items-center gap-3">
                        <span class="relative flex h-3.5 w-3.5 mt-1 sm:mt-0 shrink-0">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $isAlreadyHadir ? 'bg-emerald-400' : 'bg-blue-400' }} opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3.5 w-3.5 {{ $isAlreadyHadir ? 'bg-emerald-500' : 'bg-blue-600' }}"></span>
                        </span>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-bold text-slate-900 dark:text-white">
                                    Sesi Pertemuan Sedang Dibuka!
                                </h3>
                                <span class="text-xs px-2 py-0.5 rounded-full {{ $isAlreadyHadir ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200' : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' }} font-semibold">
                                    Tanggal: {{ \Carbon\Carbon::parse($activeP->tanggal_pertemuan)->locale('id')->isoFormat('D MMMM Y') }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-600 dark:text-slate-300 mt-1">
                                @if ($isAlreadyHadir)
                                    Presensi kehadiran kamu sudah tercatat (<strong class="text-emerald-700 dark:text-emerald-300">Hadir</strong>). Terima kasih telah hadir tepat waktu!
                                @else
                                    Guru pengajar telah mengaktifkan sesi presensi pertemuan ini. Silakan konfirmasi kehadiran atau scan QR code kelas.
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="shrink-0">
                        @if ($isAlreadyHadir)
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-600 text-white rounded-xl text-xs font-semibold shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Sudah Presensi</span>
                            </span>
                        @else
                            <a href="{{ route('siswa.absensi.scan', $activeP->id_pertemuan) }}"
                                class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow-sm transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>Konfirmasi Kehadiran Sekarang</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        {{-- Meetings Timeline Table --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">
                        Daftar Riwayat Pertemuan
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Total {{ $detail->pertemuan->count() }} sesi pertemuan terjadwal pada semester ini.
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-600 dark:text-slate-300">
                    <thead class="text-xs uppercase bg-slate-50 dark:bg-slate-900/60 text-slate-700 dark:text-slate-400 border-b border-slate-200 dark:border-slate-700">
                        <tr>
                            <th scope="col" class="px-6 py-3.5 font-semibold text-center w-24">Pertemuan</th>
                            <th scope="col" class="px-6 py-3.5 font-semibold">Tanggal Pertemuan</th>
                            <th scope="col" class="px-6 py-3.5 font-semibold text-center">Status Sesi</th>
                            <th scope="col" class="px-6 py-3.5 font-semibold text-center">Status Kehadiran</th>
                            <th scope="col" class="px-6 py-3.5 font-semibold text-center">Aksi / Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @forelse ($detail->pertemuan as $pertemuan)
                            @php
                                $absensi = $pertemuan->absensiSiswa->first() ?? $pertemuan->absensisiswa->first();
                                $status = $absensi ? $absensi->status_absensi : null;
                                $isMeetingActive = $pertemuan->status === 'Aktif';

                                $badgeClass = match ($status) {
                                    'Hadir' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800',
                                    'Izin' => 'bg-purple-100 text-purple-800 dark:bg-purple-950/60 dark:text-purple-300 border-purple-200 dark:border-purple-800',
                                    'Sakit' => 'bg-amber-100 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300 border-amber-200 dark:border-amber-800',
                                    'Alpa' => 'bg-rose-100 text-rose-800 dark:bg-rose-950/60 dark:text-rose-300 border-rose-200 dark:border-rose-800',
                                    default => 'bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-400 border-slate-200 dark:border-slate-600',
                                };
                            @endphp
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/40 transition {{ $isMeetingActive ? 'bg-emerald-50/30 dark:bg-emerald-950/10' : '' }}">
                                {{-- Pertemuan Ke- --}}
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl font-bold text-xs {{ $isMeetingActive ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200 ring-2 ring-emerald-500/20' : 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300' }}">
                                        {{ $loop->iteration }}
                                    </span>
                                </td>

                                {{-- Tanggal Pertemuan --}}
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-900 dark:text-white">
                                        {{ \Carbon\Carbon::parse($pertemuan->tanggal_pertemuan)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                                    </div>
                                    <span class="text-[11px] text-slate-400 dark:text-slate-500">
                                        Sesi mingguan ke-{{ $loop->iteration }}
                                    </span>
                                </td>

                                {{-- Status Sesi --}}
                                <td class="px-6 py-4 text-center">
                                    @if ($isMeetingActive)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-300">
                                            <span class="relative flex h-2 w-2">
                                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                            </span>
                                            Aktif / Dibuka
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300">
                                            Selesai
                                        </span>
                                    @endif
                                </td>

                                {{-- Status Kehadiran Siswa --}}
                                <td class="px-6 py-4 text-center">
                                    @if ($status)
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-lg text-xs font-bold border {{ $badgeClass }}">
                                            @if ($status === 'Hadir')
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            @elseif($status === 'Alpa')
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                            @endif
                                            {{ $status }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-slate-100 text-slate-500 dark:bg-slate-700 dark:text-slate-400">
                                            Belum Ada Data
                                        </span>
                                    @endif
                                </td>

                                {{-- Aksi / Tombol --}}
                                <td class="px-6 py-4 text-center">
                                    @if ($isMeetingActive && $status !== 'Hadir')
                                        <a href="{{ route('siswa.absensi.scan', $pertemuan->id_pertemuan) }}"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold shadow-sm transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span>Presensi Sekarang</span>
                                        </a>
                                    @elseif($status === 'Hadir')
                                        <span class="inline-flex items-center gap-1 text-xs font-medium text-emerald-600 dark:text-emerald-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Tercatat Hadir
                                        </span>
                                    @else
                                        <span class="text-xs text-slate-400 dark:text-slate-500">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-slate-400 dark:text-slate-500">
                                    Belum ada pertemuan yang dibuat untuk mata pelajaran ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Explanatory Rules & Help Box --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-slate-600 dark:text-slate-400">
            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-4 space-y-2 shadow-sm">
                <h4 class="font-bold text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Pedoman Kehadiran Siswa
                </h4>
                <p class="leading-relaxed">
                    Setiap siswa wajib mengikuti minimal <strong>75%</strong> dari total pertemuan yang diselenggarakan guru pengajar. Siswa yang tidak memenuhi batas minimum kehadiran terancam tidak dapat mengikuti Ujian Akhir / CBT semester.
                </p>
            </div>

            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-4 space-y-2 shadow-sm">
                <h4 class="font-bold text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    Keterangan Sakit / Izin
                </h4>
                <p class="leading-relaxed">
                    Jika kamu berhalangan hadir karena sakit atau urusan penting, serahkan surat izin dokter / orang tua kepada <strong>Wali Kelas</strong> atau <strong>Guru Pengajar</strong> agar status absensi kamu diperbarui dan tidak tercatat Alpa.
                </p>
            </div>
        </div>

    </div>

    {{-- SweetAlert2 Notification Script --}}
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
