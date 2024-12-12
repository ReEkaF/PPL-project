<x-app-guru-layout>
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-xl">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6">Profil Siswa : {{ $siswa->nama_siswa }}</h1>

        <div class="space-y-6">
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                <h2 class="text-lg font-semibold text-gray-700">NISN:</h2>
                <p class="text-xl text-gray-900">{{ $siswa->nisn }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                <h2 class="text-lg font-semibold text-gray-700">Nama Siswa:</h2>
                <p class="text-xl text-gray-900">{{ $siswa->nama_siswa }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                <h2 class="text-lg font-semibold text-gray-700">Tanggal Lahir:</h2>
                <p class="text-xl text-gray-900">{{ $siswa->tgl_lahir_siswa }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                <h2 class="text-lg font-semibold text-gray-700">Jenis Kelamin:</h2>
                <p class="text-xl text-gray-900">{{ $siswa->jenis_kelamin_siswa }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                <h2 class="text-lg font-semibold text-gray-700">Alamat:</h2>
                <p class="text-xl text-gray-900">{{ $siswa->alamat_siswa }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                <h2 class="text-lg font-semibold text-gray-700">Nomor WA:</h2>
                <p class="text-xl text-gray-900">{{ $siswa->nomor_wa_siswa }}</p>
            </div>
        </div>

        {{-- Tombol Kembali --}}
        <div class="mt-8 text-center">
            <a href="{{ route('guru.daftarSiswaWali') }}" 
               class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                Kembali ke Daftar Siswa
            </a>
        </div>
    </div>
</x-app-guru-layout>
