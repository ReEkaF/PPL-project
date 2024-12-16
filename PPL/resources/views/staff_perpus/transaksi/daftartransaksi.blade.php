<x-staffperpustakaan-layout>
    <div class="container mx-auto p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Daftar Transaksi Peminjaman</h1>
        <div class="flex items-center justify-between mb-6">
            <div class="container mx-auto p-6">
                <!-- Search bar -->
                <form method="GET" action="{{ route('staff_perpus.transaksi.daftartransaksi') }}" class="mb-6">
                    <input class="basis-2/4 rounded-lg" type="text" name="query"
                        value="{{ request()->input('query') }}" placeholder="Cari NIP/NISN"
                        class="border border-gray-300 rounded-lg p-2 w-full">
                    <!-- Tombol Tambah Transaksi -->
                    <div class=" basis- 1/4 text-right">
                        <a href="{{ route('staff_perpus.transaksi.create') }}"
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-600 transition duration-300">Tambah
                            Transaksi</a>
                    </div>
                </form>

                <!-- Transactions Table -->
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <table class="w-full text-left table-auto">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-sm">
                                <th class="py-3 px-6">NIP / NISN</th>
                                <th class="py-3 px-6">Tanggal Peminjaman</th>
                                <th class="py-3 px-6">Tanggal Pengembalian</th>
                                <th class="py-3 px-6">Action</th>
                                <th class="py-3 px-6">Status Denda</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transactions as $transaction)
                                @include('staff_perpus/modal/pengembalianBuku_Modal')
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-6">{{ $transaction->kode_peminjam }}</td>
                                    <td class="py-3 px-6">
                                        {{ \Carbon\Carbon::parse($transaction->tgl_peminjaman)->format('d F Y') }}
                                        <!-- {{ $transaction->tgl_pengembalian }} -->
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ \Carbon\Carbon::parse($transaction->tgl_pengembalian)->format('d F Y') }}
                                        <!-- {{ $transaction->tgl_pengembalian }} -->
                                    </td>
                                    <!-- <td class="py-3 px-6">
                                        <span
                                        class="inline-block px-3 py-1 bg-blue-500 text-white rounded-full text-xs">
                                        Belum Dikembalikan
                                        </span>
                                    </td> -->
                                    <td>
                                        <button
                                            data-modal-target="update-modal-{{ $transaction->id_transaksi_peminjaman }}"
                                            data-modal-toggle="update-modal-{{ $transaction->id_transaksi_peminjaman }}"
                                            type="button" class="flex py-3 px-6">
                                            <span
                                                class="inline-block px-3 py-1 bg-blue-500 text-white rounded-full text-xs">Edit</span>
                                        </button>
                                    </td>
                                    <td>
                                        <div class="flex gap-4 items-center">
                                            @if ($transaction->denda < 1)
                                                <button disabled
                                                    class="inline-block px-3 py-1 rounded-full text-xs {{ $transaction->status_denda == 0 ? 'bg-gray-500 text-white' : 'bg-green-500 text-white' }}">
                                                    Masih Dalam Masa Peminjaman
                                                </button>
                                            @else
                                                <button disabled
                                                    class="inline-block px-3 py-1 rounded-full text-xs {{ $transaction->status_denda == 0 ? 'bg-red-500 text-white' : 'bg-green-500 text-white' }}">
                                                    {{ $transaction->status_denda == 0 ? 'Belum Dibayar (Rp. ' . $transaction->denda . ')' : 'Sudah Dibayar' }}
                                                </button>
                                                @if ($transaction->status_denda == 0)
                                                    <form
                                                        action="{{ route('staff_perpus.transaksi.update_status_denda') }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status_denda_button" value="1">
                                                        <input type="hidden" name="status_denda_id_transaksi"
                                                            value="{{ $transaction->id_transaksi_peminjaman }}">
                                                        {{-- <button type="submit"
                                                            class="inline-block px-3 py-1 rounded-full text-xs bg-blue-500 text-white">
                                                            Ubah (Lunas)
                                                        </button> --}}
                                                    </form>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3 text-red-500">
                                        Tidak ada transaksi yang ditemukan well
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $transactions->links('pagination::tailwind') }}
                </div>
            </div>
</x-staffperpustakaan-layout>
