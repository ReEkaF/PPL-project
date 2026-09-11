<x-staffakademik-layout>
    <div class="space-y-6 pb-10">
        {{-- Session Flash Messages --}}
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
        @if(session('error'))
            <div class="flex items-center justify-between p-4 text-xs font-medium text-rose-800 bg-rose-50 border border-rose-200 rounded-xl shadow-sm">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-triangle-exclamation text-sm text-rose-600"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
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
                            <a href="{{ route('akademik.absensi.index') }}" class="text-slate-500 hover:text-brand-800 transition-colors">Rekap Absensi</a>
                        </li>
                        <li class="flex items-center text-slate-400">
                            <i class="fa-solid fa-chevron-right text-[10px] mx-1"></i>
                            <a href="{{ route('akademik.absensi.details', $detail->id_kelas_mata_pelajaran) }}" class="text-slate-500 hover:text-brand-800 transition-colors">
                                Kelas {{ $detail->kelas->nama_kelas }}
                            </a>
                        </li>
                        <li class="flex items-center text-slate-400">
                            <i class="fa-solid fa-chevron-right text-[10px] mx-1"></i>
                            <span class="text-slate-800 font-medium">Presensi Siswa</span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Presensi Pertemuan: {{ \Carbon\Carbon::parse($pertemuan->tanggal_pertemuan)->translatedFormat('d F Y') }}</h1>
                <p class="text-xs text-slate-500">
                    {{ $detail->mataPelajaran->nama_matpel ?? 'Mata Pelajaran' }} · Kelas {{ $detail->kelas->nama_kelas }} (Guru: {{ $detail->guru->nama_guru ?? '-' }})
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('akademik.absensi.details', $detail->id_kelas_mata_pelajaran) }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-medium bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 transition-colors shadow-sm">
                    <i class="fa-solid fa-arrow-left text-[11px]"></i>
                    <span>Kembali ke Sesi</span>
                </a>
            </div>
        </div>

        {{-- Form Presensi Siswa --}}
        <form action="{{ route('akademik.absensi.updateStatus') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                <div class="p-4 sm:p-5 border-b border-slate-100 bg-slate-50/40 flex items-center justify-between">
                    <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Daftar Kehadiran Siswa</h2>
                    <span class="text-xs text-slate-500 font-mono">{{ count($students) }} Siswa Terdaftar</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-600">
                        <thead class="bg-slate-50/75 border-b border-slate-100 text-slate-700 font-semibold uppercase text-[11px] tracking-wider">
                            <tr>
                                <th class="px-5 py-3 w-14 text-center">No</th>
                                <th class="px-5 py-3 w-32 font-mono">NISN</th>
                                <th class="px-5 py-3">Nama Siswa</th>
                                <th class="px-5 py-3 text-right w-44">Status Absensi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($students as $student)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="px-5 py-3.5 text-center font-mono text-slate-400">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-5 py-3.5 font-mono text-slate-500">
                                        {{ $student->nisn ?: '-' }}
                                    </td>
                                    <td class="px-5 py-3.5 font-semibold text-slate-900">
                                        <div class="inline-flex items-center gap-2.5">
                                            <div class="w-6 h-6 rounded-full bg-slate-100 text-slate-700 font-bold text-[10px] flex items-center justify-center">
                                                {{ substr($student->nama_siswa, 0, 1) }}
                                            </div>
                                            <span>{{ $student->nama_siswa }}</span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3.5 text-right">
                                        <select name="status_absensi[{{ $student->id_absensi_siswa }}]"
                                            class="text-xs font-semibold rounded-lg px-2.5 py-1.5 border transition-colors cursor-pointer {{ $student->status_absensi == 'Hadir' ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : ($student->status_absensi == 'Izin' ? 'bg-sky-50 text-sky-800 border-sky-200' : ($student->status_absensi == 'Sakit' ? 'bg-amber-50 text-amber-800 border-amber-200' : 'bg-rose-50 text-rose-800 border-rose-200')) }}">
                                            <option value="Hadir" {{ $student->status_absensi == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                            <option value="Izin" {{ $student->status_absensi == 'Izin' ? 'selected' : '' }}>Izin</option>
                                            <option value="Sakit" {{ $student->status_absensi == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                                            <option value="Alpa" {{ $student->status_absensi == 'Alpa' ? 'selected' : '' }}>Alpa</option>
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-4 sm:p-5 border-t border-slate-100 bg-slate-50/40 flex items-center justify-end">
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-medium text-white bg-brand-800 hover:bg-brand-900 rounded-lg shadow-sm transition-colors">
                        <i class="fa-solid fa-check text-[11px]"></i>
                        <span>Simpan Perubahan Status</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-staffakademik-layout>
