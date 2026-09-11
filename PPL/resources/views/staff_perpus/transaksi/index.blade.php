<x-staffperpustakaan-layout>
    <div class="p-6">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">Transaksi Peminjaman</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola pencatatan dan status peminjaman buku perpustakaan</p>
            </div>
            <div>
                <a href="{{ route('staff_perpus.transaksi.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-[#06466C] hover:bg-[#053a5a] rounded-lg shadow-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Transaksi
                </a>
            </div>
        </div>

        <!-- Card Container -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <!-- Search Bar -->
            <div class="p-4 border-b border-slate-200 bg-slate-50/50">
                <form method="GET" action="{{ route('staff_perpus.transaksi.daftartransaksi') }}" class="max-w-md">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="query" value="{{ request()->input('query') }}"
                            placeholder="Cari NIP / NISN peminjam..."
                            class="w-full pl-9 pr-4 py-2 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors">
                    </div>
                </form>
            </div>

            <!-- Transactions Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3.5">Kode / Nama Peminjam</th>
                            <th class="px-6 py-3.5">Tanggal Pengembalian</th>
                            <th class="px-6 py-3.5">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($transactions as $transaction)
                            <tr class="hover:bg-slate-50/75 transition-colors">
                                <td class="px-6 py-4 font-mono font-medium text-slate-900">{{ $transaction->kode_peminjam }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ \Carbon\Carbon::parse($transaction->tgl_pengembalian)->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    @if($transaction->isOverdue())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-700 border border-rose-200">
                                            Telat Mengembalikan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">
                                            Sedang Dipinjam
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-sm text-slate-500">
                                    Tidak ada transaksi aktif yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($transactions->hasPages())
                <div class="px-6 py-4 border-t border-slate-200 bg-white">
                    {{ $transactions->appends(['query' => $query])->links() }}
                </div>
            @endif
        </div>
    </div>
</x-staffperpustakaan-layout>
