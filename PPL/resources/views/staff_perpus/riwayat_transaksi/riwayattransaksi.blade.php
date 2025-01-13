<x-staffperpustakaan-layout>
    <div class="container mx-auto p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Riwayat Transaksi</h1>
        <div class="flex items-center justify-between mb-6">
            <div class="container mx-auto p-6">
                <!-- Search bar -->
                <form method="GET" action="{{ route('staff_perpus.riwayat_transaksi.riwayattransaksi') }}" class="mb-6">
                    <input class="basis-2/4 rounded-lg" type="text" name="query"
                        value="{{ request()->input('query') }}" placeholder="Cari NIP/NISN"
                        class="border border-gray-300 rounded-lg p-2 w-full">
                    
                </form>

                <!-- Transactions Table -->
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <table id="admin-riwayattransaksi-table" class="w-full text-left table-auto">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-sm">
                                <th class="py-3 px-6">NIP / NISN</th>
                                <th class="py-3 px-6">Tanggal Pengembalian</th>
                                <th class="py-3 px-6">Status</th>
                                <th class="py-3 px-6">Denda</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transactions as $transaction)
                                @include('staff_perpus/modal/pengembalianBuku_Modal')
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-6">{{ $transaction->kode_peminjam }}</td>
                                    <td class="py-3 px-6">
                                        {{ \Carbon\Carbon::parse($transaction->tgl_pengembalian)->format('d F Y') }}
                                    </td>
                                    <td class="py-3 px-6">
                                        {{-- <span
                                        class="inline-block px-3 py-1 bg-blue-500 text-white rounded-full text-xs"> --}}
                                        @if($transaction->status_pengembalian == 0)
                                        <span class="bg-yellow-500 text-white px-4 py-2 rounded-full">Telat</span>
                                        {{-- Telat --}}
                                        @elseif($transaction->status_pengembalian == 1)
                                        <span class="bg-blue-500 text-white px-4 py-2 rounded-full">Aman</span>
                                        {{-- Aman --}}
                                        @elseif($transaction->status_pengembalian == 2)
                                        <span class="bg-red-500 text-white px-4 py-2 rounded-full">Hilang</span>
                                        {{-- Hilang --}}
                                        @endif
                                    {{-- </span> --}}
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $transaction->denda }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3 text-red-500">
                                        Tidak ada transaksi yang ditemukan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <br>
                <!-- Menampilkan tombol pagination -->
                <div class="pagination-container">
                    {{ $transactions->links() }}
                </div>
            </div>

</x-staffperpustakaan-layout>
