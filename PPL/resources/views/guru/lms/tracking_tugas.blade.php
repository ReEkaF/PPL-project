<x-app-guru-layout>
    <div class="max-w-6xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-900">Pemeriksaan Tugas Siswa</h1>
                <p class="text-sm text-slate-500 mt-0.5">
                    Pantau status pengumpulan berkas tugas siswa dan input penilaian secara cepat.
                </p>
            </div>
            <a href="{{ route('guru.dashboard.lms') }}"
                class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors shadow-sm self-start sm:self-auto">
                <i class="fa-solid fa-arrow-left text-[11px]"></i>
                <span>Kembali ke LMS</span>
            </a>
        </div>

        {{-- Filter Bar --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-filter text-slate-400 text-xs"></i>
                <span class="text-xs font-semibold text-slate-700">Filter Rombel:</span>
            </div>
            <form action="{{ route('guru.dashboard.lms.tugas.periksa') }}" method="GET" class="w-full sm:w-64">
                <select name="kelas_id" onchange="this.form.submit()"
                    class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                    <option value="">Semua Kelas</option>
                    @foreach ($kelasList as $kelas)
                        <option value="{{ $kelas->id_kelas }}" {{ $kelas->id_kelas == $kelasId ? 'selected' : '' }}>
                            Kelas {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        {{-- Assignments List --}}
        <div class="space-y-4">
            @forelse ($tugas as $t)
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow flex flex-col md:flex-row md:items-center justify-between gap-5">
                    
                    {{-- Task Meta --}}
                    <div class="flex items-start gap-3.5">
                        <div class="w-11 h-11 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-clipboard-question text-lg"></i>
                        </div>
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h3 class="font-bold text-slate-900 text-base">
                                    {{ $t['tugas']->judul }}
                                </h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-brand-50 text-brand-700 border border-brand-200/60">
                                    Kelas {{ $t['namaKelas'] }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-500 mt-1 flex items-center gap-1.5">
                                <i class="fa-regular fa-clock text-slate-400"></i>
                                <span>Tenggat: {{ $t['deadline']->translatedFormat('l, d F Y, H:i') }} WIB</span>
                            </p>
                        </div>
                    </div>

                    {{-- Metrics & Action --}}
                    <div class="flex flex-wrap items-center gap-4 sm:gap-6 pt-3 md:pt-0 border-t md:border-t-0 border-slate-100">
                        {{-- Counter 1: Diserahkan --}}
                        <div class="text-center px-3 py-1.5 rounded-xl bg-blue-50/80 border border-blue-100 min-w-[75px]">
                            <p class="text-base font-bold text-blue-700 leading-none">{{ $t['siswaMenyerahkan'] }}</p>
                            <p class="text-[10px] text-blue-600 font-medium mt-1">Diserahkan</p>
                        </div>

                        {{-- Counter 2: Ditugaskan --}}
                        <div class="text-center px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200 min-w-[75px]">
                            <p class="text-base font-bold text-slate-700 leading-none">{{ $t['siswaBelumMenyerahkan'] }}</p>
                            <p class="text-[10px] text-slate-500 font-medium mt-1">Belum Kirim</p>
                        </div>

                        {{-- Counter 3: Dinilai --}}
                        <div class="text-center px-3 py-1.5 rounded-xl bg-emerald-50/80 border border-emerald-100 min-w-[75px]">
                            <p class="text-base font-bold text-emerald-700 leading-none">{{ $t['dinilai'] }}</p>
                            <p class="text-[10px] text-emerald-600 font-medium mt-1">Sudah Dinilai</p>
                        </div>

                        {{-- Action Button --}}
                        <a href="{{ route('guru.dashboard.lms.tugas.siswa', $t['tugas']->id_tugas) }}"
                            class="inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold bg-brand-700 text-white hover:bg-brand-800 transition-colors shadow-sm shrink-0">
                            <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                            <span>Buka Penilaian</span>
                        </a>
                    </div>

                </div>
            @empty
                <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center shadow-sm">
                    <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-clipboard-check text-2xl"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-800">Tidak Ada Tugas yang Perlu Diperiksa</h3>
                    <p class="text-sm text-slate-400 max-w-md mx-auto mt-1">
                        Belum ada penugasan yang dibuat atau seluruh penugasan telah selesai dinilai.
                    </p>
                </div>
            @endforelse
        </div>

    </div>
</x-app-guru-layout>
