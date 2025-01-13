<x-staffakademik-layout>
    <!-- KONTEN -->
    <div class="col-span-full xl:col-auto">
        
        <div class="p-4 mb-4 space-y-6 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <!-- Filter Guru -->
            <div>
                <form action="{{ route('lihat.jadwal.guru') }}" method="GET" class="flex items-center">
                    <label for="guru_id" class="mr-2">Pilih Guru:</label>
                    <select name="guru_id" id="guru_id" class="border-gray-300 rounded-md shadow-sm" onchange="this.form.submit()">
                        <option value="">Semua Guru</option>
                        @foreach($guru as $gr)
                            <option value="{{ $gr->id_guru }}" {{ isset($guru_id) && $guru_id == $gr->id_guru ? 'selected' : '' }}>
                                {{ $gr->nama_guru }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <!-- Pesan Sukses -->
            @if(session('success'))
                <div class="bg-green-500 text-white p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Tabel Jadwal -->
            @if(isset($data) && !$data->isEmpty())
                <div class="px-4 py-2 mt-4 text-gray-700 border-b border-gray-200 dark:border-gray-600">
                    <h3 class="font-semibold text-lg">Jadwal Guru</h3>
                </div>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Hari</th>
                                <th scope="col" class="px-6 py-3">Jam</th>
                                <th scope="col" class="px-6 py-3">Mata Pelajaran</th>
                                <th scope="col" class="px-6 py-3">Kelas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4">{{ $item->nama_hari }}</td>
                                    <td class="px-6 py-4">{{ $item->waktu_mulai }} - {{ $item->waktu_selesai }}</td>
                                    <td class="px-6 py-4">{{ $item->nama_matpel }}</td>
                                    <td class="px-6 py-4">{{ $item->nama_kelas }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-gray-700 mt-4">Tidak ada jadwal untuk guru yang dipilih.</div>
            @endif
        </div>
    </div>
</x-staffakademik-layout>
