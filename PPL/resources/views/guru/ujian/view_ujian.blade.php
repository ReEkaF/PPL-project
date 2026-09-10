<x-app-guru-layout>
    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-900">Manajemen Ujian / CBT</h1>
                <p class="text-sm text-slate-500 mt-0.5">
                    Daftar paket ujian sekolah yang dikelompokkan berdasarkan rombel kelas untuk memudahkan pengelolaan.
                </p>
            </div>
            <div class="flex items-center gap-2 self-start sm:self-auto">
                <a href="{{ route('guru.dashboard.ujian.create_ujian') }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold bg-brand-800 text-white hover:bg-brand-900 transition-colors shadow-sm">
                    <i class="fa-solid fa-plus text-[11px]"></i>
                    <span>Buat Ujian Baru</span>
                </a>
                <a href="{{ route('guru.dashboard.ujian.pengumpulan') }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors shadow-sm">
                    <i class="fa-solid fa-square-poll-vertical text-slate-500 text-[11px]"></i>
                    <span>Hasil Siswa</span>
                </a>
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

        {{-- Overview Metrics Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-800 flex items-center justify-center text-base shrink-0">
                    <i class="fa-solid fa-file-lines"></i>
                </div>
                <div>
                    <span class="text-2xl font-bold text-slate-900">{{ $totalUjian }}</span>
                    <p class="text-xs text-slate-500 font-medium">Total Paket Ujian</p>
                </div>
            </div>
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-700 flex items-center justify-center text-base shrink-0">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
                <div>
                    <span class="text-2xl font-bold text-slate-900">{{ $kelasList->count() }}</span>
                    <p class="text-xs text-slate-500 font-medium">Rombel / Kelas Terdaftar</p>
                </div>
            </div>
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center text-base shrink-0">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <div>
                    <span class="text-2xl font-bold text-slate-900">
                        {{ $kelasList->count() > 0 ? round($totalUjian / $kelasList->count(), 1) : 0 }}
                    </span>
                    <p class="text-xs text-slate-500 font-medium">Rata-rata Ujian per Kelas</p>
                </div>
            </div>
        </div>

        {{-- Filter & Search Controls Bar --}}
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm space-y-3">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
                {{-- Live Search Input --}}
                <div class="relative flex-1 max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </div>
                    <input type="text" id="search-ujian" placeholder="Cari judul ujian, topik, atau mata pelajaran..."
                        class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors">
                </div>

                {{-- Action Helper (Expand/Collapse All) --}}
                <div class="flex items-center gap-2 text-xs">
                    <button type="button" id="btn-toggle-all"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 font-medium transition-colors">
                        <i class="fa-solid fa-up-down text-[10px]"></i>
                        <span id="btn-toggle-text">Ciutkan Semua</span>
                    </button>
                </div>
            </div>

            {{-- Class Pills / Tabs --}}
            <div class="pt-2 border-t border-slate-100">
                <div class="flex items-center gap-1.5 overflow-x-auto pb-1 text-xs">
                    <span class="text-slate-400 text-xs font-semibold mr-1 shrink-0">
                        <i class="fa-solid fa-filter text-[10px] mr-1"></i>Pilih Kelas:
                    </span>
                    <button type="button" data-filter-class="all"
                        class="class-pill px-3 py-1.5 rounded-lg text-xs font-semibold transition-all shrink-0 bg-brand-800 text-white shadow-sm">
                        Semua Kelas <span class="ml-1 opacity-80">({{ $totalUjian }})</span>
                    </button>
                    @foreach ($kelasList as $kelasName)
                        @php $count = $classCounts[$kelasName] ?? 0; @endphp
                        <button type="button" data-filter-class="{{ $kelasName }}"
                            class="class-pill px-3 py-1.5 rounded-lg text-xs font-medium transition-all shrink-0 bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-slate-900">
                            Kelas {{ $kelasName }} <span class="ml-1 text-[11px] text-slate-400">({{ $count }})</span>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Grouped Exams Container --}}
        <div id="exam-groups-container" class="space-y-6">
            @forelse ($groupedUjian as $namaKelas => $ujianList)
                @php
                    $distinctMapels = $ujianList->map(fn($u) => $u->kelasMataPelajaran?->mataPelajaran?->nama_matpel)->filter()->unique()->values();
                @endphp
                <div class="class-card bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden transition-all"
                    data-class="{{ $namaKelas }}">
                    
                    {{-- Class Header --}}
                    <div class="class-header px-5 py-4 bg-slate-50/80 border-b border-slate-100 flex items-center justify-between cursor-pointer select-none hover:bg-slate-100/70 transition-colors">
                        <div class="flex items-center gap-3.5">
                            <div class="w-10 h-10 rounded-xl bg-brand-800 text-white font-bold flex items-center justify-center text-sm shadow-inner shrink-0">
                                {{ $namaKelas }}
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h2 class="font-bold text-slate-900 text-base">Kelas {{ $namaKelas }}</h2>
                                    <span class="text-[11px] font-semibold px-2 py-0.5 rounded-full bg-brand-50 text-brand-800 border border-brand-200/80">
                                        {{ $ujianList->count() }} Paket Ujian
                                    </span>
                                </div>
                                <p class="text-xs text-slate-500 mt-0.5">
                                    Mata Pelajaran: 
                                    @if ($distinctMapels->isNotEmpty())
                                        <span class="font-medium text-slate-700">
                                            {{ $distinctMapels->take(4)->join(', ') }}
                                            @if ($distinctMapels->count() > 4)
                                                <span class="text-slate-400">(+{{ $distinctMapels->count() - 4 }} lainnya)</span>
                                            @endif
                                        </span>
                                    @else
                                        <span class="italic text-slate-400">Tidak ada mapel terikat</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="text-xs text-slate-400 font-medium hidden sm:inline">Klik untuk buka/tutup</span>
                            <div class="toggle-icon w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-500 flex items-center justify-center text-xs transition-transform duration-200">
                                <i class="fa-solid fa-chevron-up"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Class Exam Table --}}
                    <div class="class-body overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-slate-50/50 border-b border-slate-100 text-slate-500 uppercase tracking-wider text-[11px] font-semibold">
                                    <th class="py-3 px-4 w-12 text-center">No</th>
                                    <th class="py-3 px-4 min-w-[220px]">Judul & Detail Ujian</th>
                                    <th class="py-3 px-4 min-w-[160px]">Mata Pelajaran</th>
                                    <th class="py-3 px-4 min-w-[170px]">Jadwal & Durasi</th>
                                    <th class="py-3 px-4 text-center min-w-[100px]">Soal</th>
                                    <th class="py-3 px-4 text-center min-w-[110px]">Token</th>
                                    <th class="py-3 px-4 text-center min-w-[140px]">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($ujianList as $index => $item)
                                    @php
                                        $mapelName = $item->kelasMataPelajaran->mataPelajaran->nama_matpel ?? '-';
                                        $topikTitle = $item->topik->judul_topik ?? '';
                                        $tokenValue = $item->token ?? $item->token_ujian ?? null;
                                        $jenisUjian = $item->jenis_ujian ?? 'Ujian';
                                    @endphp
                                    <tr class="exam-row hover:bg-slate-50/70 transition-colors"
                                        data-search="{{ strtolower($item->judul . ' ' . $mapelName . ' ' . $topikTitle . ' ' . ($item->deskripsi ?? '')) }}">
                                        {{-- No --}}
                                        <td class="py-3 px-4 text-center text-slate-400 font-medium">
                                            {{ $index + 1 }}
                                        </td>

                                        {{-- Judul & Detail Ujian --}}
                                        <td class="py-3 px-4">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-brand-100 text-brand-800">
                                                    {{ $jenisUjian }}
                                                </span>
                                                @if ($topikTitle)
                                                    <span class="inline-flex items-center gap-1 text-[11px] text-slate-400">
                                                        <i class="fa-solid fa-tag text-[9px] text-slate-300"></i>
                                                        <span class="truncate max-w-[180px]">{{ $topikTitle }}</span>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="font-bold text-slate-900 text-sm hover:text-brand-800 transition-colors">
                                                {{ $item->judul }}
                                            </div>
                                            @if ($item->deskripsi)
                                                <p class="text-[11px] text-slate-400 line-clamp-1 mt-0.5">
                                                    {{ $item->deskripsi }}
                                                </p>
                                            @endif
                                        </td>

                                        {{-- Mata Pelajaran --}}
                                        <td class="py-3 px-4">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-brand-50 text-brand-800 border border-brand-200/60">
                                                {{ $mapelName }}
                                            </span>
                                        </td>

                                        {{-- Jadwal & Durasi --}}
                                        <td class="py-3 px-4 text-slate-600">
                                            @if ($item->waktu_mulai)
                                                <p class="font-semibold text-slate-800">
                                                    {{ \Carbon\Carbon::parse($item->waktu_mulai)->translatedFormat('d M Y, H:i') }} WIB
                                                </p>
                                            @else
                                                <p class="text-slate-600">
                                                    {{ \Carbon\Carbon::parse($item->tanggal_dibuat ?? $item->created_at)->translatedFormat('d M Y') }}
                                                </p>
                                            @endif
                                            <p class="text-[11px] text-slate-400 mt-0.5 flex items-center gap-1">
                                                <i class="fa-regular fa-clock text-amber-500 text-[10px]"></i>
                                                <span>Durasi: {{ $item->durasi_menit ?? 60 }} Menit</span>
                                            </p>
                                        </td>

                                        {{-- Butir Soal --}}
                                        <td class="py-3 px-4 text-center">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 font-semibold text-xs">
                                                <i class="fa-solid fa-list-check text-slate-400 text-[10px]"></i>
                                                <span>{{ $item->soal_ujian_count ?? 0 }} Soal</span>
                                            </span>
                                        </td>

                                        {{-- Token Ujian --}}
                                        <td class="py-3 px-4 text-center">
                                            @if ($tokenValue)
                                                <span class="inline-block px-2.5 py-1 rounded-lg bg-amber-50 text-amber-800 border border-amber-200 font-mono font-bold tracking-wider text-xs">
                                                    {{ $tokenValue }}
                                                </span>
                                            @else
                                                <span class="text-slate-300 italic text-xs">Tanpa Token</span>
                                            @endif
                                        </td>

                                        {{-- Aksi --}}
                                        <td class="py-3 px-4 text-center">
                                            <div class="flex items-center justify-center gap-1.5">
                                                <a href="{{ route('guru.ujian.soal_ujian', $item->id_ujian) }}"
                                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 font-semibold transition-colors text-[11px]"
                                                    title="Buka Bank Soal">
                                                    <i class="fa-solid fa-list-ol text-[10px]"></i>
                                                    <span>Soal</span>
                                                </a>
                                                <a href="{{ route('guru.ujian.add.soal', $item->id_ujian) }}"
                                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-brand-50 text-brand-700 hover:bg-brand-100 font-semibold transition-colors text-[11px]"
                                                    title="Tambah Butir Soal">
                                                    <i class="fa-solid fa-plus text-[10px]"></i>
                                                    <span>Tambah</span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            @empty
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-12 text-center">
                    <div class="w-14 h-14 rounded-2xl bg-brand-50 text-brand-700 flex items-center justify-center mx-auto mb-3 text-2xl">
                        <i class="fa-solid fa-clipboard-question"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base">Belum Ada Paket Ujian</h3>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                        Belum ada paket ujian atau asesmen yang dibuat untuk kelas ini. Klik tombol "Buat Ujian Baru" di atas untuk menambahkan.
                    </p>
                </div>
            @endforelse
        </div>

        {{-- Empty Search Results Notice --}}
        <div id="search-no-results" class="hidden bg-white rounded-2xl border border-slate-200 shadow-sm p-12 text-center">
            <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3 text-xl">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <h3 class="font-bold text-slate-800 text-sm">Tidak Ada Ujian yang Cocok</h3>
            <p class="text-xs text-slate-400 mt-1">
                Kata kunci pencarian tidak cocok dengan judul ujian, mata pelajaran, atau topik apapun.
            </p>
        </div>

    </div>

    {{-- Interactive Filtering & Accordion Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search-ujian');
            const pills = document.querySelectorAll('.class-pill');
            const cards = document.querySelectorAll('.class-card');
            const noResults = document.getElementById('search-no-results');
            const toggleAllBtn = document.getElementById('btn-toggle-all');
            const toggleAllText = document.getElementById('btn-toggle-text');

            let currentClassFilter = 'all';
            let allCollapsed = false;

            // Accordion Toggle for each class card header
            document.querySelectorAll('.class-header').forEach(header => {
                header.addEventListener('click', function () {
                    const card = this.closest('.class-card');
                    const body = card.querySelector('.class-body');
                    const icon = this.querySelector('.toggle-icon');

                    if (body.classList.contains('hidden')) {
                        body.classList.remove('hidden');
                        if (icon) icon.style.transform = 'rotate(0deg)';
                    } else {
                        body.classList.add('hidden');
                        if (icon) icon.style.transform = 'rotate(180deg)';
                    }
                });
            });

            // Toggle All Accordions
            if (toggleAllBtn) {
                toggleAllBtn.addEventListener('click', function () {
                    allCollapsed = !allCollapsed;
                    cards.forEach(card => {
                        const body = card.querySelector('.class-body');
                        const icon = card.querySelector('.toggle-icon');
                        if (allCollapsed) {
                            body.classList.add('hidden');
                            if (icon) icon.style.transform = 'rotate(180deg)';
                        } else {
                            body.classList.remove('hidden');
                            if (icon) icon.style.transform = 'rotate(0deg)';
                        }
                    });
                    toggleAllText.textContent = allCollapsed ? 'Buka Semua' : 'Ciutkan Semua';
                });
            }

            // Function to filter cards & rows
            function applyFilters() {
                const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
                let visibleRowsTotal = 0;
                let visibleCardsTotal = 0;

                cards.forEach(card => {
                    const classId = card.dataset.class;
                    const matchesClass = (currentClassFilter === 'all' || currentClassFilter === classId);

                    if (!matchesClass) {
                        card.classList.add('hidden');
                        return;
                    }

                    // Search within rows of matching class
                    const rows = card.querySelectorAll('.exam-row');
                    let matchingRowsInCard = 0;

                    rows.forEach(row => {
                        const searchText = row.dataset.search || '';
                        if (!query || searchText.includes(query)) {
                            row.classList.remove('hidden');
                            matchingRowsInCard++;
                            visibleRowsTotal++;
                        } else {
                            row.classList.add('hidden');
                        }
                    });

                    if (matchingRowsInCard > 0) {
                        card.classList.remove('hidden');
                        visibleCardsTotal++;
                    } else {
                        card.classList.add('hidden');
                    }
                });

                if (noResults) {
                    if (visibleCardsTotal === 0 && cards.length > 0) {
                        noResults.classList.remove('hidden');
                    } else {
                        noResults.classList.add('hidden');
                    }
                }
            }

            // Class Pill Click Handlers
            pills.forEach(pill => {
                pill.addEventListener('click', function () {
                    const targetClass = this.dataset.filterClass;
                    currentClassFilter = targetClass;

                    // Update pill styling
                    pills.forEach(p => {
                        if (p === pill) {
                            p.className = 'class-pill px-3 py-1.5 rounded-lg text-xs font-semibold transition-all shrink-0 bg-brand-800 text-white shadow-sm';
                        } else {
                            p.className = 'class-pill px-3 py-1.5 rounded-lg text-xs font-medium transition-all shrink-0 bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-slate-900';
                        }
                    });

                    applyFilters();
                });
            });

            // Live Search Input Listener
            if (searchInput) {
                searchInput.addEventListener('input', applyFilters);
            }
        });
    </script>
</x-app-guru-layout>
