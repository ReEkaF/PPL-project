<x-siswa-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold text-center mb-6">Jadwal Siswa</h1>
        <p class="text-center text-lg mb-4">
            Selamat datang, <span class="font-semibold">{{ $siswa->nama_siswa }}</span>
        </p>

        @if (isset($message) && $message)
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 text-center">
                <p>{{ $message }}</p>
            </div>
        @elseif ($jadwal->isEmpty())
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 text-center">
                <p>Tidak ada jadwal tersedia untuk kelas Anda.</p>
            </div>
        @else
            <!-- Tombol Cetak Jadwal -->
            <div class="flex justify-end mb-4">
                <a href="{{ route('siswa.jadwal.print') }}" target="_blank"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 shadow">
                    Cetak Jadwal
                </a>
            </div>

            <!-- Tabel Jadwal -->
            <div class="overflow-x-auto shadow-md rounded-lg">
                <table class="table-auto border-collapse border border-gray-200 w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2 text-left">Hari</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Waktu Mulai</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Waktu Selesai</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Mata Pelajaran</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Guru</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jadwal as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-300 px-4 py-2">{{ $item->nama_hari }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ date('H:i', strtotime($item->waktu_mulai)) }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ date('H:i', strtotime($item->waktu_selesai)) }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $item->nama_matpel }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $item->nama_guru }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-siswa-layout>
