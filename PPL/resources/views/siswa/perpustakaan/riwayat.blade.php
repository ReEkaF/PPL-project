<x-siswa-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Daftar Transaksi Peminjaman Buku</h1>
        </div>
            <form action="{{ route('siswa.perpustakaan.riwayat') }}" method="GET" class="flex space-x-2 mb-5">
                <input type="text" name="search" value="{{ request()->get('search') }}" class="border border-gray-300 px-4 py-2 rounded-lg" placeholder="Cari berdasarkan judul buku...">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Cari</button>
            </form>

        <!-- Table Transaksi -->
        <table class="min-w-full table-auto bg-white border border-gray-200 rounded-lg shadow-sm">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Judul Buku</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Tanggal Pengembalian</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksis as $transaksi)
                    @include('guru/perpustakaan/modal/riwayatGuru_Modal')
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $transaksi->judul_buku }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ \Carbon\Carbon::parse($transaksi->tgl_pengembalian)->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if($transaksi->status_pengembalian != 1)
                                <span class="bg-red-500 text-white px-4 py-2 rounded-full">Belum Dikembalikan</span>
                            @else
                                <span class="bg-blue-500 text-white px-4 py-2 rounded-full">Sudah Dikembalikan</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <button
                                data-modal-target="update-modal-{{ $transaksi->id_transaksi_peminjaman }}"
                                data-modal-toggle="update-modal-{{ $transaksi->id_transaksi_peminjaman }}"
                                type="button" class="flex py-3 px-6">
                                <span class="inline-block bg-blue-500 text-white px-4 py-2 rounded-lg">Detail</span>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-siswa-layout>
