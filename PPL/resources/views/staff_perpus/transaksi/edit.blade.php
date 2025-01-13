<x-staffperpustakaan-layout>
    <div class="container mx-auto max-w-lg p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Edit Tenggat Pengembalian</h1>
        <a href="{{ route('staff_perpus.transaksi.daftartransaksi') }}"  class="text-blue-500 hover:text-blue-700 flex items-center mt-12">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali
        </a>
        <form action="{{ route('staff_perpus.transaksi.update', $transaksi->id_transaksi_peminjaman) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- NISN/NIP Peminjam -->
            <div>
                <label for="kode_peminjam" class="block text-gray-700 font-semibold mb-1">NISN/NIP Peminjam</label>
                <input type="text" id="kode_peminjam" class="w-full border rounded-lg px-3 py-2 bg-gray-100 focus:outline-none" value="{{ $transaksi->kode_peminjam }}" readonly>
            </div>

            <!-- Nama Buku -->
            <div>
                <label for="judul_buku" class="block text-gray-700 font-semibold mb-1">Nama Buku</label>
                <input type="text" id="judul_buku" class="w-full border rounded-lg px-3 py-2 bg-gray-100 focus:outline-none" value="{{ $transaksi->buku->judul_buku ?? 'Tidak tersedia' }}" readonly>
            </div>

            <!-- Tanggal Awal Peminjaman -->
            <div>
                <label for="tgl_awal_peminjaman" class="block text-gray-700 font-semibold mb-1">Tanggal Awal Peminjaman</label>
                <input type="date" id="tgl_awal_peminjaman" class="w-full border rounded-lg px-3 py-2 bg-gray-100 focus:outline-none" value="{{ $transaksi->tgl_awal_peminjaman->format('Y-m-d') }}" readonly>
            </div>

            <!-- Tenggat Pengembalian (Editable) -->
            <div>
                <label for="tgl_pengembalian" class="block text-gray-700 font-semibold mb-1">Tenggat Pengembalian</label>
                <input type="date" name="tgl_pengembalian" id="tgl_pengembalian" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" value="{{ $transaksi->tgl_pengembalian->format('Y-m-d') }}" required>
            </div>

            <!-- Submit Button -->
            <div class="text-left">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-600 transition duration-300">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</x-staffperpustakaan-layout>