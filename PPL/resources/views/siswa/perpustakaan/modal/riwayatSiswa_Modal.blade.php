<!-- Modal Detail Riwayat Peminjaman Siswa -->
<div id="detail-modal-{{ $transaksi->id_transaksi_peminjaman }}" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
            <!-- Modal header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-slate-50">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-700 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">
                        Detail Peminjaman Buku
                    </h3>
                </div>
                <button type="button"
                    class="text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-700 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center transition"
                    data-modal-hide="detail-modal-{{ $transaksi->id_transaksi_peminjaman }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Modal body -->
            <div class="p-6">
                <div class="divide-y divide-slate-100 text-sm">
                    <div class="py-2.5 flex justify-between gap-4">
                        <span class="text-slate-500 font-medium shrink-0">Judul Buku</span>
                        <span class="font-semibold text-slate-900 text-right">{{ $transaksi->judul_buku ?? $transaksi->buku?->judul_buku ?? '-' }}</span>
                    </div>
                    <div class="py-2.5 flex justify-between gap-4">
                        <span class="text-slate-500 font-medium shrink-0">Tanggal Peminjaman</span>
                        <span class="text-slate-700 text-right">{{ $transaksi->tgl_peminjaman ? \Carbon\Carbon::parse($transaksi->tgl_peminjaman)->translatedFormat('d F Y') : '-' }}</span>
                    </div>
                    <div class="py-2.5 flex justify-between gap-4">
                        <span class="text-slate-500 font-medium shrink-0">Batas Pengembalian</span>
                        <span class="text-slate-700 text-right">{{ $transaksi->tgl_pengembalian ? \Carbon\Carbon::parse($transaksi->tgl_pengembalian)->translatedFormat('d F Y') : '-' }}</span>
                    </div>
                    <div class="py-2.5 flex justify-between items-center gap-4">
                        <span class="text-slate-500 font-medium shrink-0">Status Pengembalian</span>
                        <div>
                            @if ($transaksi->status_pengembalian == 1)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Sudah Dikembalikan
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Sedang Dipinjam
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="py-2.5 flex justify-between items-center gap-4">
                        <span class="text-slate-500 font-medium shrink-0">Denda</span>
                        <span class="font-semibold {{ $transaksi->denda > 0 ? 'text-rose-600' : 'text-slate-700' }} text-right">
                            {{ $transaksi->denda ? 'Rp ' . number_format($transaksi->denda, 0, ',', '.') : 'Rp 0' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-100 flex justify-end">
                <button type="button"
                    class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-semibold rounded-lg transition"
                    data-modal-hide="detail-modal-{{ $transaksi->id_transaksi_peminjaman }}">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
