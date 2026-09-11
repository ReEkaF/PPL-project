<x-staffakademik-layout>
    <div class="space-y-6 pb-10">
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
                            <span class="text-slate-800 font-medium">Rekap Absensi Siswa</span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Rekapitulasi Absensi & Kehadiran</h1>
                <p class="text-xs text-slate-500">
                    Daftar jurnal presensi per mata pelajaran dan rombongan belajar untuk monitoring kehadiran siswa.
                </p>
            </div>
        </div>

        {{-- Filter Bar --}}
        <div class="bg-white border border-slate-200 rounded-xl p-4 sm:p-5 shadow-sm">
            <form action="{{ route('akademik.absensi.index') }}" method="GET" class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <label for="kelas_id" class="text-xs font-semibold text-slate-700 whitespace-nowrap">Filter Rombel:</label>
                    <select name="kelas_id" id="kelas_id" class="text-xs border-slate-200 rounded-lg shadow-sm bg-slate-50 focus:bg-white focus:border-brand-800 py-1.5 px-3" onchange="this.form.submit()">
                        <option value="">Semua Kelas</option>
                        @foreach($allKelas as $kls)
                            <option value="{{ $kls->id_kelas }}" {{ request('kelas_id') == $kls->id_kelas ? 'selected' : '' }}>
                                Kelas {{ $kls->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="text-xs text-slate-500 font-mono">
                    Total: {{ $data->count() }} kelas mata pelajaran
                </div>
            </form>
        </div>

        {{-- Cards by Kelas --}}
        @php
            $grouped = $data->groupBy('kelas.nama_kelas');
        @endphp

        <div class="space-y-6">
            @forelse ($grouped as $kelasName => $items)
                <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="p-4 sm:p-5 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-brand-50 border border-brand-100 text-brand-800 flex items-center justify-center font-bold text-xs font-mono">
                                {{ substr($kelasName, 0, 2) }}
                            </div>
                            <div>
                                <h2 class="text-sm font-bold text-slate-900">Jadwal Kelas {{ $kelasName }}</h2>
                                <p class="text-xs text-slate-500 font-mono">{{ $items->count() }} mata pelajaran terjadwal</p>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-slate-600">
                            <thead class="bg-slate-50/75 border-b border-slate-100 text-slate-700 font-semibold uppercase text-[11px] tracking-wider">
                                <tr>
                                    <th class="px-5 py-3 w-28">Hari</th>
                                    <th class="px-5 py-3 w-36">Waktu</th>
                                    <th class="px-5 py-3">Mata Pelajaran</th>
                                    <th class="px-5 py-3">Guru Pengajar</th>
                                    <th class="px-5 py-3 text-right w-32">Presensi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($items as $item)
                                    <tr class="hover:bg-slate-50/60 transition-colors">
                                        <td class="px-5 py-3.5 font-medium text-slate-800">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-slate-100 text-slate-700">
                                                {{ $item->hari->nama_hari ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-3.5 font-mono text-slate-500 whitespace-nowrap">
                                            <i class="fa-regular fa-clock text-[10px] text-slate-400 mr-1"></i>
                                            {{ substr($item->waktu_mulai ?? '', 0, 5) }} - {{ substr($item->waktu_selesai ?? '', 0, 5) }}
                                        </td>
                                        <td class="px-5 py-3.5 font-semibold text-slate-800">
                                            {{ $item->mataPelajaran->nama_matpel ?? '-' }}
                                        </td>
                                        <td class="px-5 py-3.5 text-slate-600">
                                            <div class="inline-flex items-center gap-1.5">
                                                <div class="w-5 h-5 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center text-[10px] font-bold">
                                                    {{ substr($item->guru->nama_guru ?? 'G', 0, 1) }}
                                                </div>
                                                <span>{{ $item->guru->nama_guru ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                            <a href="{{ route('akademik.absensi.details', $item->id_kelas_mata_pelajaran) }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-brand-800 bg-brand-50 hover:bg-brand-100 border border-brand-100 rounded-lg transition-colors">
                                                <i class="fa-solid fa-list-check text-[10px]"></i>
                                                <span>Rincian Presensi</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                <div class="bg-white border border-slate-200 rounded-xl p-12 text-center shadow-sm">
                    <i class="fa-regular fa-calendar-check text-4xl text-slate-300 mb-3 block"></i>
                    <h3 class="text-sm font-bold text-slate-800">Tidak Ada Data Absensi</h3>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                        Belum ada data jadwal atau presensi pertemuan yang ditemukan untuk rombel yang dipilih.
                    </p>
                </div>
            @endforelse
        </div>
    </div>
</x-staffakademik-layout>
