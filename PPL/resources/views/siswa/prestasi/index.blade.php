<x-siswa-layout>
    <div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900">
        <!-- Bagian Atas -->
        <div class="flex-grow mb-4 col-span-full xl:mb-2">
            <div class="p-4 mb-4 space-y-6 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">

                <!-- Breadcrumb -->
                <nav class="flex mb-5" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="#" class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-500">
                                <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                </svg>
                                Home
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <a href="#" class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-primary-500">Prestasi</a>
                            </div>
                        </li>
                    </ol>
                </nav>

                <!-- Header dan Deskripsi -->
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Prestasi</h1>
                <p class="mb-2 text-gray-300 dark:text-gray-200">Ini merupakan halaman Prestasi</p>

                <!-- Tombol Tambah Data dan Pengajuan -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('siswa.prestasi.create') }}"
                        class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-green-400 to-blue-600 group-hover:from-green-400 group-hover:to-blue-600 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800">
                        <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                            Ajukan Prestasi
                        </span>
                    </a>
                    <span class="h-11 w-px bg-gray-300"></span>
                </div>
            </div>
            @if (count($prestasi)!=0)
            <div class="col-span-full xl:col-auto">
                <div class="p-4 mb-4 space-y-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                    <div class="px-4 py-2 text-gray-700 border-b border-gray-200 dark:border-gray-600">
                        <center>
                            <h3 class="font-semibold text-lg">Data Prestasi</h3>
                        </center>
                    </div>
                    <!-- Tabel Data -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 rounded-lg">
                            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase text-sm leading-normal">
                                <tr>
                                    <th class="py-3 px-6 text-left">No</th>
                                    <th class="py-3 px-6 text-left">Nama Prestasi</th>
                                    <th class="py-3 px-6 text-left">Bukti</th>
                                    <th class="py-3 px-6 text-left">Deskripsi</th>
                                    <th class="py-3 px-6 text-left">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($prestasi as $row)
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="py-3 px-6">{{ $loop->iteration }}</td>
                                    <td class="py-3 px-6">{{ $row->nama_prestasi }}</td>
                                    <td class="py-3 px-6">
                                        @if ($row->bukti_prestasi)
                                        <a href="{{ route('siswa.prestasi.show', $row->id_prestasi) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Detail</a>
                                        @else
                                        <span class="text-gray-500">Tidak Ada Bukti</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-6">{{ $row->deskripsi_prestasi }}</td>
                                    <td class="py-3 px-6">
                                        <span class="px-3 py-1 rounded-full text-white {{ $row->status_prestasi == 1 ? 'bg-green-500' : 'bg-red-500' }}">
                                            {{ $row->status_prestasi == 1 ? 'Verified' : 'Unverified' }}
                                        </span>
                                    </td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                        <!-- Showing and Pagination -->
                        <div class="mt-4 flex justify-between items-center w-full">
                            <!-- Showing -->
                            <div class="text-gray-600 dark:text-gray-300 text-sm">
                                Showing {{ $prestasi->firstItem() }} to {{ $prestasi->lastItem() }} of {{ $prestasi->total() }} results
                            </div>
                        </div>
                        <br>
                        <!-- Pagination -->
                        <div class="flex justify-center">
                            <nav aria-label="Page navigation example">
                                <ul class="flex items-center -space-x-px h-8 text-sm">
                                    <!-- Previous Page Link -->
                                    <li>
                                        <a href="{{ $prestasi->previousPageUrl() }}" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                            <span class="sr-only">Previous</span>
                                            <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                                            </svg>
                                        </a>
                                    </li>

                                    <!-- Pagination Links -->
                                    @foreach ($prestasi->getUrlRange(1, $prestasi->lastPage()) as $page => $url)
                                    <li>
                                        <a href="{{ $url }}" class="flex items-center justify-center px-3 h-8 leading-tight {{ $prestasi->currentPage() == $page ? 'z-10 text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white' : 'text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white' }}">
                                            {{ $page }}
                                        </a>
                                    </li>
                                    @endforeach

                                    <!-- Next Page Link -->
                                    <li>
                                        <a href="{{ $prestasi->nextPageUrl() }}" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                            <span class="sr-only">Next</span>
                                            <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                                            </svg>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <br>
                    </div>

                </div>
            </div>
            @endif
            <!-- Tabel Data Prestasi -->

        </div>
    </div>

</x-siswa-layout>