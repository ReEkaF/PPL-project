<x-app-guru-layout>
    <div class="max-w-6xl mx-auto space-y-6">

        {{-- Page Header & Back Button --}}
        <div>
            <a href="{{ route('guru.absensi.details', $detail->id_kelas_mata_pelajaran) }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-700 hover:text-brand-800 transition-colors mb-2">
                <i class="fa-solid fa-arrow-left text-[11px]"></i>
                <span>Kembali ke Daftar Pertemuan</span>
            </a>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="flex flex-wrap items-center gap-2">
                        <h1 class="text-xl font-bold text-slate-900">
                            Presensi Pertemuan: {{ \Carbon\Carbon::parse($pertemuan->tanggal_pertemuan)->translatedFormat('l, d F Y') }}
                        </h1>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-brand-50 text-brand-700 border border-brand-200/60">
                            Kelas {{ $detail->kelas->nama_kelas ?? '-' }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 mt-1">
                        Mata Pelajaran: <span class="font-semibold text-slate-700">{{ $detail->mataPelajaran->nama_matpel ?? '-' }}</span> • Pendidik: {{ $detail->guru->nama_guru }}
                    </p>
                </div>

                {{-- Fast Action: Set All Hadir --}}
                <div class="flex items-center gap-2 self-start sm:self-auto">
                    <button type="button" onclick="setAllAttendance('Hadir')"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100 transition-colors shadow-sm">
                        <i class="fa-solid fa-check-double text-[11px]"></i>
                        <span>Set Semua Hadir</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between gap-3 text-xs">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        {{-- Attendance Form Table Card --}}
        <form action="{{ route('guru.absensi.updateStatus') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h2 class="font-bold text-slate-900 text-base">Daftar Kehadiran Siswa</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Ubah status kehadiran masing-masing siswa sesuai kondisi di kelas</p>
                    </div>
                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600">
                        {{ count($students) }} Siswa
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-100 text-slate-500 uppercase tracking-wider text-[11px] font-semibold">
                                <th class="py-3.5 px-4 w-12 text-center">No</th>
                                <th class="py-3.5 px-4">Nama Siswa</th>
                                <th class="py-3.5 px-4">NISN</th>
                                <th class="py-3.5 px-4 text-center">Status Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($students as $student)
                                <tr class="hover:bg-slate-50/70 transition-colors">
                                    {{-- No --}}
                                    <td class="py-3.5 px-4 text-center text-slate-400 font-medium">
                                        {{ $loop->iteration }}
                                    </td>

                                    {{-- Name --}}
                                    <td class="py-3.5 px-4 font-semibold text-slate-900">
                                        {{ $student->nama_siswa }}
                                    </td>

                                    {{-- NISN --}}
                                    <td class="py-3.5 px-4 font-mono text-slate-600">
                                        {{ $student->nisn ?? '-' }}
                                    </td>

                                    {{-- Status Selector --}}
                                    <td class="py-3.5 px-4 text-center">
                                        <select name="status_absensi[{{ $student->id_absensi_siswa }}]"
                                            class="attendance-select text-xs font-semibold rounded-xl px-3 py-1.5 border transition-all focus:outline-none focus:ring-2 focus:ring-brand-500
                                                {{ $student->status_absensi == 'Hadir' ? 'bg-emerald-50 text-emerald-800 border-emerald-300' : '' }}
                                                {{ $student->status_absensi == 'Izin' ? 'bg-blue-50 text-blue-800 border-blue-300' : '' }}
                                                {{ $student->status_absensi == 'Sakit' ? 'bg-amber-50 text-amber-800 border-amber-300' : '' }}
                                                {{ $student->status_absensi == 'Alpa' ? 'bg-rose-50 text-rose-800 border-rose-300' : '' }}"
                                            onchange="updateSelectColor(this)">
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

                {{-- Submit Footer --}}
                <div class="p-5 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <p class="text-xs text-slate-500">
                        Pastikan seluruh data kehadiran sudah benar sebelum menyimpan perubahan.
                    </p>
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl text-xs font-semibold bg-brand-800 text-white hover:bg-brand-900 transition-colors shadow-sm">
                        <i class="fa-solid fa-floppy-disk text-xs"></i>
                        <span>Simpan Rekap Presensi</span>
                    </button>
                </div>
            </div>
        </form>

    </div>
</x-app-guru-layout>

<script>
    function updateSelectColor(select) {
        select.classList.remove('bg-emerald-50', 'text-emerald-800', 'border-emerald-300',
                               'bg-blue-50', 'text-blue-800', 'border-blue-300',
                               'bg-amber-50', 'text-amber-800', 'border-amber-300',
                               'bg-rose-50', 'text-rose-800', 'border-rose-300');

        switch(select.value) {
            case 'Hadir':
                select.classList.add('bg-emerald-50', 'text-emerald-800', 'border-emerald-300');
                break;
            case 'Izin':
                select.classList.add('bg-blue-50', 'text-blue-800', 'border-blue-300');
                break;
            case 'Sakit':
                select.classList.add('bg-amber-50', 'text-amber-800', 'border-amber-300');
                break;
            case 'Alpa':
                select.classList.add('bg-rose-50', 'text-rose-800', 'border-rose-300');
                break;
        }
    }

    function setAllAttendance(status) {
        document.querySelectorAll('.attendance-select').forEach(select => {
            select.value = status;
            updateSelectColor(select);
        });
    }
</script>
