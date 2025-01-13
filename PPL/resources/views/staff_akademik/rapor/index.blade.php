<x-staffakademik-layout>
    <div class="flex justify-between bg-white rounded-lg shadow p-6">
        <h2 class="font-semibold text-2xl pl-4 text-gray-800 leading-tight">Rapor</h2>
        <form action="{{ route('staff_akademik.rapor.update_nilai') }}" method="GET">
            <button type="submit" class="p-2 bg-green-600 hover:bg-green-800 text-white rounded-md flex items-center">
                <svg class="w-6 h-6 pr-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 14 3-3m-3 3 3 3m-3-3h16v-3m2-7-3 3m3-3-3-3m3 3H3v3"/>
                </svg>
                Refresh Nilai
            </button>
        </form>
    </div>


    <div class="flex justify-center p-6 pb-0">
        <!-- Section Kiri dan Kanan: Tabel Siswa dan Detail -->
        <div class="flex w-full h-full bg-gray-50 rounded-lg space-x-4">
            <!-- Kolom Kiri: Tabel Daftar Siswa -->
            <div class="w-1/2 p-10 bg-white rounded-lg shadow-md">
                <h4 class="text-xl font-bold text-gray-800 mb-4">Daftar Siswa</h4>

                <form method="GET" action="{{ route('staff_akademik.rapor.index') }}" class="mb-4">
                    <div class="flex space-x-4">
                        <div class="w-1/3">
                            <input type="text" name="search" value="{{ request('search') }}" class="w-full p-2 border border-gray-300 rounded-md" placeholder="Cari Nama Siswa">
                        </div>
                        <div class="w-1/3">
                            <select name="kelas" class="w-full p-2 border border-gray-300 rounded-md">
                                <option value="">Pilih Kelas</option>
                                @foreach($kelasList as $kelas)
                                    <option value="{{ $kelas->id_kelas }}" {{ request('kelas') == $kelas->id_kelas ? 'selected' : '' }}>
                                        {{ $kelas->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-1/3">
                            <button type="submit" class="w-full p-2 bg-blue-600 hover:bg-blue-800 text-white rounded-md">Filter</button>
                        </div>
                    </div>
                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden">
                        <thead class="bg-gray-100">
                            <tr>
                                <!-- Header Nama Siswa -->
                                <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider w-1/3">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'nama_siswa', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}"
                                       class="flex items-center hover:text-blue-600 transition duration-300">
                                        Nama Siswa
                                        @if(request('sort') === 'nama_siswa')
                                            <span class="ml-2 text-sm">
                                                {{ request('order') === 'asc' ? '▲' : '▼' }}
                                            </span>
                                        @endif
                                    </a>
                                </th>

                                <!-- Header Kelas -->
                                <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider w-1/4">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'nama_kelas', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}"
                                       class="flex items-center hover:text-blue-600 transition duration-300">
                                        Kelas
                                        @if(request('sort') === 'nama_kelas')
                                            <span class="ml-2 text-sm">
                                                {{ request('order') === 'asc' ? '▲' : '▼' }}
                                            </span>
                                        @endif
                                    </a>
                                </th>

                                <!-- Header Nilai Rata-Rata -->
                                <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider w-1/4">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'nilai_rata_rata', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}"
                                       class="flex items-center hover:text-blue-600 transition duration-300">
                                        Nilai Rata-Rata
                                        @if(request('sort') === 'nilai_rata_rata')
                                            <span class="ml-2 text-sm">
                                                {{ request('order') === 'asc' ? '▲' : '▼' }}
                                            </span>
                                        @endif
                                    </a>
                                </th>

                                <!-- Header Action -->
                                <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider w-1/6">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($siswaList as $siswa)
                                <tr class="hover:bg-gray-100">
                                    <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-700 w-1/3">{{ $siswa->nama_siswa }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700 w-1/4">{{ $siswa->nama_kelas }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700 w-1/4">{{ number_format($siswa->nilai_rata_rata, 2) }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap w-1/6">
                                        <button onclick="showDetail('{{ $siswa->id_siswa }}')" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                            Lihat Detail
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

                <!-- Pagination -->
                <div class="mt-5 pb-4">
                    {{ $siswaList->links('staff_akademik.rapor.pagination-rapor') }}
                </div>
            </div>

            <!-- Kolom Kanan: Detail Siswa -->
            <div id="detailContainer" class="w-1/2 p-6 bg-white rounded-lg shadow-md">
                <div id="detailContent" class="text-gray-700">
                    <p class="text-center text-gray-500">Klik "Lihat Detail" pada daftar siswa untuk melihat detail di sini.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk menampilkan detail -->
    <script>
        function showDetail(id_siswa) {
            const detailContent = document.getElementById('detailContent');
            let downloadUrl = "{{ route('staff_akademik.rapor.download', ':id_siswa') }}";
            detailContent.innerHTML = '<p class="text-gray-500">Loading...</p>'; // Loading state
            downloadUrl = downloadUrl.replace(':id_siswa', id_siswa);
            // Fetch data dari server
            fetch(`/staff_akademik/rapor/siswa/${id_siswa}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Tampilkan data detail siswa dengan format rapor
                    console.log(data);
                    detailContent.innerHTML = `
                        <div class="max-w-4xl mx-auto p-4">
                            <table class="min-w-full table-auto">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="text-center text-xl font-bold pb-4">RAPOR SMP Negeri 2 Kamal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class=" font-semibold">Nama Sekolah</td>
                                        <td class="">: SMP Negeri 2 Kamal</td>
                                    </tr>
                                    <tr>
                                        <td class=" font-semibold">Kelas</td>
                                        <td class="">: ${data.nama_kelas}</td>
                                    </tr>
                                    <tr>
                                        <td class=" font-semibold">Alamat</td>
                                        <td class="">: Jl. Raya Telang No.3, Telang, Kec. Kamal</td>
                                    </tr>
                                    <tr>
                                        <td class=" font-semibold">Nama</td>
                                        <td class="">: ${data.nama_siswa}</td>
                                    </tr>
                                    <tr>
                                        <td class=" font-semibold">NISN</td>
                                        <td class="">: ${data.nisn}</td>
                                    </tr>
                                    <tr>
                                        <td class=" font-semibold">Tahun Ajaran</td>
                                        <td class="">: ${data.tahun_ajaran}</td>
                                    </tr>
                                    <tr>
                                        <td class=" font-semibold">Semester</td>
                                        <td class="">: ${data.semester}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Tabel Nilai Mata Pelajaran -->
                            <div class="mb-8">
                                <h3 class="text-xl font-medium py-4">Nilai Rata-Rata Mata Pelajaran</h3>
                                <table class="min-w-full table-auto border-separate border-spacing-0 border border-gray-300">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="px-4 py-2 text-left">Mata Pelajaran</th>
                                            <th class="px-4 py-2 text-left">Nilai</th>
                                            <th class="px-4 py-2 text-left">Predikat</th>
                                            <th class="px-4 py-2 text-left">Pesan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${data.nilai_matpel.map(matpel => `
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-2">${matpel.nama_matpel}</td>
                                                <td class="px-4 text-center py-2">${matpel.nilai_rata_rata_matpel}</td>
                                                <td class="px-4 text-center py-2">${matpel.predikat}</td>
                                                <td class="px-4 py-2">${matpel.pesan}</td>
                                            </tr>
                                        `).join('')}
                                    </tbody>
                                </table>
                            </div>

                            <!-- Tabel Nilai Ekstrakurikuler -->
                            <div>
                                <h3 class="text-xl font-medium mb-4">Nilai Rata-Rata Ekstrakurikuler</h3>
                                <table class="min-w-full table-auto border-separate border-spacing-0 border border-gray-300">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="px-4 py-2 text-left">Ekstrakurikuler</th>
                                            <th class="px-4 py-2 text-left">Nilai</th>
                                            <th class="px-4 py-2 text-left">Predikat</th>
                                            <th class="px-4 py-2 text-left">Pesan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${data.nilai_ekstra.map(ekstra => `
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-2">${ekstra.nama_ekstrakurikuler}</td>
                                                <td class="px-4 py-2">${ekstra.nilai_rata_rata_ekstra}</td>
                                                <td class="px-4 py-2">${ekstra.predikat}</td>
                                                <td class="px-4 py-2">${ekstra.pesan}</td>
                                            </tr>
                                        `).join('')}
                                    </tbody>
                                </table>
                            </div>
                            <button onclick="window.location='${downloadUrl}'"
                                class="bg-blue-600 text-white p-2 mt-5 rounded-md hover:bg-blue-800">
                                Download PDF
                            </button>

                        </div>
                    `;
                })
                .catch(error => {
                    console.error('Error fetching details:', error);
                    detailContent.innerHTML = '<p class="text-red-500">Error loading details. Please try again later.</p>';
                });
        }
    </script>

</x-staffakademik-layout>
