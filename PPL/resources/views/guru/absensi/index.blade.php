<x-app-guru-layout>
    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-900">Presensi & Kehadiran Siswa</h1>
                <p class="text-sm text-slate-500 mt-0.5">
                    Pilih rombel dan sesi mata pelajaran untuk input kehadiran manual atau aktivasi QR Code presensi.
                </p>
            </div>
        </div>

        {{-- Filter Bar --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-filter text-slate-400 text-xs"></i>
                <span class="text-xs font-semibold text-slate-700">Filter Rombel / Kelas:</span>
            </div>
            <form action="{{ route('guru.absensi.index') }}" method="GET" class="w-full sm:w-64">
                <select name="kelas_id" onchange="this.form.submit()"
                    class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                    <option value="">Semua Kelas</option>
                    @foreach ($allKelas as $kls)
                        <option value="{{ $kls->id_kelas }}" {{ request('kelas_id') == $kls->id_kelas ? 'selected' : '' }}>
                            Kelas {{ $kls->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        {{-- Classes Groupings --}}
        @if ($data->isNotEmpty())
            <div class="space-y-6">
                @foreach ($data->groupBy('kelas.nama_kelas') as $kelasName => $items)
                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                        
                        {{-- Class Header --}}
                        <div class="bg-slate-50 px-5 py-3.5 border-b border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-chalkboard text-brand-700 text-xs"></i>
                                <h2 class="font-bold text-slate-800 text-sm">Kelas {{ $kelasName }}</h2>
                            </div>
                            <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-brand-50 text-brand-700 border border-brand-200/60">
                                {{ $items->count() }} Sesi Mengajar
                            </span>
                        </div>

                        {{-- Table of Sessions --}}
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse text-xs">
                                <thead>
                                    <tr class="bg-slate-50/50 border-b border-slate-100 text-slate-500 uppercase tracking-wider text-[11px] font-semibold">
                                        <th class="py-3 px-5">Jadwal Hari & Jam</th>
                                        <th class="py-3 px-5">Mata Pelajaran</th>
                                        <th class="py-3 px-5">Guru Pengajar</th>
                                        <th class="py-3 px-5 text-center">Aksi Presensi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach ($items as $item)
                                        <tr class="hover:bg-slate-50/70 transition-colors">
                                            <td class="py-3.5 px-5">
                                                <div class="flex items-center gap-2">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold bg-slate-100 text-slate-700">
                                                        {{ $item->hari->nama_hari ?? 'Hari' }}
                                                    </span>
                                                    <span class="font-medium text-slate-700">
                                                        {{ date('H:i', strtotime($item->waktu_mulai)) }} - {{ date('H:i', strtotime($item->waktu_selesai)) }} WIB
                                                    </span>
                                                </div>
                                            </td>

                                            <td class="py-3.5 px-5 font-bold text-slate-900">
                                                {{ $item->mataPelajaran->nama_matpel ?? 'Mata Pelajaran' }}
                                            </td>

                                            <td class="py-3.5 px-5 text-slate-600">
                                                {{ $item->guru->nama_guru ?? '-' }}
                                            </td>

                                            <td class="py-3.5 px-5 text-center">
                                                <a href="{{ route('guru.absensi.details', $item->id_kelas_mata_pelajaran) }}"
                                                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-brand-50 text-brand-700 hover:bg-brand-100 font-semibold transition-colors shadow-sm">
                                                    <i class="fa-solid fa-clipboard-user text-[11px]"></i>
                                                    <span>Daftar Pertemuan</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center shadow-sm">
                <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-clipboard-user text-2xl"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800">Tidak Ada Sesi Kelas Ditemukan</h3>
                <p class="text-sm text-slate-400 max-w-md mx-auto mt-1">
                    Tidak ada jadwal kelas aktif yang cocok dengan filter yang dipilih.
                </p>
            </div>
        @endif

    </div>
</x-app-guru-layout>
