<x-siswa-layout>
    <div class="pt-6">
        <div class="lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-2">
                    {{-- Breadcrumb --}}
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="flex space-x-2">
                            <li class="flex">
                                <a href="{{ route('siswa.dashboard') }}" class="text-gray-400 hover:text-gray-700">
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            <div class="flex justify-center py-1">
                                <svg class="flex w-4 h-4 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
                                </svg>
                            </div>
                            <li class="flex">
                                <p class="font-semibold text-gray-700">
                                    <span>Penilaian</span>
                                </p>
                            </li>
                        </ol>
                    </nav>
                    <h2 class="text-2xl font-semibold text-gray-800">Penilaian Ekstrakurikuler {{ $nama_ekstra }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-6">
        <div class="lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold">Nama Anggota Ekstrakurikuler</h3>
                    @if (session()->has('success'))
                        <x-alert-notification :color="'green'">
                            {{ session('success') }}
                        </x-alert-notification>
                    @endif
                    <div class="mt-4">
                        <table class="min-w-full divide-y divide-gray-200" id="search-table">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>NISN</th>
                                    <th>Laporan</th>
                                    <th>Penilaian</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($laporan_anggota as $index => $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->siswa->nama_siswa }}</td>
                                        <td>{{ $item->siswa->nisn }}</td>
                                        <td>{{ $item->laporan ? $item->laporan->isi_laporan : 'Belum Terisi' }}</td>
                                        <td>{{ $item->penilaian ? $item->penilaian->penilaian : '-' }}</td>
                                        <td>{{ $item->penilaian ? $item->penilaian->tgl_penilaian : '-' }}</td>
                                        <td>
                                            <!-- Edit Laporan Modal -->
                                            <button data-modal-target="editLaporanModal-{{ $item->id_siswa }}" data-modal-toggle="editLaporanModal-{{ $item->id_siswa }}" class="bg-blue-500 text-white px-2 py-1 rounded">
                                                Edit Laporan
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal for Editing Laporan -->
                                    <div id="editLaporanModal-{{ $item->id_siswa }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full h-modal">
                                        <div class="relative p-4 w-full max-w-md max-h-full">
                                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                <div class="flex items-start justify-between p-4 border-b rounded-t">
                                                    <h3 class="text-xl font-semibold text-gray-900">
                                                        Edit Laporan
                                                    </h3>
                                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ms-auto inline-flex items-center" data-modal-hide="editLaporanModal-{{ $item->id_siswa }}">
                                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" d="M4.293 16.293a1 1 0 010-1.414L14.586 4.586a1 1 0 011.414 0l.293.293a1 1 0 010 1.414L6 16.293a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <form action="{{ route('pengurus_ekstra.penilaian.storeOrUpdate', $item->id_siswa) }}" method="POST">
                                                    @csrf
                                                    <div class="p-6 space-y-4">
                                                        <label for="isi_laporan" class="block text-sm font-medium text-gray-700">Isi Laporan</label>
                                                        <textarea name="isi_laporan" id="isi_laporan" rows="4" class="w-full border-gray-300 rounded-md">{{ $item->laporan->isi_laporan ?? '' }}</textarea>
                                                    </div>
                                                    <div class="flex items-center p-6 space-x-2 border-t">
                                                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                                                            Simpan
                                                        </button>
                                                        <button type="button" class="bg-gray-300 px-4 py-2 rounded-lg" data-modal-hide="editLaporanModal-{{ $item->id_siswa }}">
                                                            Batal
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center font-bold">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#search-table", {
                searchable: true,
                paging: false,
                sortable: true
            });
        }
    </script>
</x-siswa-layout>
