<!-- Main modal -->
<div id="update-modal-{{ $transaksi->id_transaksi_peminjaman }}" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-[50vw] max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3>
                    Detail Transaksi
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="update-modal-{{ $transaksi->id_transaksi_peminjaman }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <ul
                    class="max-w-[48vw] text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                    <li><strong>Judul Buku:</strong> {{ $transaksi->judul_buku }}</li>
                    <li><strong>Tanggal Peminjaman:</strong> {{ \Carbon\Carbon::parse($transaksi->tgl_peminjaman)->format('d M Y') }}</li>
                    <li><strong>Tanggal Pengembalian:</strong> {{ \Carbon\Carbon::parse($transaksi->tgl_pengembalian)->format('d M Y') }}</li>
                    <li><strong>Status Pengembalian:</strong>
                    @if($transaksi->status_pengembalian != 1)
                        <span class="bg-red-500 text-white px-2 py-1 rounded-full">Belum Dikembalikan</span>
                    @else
                        <span class="bg-blue-500 text-white px-2 py-1 rounded-full">Sudah Dikembalikan</span>
                    @endif
                    </li>
                    <li><strong>Denda: {{ $transaksi->denda }}</strong></li>
                </ul>
            </div>
        </div>
    </div>
</div>
