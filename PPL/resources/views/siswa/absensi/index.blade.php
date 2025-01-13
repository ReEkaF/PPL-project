<x-siswa-layout>
    <div class="col-span-full xl:col-auto">
        <div class="p-4 mb-4 bg-white border border-gray-200 rounded shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">

            @php
                $breadcrumbs = [
                    ['label' => 'Dashboard', 'route' => route('siswa.dashboard')],
                    ['label' => 'Absensi', 'route' => route('siswa.absensi.index')],
                ];
            @endphp

            <div class="flex justify-between items-center pt-4">
                <x-breadcrumb :breadcrumbs="$breadcrumbs" />
            </div>

            <div class="mt-4">
                @foreach ($data->groupBy('kelas.nama_kelas') as $kelasName => $items)
                    <div class="pb-2 text-gray-700 border-b border-gray-200 dark:border-gray-600">
                        <h3 class="font-semibold text-lg">Jadwal Kelas {{ $kelasName }}</h3>
                    </div>

                    <div class="relative overflow-x-auto shadow sm:rounded-lg mb-8">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Hari</th>
                                    <th scope="col" class="px-6 py-3">Jam</th>
                                    <th scope="col" class="px-6 py-3">Mata Pelajaran</th>
                                    <th scope="col" class="px-6 py-3">Guru</th>
                                    <th scope="col" class="px-6 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr class="odd:bg-white border-b dark:bg-gray-800 dark:border-gray-700 even:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4">{{ $item->hari->nama_hari }}</td>
                                        <td class="px-6 py-4">{{ $item->waktu_mulai }} - {{ $item->waktu_selesai }}</td>
                                        <td class="px-6 py-4">{{ $item->mataPelajaran->nama_matpel }}</td>
                                        <td class="px-6 py-4">{{ $item->guru->nama_guru }}</td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('siswa.absensi.details', $item->id_kelas_mata_pelajaran) }}" class="text-blue-500 hover:underline flex gap-2">
                                                <button class="flex items-center gap-1 bg-blue-100 text-primary-800 text-xs font-medium py-0.5 px-2 rounded-md border border-blue-300 hover:text-blue-700 focus:ring-2 focus:outline-none focus:ring-blue-300">
                                                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"></path>
                                                    <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                                                    </svg>
                                                    Detail
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-siswa-layout>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session('error') }}',
        });
    @endif

</script>
