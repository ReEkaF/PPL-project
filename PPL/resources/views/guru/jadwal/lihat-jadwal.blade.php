<x-app-guru-layout>
    <div class="max-w-6xl mx-auto space-y-6" x-data="{ activeTab: 'Semua' }">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-900">Jadwal Mengajar</h1>
                <p class="text-sm text-slate-500 mt-0.5">
                    Pendidik: <span class="font-semibold text-slate-700">{{ $guru->nama_guru }}</span> — Tahun Ajaran Aktif
                </p>
            </div>

            @if ($query->isNotEmpty())
                <a href="{{ route('guru.jadwal.print') }}" target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-brand-800 text-white text-sm font-medium rounded-xl hover:bg-brand-900 transition-colors shadow-sm self-start sm:self-auto">
                    <i class="fa-solid fa-print text-xs"></i>
                    <span>Cetak PDF</span>
                </a>
            @endif
        </div>

        @if ($query->isEmpty())
            {{-- Empty State --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-12 text-center shadow-sm">
                <div class="w-16 h-16 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-calendar-xmark text-2xl"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800">Jadwal Mengajar Belum Tersedia</h3>
                <p class="text-sm text-slate-400 max-w-md mx-auto mt-1">
                    Saat ini belum ada data jadwal tatap muka yang dialokasikan untuk Anda pada tahun ajaran aktif.
                </p>
            </div>
        @else
            @php
                $urutanHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                $jadwalPerHari = $query->groupBy('nama_hari');
                $totalSesi = $query->count();
                $totalKelasUnik = $query->pluck('nama_kelas')->unique()->count();
                $mapelUnik = $query->pluck('nama_matpel')->unique();
            @endphp

            {{-- Summary Metrics Banner --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-lg bg-brand-50 text-brand-700 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-clock text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-medium">Total Sesi Mengajar</p>
                        <p class="text-lg font-bold text-slate-900">{{ $totalSesi }} Sesi / Minggu</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-chalkboard text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-medium">Kelas yang Diampu</p>
                        <p class="text-lg font-bold text-slate-900">{{ $totalKelasUnik }} Kelas</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-700 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-book-bookmark text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-medium">Mata Pelajaran</p>
                        <p class="text-lg font-bold text-slate-900 truncate max-w-[200px]" title="{{ $mapelUnik->implode(', ') }}">
                            {{ $mapelUnik->first() }}
                            @if ($mapelUnik->count() > 1)
                                <span class="text-xs font-normal text-slate-400">(+{{ $mapelUnik->count() - 1 }})</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            {{-- Filter Tabs Hari --}}
            <div class="flex items-center gap-1.5 overflow-x-auto pb-1 border-b border-slate-200 scrollbar-none">
                <button type="button" @click="activeTab = 'Semua'"
                    :class="activeTab === 'Semua' ? 'bg-brand-800 text-white font-semibold shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                    class="px-3.5 py-2 text-xs rounded-xl transition-all whitespace-nowrap flex items-center gap-1.5">
                    <span>Semua Hari</span>
                    <span :class="activeTab === 'Semua' ? 'bg-brand-700 text-white' : 'bg-slate-100 text-slate-600'"
                        class="px-1.5 py-0.5 rounded-full text-[10px]">
                        {{ $totalSesi }}
                    </span>
                </button>

                @foreach ($urutanHari as $hari)
                    @php $countHari = isset($jadwalPerHari[$hari]) ? $jadwalPerHari[$hari]->count() : 0; @endphp
                    @if ($countHari > 0)
                        <button type="button" @click="activeTab = '{{ $hari }}'"
                            :class="activeTab === '{{ $hari }}' ? 'bg-brand-800 text-white font-semibold shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                            class="px-3.5 py-2 text-xs rounded-xl transition-all whitespace-nowrap flex items-center gap-1.5">
                            <span>{{ $hari }}</span>
                            <span :class="activeTab === '{{ $hari }}' ? 'bg-brand-700 text-white' : 'bg-slate-100 text-slate-600'"
                                class="px-1.5 py-0.5 rounded-full text-[10px]">
                                {{ $countHari }}
                            </span>
                        </button>
                    @endif
                @endforeach
            </div>

            {{-- Schedule Cards by Day --}}
            <div class="space-y-5">
                @foreach ($urutanHari as $hari)
                    @if (isset($jadwalPerHari[$hari]))
                        <div x-show="activeTab === 'Semua' || activeTab === '{{ $hari }}'"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                            
                            {{-- Day Header --}}
                            <div class="bg-slate-50 px-5 py-3 border-b border-slate-100 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-calendar-day text-brand-700 text-xs"></i>
                                    <h3 class="font-bold text-slate-800 text-sm">Hari {{ $hari }}</h3>
                                </div>
                                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-brand-50 text-brand-700 border border-brand-200/60">
                                    {{ $jadwalPerHari[$hari]->count() }} Sesi
                                </span>
                            </div>

                            {{-- Lessons List --}}
                            <div class="divide-y divide-slate-100">
                                @foreach ($jadwalPerHari[$hari] as $item)
                                    <div class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50/50 transition-colors">
                                        <div class="flex items-start gap-4">
                                            {{-- Time Badge --}}
                                            <div class="shrink-0 w-20 px-2 py-2 rounded-xl bg-slate-100 text-slate-700 text-center">
                                                <p class="text-xs font-bold">{{ date('H:i', strtotime($item->waktu_mulai)) }}</p>
                                                <p class="text-[10px] text-slate-400">s/d</p>
                                                <p class="text-xs font-semibold text-slate-600">{{ date('H:i', strtotime($item->waktu_selesai)) }}</p>
                                            </div>

                                            <div>
                                                <div class="flex flex-wrap items-center gap-2">
                                                    <h4 class="font-bold text-slate-900 text-sm md:text-base">
                                                        {{ $item->nama_matpel }}
                                                    </h4>
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-brand-50 text-brand-700 border border-brand-200/60">
                                                        <i class="fa-solid fa-chalkboard text-[10px]"></i>
                                                        {{ $item->nama_kelas }}
                                                    </span>
                                                </div>
                                                <p class="text-xs text-slate-500 mt-1 flex items-center gap-3">
                                                    <span>
                                                        <i class="fa-solid fa-location-dot text-slate-400 mr-1"></i>
                                                        Ruang Kelas {{ $item->nama_kelas }}
                                                    </span>
                                                    <span class="text-slate-300">•</span>
                                                    <span>
                                                        <i class="fa-solid fa-user-tie text-slate-400 mr-1"></i>
                                                        {{ $guru->nama_guru }}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>

                                        {{-- Actions --}}
                                        <div class="flex items-center gap-2 shrink-0">
                                            <a href="{{ route('guru.absensi.index') }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-xl bg-brand-50 text-brand-700 hover:bg-brand-100 transition-colors">
                                                <i class="fa-solid fa-clipboard-user text-xs"></i>
                                                Presensi
                                            </a>
                                            <a href="{{ route('guru.dashboard.lms') }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">
                                                <i class="fa-solid fa-graduation-cap text-xs"></i>
                                                LMS
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    @endif
                @endforeach
            </div>

        @endif

    </div>
</x-app-guru-layout>
