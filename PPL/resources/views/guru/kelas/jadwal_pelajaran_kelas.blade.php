<x-app-guru-layout>
    <div class="p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Jadwal Pelajaran Kelas</h1>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($kelasMataPelajaran as $kelasMP)
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $kelasMP->kelas->nama_kelas }}</h2>
                    <p class="text-sm text-gray-600 mb-1">Mata Pelajaran: <span class="font-medium">{{ $kelasMP->mataPelajaran->nama_matpel }}</span></p>
                    <p class="text-sm text-gray-600 mb-1">Guru: <span class="font-medium">{{ $kelasMP->guru->nama_guru }}</span></p>
                    <p class="text-sm text-gray-600 mb-1">Hari: <span class="font-medium">{{ $kelasMP->hari->nama_hari }}</span></p>
                    <p class="text-sm text-gray-600">Waktu: <span class="font-medium">{{ $kelasMP->waktu_mulai }} - {{ $kelasMP->waktu_selesai }}</span></p>
                </div>
            @endforeach
        </div>
    </div>
</x-app-guru-layout>
