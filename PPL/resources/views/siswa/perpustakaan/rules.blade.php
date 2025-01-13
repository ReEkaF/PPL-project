<x-siswa-layout>
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-center mb-6">Aturan Peminjaman Buku</h1>

    <!-- Aturan untuk Siswa -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Aturan Peminjaman Buku untuk Siswa</h2>
        <ul class="list-disc pl-6 space-y-2 text-gray-700">
            <li><strong>Validasi Identitas:</strong> NISN siswa harus valid dan terdaftar di sistem.</li>
            <li><strong>Pengecekan Denda:</strong> Siswa tidak boleh memiliki lebih dari 3 denda yang belum dibayar.</li>
            <li><strong>Batas Peminjaman Buku Non-Paket:</strong> Siswa hanya dapat meminjam maksimal 3 buku non-paket yang belum dikembalikan.</li>
            <li><strong>Durasi Peminjaman:</strong>
                <ul class="list-inside list-disc text-gray-600">
                    <li>Buku Paket: 1 tahun</li>
                    <li>Buku Non-Paket: 2 minggu</li>
                </ul>
            </li>
            <li><strong>Pengembalian Buku:</strong>
                <ul class="list-inside list-disc text-gray-600">
                    <li>Buku Paket: 1 tahun</li>
                    <li>Buku Non-Paket: 2 minggu</li>
                </ul>
            </li>
        </ul>
    </div>

    <!-- Aturan untuk Guru -->
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Aturan Peminjaman Buku untuk Guru</h2>
        <ul class="list-disc pl-6 space-y-2 text-gray-700">
            <li><strong>Validasi Identitas:</strong> NIP guru harus valid dan terdaftar di sistem.</li>
            <li><strong>Pengecekan Denda:</strong> Guru tidak boleh memiliki lebih dari 3 denda yang belum dibayar.</li>
            <li><strong>Batas Peminjaman Buku Non-Paket:</strong> Guru hanya dapat meminjam maksimal 3 buku non-paket yang belum dikembalikan.</li>
            <li><strong>Durasi Peminjaman:</strong>
                <ul class="list-inside list-disc text-gray-600">
                    <li>Semua Buku (Paket dan Non-Paket): 1 tahun</li>
                </ul>
            </li>
            <li><strong>Pengembalian Buku:</strong>
                <ul class="list-inside list-disc text-gray-600">
                    <li>Semua Buku: 1 tahun</li>
                </ul>
            </li>
        </ul>
    </div>
</div>
</x-siswa-layout>
