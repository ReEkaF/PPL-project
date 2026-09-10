<x-app-guru-layout>
    <div class="max-w-6xl mx-auto space-y-6" x-data="{ activeKelas: 'Semua' }">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-900">Jadwal Pelajaran Kelas</h1>
                <p class="text-sm text-slate-500 mt-0.5">
                    Seluruh jadwal sesi mengajar Anda yang dikelompokkan berdasarkan rombongan belajar (kelas).
                </p>
            </div>
            <a href="{{ route('lihat-jadwal-guru') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-brand-800 text-white text-sm font-medium rounded-xl hover:bg-brand-900 transition-colors shadow-sm self-start sm:self-auto">
                <i class="fa-solid fa-calendar-days text-xs"></i>
                <span>Lihat Format Mingguan</span>
            </a>
        </div>

        @if ($kelasMataPelajaran->isEmpty())
            {{-- Empty State --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-12 text-center shadow-sm">
                <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-calendar-xmark text-2xl"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800">Belum Ada Jadwal Kelas</h3>
                <p class="text-sm text-slate-400 max-w-md mx-auto mt-1">
                    Anda belum memiliki alokasi jadwal pelajaran di kelas manapun untuk tahun ajaran aktif ini.
                </p>
            </div>
        @else
            @php
                $kelasList = $kelasMataPelajaran->pluck('kelas.nama_kelas')->unique()->filter()->values();
            @endphp

            {{-- Filter Tabs per Kelas --}}
            <div class="flex items-center gap-1.5 overflow-x-auto pb-1 border-b border-slate-200 scrollbar-none">
                <button type="button" @click="activeKelas = 'Semua'"
                    :class="activeKelas === 'Semua' ? 'bg-brand-800 text-white font-semibold shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                    class="px-3.5 py-2 text-xs rounded-xl transition-all whitespace-nowrap flex items-center gap-1.5">
                    <span>Semua Kelas</span>
                    <span :class="activeKelas === 'Semua' ? 'bg-brand-700 text-white' : 'bg-slate-100 text-slate-600'"
                        class="px-1.5 py-0.5 rounded-full text-[10px]">
                        {{ $kelasMataPelajaran->count() }}
                    </span>
                </button>

                @foreach ($kelasList as $namaKelas)
                    @php $countK = $kelasMataPelajaran->where('kelas.nama_kelas', $namaKelas)->count(); @endphp
                    <button type="button" @click="activeKelas = '{{ $namaKelas }}'"
                        :class="activeKelas === '{{ $namaKelas }}' ? 'bg-brand-800 text-white font-semibold shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                        class="px-3.5 py-2 text-xs rounded-xl transition-all whitespace-nowrap flex items-center gap-1.5">
                        <span>{{ $namaKelas }}</span>
                        <span :class="activeKelas === '{{ $namaKelas }}' ? 'bg-brand-700 text-white' : 'bg-slate-100 text-slate-600'"
                            class="px-1.5 py-0.5 rounded-full text-[10px]">
                            {{ $countK }}
                        </span>
                    </button>
                @endforeach
            </div>

            {{-- Grid of Class Schedule Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach ($kelasMataPelajaran as $item)
                    @php
                        $namaKelas = $item->kelas->nama_kelas ?? 'Kelas';
                        $namaHari = $item->hari->nama_hari ?? 'Hari';
                    @endphp
                    <div x-show="activeKelas === 'Semua' || activeKelas === '{{ $namaKelas }}'"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between gap-4">
                        
                        {{-- Top Details --}}
                        <div class="space-y-3">
                            <div class="flex items-center justify-between gap-2">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-brand-50 text-brand-700 border border-brand-200/60">
                                    <i class="fa-solid fa-chalkboard text-[10px]"></i>
                                    {{ $namaKelas }}
                                </span>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-700">
                                    <i class="fa-regular fa-calendar text-[10px]"></i>
                                    {{ $namaHari }}
                                </span>
                            </div>

                            <div>
                                <h3 class="font-bold text-slate-900 text-base">
                                    {{ $item->mataPelajaran->nama_matpel ?? 'Mata Pelajaran' }}
                                </h3>
                                <p class="text-xs text-slate-500 mt-1 flex items-center gap-1.5">
                                    <i class="fa-regular fa-clock text-slate-400"></i>
                                    <span>Pukul {{ date('H:i', strtotime($item->waktu_mulai)) }} - {{ date('H:i', strtotime($item->waktu_selesai)) }} WIB</span>
                                </p>
                            </div>

                            <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                                <span class="flex items-center gap-1.5">
                                    <i class="fa-solid fa-location-dot text-slate-400"></i>
                                    Ruang {{ $namaKelas }}
                                </span>
                                <span class="text-slate-400">Tatap Muka</span>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="pt-3 border-t border-slate-100 grid grid-cols-2 gap-2">
                            <a href="{{ route('guru.absensi.index') }}"
                                class="inline-flex items-center justify-center gap-1.5 py-2 px-3 rounded-xl text-xs font-semibold bg-brand-50 text-brand-700 hover:bg-brand-100 transition-colors">
                                <i class="fa-solid fa-clipboard-user text-[11px]"></i>
                                <span>Presensi</span>
                            </a>
                            <a href="{{ route('guru.dashboard.lms') }}"
                                class="inline-flex items-center justify-center gap-1.5 py-2 px-3 rounded-xl text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">
                                <i class="fa-solid fa-graduation-cap text-[11px]"></i>
                                <span>Buka LMS</span>
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>

        @endif

    </div>
</x-app-guru-layout>
