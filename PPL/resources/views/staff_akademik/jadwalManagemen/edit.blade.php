<x-staffakademik-layout>
    <div class="space-y-6 pb-10">
        {{-- Flash Alerts --}}
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
                            <span class="text-slate-800 font-medium">Edit Jadwal</span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Edit Jadwal Pelajaran</h1>
                <p class="text-xs text-slate-500">
                    Perbarui informasi kelas, hari, waktu sesi, dan guru mata pelajaran untuk jadwal ini.
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
        <div class="max-w-2xl bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 bg-slate-50/40 flex items-center justify-between">
                <div>
                    <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Formulir Perubahan Jadwal</h2>
                    <p class="text-[11px] text-slate-500 mt-0.5">Pastikan tidak ada bentrok waktu dengan guru atau kelas yang sama.</p>
                </div>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-mono bg-slate-100 text-slate-600 border border-slate-200">
                    ID: {{ substr($jadwal->id_kelas_mata_pelajaran, 0, 8) }}
                </span>
            </div>

            <form action="{{ route('staff_akademik.jadwal.update', $jadwal->id_kelas_mata_pelajaran) }}" method="POST" class="p-5 sm:p-6 space-y-4">
                @csrf
                @method('PUT')

                {{-- Kelas --}}
                <div>
                    <label for="kelas_id" class="block text-xs font-semibold text-slate-700 mb-1.5">Kelas / Rombel</label>
                    <select name="kelas_id" id="kelas_id" required
                        class="block w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-brand-500 focus:border-brand-500 transition-colors">
                        @foreach ($kelas as $kls)
                            <option value="{{ $kls->id_kelas }}" {{ old('kelas_id', $jadwal->kelas_id) == $kls->id_kelas ? 'selected' : '' }}>
                                {{ $kls->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                    @error('kelas_id')
                        <p class="text-[11px] text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Hari --}}
                <div>
                    <label for="hari_id" class="block text-xs font-semibold text-slate-700 mb-1.5">Hari</label>
                    <select name="hari_id" id="hari_id" required
                        class="block w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-brand-500 focus:border-brand-500 transition-colors">
                        @foreach ($hari as $h)
                            <option value="{{ $h->id_hari }}" {{ old('hari_id', $jadwal->hari_id) == $h->id_hari ? 'selected' : '' }}>
                                {{ $h->nama_hari }}
                            </option>
                        @endforeach
                    </select>
                    @error('hari_id')
                        <p class="text-[11px] text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jam Pelajaran --}}
                @php
                    $currentSlot = old('jam_pelajaran', $jadwal->waktu_mulai . '-' . $jadwal->waktu_selesai);
                @endphp
                <div>
                    <label for="jam_pelajaran" class="block text-xs font-semibold text-slate-700 mb-1.5">Jam Pelajaran (Sesi Waktu)</label>
                    <select name="jam_pelajaran" id="jam_pelajaran" required
                        class="block w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-brand-500 focus:border-brand-500 transition-colors">
                        <option value="07:00-09:00" {{ $currentSlot == '07:00-09:00' ? 'selected' : '' }}>Sesi 1 (07:00 - 09:00 WIB)</option>
                        <option value="10:00-12:00" {{ $currentSlot == '10:00-12:00' ? 'selected' : '' }}>Sesi 2 (10:00 - 12:00 WIB)</option>
                        <option value="13:00-15:00" {{ $currentSlot == '13:00-15:00' ? 'selected' : '' }}>Sesi 3 (13:00 - 15:00 WIB)</option>
                        <option value="15:01-16:00" {{ $currentSlot == '15:01-16:00' ? 'selected' : '' }}>Sesi 4 (15:01 - 16:00 WIB)</option>
                    </select>
                    @error('jam_pelajaran')
                        <p class="text-[11px] text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Guru dan Mata Pelajaran --}}
                <div>
                    <label for="guruid_matpelid" class="block text-xs font-semibold text-slate-700 mb-1.5">Guru Pengajar & Mata Pelajaran</label>
                    <select name="guruid_matpelid" id="guruid_matpelid" required
                        class="block w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-brand-500 focus:border-brand-500 transition-colors">
                        @foreach ($guruMataPelajaran as $guruMatpel)
                            @php
                                $val = $guruMatpel->id_guru . '_' . $guruMatpel->id_matpel;
                                $isSelected = old('guruid_matpelid')
                                    ? old('guruid_matpelid') == $val
                                    : ($jadwal->guru_id == $guruMatpel->id_guru && ($jadwal->mata_pelajaran_id == $guruMatpel->id_matpel || !$jadwal->mata_pelajaran_id));
                            @endphp
                            <option value="{{ $val }}" {{ $isSelected ? 'selected' : '' }}>
                                {{ $guruMatpel->nama_guru }} — {{ $guruMatpel->nama_matpel }}
                            </option>
                        @endforeach
                    </select>
                    @error('guruid_matpelid')
                        <p class="text-[11px] text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="pt-3 border-t border-slate-100 flex items-center gap-2.5">
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-lg text-xs font-medium bg-brand-800 hover:bg-brand-900 text-white shadow-sm transition-colors">
                        <i class="fa-solid fa-check text-[11px]"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                    <a href="{{ route('staff_akademik.jadwal') }}"
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-lg text-xs font-medium bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                        <span>Batal</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-staffakademik-layout>
