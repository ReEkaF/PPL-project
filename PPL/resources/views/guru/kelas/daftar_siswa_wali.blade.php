<x-app-guru-layout>
    <div class="p-6 bg-white shadow-md rounded-lg">
        {{-- Header --}}
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Daftar Siswa Wali</h1>
        {{-- Nama Kelas --}}
        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-700">Kelas:</h3>
            <p class="text-xl font-semibold text-green-600">
                {{ $kelasList->isNotEmpty() ? $kelasList->first()->nama_kelas : 'Tidak ada kelas terdaftar' }}
            </p>
        </div>

        {{-- Informasi Wali Kelas --}}
        <div class="mb-6">
            <h2 class="text-lg font-medium text-gray-700">Wali Kelas:</h2>
            <p class="text-xl font-semibold text-blue-600">{{ $guru->nama_guru }}</p>
        </div>

        

        {{-- Daftar Siswa --}}
        <div>
            <h3 class="text-lg font-medium text-gray-700 mb-3">Daftar Siswa:</h3>

            {{-- Cek jika daftar siswa ada --}}
            @if ($siswaList->isNotEmpty())
                <ul class="bg-gray-50 border border-gray-200 rounded-lg divide-y divide-gray-200">
                    @foreach ($siswaList as $kelasSiswa)
                        <li class="px-4 py-2 text-gray-700 hover:bg-gray-100">
                            <a href="{{ route('kelas.siswa.profil', ['id_kelas' => $kelasList->first()->id_kelas, 'id_siswa' => $kelasSiswa->siswa->id_siswa]) }}" 
                            class="text-black-600 hover:underline">
                                {{ $kelasSiswa->siswa->nama_siswa }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">Belum ada siswa di kelas ini.</p>
            @endif
        </div>
    </div>
</x-app-guru-layout>
