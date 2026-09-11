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
                            <span class="text-slate-800 font-medium">Monitoring Jadwal Kelas</span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Monitoring Jadwal per Kelas</h1>
                <p class="text-xs text-slate-500">
                    Lihat dan pantau susunan jadwal pembelajaran siswa per rombongan belajar secara terpusat.
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

        {{-- Filter Bar --}}
        <div class="bg-white border border-slate-200 rounded-xl p-4 sm:p-5 shadow-sm">
            <form action="{{ route('lihat.jadwal.kelas') }}" method="GET" class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <label for="kelas_id" class="text-xs font-semibold text-slate-700 whitespace-nowrap">Pilih Kelas:</label>
                    <select name="kelas_id" id="kelas_id" class="text-xs border-slate-200 rounded-lg shadow-sm bg-slate-50 focus:bg-white focus:border-brand-800 py-1.5 px-3" onchange="this.form.submit()">
                        <option value="">Semua Kelas</option>
                        @foreach($kelas as $kls)
                            <option value="{{ $kls->id_kelas }}" {{ (isset($kelas_id) && $kelas_id == $kls->id_kelas) || request('kelas_id') == $kls->id_kelas ? 'selected' : '' }}>
                                Kelas {{ $kls->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="text-xs text-slate-500 font-mono">
                    Total: {{ $data->count() }} sesi terjadwal
                </div>
            </form>
        </div>

        {{-- Jadwal per Kelas --}}
        @php
            $targetKelas = $kelas->when(isset($kelas_id) && $kelas_id, function($q) use ($kelas_id) {
                return $q->where('id_kelas', $kelas_id);
            });
            $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            $hasAnyData = false;
        @endphp

        <div class="space-y-6">
            @foreach ($targetKelas as $kls)
                @php
                    $jadwalKelas = $data->where('nama_kelas', $kls->nama_kelas);
                @endphp

                @if ($jadwalKelas->isEmpty())
                    @continue
                @endif

                @php $hasAnyData = true; @endphp

                <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="p-4 sm:p-5 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-brand-50 border border-brand-100 text-brand-800 flex items-center justify-center font-bold text-xs font-mono">
                                {{ substr($kls->nama_kelas, 0, 2) }}
                            </div>
                            <div>
                                <h2 class="text-sm font-bold text-slate-900">Jadwal Kelas {{ $kls->nama_kelas }}</h2>
                                <p class="text-xs text-slate-500 font-mono">{{ $jadwalKelas->count() }} sesi terdaftar</p>
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
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($hariList as $hari)
                                    @php
                                        $jadwalHari = $jadwalKelas->where('nama_hari', $hari)->sortBy('waktu_mulai');
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
                                            <td class="px-5 py-3 text-slate-600">
                                                <div class="inline-flex items-center gap-1.5">
                                                    <div class="w-5 h-5 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center text-[10px] font-bold">
                                                        {{ substr($item->nama_guru ?? 'G', 0, 1) }}
                                                    </div>
                                                    <span>{{ $item->nama_guru }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach

            @if(!$hasAnyData)
                <div class="bg-white border border-slate-200 rounded-xl p-12 text-center shadow-sm">
                    <i class="fa-regular fa-calendar-xmark text-4xl text-slate-300 mb-3 block"></i>
                    <h3 class="text-sm font-bold text-slate-800">Tidak Ada Jadwal Kelas</h3>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                        Belum ada jadwal pembelajaran yang terdata untuk kelas yang dipilih.
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-staffakademik-layout>
