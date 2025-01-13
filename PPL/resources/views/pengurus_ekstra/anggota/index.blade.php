<x-siswa-layout>
    <div class="p-4 bg-gray-100 min-h-screen">
        <!-- Header Anggota Ekstrakurikuler -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <div class="text-sm text-gray-500 mb-4">
                Dashboard > <span class="font-semibold text-gray-700">Anggota</span>
            </div>
            <h2 class="text-2xl font-semibold text-gray-800">Anggota Ekstrakurikuler {{ $ekstrakurikuler }}</h2>
            <div class="mt-2 text-gray-600">
                <p>Pengurus: <span class="font-semibold text-gray-700">{{ $loggedInUsername }}</span></p>
                <p>Tahun Ajaran: <span class="font-semibold text-gray-700">2024/2025</span></p>
                <p>Total Anggota: <span class="font-semibold text-gray-700">{{ $totalItems }}</span></p>
            </div>
        </div>

        <!-- Tabel Nama Anggota Ekstrakurikuler -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Nama Anggota Ekstrakurikuler</h3>
            <p class="text-sm text-gray-500 mb-4">Ini adalah list untuk anggota ekstrakurikuler</p>

            <table class="w-full table-auto" id="search-table">
                <thead>
                    <tr class="text-left text-gray-600">
                        <th class="p-2 border-b">No</th>
                        <th class="p-2 border-b">Nama Siswa</th>
                        <th class="p-2 border-b">NISN</th>
                        <th class="p-2 border-b">Alamat</th>
                        <th class="p-2 border-b">Status</th>
                        <th class="p-2 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($members as $index => $member)
                    <tr class="hover:bg-gray-50">
                        <td class="p-2 border-b">{{ $index+1 }}</td>
                        <td class="p-2 border-b">{{ $member->nama_siswa }}</td>
                        <td class="p-2 border-b">{{ $member->nisn }}</td>
                        <td class="p-2 border-b">{{ $member->alamat_siswa }}</td>
                        <td class="p-2 border-b">{{ $member->status }}</td>
                        <td class="p-2 border-b">
                            <!-- Trigger button for edit modal -->
                            <button data-modal-target="editStatus-{{ $member->id_siswa }}" data-modal-toggle="editStatus-{{ $member->id_siswa }}" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">
                                Update Status
                            </button>
                        </td>
                    </tr>

                    <!-- Modal for Editing Status -->
                    <div id="editStatus-{{ $member->id_siswa }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-w-md max-h-full">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <!-- Modal header -->
                                <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                        Update Status Anggota
                                    </h3>
                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="editStatus-{{ $member->id_siswa }}">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="p-4 space-y-4">
                                    <form action="{{ route('pengurus_ekstra.anggota.updateStatus', $member->id_siswa) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status:</label>
                                        <select name="status" class="w-full border rounded p-2 mb-4">
                                            <option value="Diterima" {{ $member->status == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                            <option value="Ditolak" {{ $member->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                </div>
                                <!-- Modal footer -->
                                <div class="flex items-center p-4 border-t border-gray-200 rounded-b dark:border-gray-600">
                                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Simpan</button>
                                    </form>
                                    <button data-modal-hide="editStatus-{{ $member->id_siswa }}" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Batal</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                        <tr>
                            <td class="p-2 border   text-center" colspan="6">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
