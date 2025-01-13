<x-staffperpustakaan-layout>
    @php
        $ColorPack = [
            'bg-blue-300 text-blue-950',
            'bg-green-300 text-green-950',
            'bg-red-300 text-red-950',
            'bg-indigo-300 text-indigo-950',
            'bg-amber-300 text-amber-950',
        ];
    @endphp
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <div class="container mx-auto p-6">
        <!-- Search bar -->
        <form method="GET" action="{{ route('staff_perpus.transaksi.daftartransaksi') }}" class="mb-6">
            <input class="basis-2/4 rounded-lg" type="text" name="query" value="{{ request()->input('query') }}"
                placeholder="Cari nama peminjam..." 
                class="border border-gray-300 rounded-lg p-2 w-full">
            <!-- Tombol Tambah Transaksi -->
            <div class=" basis- 1/4 text-right">
                <a href="{{ route('staff_perpus.transaksi.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-600 transition duration-300">Tambah Transaksi</a>
            </div>
        </form>

        <!-- Transactions Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="w-full text-left table-auto">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm">
                        <th class="py-3 px-6">Nama Peminjam</th>
                        <th class="py-3 px-6">Tanggal Pengembalian</th>
                        <th class="py-3 px-6">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-6">{{ $transaction->kode_peminjam }}</td>
                            <td class="py-3 px-6">{{ \Carbon\Carbon::parse($transaction->tgl_pengembalian)->format('d F Y') }}</td>
                            <td class="py-3 px-6">
                                @if($transaction->isOverdue())
                                    <span class="inline-block px-3 py-1 bg-red-500 text-white rounded-full text-xs">Telat Mengembalikan</span>
                                @else
                                    <span class="inline-block px-3 py-1 bg-blue-500 text-white rounded-full text-xs">Belum Dikembalikan</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $transactions->appends(['query' => $query])->links() }}
        </div>
    </div>
</x-staffperpustakaan-layout>
