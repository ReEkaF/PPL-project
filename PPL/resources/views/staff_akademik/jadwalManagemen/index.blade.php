<x-staffakademik-layout>
    <div class="space-y-6 pb-10">
        {{-- Session Flash Messages & Alerts --}}
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

        {{-- Bentrok / Warning Alerts --}}
        @if(session('error') && session('bentrok'))
            <div class="p-4 sm:p-5 text-xs text-amber-900 bg-amber-50 border border-amber-200 rounded-xl shadow-sm space-y-2">
                <div class="flex items-center gap-2 font-bold text-amber-800">
                    <i class="fa-solid fa-triangle-exclamation text-amber-600 text-sm"></i>
                    <span>Peringatan: Jadwal Bentrok Terdeteksi</span>
                </div>
                <ul class="list-disc list-inside space-y-1 pl-1 text-slate-700">
                    @foreach(session('bentrok') as $item)
                        <li>
                            @if(($item['tipe'] ?? '') == 'guru')
                                Guru <strong class="text-slate-900">{{ $item['nama_guru'] }}</strong> memiliki jadwal bentrok di kelas lain pada hari {{ $item['nama_hari'] }} jam {{ $item['jam_pelajaran'] }}.
                            @elseif(($item['tipe'] ?? '') == 'kelas')
                                Kelas <strong class="text-slate-900">{{ $item['nama_kelas'] }}</strong> sudah memiliki jadwal pada hari {{ $item['nama_hari'] }} jam {{ $item['jam_pelajaran'] }}.
                            @else
                                {{ json_encode($item) }}
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('error-update'))
            <div class="flex items-center justify-between p-4 text-xs font-medium text-rose-800 bg-rose-50 border border-rose-200 rounded-xl shadow-sm">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-xmark text-sm text-rose-600"></i>
                    <span>{{ session('error-update') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
        @endif

        @if(session('error-delete'))
            <div class="flex items-center justify-between p-4 text-xs font-medium text-rose-800 bg-rose-50 border border-rose-200 rounded-xl shadow-sm">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-xmark text-sm text-rose-600"></i>
                    <span>{{ session('error-delete') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
        @endif

        @if(session('error-excel'))
            <div class="p-4 text-xs text-rose-900 bg-rose-50 border border-rose-200 rounded-xl shadow-sm space-y-1.5">
                <div class="flex items-center gap-2 font-bold text-rose-800">
                    <i class="fa-solid fa-file-excel text-rose-600"></i>
                    <span>Terjadi kesalahan saat mengimpor berkas jadwal:</span>
                </div>
                <ul class="list-disc list-inside space-y-1 pl-1 text-slate-700">
                    @foreach(explode(";", session('error-excel')) as $error)
                        @if(trim($error))
                            <li>{{ $error }}</li>
                        @endif
                    @endforeach
                </ul>
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
                            <span class="text-slate-800 font-medium">Kelola Jadwal Pelajaran</span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Manajemen Jadwal Pelajaran</h1>
                <p class="text-xs text-slate-500">
                    Kelola dan atur jadwal pembelajaran per rombongan belajar serta jam mengajar guru.
                </p>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <a href="{{ route('staff_akademik.jadwal.create') }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-medium bg-brand-800 hover:bg-brand-900 text-white transition-colors shadow-sm">
                    <i class="fa-solid fa-plus text-[11px]"></i>
                    <span>Tambah Jadwal</span>
                </a>
                <a href="{{ route('staff_akademik.jadwal.import-page') }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-medium bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 transition-colors shadow-sm">
                    <i class="fa-solid fa-file-excel text-emerald-600 text-[11px]"></i>
                    <span>Import Excel</span>
                </a>
            </div>
        </div>

        {{-- Filter & Actions Card --}}
        <div class="bg-white border border-slate-200 rounded-xl p-4 sm:p-5 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <form action="{{ route('staff_akademik.jadwal') }}" method="GET" class="flex items-center gap-2">
                    <label for="kelas_id" class="text-xs font-medium text-slate-600 whitespace-nowrap">Filter Kelas:</label>
                    <select name="kelas_id" id="kelas_id" class="text-xs border-slate-200 rounded-lg shadow-sm bg-slate-50 focus:bg-white focus:border-brand-800 py-1.5 px-3" onchange="this.form.submit()">
                        <option value="">Semua Kelas</option>
                        @foreach($kelas as $kls)
                            <option value="{{ $kls->id_kelas }}" {{ (isset($kelas_id) && $kelas_id == $kls->id_kelas) || request('kelas_id') == $kls->id_kelas ? 'selected' : '' }}>
                                Kelas {{ $kls->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </form>

                <div class="flex items-center gap-2">
                    <a href="{{ route('staff_akademik.jadwal.export', ['kelas_id' => request('kelas_id', $kelas_id ?? '')]) }}"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 rounded-lg transition-colors shadow-sm">
                        <i class="fa-solid fa-file-excel text-emerald-600 text-xs"></i>
                        <span>Export Excel</span>
                    </a>
                    <a href="{{ route('staff_akademik.jadwal.pdf', ['kelas_id' => request('kelas_id', $kelas_id ?? '')]) }}"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 rounded-lg transition-colors shadow-sm">
                        <i class="fa-solid fa-file-pdf text-rose-600 text-xs"></i>
                        <span>Export PDF</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Jadwal Cards grouped by Kelas --}}
        @php
            $targetKelas = $kelas->when(isset($kelas_id) && $kelas_id, function($q) use ($kelas_id) {
                return $q->where('id_kelas', $kelas_id);
            });
            $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            $hasAnySchedule = false;
        @endphp

        <div class="space-y-6">
            @foreach($targetKelas as $kls)
                @php
                    $jadwalKelas = $data->where('nama_kelas', $kls->nama_kelas);
                @endphp

                @if($jadwalKelas->isEmpty())
                    @continue
                @endif

                @php $hasAnySchedule = true; @endphp

                <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="p-4 sm:p-5 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-brand-50 border border-brand-100 text-brand-800 flex items-center justify-center font-bold text-xs font-mono">
                                {{ substr($kls->nama_kelas, 0, 2) }}
                            </div>
                            <div>
                                <h2 class="text-sm font-bold text-slate-900">Jadwal Kelas {{ $kls->nama_kelas }}</h2>
                                <p class="text-xs text-slate-500 font-mono">{{ $jadwalKelas->count() }} sesi pelajaran terdaftar</p>
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
                                    <th class="px-5 py-3 text-right w-44">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($hariList as $hari)
                                    @php
                                        $jadwalHari = $jadwalKelas->where('nama_hari', $hari)->sortBy('waktu_mulai');
                                    @endphp

                                    @foreach($jadwalHari as $item)
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
                                            <td class="px-5 py-3 text-right whitespace-nowrap">
                                                <div class="inline-flex items-center gap-1.5 justify-end">
                                                    <a href="{{ route('staff_akademik.jadwal.edit', $item->id_kelas_mata_pelajaran) }}"
                                                        class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-medium text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors shadow-sm"
                                                        title="Edit Sesi Jadwal">
                                                        <i class="fa-solid fa-pen text-[10px] text-slate-500"></i>
                                                        <span>Edit</span>
                                                    </a>
                                                    <form action="{{ route('staff_akademik.jadwal.delete', $item->id_kelas_mata_pelajaran) }}" method="POST"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-medium text-rose-700 bg-rose-50 border border-rose-100 rounded-lg hover:bg-rose-100 transition-colors"
                                                            title="Hapus Sesi Jadwal">
                                                            <i class="fa-solid fa-trash text-[10px]"></i>
                                                            <span>Hapus</span>
                                                        </button>
                                                    </form>
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

            @if(!$hasAnySchedule)
                <div class="bg-white border border-slate-200 rounded-xl p-12 text-center shadow-sm">
                    <i class="fa-regular fa-calendar-xmark text-4xl text-slate-300 mb-3 block"></i>
                    <h3 class="text-sm font-bold text-slate-800">Tidak Ada Jadwal Ditemukan</h3>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                        Belum ada jadwal yang terdaftar untuk filter kelas yang dipilih atau jadwal tahun ajaran aktif belum dikonfigurasi.
                    </p>
                    <div class="mt-4">
                        <a href="{{ route('staff_akademik.jadwal.create') }}"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-medium bg-brand-800 hover:bg-brand-900 text-white transition-colors shadow-sm">
                            <i class="fa-solid fa-plus text-[10px]"></i>
                            <span>Buat Jadwal Baru</span>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-staffakademik-layout>