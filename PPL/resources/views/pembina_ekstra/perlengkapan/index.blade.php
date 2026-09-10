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
                        <li class="flex items-center text-slate-800 font-semibold">
                            <i class="fa-solid fa-chevron-right text-[10px] mx-1"></i>
                            <span>Perlengkapan & Inventaris</span>
                        </li>
                    </ol>
                </nav>
                <div class="flex items-center gap-3 pt-1">
                    <h1 class="text-xl font-bold text-slate-900 tracking-tight">Perlengkapan Ekstrakurikuler {{ $nama_ekstrakurikuler }}</h1>
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                        <i class="fa-solid fa-boxes-stacked text-[10px] text-emerald-600"></i>
                        Inventaris
                    </span>
                </div>
                <p class="text-xs text-slate-500">
                    Daftar inventaris sarana kegiatan ekstrakurikuler serta riwayat peminjaman barang oleh siswa.
                </p>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('pembina.index') }}"
                    class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors shadow-sm">
                    <i class="fa-solid fa-arrow-left text-[11px]"></i>
                    <span>Kembali ke Portal</span>
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
                    <span class="text-[11px] text-slate-400 uppercase tracking-wider font-medium">Pembina Ekstra</span>
                    <p class="font-bold text-slate-800 text-sm mt-0.5 flex items-center gap-1.5">
                        <i class="fa-solid fa-user-tie text-brand-700 text-xs"></i>
                        {{ auth()->guard('web-guru')->user()?->nama_guru ?? 'Guru Pembina' }}
                    </p>
                </div>
                <div>
                    <span class="text-[11px] text-slate-400 uppercase tracking-wider font-medium">Nama Ekstrakurikuler</span>
                    <p class="font-bold text-brand-900 text-sm mt-0.5 flex items-center gap-1.5">
                        <i class="fa-solid fa-award text-amber-600 text-xs"></i>
                        {{ $nama_ekstrakurikuler }}
                    </p>
                </div>
                <div>
                    <span class="text-[11px] text-slate-400 uppercase tracking-wider font-medium">Total Item Inventaris</span>
                    <p class="font-bold text-emerald-700 text-sm mt-0.5 flex items-center gap-1.5">
                        <i class="fa-solid fa-boxes-stacked text-xs"></i>
                        {{ $perlengkapan_ekstras ? (is_object($perlengkapan_ekstras) && method_exists($perlengkapan_ekstras, 'total') ? $perlengkapan_ekstras->total() : count($perlengkapan_ekstras)) : 0 }} Jenis Barang
                    </p>
                </div>
            </div>
        </div>

        {{-- Tabel Perlengkapan --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center text-xs font-bold">
                        <i class="fa-solid fa-boxes-stacked"></i>
                    </span>
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Daftar Inventaris Perlengkapan</h2>
                        <p class="text-xs text-slate-500">Stok barang dan riwayat mutasi sarana kegiatan</p>
                    </div>
                </div>
            </div>

            <div class="p-5">
                <table class="w-full text-xs text-left" id="search-table">
                    <thead class="text-[11px] text-slate-500 uppercase bg-slate-50/80 border-b border-slate-200">
                        <tr>
                            <th scope="col" class="px-4 py-3 font-semibold text-center w-12">No</th>
                            <th scope="col" class="px-4 py-3 font-semibold">Nama Barang</th>
                            <th scope="col" class="px-4 py-3 font-semibold text-center">Stok Tersedia</th>
                            <th scope="col" class="px-4 py-3 font-semibold text-center">Aksi / Histori</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse ($perlengkapan_ekstras as $index => $item)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-4 py-3.5 text-center font-bold text-slate-400">
                                    {{ is_object($perlengkapan_ekstras) && method_exists($perlengkapan_ekstras, 'firstItem') ? ($perlengkapan_ekstras->firstItem() + $index) : ($index + 1) }}
                                </td>
                                <td class="px-4 py-3.5 font-bold text-slate-900">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-xs shrink-0">
                                            <i class="fa-solid fa-box text-slate-500"></i>
                                        </div>
                                        <span>{{ $item->nama_barang }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3.5 text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-bold {{ $item->stok > 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                                        {{ $item->stok }} unit
                                    </span>
                                </td>
                                <td class="px-4 py-3.5 text-center">
                                    <a href="{{ route('pembina.histori', $item->id_inventaris) }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors shadow-sm">
                                        <i class="fa-solid fa-clock-rotate-left text-brand-700 text-[11px]"></i>
                                        <span>Histori Peminjaman</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-12 text-center text-slate-400 text-xs">
                                    <i class="fa-solid fa-box-open text-3xl mb-2 text-slate-300 block"></i>
                                    <p class="font-semibold text-slate-700 text-sm">Tidak ada inventaris</p>
                                    <p class="text-slate-400 mt-0.5">Belum ada data barang perlengkapan untuk ekstrakurikuler ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if (is_object($perlengkapan_ekstras) && method_exists($perlengkapan_ekstras, 'hasPages') && $perlengkapan_ekstras->hasPages())
                    <div class="pt-4 border-t border-slate-100 mt-4">
                        {{ $perlengkapan_ekstras->links() }}
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
