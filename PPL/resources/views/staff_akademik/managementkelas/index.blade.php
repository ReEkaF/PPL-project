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
                            <span class="text-slate-800 font-medium">Manajemen Kelas</span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Manajemen Rombongan Belajar</h1>
                <p class="text-xs text-slate-500">
                    Daftar rombongan belajar aktif beserta alokasi dan jumlah siswa terdaftar per kelas.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('staff_akademik.kelas.index') }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-medium bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 transition-colors shadow-sm">
                    <i class="fa-solid fa-gear text-[11px] text-slate-500"></i>
                    <span>Master Data Kelas</span>
                </a>
            </div>
        </div>

        {{-- Quick Stats Summary --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="bg-white border border-slate-200 rounded-xl p-4 sm:p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-slate-500">Total Rombongan Belajar</p>
                        <h3 class="text-2xl font-bold text-slate-900 mt-1 font-mono">{{ $kelas->count() }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-brand-50 border border-brand-100 text-brand-800 flex items-center justify-center">
                        <i class="fa-solid fa-chalkboard-user text-sm"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white border border-slate-200 rounded-xl p-4 sm:p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-slate-500">Total Siswa Terdaftar</p>
                        <h3 class="text-2xl font-bold text-slate-900 mt-1 font-mono">{{ $kelas->sum('siswa_count') }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-800 flex items-center justify-center">
                        <i class="fa-solid fa-users text-sm"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white border border-slate-200 rounded-xl p-4 sm:p-5 shadow-sm sm:col-span-2 lg:col-span-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-slate-500">Rata-rata Siswa / Kelas</p>
                        <h3 class="text-2xl font-bold text-slate-900 mt-1 font-mono">
                            {{ $kelas->count() > 0 ? round($kelas->sum('siswa_count') / $kelas->count()) : 0 }}
                        </h3>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 text-blue-800 flex items-center justify-center">
                        <i class="fa-solid fa-chart-simple text-sm"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card Table --}}
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-100 bg-slate-50/40">
                <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Daftar Rombongan Belajar & Jumlah Siswa</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50/75 border-b border-slate-100 text-slate-700 font-semibold uppercase text-[11px] tracking-wider">
                        <tr>
                            <th class="px-5 py-3 w-14 text-center">No</th>
                            <th class="px-5 py-3">Nama Kelas</th>
                            <th class="px-5 py-3">Jumlah Siswa</th>
                            <th class="px-5 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($kelas as $index => $class)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-5 py-3.5 text-center font-mono text-slate-400">{{ $index + 1 }}</td>
                                <td class="px-5 py-3.5 font-semibold text-slate-900">
                                    <div class="inline-flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-lg bg-brand-50 border border-brand-100 text-brand-800 flex items-center justify-center font-bold text-xs font-mono">
                                            {{ substr($class->nama_kelas, 0, 2) }}
                                        </div>
                                        <span>Kelas {{ $class->nama_kelas }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold font-mono {{ $class->siswa_count > 0 ? 'bg-slate-100 text-slate-800' : 'bg-rose-50 text-rose-700 border border-rose-100' }}">
                                        <i class="fa-solid fa-user-group text-[10px] text-slate-400"></i>
                                        <span>{{ $class->siswa_count }} Siswa</span>
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                    <a href="{{ route('kelas.siswa', $class->id_kelas) }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-brand-800 bg-brand-50 hover:bg-brand-100 border border-brand-100 rounded-lg transition-colors">
                                        <span>Kelola Anggota</span>
                                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-12 text-center text-slate-400">
                                    <i class="fa-regular fa-folder-open text-3xl mb-2 text-slate-300 block"></i>
                                    <span>Tidak ada data kelas yang terdaftar.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-staffakademik-layout>
