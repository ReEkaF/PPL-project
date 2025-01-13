<x-siswa-layout>
    <div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900">
        <div class="mb-4 col-span-full xl:mb-2">
            <div class="p-4 mb-4 space-y-6 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <nav class="flex mb-5" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="#"
                                class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-500">
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
                                <a href="{{route('siswa.prestasi')}}" class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-primary-500">Prestasi</a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Tambah Data</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">
                    Tambah Prestasi
                </h1>
                <p class="mb-2 text-gray-300 dark:text-gray-200">Ini adalah halaman untuk menambahkan prestasi siswa</p>
                <div class="flex items-center">
                    <a href="{{route('prestasi.index')}}"
                        class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                        <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                            Kelola Prestasi
                        </span>
                    </a>

                </div>
            </div>
        </div>

        <!-- Right Content -->
        <!-- Right Content -->
        <div class="mb-4 col-span-full xl:mb-2 flex justify-center">
            <div class="p-6 bg-white rounded-lg shadow-lg w-full max-w-3xl">
                <br>
                <h2 class="text-lg font-semibold text-gray-800 text-center">Tambah Prestasi</h2> <br>
                <hr class="my-2 w-1/2 mx-auto border-gray-300"> <br>
                <form action="{{ route('siswa.prestasi.store') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="nama_prestasi" class="block text-sm font-medium text-gray-700">Nama Prestasi</label>
                            <input type="text" id="nama_prestasi" name="nama_prestasi" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" placeholder="Masukkan nama prestasi">
                            @error('nama_prestasi')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="bukti_prestasi" class="block text-sm font-medium text-gray-700">Bukti (file)</label>
                            <input type="file" id="bukti_prestasi" name="bukti_prestasi" accept="image/*" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            @error('bukti_prestasi')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="deskripsi_prestasi" class="block text-sm font-medium text-gray-700">Deskripsi Prestasi</label>
                            <textarea id="deskripsi_prestasi" name="deskripsi_prestasi" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" placeholder="Masukkan deskripsi prestasi"></textarea>
                            @error('deskripsi_prestasi')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-siswa-layout>