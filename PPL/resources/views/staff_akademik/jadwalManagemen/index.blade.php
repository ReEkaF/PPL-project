<x-staffakademik-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jadwal Kelas') }}
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
                                class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-primary-500">Kelola Jadwal</a>
                        </div>
                    </li>
                </ol>
            </nav>
            
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">
                Kelola Jadwal Kelas
            </h1>
            <p class="mb-2 text-black-300 dark:text-black-200">Ini merupakan halaman kelola Jadwal</p>
            <div class="flex items-center space-x-4">
                <!-- TAMBAH JADWAL -->
                <button onclick="window.location.href='{{ route('staff_akademik.jadwal.create') }}'"
                class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-green-400 to-blue-600 group-hover:from-green-400 group-hover:to-blue-600 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800" 
                data-modal-target="authentication-modal" data-modal-toggle="authentication-modal">
                <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                Tambah Jadwal
                </span>
                </button>

                <!-- Vertical Divider Line -->
                <span class="h-11 w-px bg-gray-300"></span>
                
                <!-- Import EXCEL -->
                <button  onclick="window.location.href='{{ route('staff_akademik.jadwal.import') }}'"
                class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                    <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                    Import Excel
                    </span>
                </button>
            </div>
        </div>

        <!-- KONTEN -->
        <div class="col-span-full xl:col-auto">
            
            <div class="p-4 mb-4 space-y-6 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">

                <!-- Filter kelas -->
                <div>
                    <form action="{{ route('staff_akademik.jadwal') }}" method="GET" class="flex items-center">
                        <label for="kelas_id" class="mr-2">Pilih Kelas:</label>
                        <select name="kelas_id" id="kelas_id" class="border-gray-300 rounded-md shadow-sm" onchange="this.form.submit()">
                            <option value="">Semua Kelas</option>
                            @foreach($kelas as $kls)
                                <option value="{{ $kls->id_kelas }}" {{ isset($kelas_id) && $kelas_id == $kls->id_kelas ? 'selected' : '' }}>
                                    {{ $kls->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <!-- Export EXCEL -->
                <button onclick="window.location.href='{{ route('staff_akademik.jadwal.export', ['kelas_id' => request('kelas_id')]) }}'"
                    class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-yellow-400 to-orange-600 group-hover:from-yellow-400 group-hover:to-orange-600 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-yellow-200 dark:focus:ring-yellow-800">
                    <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                    Export Excel
                    </span>
                </button>
                
                <!-- Export PDF -->
                <button onclick="window.location.href='{{ route('staff_akademik.jadwal.pdf', ['kelas_id' => request('kelas_id')]) }}'"
                    class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-yellow-400 to-orange-600 group-hover:from-yellow-400 group-hover:to-orange-600 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-yellow-200 dark:focus:ring-yellow-800">
                    <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                    Export PDF
                    </span>
                </button>

                <!-- Pesan Bentrok -->
                @if(session('error'))
                    <div class="bg-red-500 text-white p-4 rounded mb-4">
                        <strong>List jadwal bentrok</strong>
                        <ul class="list-disc pl-5">
                            @foreach(session('bentrok') as $item)
                                <li>
                                    @if($item['tipe'] == 'guru')
                                        Guru {{ $item['nama_guru'] }} memiliki jadwal bentrok di kelas lain pada hari {{ $item['nama_hari'] }} jam {{ $item['jam_pelajaran'] }}.
                                    @elseif($item['tipe'] == 'kelas')
                                        Kelas {{ $item['nama_kelas'] }} sudah memiliki jadwal pada hari {{ $item['nama_hari'] }} jam {{ $item['jam_pelajaran'] }}.
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Pesan Update Bentrok -->
                @if(session('error-update'))
                    <div class="bg-red-500 text-white p-4 rounded mb-4">
                        <strong>List jadwal bentrok</strong>
                        <ul class="list-disc pl-5">
                            <li>{{ session('error-update') }}</li>
                        </ul>
                    </div>
                @endif

                <!-- Pesan error delete -->
                @if(session('error-delete'))
                    <div class="bg-red-500 text-white p-4 rounded mb-4">
                        <strong>Delete Gagal</strong>
                        <ul class="list-disc pl-5">
                            <li>{{ session('error-delete') }}</li>
                        </ul>
                    </div>
                @endif

                <!-- Pesan error excel -->
                @if (session('error-excel'))
                <div class="bg-red-500 text-white p-4 rounded mb-4">
                    <strong>Terjadi kesalahan saat mengimpor jadwal:</strong>
                    <ul class="list-disc pl-5">
                        @foreach (explode(";", session('error-excel')) as $error)
                        @if ($loop->last)
                            @break
                        @endif
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Pesan Sukses -->
                @if(session('success'))
                    <div class="bg-green-500 text-white p-4 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                
                <div>
                    @foreach ($kelas as $kls)
                    @if (isset($kelas_id) && $kelas_id != $kls->id_kelas)
                    @continue
                    @endif

                    @php
                        $cek = DB::table('kelas')
                        ->join('kelas_mata_pelajaran', 'kelas.id_kelas', '=', 'kelas_mata_pelajaran.kelas_id')
                        ->join('mata_pelajaran', 'kelas_mata_pelajaran.mata_pelajaran_id', '=', 'mata_pelajaran.id_matpel')
                        ->join('tahun_ajaran', 'kelas_mata_pelajaran.tahun_ajaran_id', '=', 'tahun_ajaran.id_tahun_ajaran')
                        ->where('tahun_ajaran.aktif', 1)
                        ->where('kelas.nama_kelas', $kls->nama_kelas)
                        ->get();
                    @endphp

                    @if ($cek->isEmpty())
                        @continue
                    @endif

                    <!-- nama kelas -->
                    <div class="px-4 py-2 mt-4 text-gray-700 border-b border-gray-200 dark:border-gray-600">
                        <h3 class="font-semibold text-lg">Jadwal Kelas {{ $kls->nama_kelas }}</h3>
                    </div>
                    <!-- Table -->
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Hari
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Jam
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Mata Pelajaran
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Guru
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    @if ($item->nama_kelas == $kls->nama_kelas && $item->nama_hari=="Senin")
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                            <td class="px-6 py-4">
                                                {{ $item->nama_hari }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $item->waktu_mulai }} - {{ $item->waktu_selesai }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $item->nama_matpel }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $item->nama_guru }}
                                            </td>
                                            <td class="flex items-center px-6 py-4">
                                                <a href="{{ route('staff_akademik.jadwal.edit', $item->id_kelas_mata_pelajaran) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                                <form action="{{ route('staff_akademik.jadwal.delete', $item->id_kelas_mata_pelajaran) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                @foreach ($data as $item)
                                    @if ($item->nama_kelas == $kls->nama_kelas && $item->nama_hari=="Selasa")
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                            <td class="px-6 py-4">
                                                {{ $item->nama_hari }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $item->waktu_mulai }} - {{ $item->waktu_selesai }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $item->nama_matpel }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $item->nama_guru }}
                                            </td>
                                            <td class="flex items-center px-6 py-4">
                                                <a href="{{ route('staff_akademik.jadwal.edit', $item->id_kelas_mata_pelajaran) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                                <form action="{{ route('staff_akademik.jadwal.delete', $item->id_kelas_mata_pelajaran) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                @foreach ($data as $item)
                                    @if ($item->nama_kelas == $kls->nama_kelas && $item->nama_hari=="Rabu")
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                            <td class="px-6 py-4">
                                                {{ $item->nama_hari }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $item->waktu_mulai }} - {{ $item->waktu_selesai }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $item->nama_matpel }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $item->nama_guru }}
                                            </td>
                                            <td class="flex items-center px-6 py-4">
                                                <a href="{{ route('staff_akademik.jadwal.edit', $item->id_kelas_mata_pelajaran) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                                <form action="{{ route('staff_akademik.jadwal.delete', $item->id_kelas_mata_pelajaran) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                @foreach ($data as $item)
                                    @if ($item->nama_kelas == $kls->nama_kelas && $item->nama_hari=="Kamis")
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                            <td class="px-6 py-4">
                                                {{ $item->nama_hari }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $item->waktu_mulai }} - {{ $item->waktu_selesai }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $item->nama_matpel }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $item->nama_guru }}
                                            </td>
                                            <td class="flex items-center px-6 py-4">
                                                <a href="{{ route('staff_akademik.jadwal.edit', $item->id_kelas_mata_pelajaran) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                                <form action="{{ route('staff_akademik.jadwal.delete', $item->id_kelas_mata_pelajaran) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                @foreach ($data as $item)
                                    @if ($item->nama_kelas == $kls->nama_kelas && $item->nama_hari=="Jumat")
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                            <td class="px-6 py-4">
                                                {{ $item->nama_hari }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $item->waktu_mulai }} - {{ $item->waktu_selesai }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $item->nama_matpel }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $item->nama_guru }}
                                            </td>
                                            <td class="flex items-center px-6 py-4">
                                                <a href="{{ route('staff_akademik.jadwal.edit', $item->id_kelas_mata_pelajaran) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                                <form action="{{ route('staff_akademik.jadwal.delete', $item->id_kelas_mata_pelajaran) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                @foreach ($data as $item)
                                    @if ($item->nama_kelas == $kls->nama_kelas && $item->nama_hari=="Sabtu")
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                            <td class="px-6 py-4">
                                                {{ $item->nama_hari }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $item->waktu_mulai }} - {{ $item->waktu_selesai }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $item->nama_matpel }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $item->nama_guru }}
                                            </td>
                                            <td class="flex items-center px-6 py-4">
                                                <a href="{{ route('staff_akademik.jadwal.edit', $item->id_kelas_mata_pelajaran) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                                <form action="{{ route('staff_akademik.jadwal.delete', $item->id_kelas_mata_pelajaran) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                @foreach ($data as $item)
                                    @if ($item->nama_kelas == $kls->nama_kelas && $item->nama_hari=="Minggu")
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                            <td class="px-6 py-4">
                                                {{ $item->nama_hari }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $item->waktu_mulai }} - {{ $item->waktu_selesai }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $item->nama_matpel }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $item->nama_guru }}
                                            </td>
                                            <td class="flex items-center px-6 py-4">
                                                <a href="{{ route('staff_akademik.jadwal.edit', $item->id_kelas_mata_pelajaran) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                                <form action="{{ route('staff_akademik.jadwal.delete', $item->id_kelas_mata_pelajaran) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</x-staffakademik-layout>