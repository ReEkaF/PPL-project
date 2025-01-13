<x-siswa-layout>
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-lg dark:bg-gray-800 max-w-4xl">
        <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-6">Detail Prestasi</h1>

        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Nama Prestasi</h2>
            <p class="text-gray-600 dark:text-gray-400">{{ $prestasi->nama_prestasi }}</p>

            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mt-4">Deskripsi</h2>
            <p class="text-gray-600 dark:text-gray-400">{{ $prestasi->deskripsi_prestasi }}</p>

            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mt-4">Status</h2>
            <span class="inline-block px-3 py-1 rounded-full text-sm font-medium {{ $prestasi->status_prestasi == 1 ? 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100' : 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100' }}">
                {{ $prestasi->status_prestasi == 1 ? 'Terverifikasi' : 'Belum Terverifikasi' }}
            </span>

            <div class="mt-6 text-center">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Bukti Prestasi</h2>
                @if ($prestasi->bukti_prestasi)
                <img src="{{ asset('storage/' . $prestasi->bukti_prestasi) }}" alt="Bukti Prestasi" class="mt-4 w-full max-w-md rounded-lg shadow-lg mx-auto">
                @else
                <p class="text-gray-500 dark:text-gray-400">Tidak ada bukti prestasi.</p>
                @endif
            </div>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('siswa.prestasi') }}" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                Kembali
            </a>
        </div>
    </div>
</x-siswa-layout>