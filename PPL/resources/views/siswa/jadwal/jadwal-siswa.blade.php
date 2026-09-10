<x-siswa-layout>
    <div class="max-w-6xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-900">Jadwal Pelajaran</h1>
                <p class="text-sm text-slate-500 mt-0.5">
                    Halo, <span class="font-semibold text-slate-700">{{ $siswa->nama_siswa }}</span> — berikut jadwal pelajaran kamu minggu ini.
                </p>
            </div>

            @if (!isset($message) && !$jadwal->isEmpty())
            <a href="{{ route('siswa.jadwal.print') }}" target="_blank"
                class="inline-flex items-center gap-2 px-4 py-2 bg-brand-800 text-white text-sm font-medium rounded-lg hover:bg-brand-900 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak PDF
            </a>
            @endif
        </div>

        {{-- No Schedule State --}}
        @if (isset($message) && $message)
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 flex items-start gap-4">
                <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-amber-800 text-sm">Belum Ada Kelas</p>
                    <p class="text-amber-700 text-sm mt-0.5">{{ $message }}</p>
                </div>
            </div>

        @elseif ($jadwal->isEmpty())
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-12 text-center">
                <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="font-semibold text-slate-600">Jadwal Belum Tersedia</p>
                <p class="text-sm text-slate-400 mt-1">Jadwal pelajaran untuk kelas kamu belum diatur.</p>
            </div>

        @else
            @php
                // Group jadwal by hari
                $jadwalPerHari = $jadwal->groupBy('nama_hari');

                // Urutan hari yang benar
                $urutan = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

                // Warna per mata pelajaran (konsisten berdasarkan nama)
                $warnaPalette = [
                    'brand'   => ['bg-brand-50', 'border-brand-200', 'text-brand-800', 'text-brand-600'],
                    'emerald' => ['bg-emerald-50', 'border-emerald-200', 'text-emerald-800', 'text-emerald-600'],
                    'violet'  => ['bg-violet-50', 'border-violet-200', 'text-violet-800', 'text-violet-600'],
                    'amber'   => ['bg-amber-50', 'border-amber-200', 'text-amber-800', 'text-amber-600'],
                    'rose'    => ['bg-rose-50', 'border-rose-200', 'text-rose-800', 'text-rose-600'],
                    'cyan'    => ['bg-cyan-50', 'border-cyan-200', 'text-cyan-800', 'text-cyan-600'],
                    'orange'  => ['bg-orange-50', 'border-orange-200', 'text-orange-800', 'text-orange-600'],
                    'teal'    => ['bg-teal-50', 'border-teal-200', 'text-teal-800', 'text-teal-600'],
                ];
                $paletteKeys = array_keys($warnaPalette);
                $matpelColors = [];
                $colorIdx = 0;
                foreach ($jadwal as $item) {
                    if (!isset($matpelColors[$item->nama_matpel])) {
                        $matpelColors[$item->nama_matpel] = $warnaPalette[$paletteKeys[$colorIdx % count($paletteKeys)]];
                        $colorIdx++;
                    }
                }

                // Hari ini
                $hariIni = match(date('N')) {
                    '1' => 'Senin', '2' => 'Selasa', '3' => 'Rabu',
                    '4' => 'Kamis', '5' => 'Jumat', '6' => 'Sabtu', default => ''
                };

                // Ringkasan statistik
                $totalMapel   = $jadwal->pluck('nama_matpel')->unique()->count();
                $totalSesi    = $jadwal->count();
                $hariAktif    = $jadwalPerHari->count();
            @endphp

            {{-- Stats Strip --}}
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white border border-slate-200 rounded-xl p-4 text-center">
                    <div class="text-2xl font-extrabold text-slate-900">{{ $hariAktif }}</div>
                    <div class="text-xs text-slate-500 mt-0.5">Hari Sekolah</div>
                </div>
                <div class="bg-white border border-slate-200 rounded-xl p-4 text-center">
                    <div class="text-2xl font-extrabold text-slate-900">{{ $totalSesi }}</div>
                    <div class="text-xs text-slate-500 mt-0.5">Total Sesi</div>
                </div>
                <div class="bg-white border border-slate-200 rounded-xl p-4 text-center">
                    <div class="text-2xl font-extrabold text-slate-900">{{ $totalMapel }}</div>
                    <div class="text-xs text-slate-500 mt-0.5">Mata Pelajaran</div>
                </div>
            </div>

            {{-- Schedule Per Day --}}
            <div class="space-y-4">
                @foreach ($urutan as $hari)
                    @if ($jadwalPerHari->has($hari))
                        @php
                            $sesiHari   = $jadwalPerHari[$hari];
                            $isHariIni  = ($hari === $hariIni);
                        @endphp

                        <div class="bg-white border rounded-xl overflow-hidden {{ $isHariIni ? 'border-brand-300 shadow-md' : 'border-slate-200' }}">
                            {{-- Day Header --}}
                            <div class="flex items-center gap-3 px-5 py-3.5 {{ $isHariIni ? 'bg-brand-800' : 'bg-slate-50 border-b border-slate-200' }}">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ $isHariIni ? 'bg-white/20' : 'bg-white border border-slate-200' }}">
                                    <svg class="w-4 h-4 {{ $isHariIni ? 'text-white' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <span class="font-bold text-sm {{ $isHariIni ? 'text-white' : 'text-slate-900' }}">{{ $hari }}</span>
                                    @if ($isHariIni)
                                        <span class="ml-2 text-xs bg-white/20 text-white px-2 py-0.5 rounded-full font-medium">Hari ini</span>
                                    @endif
                                </div>
                                <span class="text-xs font-medium {{ $isHariIni ? 'text-white/70' : 'text-slate-400' }}">{{ $sesiHari->count() }} sesi</span>
                            </div>

                            {{-- Sessions List --}}
                            <div class="divide-y divide-slate-100">
                                @foreach ($sesiHari as $idx => $sesi)
                                    @php
                                        $color = $matpelColors[$sesi->nama_matpel] ?? $warnaPalette['brand'];
                                    @endphp
                                    <div class="flex items-center gap-4 px-5 py-3.5 hover:bg-slate-50/70 transition-colors">
                                        {{-- Session Number --}}
                                        <div class="w-7 h-7 rounded-full bg-slate-100 flex items-center justify-center shrink-0">
                                            <span class="text-xs font-bold text-slate-500">{{ $idx + 1 }}</span>
                                        </div>

                                        {{-- Time --}}
                                        <div class="w-28 shrink-0">
                                            <div class="flex items-center gap-1 text-sm font-semibold text-slate-700">
                                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                {{ date('H:i', strtotime($sesi->waktu_mulai)) }}
                                            </div>
                                            <div class="text-xs text-slate-400 ml-[18px]">
                                                s.d. {{ date('H:i', strtotime($sesi->waktu_selesai)) }}
                                            </div>
                                        </div>

                                        {{-- Divider --}}
                                        <div class="w-px h-8 bg-slate-200 shrink-0"></div>

                                        {{-- Subject Badge + Teacher --}}
                                        <div class="flex-1 min-w-0 flex flex-col sm:flex-row sm:items-center gap-1.5 sm:gap-3">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold border {{ $color[0] }} {{ $color[1] }} {{ $color[2] }} w-fit">
                                                {{ $sesi->nama_matpel }}
                                            </span>
                                            <div class="flex items-center gap-1.5 text-sm text-slate-500">
                                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                                <span class="truncate">{{ $sesi->nama_guru }}</span>
                                            </div>
                                        </div>

                                        {{-- Duration Badge --}}
                                        @php
                                            $durasi = (strtotime($sesi->waktu_selesai) - strtotime($sesi->waktu_mulai)) / 60;
                                        @endphp
                                        <div class="hidden sm:block shrink-0 text-xs text-slate-400 font-medium">
                                            {{ $durasi }} mnt
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            {{-- Legend: Mata Pelajaran --}}
            <div class="bg-white border border-slate-200 rounded-xl p-5">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Legenda Mata Pelajaran</p>
                <div class="flex flex-wrap gap-2">
                    @foreach ($matpelColors as $namaMapel => $color)
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium border {{ $color[0] }} {{ $color[1] }} {{ $color[2] }}">
                            {{ $namaMapel }}
                        </span>
                    @endforeach
                </div>
            </div>

        @endif
    </div>
</x-siswa-layout>
