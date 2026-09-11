<x-app-guru-layout>
    <div class="max-w-7xl mx-auto space-y-6 pb-10">

        {{-- Header & Breadcrumbs --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="space-y-1">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2 text-xs">
                        <li class="inline-flex items-center">
                            <a href="{{ route('guru.dashboard') }}" class="text-slate-500 hover:text-brand-800 transition-colors flex items-center gap-1.5">
                                <i class="fa-solid fa-house text-[11px]"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="flex items-center text-slate-400">
                            <i class="fa-solid fa-chevron-right text-[10px] mx-1"></i>
                            <span class="text-slate-800 font-medium">Ekstrakurikuler</span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Portal Pembina Ekstrakurikuler</h1>
                <p class="text-xs text-slate-500">
                    Pusat kendali kegiatan ekstrakurikuler, evaluasi penilaian nilai rapor siswa, dan pengawasan inventaris perlengkapan.
                </p>
            </div>
        </div>

        @if ($ekstra)
            {{-- Flat Light Panel Ekstrakurikuler --}}
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div class="space-y-2">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-brand-50 text-brand-800 border border-brand-200/60">
                                <i class="fa-solid fa-award text-brand-700"></i>
                                Ekstrakurikuler binaan
                            </span>
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-[11px] font-medium {{ $ekstra->status === 'buka' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                                <i class="fa-solid fa-circle text-[6px]"></i>
                                Pendaftaran: {{ $ekstra->status === 'buka' ? 'Dibuka' : 'Ditutup' }}
                            </span>
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">
                            {{ $ekstra->nama_ekstrakurikuler }}
                        </h2>
                        <p class="text-xs md:text-sm text-slate-500 max-w-2xl leading-relaxed">
                            {{ $ekstra->deskripsi ?: 'Bimbing dan pantau perkembangan minat & bakat siswa pada kegiatan ekstrakurikuler resmi SMPN 2 Kamal.' }}
                        </p>
                    </div>

                    <div class="shrink-0 bg-slate-50 rounded-lg p-4 border border-slate-200 text-left sm:text-right min-w-[210px] space-y-1">
                        <p class="text-[11px] text-slate-500 font-medium">Guru pembina</p>
                        <p class="text-sm font-bold text-slate-900">{{ $guru->nama_guru }}</p>
                        <p class="text-xs text-slate-500 pt-1 flex items-center sm:justify-end gap-1.5">
                            <i class="fa-regular fa-calendar-check text-[11px]"></i>
                            Tahun ajaran: {{ $tahunAjaranAktif ? $tahunAjaranAktif->tahun_mulai . '/' . $tahunAjaranAktif->tahun_selesai : '2024/2025' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- 3 KPI Metrics Summary Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                {{-- Total Anggota --}}
                <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-slate-500">Anggota terdaftar</span>
                        <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-800 border border-brand-100/50 flex items-center justify-center text-sm">
                            <i class="fa-solid fa-users"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <p class="text-2xl font-bold text-slate-900 font-mono">{{ $totalAnggota }}</p>
                        <p class="text-xs text-slate-500 mt-1">
                            Siswa aktif dengan status pendaftaran diterima
                        </p>
                    </div>
                </div>

                {{-- Anggota Dinilai --}}
                <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-slate-500">Nilai rapor terisi</span>
                        <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-800 border border-brand-100/50 flex items-center justify-center text-sm">
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="flex items-baseline gap-2">
                            <p class="text-2xl font-bold text-slate-900 font-mono">{{ $totalDinilai }}</p>
                            <span class="text-xs text-slate-400 font-mono">/ {{ $totalAnggota }} anggota</span>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">
                            Predikat nilai ekstrakurikuler yang tersimpan
                        </p>
                    </div>
                </div>

                {{-- Total Inventaris --}}
                <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-slate-500">Perlengkapan ekstra</span>
                        <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-800 border border-brand-100/50 flex items-center justify-center text-sm">
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <p class="text-2xl font-bold text-slate-900 font-mono">{{ $totalInventaris }}</p>
                        <p class="text-xs text-slate-500 mt-1">
                            Jenis barang sarana & inventaris terdaftar
                        </p>
                    </div>
                </div>
            </div>

            {{-- 3 Kartu Menu Fitur Ekstrakurikuler --}}
            <div class="space-y-3">
                <div>
                    <h2 class="text-sm font-bold text-slate-900">Menu & Fitur Pembina</h2>
                    <p class="text-xs text-slate-500">Akses modul evaluasi penilaian nilai, anggota, dan perlengkapan sarana</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {{-- Card 1: Penilaian Nilai (Primary) --}}
                    <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex flex-col justify-between space-y-4">
                        <div class="space-y-3">
                            <div class="w-10 h-10 rounded-lg bg-brand-50 text-brand-800 border border-brand-100/50 flex items-center justify-center text-base">
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-slate-900 text-sm">
                                    Penilaian Nilai Ekstrakurikuler
                                </h3>
                                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                    Periksa laporan kegiatan siswa dan berikan predikat nilai rapor resmi (A, B, C, D, E) untuk seluruh anggota.
                                </p>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-[11px] font-medium text-slate-600 bg-slate-100 px-2 py-0.5 rounded">
                                {{ $totalDinilai }} Nilai tersimpan
                            </span>
                            <a href="{{ route('pembina.penilaian') }}"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-brand-800 hover:bg-brand-900 text-white transition-colors">
                                <span>Kelola Nilai</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Card 2: Data Anggota (Secondary Outline) --}}
                    <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex flex-col justify-between space-y-4">
                        <div class="space-y-3">
                            <div class="w-10 h-10 rounded-lg bg-brand-50 text-brand-800 border border-brand-100/50 flex items-center justify-center text-base">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-slate-900 text-sm">
                                    Data Anggota Siswa
                                </h3>
                                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                    Lihat daftar lengkap siswa yang bergabung, nomor induk (NISN), alamat domisili, dan status pendaftaran.
                                </p>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-[11px] font-medium text-slate-600 bg-slate-100 px-2 py-0.5 rounded">
                                {{ $totalAnggota }} Siswa terdaftar
                            </span>
                            <a href="{{ route('pembina.anggota') }}"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 transition-colors">
                                <span>Lihat Anggota</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Card 3: Perlengkapan & Inventaris (Secondary Outline) --}}
                    <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex flex-col justify-between space-y-4">
                        <div class="space-y-3">
                            <div class="w-10 h-10 rounded-lg bg-brand-50 text-brand-800 border border-brand-100/50 flex items-center justify-center text-base">
                                <i class="fa-solid fa-boxes-stacked"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-slate-900 text-sm">
                                    Perlengkapan & Inventaris
                                </h3>
                                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                    Pantau stok perlengkapan sarana ekstrakurikuler dan riwayat histori peminjaman barang oleh siswa.
                                </p>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-[11px] font-medium text-slate-600 bg-slate-100 px-2 py-0.5 rounded">
                                {{ $totalInventaris }} Barang terdaftar
                            </span>
                            <a href="{{ route('pembina.perlengkapan') }}"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 transition-colors">
                                <span>Kelola Barang</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2 Kolom Preview Ringkasan Cepat --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pt-1">
                {{-- Preview Anggota --}}
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-user-group text-brand-800 text-xs"></i>
                            <h3 class="font-semibold text-slate-800 text-xs">Anggota Baru Terdaftar</h3>
                        </div>
                        <a href="{{ route('pembina.anggota') }}" class="text-xs font-medium text-brand-800 hover:text-brand-900 transition-colors flex items-center gap-1">
                            Lihat semua
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </a>
                    </div>
                    <div class="divide-y divide-slate-100 text-xs">
                        @forelse ($anggotaTerbaru as $reg)
                            <div class="px-4 py-3 flex items-center justify-between hover:bg-slate-50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="w-7 h-7 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center font-semibold text-[11px]">
                                        {{ substr($reg->siswa->nama_siswa ?? 'S', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-900">{{ $reg->siswa->nama_siswa ?? 'Siswa' }}</p>
                                        <p class="text-[11px] text-slate-400 font-mono">NISN: {{ $reg->siswa->nisn ?? '-' }}</p>
                                    </div>
                                </div>
                                <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    {{ $reg->status }}
                                </span>
                            </div>
                        @empty
                            <div class="p-6 text-center text-slate-400 text-xs">
                                Belum ada anggota terdaftar.
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Preview Perlengkapan --}}
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-boxes-stacked text-brand-800 text-xs"></i>
                            <h3 class="font-semibold text-slate-800 text-xs">Perlengkapan & Stok</h3>
                        </div>
                        <a href="{{ route('pembina.perlengkapan') }}" class="text-xs font-medium text-brand-800 hover:text-brand-900 transition-colors flex items-center gap-1">
                            Lihat semua
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </a>
                    </div>
                    <div class="divide-y divide-slate-100 text-xs">
                        @forelse ($inventarisList as $item)
                            <div class="px-4 py-3 flex items-center justify-between hover:bg-slate-50 transition-colors">
                                <div>
                                    <p class="font-medium text-slate-900">{{ $item->nama_barang }}</p>
                                    <p class="text-[11px] text-slate-400 font-mono">ID: {{ Str::limit($item->id_inventaris, 15) }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="px-2 py-0.5 rounded bg-slate-100 border border-slate-200 text-xs font-mono text-slate-700">
                                        Stok: {{ $item->stok }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center text-slate-400 text-xs">
                                Belum ada data inventaris.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        @else
            {{-- Empty State: Guru belum memiliki ekskul binaan --}}
            <div class="bg-white rounded-xl border border-slate-200 p-12 text-center shadow-sm space-y-4 max-w-lg mx-auto">
                <div class="w-12 h-12 rounded-lg bg-brand-50 text-brand-800 border border-brand-100/50 flex items-center justify-center text-xl mx-auto">
                    <i class="fa-solid fa-award"></i>
                </div>
                <div class="space-y-1.5">
                    <h3 class="text-base font-bold text-slate-900">Belum Ada Ekstrakurikuler yang Diampu</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Akun Anda memiliki status pembina, namun belum ada ekstrakurikuler yang ditugaskan ke akun Anda di sistem. Silakan hubungi Administrator sekolah untuk menetapkan ekstrakurikuler binaan.
                    </p>
                </div>
                <div class="pt-2">
                    <a href="{{ route('guru.dashboard') }}"
                        class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg text-xs font-medium bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                        <i class="fa-solid fa-arrow-left text-[10px]"></i>
                        <span>Kembali ke Dashboard Guru</span>
                    </a>
                </div>
            </div>
        @endif

    </div>
</x-app-guru-layout>
