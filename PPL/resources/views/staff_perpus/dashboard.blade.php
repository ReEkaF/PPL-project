<x-staffperpustakaan-layout>
    @php
        $totalBukuCount = $totalBookStock ?? ($buku->first()->stok_buku ?? 0);
        $totalDipinjam = $borrowCount ?? 0;
        $totalKembali = $backCount ?? 0;
        $totalHilang = $lostCount ?? 0;
        $staff = Auth::guard('web-staffperpus')->user();
    @endphp

    <div class="space-y-6 pb-10">

        {{-- Header & Breadcrumbs --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="space-y-1">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2 text-xs">
                        <li class="inline-flex items-center">
                            <span class="text-slate-500 flex items-center gap-1.5">
                                <i class="fa-solid fa-house text-[11px]"></i>
                                <span>Dashboard</span>
                            </span>
                        </li>
                        <li class="flex items-center text-slate-400">
                            <i class="fa-solid fa-chevron-right text-[10px] mx-1"></i>
                            <span class="text-slate-800 font-medium">Perpustakaan</span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Portal Manajemen Perpustakaan</h1>
                <p class="text-xs text-slate-500">
                    Pusat kendali sirkulasi katalog buku, pencatatan transaksi peminjaman, serta pemantauan ketersediaan stok koleksi.
                </p>
            </div>
        </div>

        {{-- Greeting / Info Banner (Flat Light Panel) --}}
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="space-y-2">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-brand-50 text-brand-800 border border-brand-200/60">
                            <i class="fa-solid fa-book-bookmark text-brand-700"></i>
                            Layanan sirkulasi koleksi
                        </span>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-[11px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <i class="fa-solid fa-circle text-[6px]"></i>
                            Layanan dibuka (07:00 - 15:00 WIB)
                        </span>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">
                        Selamat Datang, {{ $staff->nama_staff_perpus ?? 'Staff Perpustakaan' }}
                    </h2>
                    <p class="text-xs md:text-sm text-slate-500 max-w-2xl leading-relaxed">
                        Kelola katalog buku perpustakaan SMPN 2 Kamal, catat transaksi peminjaman baru oleh guru dan siswa, serta pantau kepatuhan tenggat waktu pengembalian buku.
                    </p>
                </div>

                <div class="shrink-0 bg-slate-50 rounded-lg p-4 border border-slate-200 text-left sm:text-right min-w-[210px] space-y-1">
                    <p class="text-[11px] text-slate-500 font-medium">Petugas perpustakaan</p>
                    <p class="text-sm font-bold text-slate-900">{{ $staff->nama_staff_perpus ?? 'Staff Perpustakaan' }}</p>
                    <p class="text-xs text-slate-500 pt-1 flex items-center sm:justify-end gap-1.5 font-mono">
                        <i class="fa-solid fa-id-badge text-[11px]"></i>
                        {{ $staff->email ?? 'perpus@smpn2kamal.sch.id' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- 4 Standard KPI Stat Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Total Stok Buku --}}
            <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500">Koleksi buku terdaftar</span>
                    <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-800 border border-brand-100/50 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-book"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-2xl font-bold text-slate-900 font-mono">{{ $totalBukuCount }}</p>
                    <p class="text-xs text-slate-500 mt-1">Total eksemplar buku di perpustakaan</p>
                </div>
            </div>

            {{-- Sedang Dipinjam --}}
            <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500">Buku sedang dipinjam</span>
                    <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-800 border border-brand-100/50 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-hand-holding-hand"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-2xl font-bold text-slate-900 font-mono">{{ $totalDipinjam }}</p>
                    <p class="text-xs text-slate-500 mt-1">Eksemplar dalam sirkulasi peminjaman</p>
                </div>
            </div>

            {{-- Selesai Dikembalikan --}}
            <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500">Selesai dikembalikan</span>
                    <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-800 border border-brand-100/50 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-2xl font-bold text-slate-900 font-mono">{{ $totalKembali }}</p>
                    <p class="text-xs text-slate-500 mt-1">Transaksi pengembalian terselesaikan</p>
                </div>
            </div>

            {{-- Buku Rusak / Hilang --}}
            <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500">Buku rusak / hilang</span>
                    <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-800 border border-brand-100/50 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="flex items-baseline gap-2">
                        <p class="text-2xl font-bold text-slate-900 font-mono">{{ $totalHilang }}</p>
                        @if ($totalHilang > 0)
                            <span class="text-xs font-medium text-rose-700 bg-rose-50 border border-rose-200 px-1.5 py-0.5 rounded">
                                Perlu tindak lanjut
                            </span>
                        @endif
                    </div>
                    <p class="text-xs text-slate-500 mt-1">Laporan hilang & denda penggantian</p>
                </div>
            </div>
        </div>

        {{-- Layanan Operasional Cepat --}}
        <div class="space-y-3">
            <div>
                <h2 class="text-sm font-bold text-slate-900">Layanan Operasional Cepat</h2>
                <p class="text-xs text-slate-500">Akses tindakan langsung untuk manajemen peminjaman dan katalog buku</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Modul 1: Transaksi Peminjaman (Primary) --}}
                <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-lg bg-brand-50 text-brand-800 border border-brand-100/50 flex items-center justify-center text-base">
                            <i class="fa-solid fa-cart-plus"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-900 text-sm">
                                Peminjaman Buku Baru
                            </h3>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                Catat peminjaman buku oleh guru atau siswa, verifikasi nomor barcode, dan tetapkan batas pengembalian.
                            </p>
                        </div>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] font-medium text-slate-600 bg-slate-100 px-2 py-0.5 rounded">
                            Sirkulasi aktif
                        </span>
                        <a href="{{ route('staff_perpus.transaksi.create') }}"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-brand-800 hover:bg-brand-900 text-white transition-colors">
                            <span>Tambah Transaksi</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>

                {{-- Modul 2: Tambah Koleksi Buku --}}
                <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-lg bg-brand-50 text-brand-800 border border-brand-100/50 flex items-center justify-center text-base">
                            <i class="fa-solid fa-book-medical"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-900 text-sm">
                                Tambah Koleksi Buku
                            </h3>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                Registrasikan judul buku baru, tentukan kategori, penerbit, nomor rak, serta jumlah stok buku fisik.
                            </p>
                        </div>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] font-medium text-slate-600 bg-slate-100 px-2 py-0.5 rounded">
                            Katalog perpus
                        </span>
                        <a href="{{ route('staff_perpus.buku.create') }}"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 transition-colors">
                            <span>Input Buku</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>

                {{-- Modul 3: Kelola Kategori --}}
                <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-lg bg-brand-50 text-brand-800 border border-brand-100/50 flex items-center justify-center text-base">
                            <i class="fa-solid fa-tags"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-900 text-sm">
                                Kategori & Klasifikasi
                            </h3>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                Kelola klasifikasi bidang ilmu dan jenis buku perpustakaan untuk mempermudah pencarian koleksi.
                            </p>
                        </div>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] font-medium text-slate-600 bg-slate-100 px-2 py-0.5 rounded">
                            {{ $totalCategory ?? 0 }} Kategori
                        </span>
                        <a href="{{ route('staff_perpus.kategori.index') }}"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 transition-colors">
                            <span>Kelola Kategori</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2 Kolom Ringkasan Cepat: Buku Terbaru & Kategori --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pt-1">
            {{-- Kolom 1: Koleksi Buku Terbaru --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-book-open text-brand-800 text-xs"></i>
                        <h3 class="font-semibold text-slate-800 text-xs">Koleksi Buku Terbaru</h3>
                    </div>
                    <a href="{{ route('staff_perpus.buku.index') }}" class="text-xs font-medium text-brand-800 hover:text-brand-900 transition-colors flex items-center gap-1">
                        Lihat semua
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </a>
                </div>
                <div class="divide-y divide-slate-100 text-xs">
                    @forelse ($buku10 as $itemBuku)
                        <div class="px-4 py-3 flex items-center justify-between hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-800 flex items-center justify-center text-xs font-bold shrink-0">
                                    <i class="fa-solid fa-book"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="font-medium text-slate-900 truncate">{{ $itemBuku->judul_buku }}</p>
                                    <p class="text-[11px] text-slate-400">
                                        {{ $itemBuku->author_buku ?: 'Penulis tidak diketahui' }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right shrink-0">
                                <span class="px-2 py-0.5 rounded bg-slate-100 border border-slate-200 text-xs font-mono text-slate-700">
                                    Stok: {{ $itemBuku->stok_buku ?? 0 }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-slate-400 text-xs">
                            Belum ada data koleksi buku.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Kolom 2: Kategori Buku Terdaftar --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-tags text-brand-800 text-xs"></i>
                        <h3 class="font-semibold text-slate-800 text-xs">Kategori Buku Terdaftar</h3>
                    </div>
                    <a href="{{ route('staff_perpus.kategori.index') }}" class="text-xs font-medium text-brand-800 hover:text-brand-900 transition-colors flex items-center gap-1">
                        Lihat semua
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </a>
                </div>
                <div class="p-4">
                    <div class="flex flex-wrap gap-2">
                        @forelse ($cat10 as $itemCat)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-slate-100 hover:bg-brand-50 hover:text-brand-800 text-slate-700 border border-slate-200 transition-colors">
                                <i class="fa-regular fa-folder text-[10px]"></i>
                                <span>{{ $itemCat->nama_kategori }}</span>
                            </span>
                        @empty
                            <p class="text-xs text-slate-400 py-4">Belum ada kategori buku.</p>
                        @endforelse
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 text-xs text-slate-500 flex items-center justify-between">
                        <span>Total klasifikasi kategori:</span>
                        <span class="font-mono font-semibold text-slate-800">{{ $totalCategory ?? count($cat10) }} Kategori</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Transaksi Peminjaman Terkini --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div>
                    <h3 class="font-bold text-slate-900 text-sm">Transaksi Peminjaman Terkini</h3>
                    <p class="text-xs text-slate-500">Daftar aktivitas sirkulasi peminjaman buku perpustakaan terakhir</p>
                </div>
                <a href="{{ route('staff_perpus.transaksi.index') }}"
                    class="text-xs font-medium text-brand-800 hover:text-brand-900 transition-colors flex items-center gap-1">
                    Lihat semua transaksi
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left text-slate-600">
                    <thead class="text-[11px] font-semibold text-slate-500 bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th scope="col" class="px-5 py-3">Peminjam</th>
                            <th scope="col" class="px-5 py-3">Tanggal Pinjam</th>
                            <th scope="col" class="px-5 py-3">Batas Kembali</th>
                            <th scope="col" class="px-5 py-3">Judul Buku</th>
                            <th scope="col" class="px-5 py-3">Kategori</th>
                            <th scope="col" class="px-5 py-3 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($transaksi as $tp)
                            @php
                                $Nama_Peminjam = $tp->nama_guru ?? ($tp->nama_siswa ?? 'Peminjam');
                            @endphp
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-5 py-3.5 font-medium text-slate-900 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-[10px]">
                                            {{ substr($Nama_Peminjam, 0, 1) }}
                                        </div>
                                        <span>{{ $Nama_Peminjam }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap font-mono text-[11px] text-slate-500">
                                    {{ $tp->tgl_awal_peminjaman ? date_format(date_create($tp->tgl_awal_peminjaman), 'd M Y') : '-' }}
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap font-mono text-[11px] text-slate-500">
                                    {{ $tp->tgl_pengembalian ? date_format(date_create($tp->tgl_pengembalian), 'd M Y') : 'Tanpa batas' }}
                                </td>
                                <td class="px-5 py-3.5 font-medium text-slate-900 max-w-xs truncate">
                                    {{ $tp->judul_buku ?? 'Buku' }}
                                </td>
                                <td class="px-5 py-3.5 text-slate-500 whitespace-nowrap">
                                    <span class="px-2 py-0.5 rounded bg-slate-100 border border-slate-200 text-[10px]">
                                        {{ $tp->nama_kategori ?? 'Umum' }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                    @if ($tp->status_pengembalian == 0)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-brand-50 text-brand-800 border border-brand-200/60">
                                            Sedang dipinjam
                                        </span>
                                    @elseif ($tp->status_pengembalian == 1)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            Sudah dikembalikan
                                        </span>
                                    @elseif ($tp->status_pengembalian == 2)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-rose-50 text-rose-700 border border-rose-200">
                                            Buku hilang
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-amber-50 text-amber-700 border border-amber-200">
                                            Denda keterlambatan
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-8 text-center text-slate-400">
                                    Belum ada transaksi peminjaman tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-staffperpustakaan-layout>

