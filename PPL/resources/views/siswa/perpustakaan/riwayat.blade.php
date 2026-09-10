<x-siswa-layout>
    <div class="max-w-6xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-900">Riwayat Peminjaman Buku</h1>
                <p class="text-sm text-slate-500 mt-0.5">Pantau status buku yang sedang kamu pinjam atau yang sudah pernah kamu kembalikan.</p>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="flex gap-1 bg-slate-100 p-1 rounded-xl w-fit">
            <a href="{{ route('siswa.perpustakaan.index') }}"
                class="px-4 py-2 text-sm font-medium rounded-lg transition-colors text-slate-500 hover:text-slate-700">
                Katalog Buku
            </a>
            <a href="{{ route('siswa.perpustakaan.riwayat') }}"
                class="px-4 py-2 text-sm font-medium rounded-lg transition-colors bg-white text-slate-900 shadow-sm">
                Riwayat Peminjaman
            </a>
            <a href="{{ route('siswa.perpustakaan.rules') }}"
                class="px-4 py-2 text-sm font-medium rounded-lg transition-colors text-slate-500 hover:text-slate-700">
                Aturan Perpustakaan
            </a>
        </div>

        {{-- Summary Metric Cards --}}
        @php
            $total = $transaksis->count();
            $dipinjam = $transaksis->where('status_pengembalian', '!=', 1)->count();
            $dikembalikan = $transaksis->where('status_pengembalian', 1)->count();
        @endphp
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white border border-slate-200 rounded-xl p-4 flex items-center gap-3.5 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Total Peminjaman</p>
                    <p class="text-lg font-bold text-slate-900">{{ $total }} Buku</p>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-xl p-4 flex items-center gap-3.5 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Sedang Dipinjam</p>
                    <p class="text-lg font-bold text-amber-700">{{ $dipinjam }} Buku</p>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-xl p-4 flex items-center gap-3.5 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Sudah Dikembalikan</p>
                    <p class="text-lg font-bold text-emerald-700">{{ $dikembalikan }} Buku</p>
                </div>
            </div>
        </div>

        {{-- Search Bar --}}
        <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
            <form action="{{ route('siswa.perpustakaan.riwayat') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" placeholder="Cari riwayat berdasarkan judul buku..."
                        class="w-full pl-10 pr-4 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400 placeholder-slate-400"
                        value="{{ request('search') }}" />
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                        class="px-4 py-2 bg-brand-800 text-white text-sm font-medium rounded-lg hover:bg-brand-900 transition-colors shadow-sm flex items-center justify-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <span>Cari</span>
                    </button>
                    @if (request('search'))
                        <a href="{{ route('siswa.perpustakaan.riwayat') }}"
                            class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-medium rounded-lg transition-colors flex items-center justify-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Transactions List --}}
        @if ($transaksis->isEmpty())
            <div class="bg-white border border-slate-200 rounded-xl p-12 text-center">
                <div class="w-14 h-14 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-slate-800">Tidak Ada Riwayat Peminjaman</h3>
                <p class="text-sm text-slate-500 mt-1">Kamu belum pernah meminjam buku atau tidak ada hasil yang cocok dengan kata kunci pencarian.</p>
                @if (request('search'))
                    <a href="{{ route('siswa.perpustakaan.riwayat') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition">
                        Reset Pencarian
                    </a>
                @endif
            </div>
        @else
            <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <tr>
                                <th scope="col" class="px-5 py-3.5">Judul Buku</th>
                                <th scope="col" class="px-5 py-3.5">Tanggal Pinjam</th>
                                <th scope="col" class="px-5 py-3.5">Batas Pengembalian</th>
                                <th scope="col" class="px-5 py-3.5">Status</th>
                                <th scope="col" class="px-5 py-3.5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($transaksis as $transaksi)
                                @include('siswa.perpustakaan.modal.riwayatSiswa_Modal')
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="px-5 py-4">
                                        <div class="font-semibold text-slate-900 leading-snug">
                                            {{ $transaksi->judul_buku ?? $transaksi->buku?->judul_buku ?? '-' }}
                                        </div>
                                        @if ($transaksi->buku?->author_buku)
                                            <div class="text-xs text-slate-400 mt-0.5">
                                                {{ $transaksi->buku->author_buku }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap text-slate-600">
                                        {{ $transaksi->tgl_peminjaman ? \Carbon\Carbon::parse($transaksi->tgl_peminjaman)->format('d M Y') : '-' }}
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap text-slate-600">
                                        {{ $transaksi->tgl_pengembalian ? \Carbon\Carbon::parse($transaksi->tgl_pengembalian)->format('d M Y') : '-' }}
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        @if ($transaksi->status_pengembalian == 1)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Sudah Kembali
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                Sedang Dipinjam
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap text-center">
                                        <button type="button"
                                            data-modal-target="detail-modal-{{ $transaksi->id_transaksi_peminjaman }}"
                                            data-modal-toggle="detail-modal-{{ $transaksi->id_transaksi_peminjaman }}"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-brand-700 bg-brand-50 hover:bg-brand-100 rounded-lg transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            <span>Detail</span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </div>
</x-siswa-layout>
