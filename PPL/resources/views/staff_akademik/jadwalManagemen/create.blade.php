<x-staffakademik-layout>
    <div class="space-y-6 pb-10">
        {{-- Flash Alerts --}}
        @if($errors->any())
            <div class="p-4 text-xs font-medium text-rose-800 bg-rose-50 border border-rose-200 rounded-xl shadow-sm space-y-1">
                <div class="flex items-center gap-2 font-bold text-rose-800 mb-1">
                    <i class="fa-solid fa-triangle-exclamation text-rose-600 text-sm"></i>
                    <span>Terdapat kesalahan pada formulir:</span>
                </div>
                <ul class="list-disc list-inside space-y-0.5 text-rose-700">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Header & Breadcrumb --}}
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
                            <a href="{{ route('staff_akademik.jadwal') }}" class="text-slate-500 hover:text-brand-800 transition-colors">Kelola Jadwal</a>
                        </li>
                        <li class="flex items-center text-slate-400">
                            <i class="fa-solid fa-chevron-right text-[10px] mx-1"></i>
                            <span class="text-slate-800 font-medium">Tambah Jadwal</span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Tambah Jadwal Pelajaran</h1>
                <p class="text-xs text-slate-500">
                    Tambahkan susunan jadwal pembelajaran baru untuk kelas pada semester aktif.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('staff_akademik.jadwal') }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-medium bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 transition-colors shadow-sm">
                    <i class="fa-solid fa-arrow-left text-[11px]"></i>
                    <span>Kembali ke Jadwal</span>
                </a>
            </div>
        </div>

        {{-- Form Card --}}
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 bg-slate-50/40 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Formulir Jadwal Baru</h2>
                    <p class="text-[11px] text-slate-500 mt-0.5">Pilih kelas tujuan lalu tentukan sesi pembelajaran.</p>
                </div>
                <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-lg bg-brand-50 border border-brand-100 text-brand-800 text-xs font-medium">
                    <i class="fa-solid fa-calendar-check text-[11px]"></i>
                    <span>Tahun Ajaran: {{ $tahunAjaran->tahun_ajaran }} ({{ $tahunAjaran->semester }})</span>
                </div>
            </div>

            <form action="{{ route('staff_akademik.jadwal.store') }}" method="POST" class="p-5 sm:p-6 space-y-6">
                @csrf
                <input type="hidden" name="tahun_ajaran_id" value="{{ $tahunAjaran->id_tahun_ajaran }}">

                {{-- Pilih Kelas --}}
                <div class="max-w-md">
                    <label for="kelas_id" class="block text-xs font-semibold text-slate-700 mb-1.5">Kelas / Rombongan Belajar</label>
                    <select name="kelas_id" id="kelas_id" required
                        class="block w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-brand-500 focus:border-brand-500 transition-colors">
                        @foreach ($kelas as $kls)
                            <option value="{{ $kls->id_kelas }}" {{ old('kelas_id') == $kls->id_kelas ? 'selected' : '' }}>
                                {{ $kls->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                    @error('kelas_id')
                        <p class="text-[11px] text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Table Sesi Jadwal --}}
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-semibold text-slate-700">Daftar Sesi Pembelajaran</label>
                        <button type="button" onclick="addRow()"
                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-white hover:bg-slate-50 text-slate-700 font-medium text-xs rounded-lg border border-slate-200 transition-colors shadow-sm">
                            <i class="fa-solid fa-plus text-[10px] text-brand-700"></i>
                            <span>Tambah Baris Sesi</span>
                        </button>
                    </div>

                    <div class="overflow-x-auto border border-slate-200 rounded-xl">
                        <table class="w-full text-left text-xs text-slate-600">
                            <thead class="bg-slate-50/75 border-b border-slate-100 text-slate-700 font-semibold uppercase text-[11px] tracking-wider">
                                <tr>
                                    <th class="px-4 py-3 w-36">Hari</th>
                                    <th class="px-4 py-3 w-52">Waktu Sesi</th>
                                    <th class="px-4 py-3">Guru & Mata Pelajaran</th>
                                    <th class="px-4 py-3 w-16 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="jadwal-rows" class="divide-y divide-slate-100">
                                <tr>
                                    <td class="px-4 py-2.5">
                                        <select name="jadwal[0][hari_id]" required
                                            class="w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-lg px-2.5 py-1.5 focus:ring-1 focus:ring-brand-500 focus:border-brand-500">
                                            @foreach ($hari as $h)
                                                <option value="{{ $h->id_hari }}">{{ $h->nama_hari }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-4 py-2.5">
                                        <select name="jadwal[0][jam_pelajaran]" required
                                            class="w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-lg px-2.5 py-1.5 focus:ring-1 focus:ring-brand-500 focus:border-brand-500">
                                            <option value="07:00-09:00">07:00 - 09:00 WIB (Sesi 1)</option>
                                            <option value="10:00-12:00">10:00 - 12:00 WIB (Sesi 2)</option>
                                            <option value="13:00-15:00">13:00 - 15:00 WIB (Sesi 3)</option>
                                            <option value="15:01-16:00">15:01 - 16:00 WIB (Sesi 4)</option>
                                        </select>
                                    </td>
                                    <td class="px-4 py-2.5">
                                        <select name="jadwal[0][guru_id]" required
                                            class="w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-lg px-2.5 py-1.5 focus:ring-1 focus:ring-brand-500 focus:border-brand-500">
                                            @foreach ($guruMataPelajaran as $guruMatpel)
                                                <option value="{{ $guruMatpel->id_guru }}_{{ $guruMatpel->id_matpel }}">
                                                    {{ $guruMatpel->nama_guru }} — {{ $guruMatpel->nama_matpel }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-4 py-2.5 text-center">
                                        <span class="text-slate-300 text-xs">—</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="pt-4 border-t border-slate-100 flex items-center gap-2.5">
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-lg text-xs font-medium bg-brand-800 hover:bg-brand-900 text-white shadow-sm transition-colors">
                        <i class="fa-solid fa-check text-[11px]"></i>
                        <span>Simpan Jadwal</span>
                    </button>
                    <a href="{{ route('staff_akademik.jadwal') }}"
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-lg text-xs font-medium bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                        <span>Batal</span>
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Script Tambah Row --}}
    <script>
        let rowCount = 1;
        const hariOptions = `@foreach ($hari as $h)<option value="{{ $h->id_hari }}">{{ $h->nama_hari }}</option>@endforeach`;
        const guruOptions = `@foreach ($guruMataPelajaran as $guruMatpel)<option value="{{ $guruMatpel->id_guru }}_{{ $guruMatpel->id_matpel }}">{{ addslashes($guruMatpel->nama_guru) }} — {{ addslashes($guruMatpel->nama_matpel) }}</option>@endforeach`;

        function addRow() {
            const tbody = document.getElementById('jadwal-rows');
            const newRow = document.createElement('tr');
            newRow.className = 'hover:bg-slate-50/60 transition-colors';

            newRow.innerHTML = `
                <td class="px-4 py-2.5">
                    <select name="jadwal[${rowCount}][hari_id]" required
                        class="w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-lg px-2.5 py-1.5 focus:ring-1 focus:ring-brand-500 focus:border-brand-500">
                        ${hariOptions}
                    </select>
                </td>
                <td class="px-4 py-2.5">
                    <select name="jadwal[${rowCount}][jam_pelajaran]" required
                        class="w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-lg px-2.5 py-1.5 focus:ring-1 focus:ring-brand-500 focus:border-brand-500">
                        <option value="07:00-09:00">07:00 - 09:00 WIB (Sesi 1)</option>
                        <option value="10:00-12:00">10:00 - 12:00 WIB (Sesi 2)</option>
                        <option value="13:00-15:00">13:00 - 15:00 WIB (Sesi 3)</option>
                        <option value="15:01-16:00">15:01 - 16:00 WIB (Sesi 4)</option>
                    </select>
                </td>
                <td class="px-4 py-2.5">
                    <select name="jadwal[${rowCount}][guru_id]" required
                        class="w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-lg px-2.5 py-1.5 focus:ring-1 focus:ring-brand-500 focus:border-brand-500">
                        ${guruOptions}
                    </select>
                </td>
                <td class="px-4 py-2.5 text-center">
                    <button type="button" onclick="this.closest('tr').remove()"
                        class="px-2 py-1 text-xs font-medium text-rose-700 bg-rose-50 border border-rose-100 rounded-lg hover:bg-rose-100 transition-colors"
                        title="Hapus baris">
                        <i class="fa-solid fa-trash text-[10px]"></i>
                    </button>
                </td>
            `;

            tbody.appendChild(newRow);
            rowCount++;
        }
    </script>
</x-staffakademik-layout>