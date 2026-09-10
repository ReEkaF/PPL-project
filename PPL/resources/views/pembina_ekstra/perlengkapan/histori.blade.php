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
                            <a href="{{ route('pembina.index') }}" class="text-slate-500 hover:text-brand-800 transition-colors">
                                Ekstrakurikuler
                            </a>
                        </li>
                        <li class="flex items-center text-slate-400">
                            <i class="fa-solid fa-chevron-right text-[10px] mx-1"></i>
                            <a href="{{ route('pembina.perlengkapan') }}" class="text-slate-500 hover:text-brand-800 transition-colors">
                                Perlengkapan
                            </a>
                        </li>
                        <li class="flex items-center text-slate-800 font-semibold">
                            <i class="fa-solid fa-chevron-right text-[10px] mx-1"></i>
                            <span>Histori Peminjaman</span>
                        </li>
                    </ol>
                </nav>
                <div class="flex items-center gap-3 pt-1">
                    <h1 class="text-xl font-bold text-slate-900 tracking-tight">Histori Peminjaman: {{ $barang }}</h1>
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-blue-50 text-blue-800 border border-blue-200">
                        <i class="fa-solid fa-clock-rotate-left text-[10px] text-blue-600"></i>
                        Log Mutasi
                    </span>
                </div>
                <p class="text-xs text-slate-500">
                    Log mutasi keluar dan masuk barang inventaris ekstrakurikuler.
                </p>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('pembina.perlengkapan') }}"
                    class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors shadow-sm">
                    <i class="fa-solid fa-arrow-left text-[11px]"></i>
                    <span>Kembali ke Daftar Barang</span>
                </a>
            </div>
        </div>

        @if (session()->has('success'))
            <x-alert-notification :color="'green'">
                {{ session('success') }}
            </x-alert-notification>
        @endif

        {{-- Overview Card --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                <div>
                    <span class="text-[11px] text-slate-400 uppercase tracking-wider font-medium">Nama Barang</span>
                    <p class="font-bold text-slate-800 text-sm mt-0.5 flex items-center gap-1.5">
                        <i class="fa-solid fa-box text-brand-700 text-xs"></i>
                        {{ $barang }}
                    </p>
                </div>
                <div>
                    <span class="text-[11px] text-slate-400 uppercase tracking-wider font-medium">ID Inventaris</span>
                    <p class="font-mono text-slate-600 text-xs mt-1">
                        {{ $id_inventaris }}
                    </p>
                </div>
                <div>
                    <span class="text-[11px] text-slate-400 uppercase tracking-wider font-medium">Total Catatan Log</span>
                    <p class="font-bold text-blue-700 text-sm mt-0.5 flex items-center gap-1.5">
                        <i class="fa-solid fa-list-check text-xs"></i>
                        {{ is_object($items) && method_exists($items, 'total') ? $items->total() : count($items) }} Catatan
                    </p>
                </div>
            </div>
        </div>

        {{-- Tabel Histori Peminjaman --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center text-xs font-bold">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </span>
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Riwayat Mutasi & Peminjaman</h2>
                        <p class="text-xs text-slate-500">Log pencatatan barang dipinjam dan dikembalikan</p>
                    </div>
                </div>
            </div>

            <div class="p-5">
                <table class="w-full text-xs text-left" id="search-table">
                    <thead class="text-[11px] text-slate-500 uppercase bg-slate-50/80 border-b border-slate-200">
                        <tr>
                            <th scope="col" class="px-4 py-3 font-semibold text-center w-12">No</th>
                            <th scope="col" class="px-4 py-3 font-semibold">Keterangan / Keperluan</th>
                            <th scope="col" class="px-4 py-3 font-semibold text-center">Jumlah</th>
                            <th scope="col" class="px-4 py-3 font-semibold text-center">Waktu Keluar</th>
                            <th scope="col" class="px-4 py-3 font-semibold text-center">Waktu Masuk</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse ($items as $index => $item)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-4 py-3.5 text-center font-bold text-slate-400">
                                    {{ is_object($items) && method_exists($items, 'firstItem') ? ($items->firstItem() + $index) : ($index + 1) }}
                                </td>
                                <td class="px-4 py-3.5 font-medium text-slate-900">
                                    {{ $item->keterangan ?: 'Peminjaman inventaris' }}
                                </td>
                                <td class="px-4 py-3.5 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ $item->jumlah }} item
                                    </span>
                                </td>
                                <td class="px-4 py-3.5 text-center font-mono text-slate-600">
                                    @if ($item->histori_keluar)
                                        <span class="inline-flex items-center gap-1 text-rose-600 font-semibold">
                                            <i class="fa-solid fa-arrow-up text-[9px]"></i>
                                            {{ $item->histori_keluar }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-3.5 text-center font-mono text-slate-600">
                                    @if ($item->histori_masuk)
                                        <span class="inline-flex items-center gap-1 text-emerald-600 font-semibold">
                                            <i class="fa-solid fa-arrow-down text-[9px]"></i>
                                            {{ $item->histori_masuk }}
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                            Belum Kembali
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-12 text-center text-slate-400 text-xs">
                                    <i class="fa-solid fa-clock text-3xl mb-2 text-slate-300 block"></i>
                                    <p class="font-semibold text-slate-700 text-sm">Tidak ada catatan histori</p>
                                    <p class="text-slate-400 mt-0.5">Belum ada catatan transaksi peminjaman untuk barang ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if (is_object($items) && method_exists($items, 'hasPages') && $items->hasPages())
                    <div class="pt-4 border-t border-slate-100 mt-4">
                        {{ $items->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById("search-table") && typeof simpleDatatables !== 'undefined' && typeof simpleDatatables.DataTable !== 'undefined') {
                new simpleDatatables.DataTable("#search-table", {
                    searchable: true,
                    paging: false,
                    sortable: true
                });
            }
        });
    </script>
</x-app-guru-layout>