<x-staffperpustakaan-layout>
    <div class="p-6">
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Riwayat Transaksi</h1>
            <p class="text-sm text-slate-500 mt-1">Catatan riwayat pengembalian buku dan penyelesaian denda perpustakaan</p>
        </div>

        <!-- Card Container -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <!-- Search bar -->
            <div class="p-4 border-b border-slate-200 bg-slate-50/50">
                <form method="GET" action="{{ route('staff_perpus.riwayat_transaksi.riwayattransaksi') }}" class="max-w-md">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="query"
                            value="{{ request()->input('query') }}" placeholder="Cari NIP / NISN peminjam..."
                            class="w-full pl-9 pr-4 py-2 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors">
                    </div>
                </form>
            </div>

            <!-- Transactions Table -->
            <div class="overflow-x-auto">
                <table id="admin-riwayattransaksi-table" class="w-full text-left text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3.5">NIP / NISN</th>
                            <th class="px-6 py-3.5">Tanggal Pengembalian</th>
                            <th class="px-6 py-3.5">Status Pengembalian</th>
                            <th class="px-6 py-3.5">Denda</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($transactions as $transaction)
                            @include('staff_perpus/modal/pengembalianBuku_Modal')
                            <tr class="hover:bg-slate-50/75 transition-colors">
                                <td class="px-6 py-4 font-mono font-medium text-slate-900">{{ $transaction->kode_peminjam }}</td>
                                <td class="px-6 py-4 text-slate-600">
                                    {{ \Carbon\Carbon::parse($transaction->tgl_pengembalian)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($transaction->status_pengembalian == 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">
                                            Telat Mengembalikan
                                        </span>
                                    @elseif($transaction->status_pengembalian == 1)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            Tepat Waktu
                                        </span>
                                    @elseif($transaction->status_pengembalian == 2)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-700 border border-rose-200">
                                            Buku Hilang
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-mono text-slate-900">
                                    {{ $transaction->denda > 0 ? 'Rp ' . number_format($transaction->denda, 0, ',', '.') : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-sm text-slate-500">
                                    Tidak ada riwayat transaksi yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($transactions->hasPages())
                <div class="px-6 py-4 border-t border-slate-200 bg-white">
                    {{ $transactions->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>
</x-staffperpustakaan-layout>
