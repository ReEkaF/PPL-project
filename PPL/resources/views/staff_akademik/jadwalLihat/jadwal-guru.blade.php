<x-staffakademik-layout>
    <div class="space-y-6 pb-10">
        {{-- Session Flash Message --}}
        @if(session('success'))
            <div class="flex items-center justify-between p-4 text-xs font-medium text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-xl shadow-sm">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-check text-sm text-emerald-600"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
        @endif

        {{-- Header & Breadcrumbs --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="space-y-1">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2 text-xs">
                        <li class="inline-flex items-center">
                            <a href="{{ route('staff_akademik.dashboard') }}" class="text-slate-500 hover:text-brand-800 transition-colors flex items-center gap-1.5">
                                <i class="fa-solid fa-house text-[11px]"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="flex items-center text-slate-400">
                            <i class="fa-solid fa-chevron-right text-[10px] mx-1"></i>
                            <span class="text-slate-800 font-medium">Monitoring Jadwal Guru</span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Monitoring Jadwal per Guru</h1>
                <p class="text-xs text-slate-500">
                    Pantau alokasi jam mengajar, kelas bimbingan, dan beban kerja pengajaran masing-masing guru.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('staff_akademik.jadwal') }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-medium bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 transition-colors shadow-sm">
                    <i class="fa-solid fa-sliders text-[11px] text-slate-500"></i>
                    <span>Kelola Jadwal</span>
                </a>
            </div>
        </div>

        {{-- Filter Card --}}
        <div class="bg-white border border-slate-200 rounded-xl p-4 sm:p-5 shadow-sm">
            <form action="{{ route('lihat.jadwal.guru') }}" method="GET" class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex flex-col sm:flex-row sm:items-center gap-2.5">
                    <label for="guru_id" class="text-xs font-semibold text-slate-700 whitespace-nowrap">Filter Tenaga Pendidik:</label>
                    <select name="guru_id" id="guru_id" class="text-xs border border-slate-200 rounded-lg shadow-sm bg-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 py-2 px-3 sm:w-80" onchange="this.form.submit()">
                        <option value="">-- Semua Guru (Tampilkan Seluruh Jadwal) --</option>
                        @foreach($guru as $gr)
                            <option value="{{ $gr->id_guru }}" {{ (isset($guru_id) && $guru_id == $gr->id_guru) || request('guru_id') == $gr->id_guru ? 'selected' : '' }}>
                                {{ $gr->nama_guru }}
                            </option>
                        @endforeach
                    </select>
                    @if(request('guru_id'))
                        <a href="{{ route('lihat.jadwal.guru') }}" class="inline-flex items-center gap-1 text-xs text-slate-500 hover:text-rose-600 transition-colors">
                            <i class="fa-solid fa-xmark text-[11px]"></i>
                            <span>Reset Filter</span>
                        </a>
                    @endif
                </div>

                @if(isset($data) && !$data->isEmpty())
                    <div class="text-xs text-slate-500 font-mono">
                        Total Sesi Terjadwal: <span class="font-bold text-slate-800">{{ $data->count() }} sesi</span>
                    </div>
                @endif
            </form>
        </div>

        {{-- Jadwal Cards Grouped by Guru --}}
        @php
            $targetGurus = $guru->when(isset($guru_id) && $guru_id, function($q) use ($guru_id) {
                return $q->where('id_guru', $guru_id);
            });
            $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            $hasAnyData = false;
        @endphp

        <div class="space-y-6">
            @foreach ($targetGurus as $gr)
                @php
                    $jadwalGuru = $data->where('id_guru', $gr->id_guru);
                @endphp

                @if ($jadwalGuru->isEmpty())
                    @continue
                @endif

                @php $hasAnyData = true; @endphp

                <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="p-4 sm:p-5 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-brand-50 border border-brand-100 text-brand-800 flex items-center justify-center font-bold text-xs uppercase shadow-xs">
                                {{ substr($gr->nama_guru ?? 'G', 0, 1) }}
                            </div>
                            <div>
                                <h2 class="text-sm font-bold text-slate-900">{{ $gr->nama_guru }}</h2>
                                <div class="flex items-center gap-2 mt-0.5 text-xs text-slate-500 font-mono">
                                    <span>NIP: {{ $gr->nip ?? '-' }}</span>
                                    <span>•</span>
                                    <span>{{ $jadwalGuru->count() }} sesi pembelajaran aktif</span>
                                </div>
                            </div>
                        </div>
                        @if(!request('guru_id'))
                            <div>
                                <a href="{{ route('lihat.jadwal.guru', ['guru_id' => $gr->id_guru]) }}"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 transition-colors shadow-sm">
                                    <span>Fokus Guru Ini</span>
                                    <i class="fa-solid fa-arrow-right text-[10px] text-slate-400"></i>
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-slate-600">
                            <thead class="bg-slate-50/75 border-b border-slate-100 text-slate-700 font-semibold uppercase text-[11px] tracking-wider">
                                <tr>
                                    <th class="px-5 py-3 w-28">Hari</th>
                                    <th class="px-5 py-3 w-36">Waktu</th>
                                    <th class="px-5 py-3">Mata Pelajaran</th>
                                    <th class="px-5 py-3">Rombel Kelas</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($hariList as $hari)
                                    @php
                                        $jadwalHari = $jadwalGuru->where('nama_hari', $hari)->sortBy('waktu_mulai');
                                    @endphp

                                    @foreach ($jadwalHari as $item)
                                        <tr class="hover:bg-slate-50/60 transition-colors">
                                            <td class="px-5 py-3 font-medium text-slate-800">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-slate-100 text-slate-700">
                                                    {{ $item->nama_hari }}
                                                </span>
                                            </td>
                                            <td class="px-5 py-3 font-mono text-slate-500 whitespace-nowrap">
                                                <i class="fa-regular fa-clock text-[10px] text-slate-400 mr-1"></i>
                                                {{ substr($item->waktu_mulai, 0, 5) }} - {{ substr($item->waktu_selesai, 0, 5) }}
                                            </td>
                                            <td class="px-5 py-3 font-semibold text-slate-800">
                                                {{ $item->nama_matpel }}
                                            </td>
                                            <td class="px-5 py-3">
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-medium bg-brand-50 border border-brand-100 text-brand-800 font-mono">
                                                    <i class="fa-solid fa-chalkboard text-[10px]"></i>
                                                    <span>Kelas {{ $item->nama_kelas }}</span>
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach

            @if (!$hasAnyData)
                <div class="bg-white border border-slate-200 rounded-xl p-12 text-center shadow-sm">
                    <i class="fa-regular fa-calendar-xmark text-4xl text-slate-300 mb-3 block"></i>
                    <h3 class="text-sm font-bold text-slate-800">Tidak Ada Jadwal Mengajar Ditemukan</h3>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                        {{ request('guru_id') ? 'Guru yang dipilih belum memiliki jadwal mengajar pada tahun ajaran aktif.' : 'Belum ada jadwal mengajar guru yang terdaftar pada tahun ajaran aktif.' }}
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-staffakademik-layout>
