<x-siswa-layout>
    <div class="max-w-6xl mx-auto space-y-5">

        {{-- Header --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('siswa.dashboard.lms') }}"
                class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-900 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-xl font-bold text-slate-900">{{ $mataPelajaran->nama_matpel }}</h1>
                <p class="text-sm text-slate-500">{{ $guru->nama_guru }} · {{ $hari->nama_hari }}, {{ substr($waktu_mulai,0,5) }}–{{ substr($waktu_selesai,0,5) }} WIB</p>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="flex gap-1 bg-slate-100 p-1 rounded-xl w-fit">
            @php
                $tabs = [
                    ['route' => 'siswa.dashboard.lms.forum',        'label' => 'Forum',   'param' => $id],
                    ['route' => 'siswa.dashboard.lms.forum.tugas',  'label' => 'Tugas',   'param' => $id],
                    ['route' => 'siswa.dashboard.lms.forum.anggota','label' => 'Anggota', 'param' => $id],
                ];
            @endphp
            @foreach ($tabs as $tab)
                @php $isActive = request()->routeIs($tab['route']) || request()->routeIs(str_replace('dashboard.', '', $tab['route'])); @endphp
                <a href="{{ route($tab['route'], $tab['param']) }}"
                    class="px-4 py-2 text-sm font-medium rounded-lg transition-colors
                    {{ $isActive ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                    {{ $tab['label'] }}
                </a>
            @endforeach
        </div>

        {{-- Main 2-col layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- Left: Classmates List (2/3) --}}
            <div class="lg:col-span-2">
                <div class="bg-white border border-slate-200 rounded-xl p-4 sm:p-5">
                    {{-- Header with Live Search --}}
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 mb-4 border-b border-slate-100">
                        <div>
                            <h2 class="font-bold text-slate-800 text-sm">Teman Sekelas</h2>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $jumlahAnggota }} siswa terdaftar di rombel kelas ini</p>
                        </div>

                        {{-- Search Input --}}
                        <div class="relative w-full sm:w-60">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" id="search-student" placeholder="Cari nama teman..."
                                class="w-full pl-9 pr-3 py-1.5 rounded-lg border border-slate-200 text-xs focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors">
                        </div>
                    </div>

                    {{-- Student Grid --}}
                    @if ($anggotaKelas->isNotEmpty())
                        <div id="student-grid" class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach ($anggotaKelas as $anggota)
                                @php
                                    $jk = $anggota->jenis_kelamin_siswa ?? '';
                                    $isMale = ($jk == 'L' || strtolower((string)$jk) == 'laki-laki');
                                    $avatarBg = $isMale ? 'bg-sky-100 text-sky-800' : 'bg-rose-100 text-rose-800';
                                @endphp
                                <div class="student-card flex items-center gap-3 p-3 rounded-lg border border-slate-200 bg-white hover:border-slate-300 hover:shadow-sm transition-all"
                                    data-name="{{ strtolower($anggota->nama_siswa ?? '') }}"
                                    data-nisn="{{ $anggota->nisn ?? '' }}">
                                    <div class="w-9 h-9 rounded-full {{ $avatarBg }} flex items-center justify-center font-bold text-sm shrink-0">
                                        {{ strtoupper(substr($anggota->nama_siswa ?? 'S', 0, 2)) }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="font-semibold text-slate-800 text-sm truncate">{{ $anggota->nama_siswa }}</p>
                                        <div class="flex items-center gap-2 mt-0.5 text-xs text-slate-400">
                                            @if ($anggota->nisn)
                                                <span>NISN: {{ $anggota->nisn }}</span>
                                            @else
                                                <span class="truncate">{{ $anggota->email }}</span>
                                            @endif
                                            @if ($jk)
                                                <span>·</span>
                                                <span class="{{ $isMale ? 'text-sky-600' : 'text-rose-500' }}">
                                                    {{ $isMale ? 'Laki-laki' : 'Perempuan' }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Empty Search Results Notice --}}
                        <div id="no-students-found" class="hidden py-8 text-center text-xs text-slate-400">
                            Tidak ada nama siswa yang cocok dengan kata kunci pencarian.
                        </div>
                    @else
                        <div class="py-10 text-center text-slate-500 text-sm">
                            Belum ada siswa yang terdaftar di kelas ini.
                        </div>
                    @endif
                </div>
            </div>

            {{-- Right Sidebar (1/3) --}}
            <div class="space-y-4">

                {{-- Instructor Card --}}
                <div class="bg-white border border-slate-200 rounded-xl p-4">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Pengajar</p>
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-brand-100 text-brand-800 flex items-center justify-center font-bold text-sm shrink-0">
                            {{ strtoupper(substr($guru->nama_guru, 0, 2)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-slate-800 text-sm">{{ $guru->nama_guru }}</p>
                            <p class="text-xs text-slate-500">{{ $mataPelajaran->nama_matpel }}</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-slate-100 flex items-center gap-2 text-xs text-slate-500">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ $hari->nama_hari }}, {{ substr($waktu_mulai,0,5) }}–{{ substr($waktu_selesai,0,5) }} WIB</span>
                    </div>
                </div>

                {{-- Student Statistics Card --}}
                <div class="bg-white border border-slate-200 rounded-xl p-4">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Statistik Siswa</p>
                    @php
                        $maleCount = $anggotaKelas->filter(fn($s) => ($s->jenis_kelamin_siswa ?? '') == 'L' || strtolower((string)($s->jenis_kelamin_siswa ?? '')) == 'laki-laki')->count();
                        $femaleCount = $anggotaKelas->filter(fn($s) => ($s->jenis_kelamin_siswa ?? '') == 'P' || strtolower((string)($s->jenis_kelamin_siswa ?? '')) == 'perempuan')->count();
                    @endphp
                    <div class="grid grid-cols-3 gap-2 text-center">
                        <div class="p-2.5 bg-slate-50 rounded-lg border border-slate-100">
                            <span class="block text-base font-bold text-slate-800">{{ $jumlahAnggota }}</span>
                            <span class="text-[11px] text-slate-500 font-medium">Total</span>
                        </div>
                        <div class="p-2.5 bg-sky-50/70 rounded-lg border border-sky-100">
                            <span class="block text-base font-bold text-sky-700">{{ $maleCount }}</span>
                            <span class="text-[11px] text-sky-700 font-medium">Laki-laki</span>
                        </div>
                        <div class="p-2.5 bg-rose-50/70 rounded-lg border border-rose-100">
                            <span class="block text-base font-bold text-rose-700">{{ $femaleCount }}</span>
                            <span class="text-[11px] text-rose-700 font-medium">Perempuan</span>
                        </div>
                    </div>
                    @if (isset($kelas->nama_kelas))
                        <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                            <span class="text-slate-400">Kelas</span>
                            <span class="font-semibold text-slate-700">{{ $kelas->nama_kelas }}</span>
                        </div>
                    @endif
                </div>

            </div>

        </div>

    </div>
</x-siswa-layout>

{{-- Client-side Live Search Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search-student');
        const cards = document.querySelectorAll('.student-card');
        const noResults = document.getElementById('no-students-found');

        if (searchInput && cards.length > 0) {
            searchInput.addEventListener('input', function () {
                const query = this.value.toLowerCase().trim();
                let matchCount = 0;

                cards.forEach(card => {
                    const name = card.dataset.name || '';
                    const nisn = card.dataset.nisn || '';
                    if (name.includes(query) || nisn.includes(query)) {
                        card.classList.remove('hidden');
                        matchCount++;
                    } else {
                        card.classList.add('hidden');
                    }
                });

                if (noResults) {
                    if (matchCount === 0) {
                        noResults.classList.remove('hidden');
                    } else {
                        noResults.classList.add('hidden');
                    }
                }
            });
        }
    });
</script>
