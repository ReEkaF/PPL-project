<x-siswa-layout>
    <div class="col-span-full xl:col-auto">
        <div class="p-4 mb-4 bg-white border border-gray-200 rounded shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">

            @php
                $breadcrumbs = [
                    ['label' => 'Dashboard', 'route' => route('siswa.dashboard')],
                    ['label' => 'Absensi', 'route' => route('siswa.absensi.index')],
                    ['label' => 'Kelas', 'route' => route('siswa.absensi.details', $detail->id_kelas_mata_pelajaran)],
                ];
            @endphp

            <div class="flex justify-between items-center pt-4">
                <x-breadcrumb :breadcrumbs="$breadcrumbs" />
            </div>

            <div class="mt-4">
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 my-2">Detail Pertemuan Kelas {{ $detail->kelas->nama_kelas }}</h2>

                <div class="mb-4 grid grid-cols-2 gap-4">
                    <div class="px-3 py-3 bg-gray-50 dark:bg-gray-800 rounded-t-md">
                        <p class="font-bold text-gray-800 dark:text-gray-200">Mata Pelajaran:</p>
                        <p class="font-semibold text-gray-500 dark:text-gray-400">{{ $detail->mataPelajaran->nama_matpel }}</p>
                    </div>
                    <div class="px-3 py-3 bg-gray-50 dark:bg-gray-700">
                        <p class="font-bold text-gray-800 dark:text-gray-200">Guru:</p>
                        <p class="font-semibold text-gray-500 dark:text-gray-400">{{ $detail->guru->nama_guru }}</p>
                    </div>
                    <div class="px-3 py-3 bg-gray-50 dark:bg-gray-800">
                        <p class="font-bold text-gray-800 dark:text-gray-200">Hari:</p>
                        <p class="font-semibold text-gray-500 dark:text-gray-400">{{ $detail->hari->nama_hari }}</p>
                    </div>
                    <div class="px-3 py-3 bg-gray-50 dark:bg-gray-700 rounded-b-md">
                        <p class="font-bold text-gray-800 dark:text-gray-200">Jam:</p>
                        <p class="font-semibold text-gray-500 dark:text-gray-400">{{ $detail->waktu_mulai }} - {{ $detail->waktu_selesai }}</p>
                    </div>
                </div>

                <div class="relative overflow-x-auto shadow sm:rounded-lg mt-6 mb-8">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Pertemuan Ke-</th>
                                <th scope="col" class="px-6 py-3">Tanggal Pertemuan</th>
                                <th scope="col" class="px-6 py-3">Status Absensi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($detail->pertemuan as $pertemuan)
                                <tr class="odd:bg-white border-t-2 dark:bg-gray-800 dark:border-gray-700 even:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-16 py-4 font-semibold text-gray-500">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 font-semibold text-gray-500">{{ \Carbon\Carbon::parse($pertemuan->tanggal_pertemuan)->translatedFormat('d F Y') }}</td>
                                    <td class="px-6 py-4 font-semibold text-gray-500">
                                        @if ($pertemuan->absensiSiswa->isNotEmpty())
                                            @php
                                                $status = $pertemuan->absensiSiswa->first()->status_absensi;
                                                $badgeColor = match($status) {
                                                    'Hadir' => 'bg-green-100 text-green-800 rounded-lg',
                                                    'Alpa' => 'bg-red-100 text-red-800 rounded-lg',
                                                    'Sakit' => 'bg-yellow-100 text-yellow-800 rounded-lg',
                                                    'Izin' => 'bg-purple-100 text-purple-800 rounded-lg',
                                                    default => 'bg-gray-100 text-gray-800 rounded-lg',
                                                };
                                            @endphp
                                            <span class="px-2.5 py-0.5 rounded text-xs font-medium {{ $badgeColor }}">{{ $status }}</span>
                                        @else
                                            <span class="px-2.5 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">Belum Ada Data</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-4 text-center text-gray-500">Tidak Ada Data Absensi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Sukses',
            text: '{{ session('success') }}',
        });
    @endif

    @if(session('info'))
        Swal.fire({
            icon: 'info',
            title: 'Informasi',
            text: '{{ session('info') }}',
        });
    @endif
</script>
