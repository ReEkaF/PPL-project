<x-app-guru-layout>
    <div class="max-w-6xl mx-auto space-y-6" x-data="{ search: '' }">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-900">Daftar Siswa Perwalian</h1>
                <p class="text-sm text-slate-500 mt-0.5">
                    Data siswa di kelas perwalian Anda — pantau biodata, absensi, dan informasi kontak.
                </p>
            </div>
        </div>

        @if (!$kelasWali)
            {{-- Non-Wali Empty State --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-12 text-center shadow-sm">
                <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-user-shield text-2xl"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800">Bukan Wali Kelas</h3>
                <p class="text-sm text-slate-500 max-w-md mx-auto mt-1">
                    Akun Anda saat ini tidak terdaftar sebagai wali kelas aktif pada tahun ajaran ini. Modul ini diperuntukkan bagi pendidik yang bertugas sebagai wali kelas.
                </p>
                <a href="{{ route('guru.dashboard') }}" class="inline-flex items-center gap-1.5 mt-4 px-4 py-2 rounded-xl text-xs font-semibold bg-brand-700 text-white hover:bg-brand-800 transition-colors shadow-sm">
                    <i class="fa-solid fa-house text-xs"></i>
                    Kembali ke Dashboard
                </a>
            </div>
        @else

            {{-- Perwalian Hero & Metric Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-chalkboard-user text-xl"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-medium">Kelas Perwalian</p>
                        <p class="text-xl font-bold text-slate-900">{{ $kelasWali->nama_kelas }}</p>
                        <p class="text-[11px] text-brand-700 font-medium mt-0.5">Wali: {{ $guru->nama_guru }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-users text-xl"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-medium">Total Siswa Terdaftar</p>
                        <p class="text-xl font-bold text-slate-900">{{ $totalSiswa }} Siswa</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">Aktif di rombel</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-venus-mars text-xl"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-medium">Komposisi Gender</p>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span class="text-xs font-semibold text-blue-700 bg-blue-50 px-2 py-0.5 rounded-lg border border-blue-200/60">
                                <i class="fa-solid fa-mars text-[10px] mr-0.5"></i> {{ $totalLaki }} L
                            </span>
                            <span class="text-xs font-semibold text-rose-700 bg-rose-50 px-2 py-0.5 rounded-lg border border-rose-200/60">
                                <i class="fa-solid fa-venus text-[10px] mr-0.5"></i> {{ $totalPerempuan }} P
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Table Card --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                
                {{-- Table Top Header & Search Filter --}}
                <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="font-bold text-slate-900 text-base">Daftar Anggota Rombel</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Pencarian langsung berdasarkan nama atau NISN siswa</p>
                    </div>

                    {{-- Search Input --}}
                    <div class="relative w-full sm:w-72">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        </span>
                        <input type="text" x-model="search"
                            placeholder="Cari nama atau NISN..."
                            class="w-full pl-9 pr-4 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all text-slate-800 placeholder-slate-400">
                    </div>
                </div>

                {{-- Table Content --}}
                <div class="overflow-x-auto">
                    @if ($siswaList->isNotEmpty())
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-slate-50/80 border-b border-slate-100 text-slate-500 uppercase tracking-wider text-[11px] font-semibold">
                                    <th class="py-3.5 px-4 w-12 text-center">No</th>
                                    <th class="py-3.5 px-4">Nama Siswa</th>
                                    <th class="py-3.5 px-4">NISN</th>
                                    <th class="py-3.5 px-4">L/P</th>
                                    <th class="py-3.5 px-4">Kontak Siswa / Ortu</th>
                                    <th class="py-3.5 px-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($siswaList as $index => $kelasSiswa)
                                    @php
                                        $s = $kelasSiswa->siswa;
                                        $isMale = strtolower($s->jenis_kelamin_siswa ?? '') === 'laki-laki';
                                    @endphp
                                    <tr class="hover:bg-slate-50/70 transition-colors"
                                        x-show="!search || '{{ strtolower($s->nama_siswa ?? '') }}'.includes(search.toLowerCase()) || '{{ $s->nisn ?? '' }}'.includes(search)">
                                        
                                        {{-- No --}}
                                        <td class="py-3 px-4 text-center text-slate-400 font-medium">
                                            {{ $index + 1 }}
                                        </td>

                                        {{-- Name & Avatar --}}
                                        <td class="py-3 px-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-9 h-9 rounded-full bg-slate-100 border border-slate-200 overflow-hidden shrink-0 flex items-center justify-center">
                                                    @if (!empty($s->foto_siswa))
                                                        <img src="{{ asset('images/siswa/' . $s->foto_siswa) }}" alt="{{ $s->nama_siswa }}" class="w-full h-full object-cover">
                                                    @else
                                                        <i class="fa-solid fa-user text-slate-400 text-xs"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <a href="{{ route('guru.wali-kelas.siswa.profil', ['id_kelas' => $kelasWali->id_kelas, 'id_siswa' => $s->id_siswa]) }}"
                                                        class="font-semibold text-slate-900 hover:text-brand-700 transition-colors">
                                                        {{ $s->nama_siswa ?? '-' }}
                                                    </a>
                                                    <p class="text-[11px] text-slate-400">{{ $s->email ?? 'Belum ada email' }}</p>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- NISN --}}
                                        <td class="py-3 px-4 font-mono text-slate-600">
                                            {{ $s->nisn ?? '-' }}
                                        </td>

                                        {{-- Gender --}}
                                        <td class="py-3 px-4">
                                            @if ($isMale)
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-semibold bg-blue-50 text-blue-700 border border-blue-200/60">
                                                    <i class="fa-solid fa-mars text-[9px]"></i> Laki-laki
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-semibold bg-rose-50 text-rose-700 border border-rose-200/60">
                                                    <i class="fa-solid fa-venus text-[9px]"></i> Perempuan
                                                </span>
                                            @endif
                                        </td>

                                        {{-- Phone / WA --}}
                                        <td class="py-3 px-4">
                                            @if (!empty($s->nomor_wa_siswa))
                                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $s->nomor_wa_siswa) }}" target="_blank"
                                                    class="inline-flex items-center gap-1.5 text-slate-700 hover:text-emerald-600 font-medium transition-colors">
                                                    <i class="fa-brands fa-whatsapp text-emerald-500 text-sm"></i>
                                                    <span>{{ $s->nomor_wa_siswa }}</span>
                                                </a>
                                            @else
                                                <span class="text-slate-400 italic">Tidak ada nomor</span>
                                            @endif
                                        </td>

                                        {{-- Actions --}}
                                        <td class="py-3 px-4 text-center">
                                            <a href="{{ route('guru.wali-kelas.siswa.profil', ['id_kelas' => $kelasWali->id_kelas, 'id_siswa' => $s->id_siswa]) }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-brand-50 text-brand-700 hover:bg-brand-100 font-semibold transition-colors">
                                                <i class="fa-solid fa-id-card text-[11px]"></i>
                                                <span>Profil</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-10 px-4">
                            <p class="text-xs text-slate-500">Belum ada siswa yang ditempatkan di kelas ini.</p>
                        </div>
                    @endif
                </div>

            </div>

        @endif

    </div>
</x-app-guru-layout>
