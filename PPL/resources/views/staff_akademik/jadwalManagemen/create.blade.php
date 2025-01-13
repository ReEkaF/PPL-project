<x-staffakademik-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Jadwal') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900">
        {{-- HEADER --}}
        <div class="mb-4 col-span-full xl:mb-2">
            <div class="p-4 mb-4 space-y-6 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('staff_akademik.dashboard') }}"
                            class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-500">
                            <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('staff_akademik.jadwal') }}"
                                class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-500">Kelola Jadwal</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('staff_akademik.jadwal.create') }}"
                                class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-primary-500">Tambah Jadwal</a>
                        </div>
                    </li>
                </ol>
            </nav>
            
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Tambah Jadwal
            </h1>
            <p class="mb-2 text-black-300 dark:text-black-200">Ini merupakan halaman Tambah Jadwal</p>
            <div class="flex items-center space-x-4">
                <!-- KEMBALI -->
                <button onclick="window.location.href='{{ route('staff_akademik.jadwal') }}'"
                class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-green-400 to-blue-600 group-hover:from-green-400 group-hover:to-blue-600 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800" 
                data-modal-target="authentication-modal" data-modal-toggle="authentication-modal">
                <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                Kembali
                </span>
                </button>
            </div>
        </div>

        {{-- KONTEN --}}
        <div class="col-span-full xl:col-auto">
            <div class="p-4 mb-4 space-y-6 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <!-- Form Tambah Jadwal -->
                <form action="{{ route('staff_akademik.jadwal.store') }}" method="POST">
                    @csrf
                    {{-- Mendapatkan id tahun ajaran --}}
                    <input type="hidden" name="tahun_ajaran_id" value="{{ $tahunAjaran->id_tahun_ajaran }}">
                    <!-- Pilih Kelas -->
                    <div class="mb-4">
                        <label for="kelas_id" class="block text-gray-700">Kelas:</label>
                        <select name="kelas_id" id="kelas_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @foreach ($kelas as $kls)
                                <option value="{{ $kls->id_kelas }}">{{ $kls->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Table Input Jadwal -->
                    <table class="w-full text-left border mt-4">
                        <thead>
                            <tr>
                                <th>Hari</th>
                                <th>Waktu Mulai-Selesai</th>
                                <th>Guru dan Mata Pelajaran</th>
                            </tr>
                        </thead>
                        <tbody id="jadwal-rows">
                            <tr>
                                <!-- Pilihan Hari -->
                                <td>
                                    <select name="jadwal[0][hari_id]" class="border-gray-300 rounded">
                                        @foreach ($hari as $h)
                                            <option value="{{ $h->id_hari }}">{{ $h->nama_hari }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <!-- Pilihan Jam Pelajaran -->
                                <td>
                                    <select name="jadwal[0][jam_pelajaran]" class="border-gray-300 rounded">
                                        <option value="07:00-09:00">07:00-09:00</option>
                                        <option value="10:00-12:00">10:00-12:00</option>
                                        <option value="13:00-15:00">13:00-15:00</option>
                                        <option value="15:01-16:00">15:01-16:00</option>
                                    </select>
                                </td>
                                <!-- Pilihan Guru dan Mata Pelajaran -->
                                <td>
                                    <select name="jadwal[0][guru_id]" class="border-gray-300 rounded">
                                        @foreach ($guruMataPelajaran as $guruMatpel)
                                            <option value="{{ $guruMatpel->id_guru }}_{{ $guruMatpel->id_matpel }}">
                                                {{ $guruMatpel->nama_guru }} - {{ $guruMatpel->nama_matpel }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="mt-6 flex space-x-4">
                        <!-- Tombol Tambah Row -->
                        <button type="button" onclick="addRow()" 
                            class="inline-flex items-center justify-center px-6 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 transform transition-all duration-200 ease-in-out">
                            Tambah
                        </button>
                    
                        <!-- Tombol Submit -->
                        <button type="submit" 
                            class="inline-flex items-center justify-center px-6 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 transform transition-all duration-200 ease-in-out">
                            Submit
                        </button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>

    <!-- Script untuk menambah row baru -->
    <script>
        let rowCount = 1;

        function addRow() {
            const tbody = document.getElementById('jadwal-rows');
            const newRow = document.createElement('tr');

            newRow.innerHTML = `
                <td>
                    <select name="jadwal[${rowCount}][hari_id]" class="border-gray-300 rounded">
                        @foreach ($hari as $h)
                            <option value="{{ $h->id_hari }}">{{ $h->nama_hari }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="jadwal[${rowCount}][jam_pelajaran]" class="border-gray-300 rounded">
                        <option value="07:00-09:00">07:00-09:00</option>
                        <option value="10:00-12:00">10:00-12:00</option>
                        <option value="13:00-15:00">13:00-15:00</option>
                        <option value="15:01-16:00">15:01-16:00</option>
                    </select>
                </td>
                <td>
                    <select name="jadwal[${rowCount}][guru_id]" class="border-gray-300 rounded">
                        @foreach ($guruMataPelajaran as $guruMatpel)
                            <option value="{{ $guruMatpel->id_guru }}_{{ $guruMatpel->id_matpel }}">
                                {{ $guruMatpel->nama_guru }} - {{ $guruMatpel->nama_matpel }}
                            </option>
                        @endforeach
                    </select>
                </td>
            `;

        tbody.appendChild(newRow);
        rowCount++;
    }
    </script>
    
</x-staffakademik-layout>