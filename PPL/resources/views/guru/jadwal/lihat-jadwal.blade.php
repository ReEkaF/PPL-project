<x-app-guru-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold text-center mb-6">Jadwal Guru</h1>
        <p class="text-center text-lg mb-4">Selamat datang, <span class="font-semibold">{{ $guru->nama_guru }}</span></p>
    
        @if($query->isEmpty())
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 text-center">
                <p>Tidak ada jadwal tersedia.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="table-auto border-collapse border border-gray-200 w-full text-left text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2">Hari</th>
                            <th class="border border-gray-300 px-4 py-2">Waktu Mulai</th>
                            <th class="border border-gray-300 px-4 py-2">Waktu Selesai</th>
                            <th class="border border-gray-300 px-4 py-2">Mata Pelajaran</th>
                            <th class="border border-gray-300 px-4 py-2">Kelas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($query as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-300 px-4 py-2">{{ $item->nama_hari }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ date('H:i', strtotime($item->waktu_mulai)) }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ date('H:i', strtotime($item->waktu_selesai)) }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $item->nama_matpel }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $item->nama_kelas }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Tombol Cetak Jadwal -->
        <div classs="flex justify-end mt-4">
            <a href="{{ route('guru.jadwal.print') }}" target="_blank"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 shadow">
                Cetak Jadwal
            </a>
        </div>
    </div>
</x-app-guru-layout>
