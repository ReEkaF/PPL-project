<x-staffakademik-layout>
    <div class="col-span-full xl:col-auto">
        <div class="p-4 mb-4 bg-white border border-gray-200 rounded shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">

            @php
                $breadcrumbs = [
                    ['label' => 'Dashboard', 'route' => route('staff_akademik.dashboard')],
                    ['label' => 'Absensi', 'route' => route('akademik.absensi.index')],
                    ['label' => 'Kelas', 'route' => route('akademik.absensi.details', $detail->id_kelas_mata_pelajaran)],
                    ['label' => 'Pertemuan', 'route' => route('akademik.absensi.details', $detail->id_kelas_mata_pelajaran)],
                ];
            @endphp

            <div class="flex justify-between items-center pt-4">
                <x-breadcrumb :breadcrumbs="$breadcrumbs" />
            </div>

            <div class="mt-4">
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 my-2">Daftar Absensi Pertemuan {{ \Carbon\Carbon::parse($pertemuan->tanggal_pertemuan)->translatedFormat('d F Y') }}</h2>

                <form action="{{ route('akademik.absensi.updateStatus') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="relative overflow-x-auto shadow sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">NO</th>
                                    <th scope="col" class="px-6 py-3">NISN</th>
                                    <th scope="col" class="px-6 py-3">Nama Siswa</th>
                                    <th scope="col" class="px-6 py-3">Status Absensi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr class="odd:bg-white border-b dark:bg-gray-800 dark:border-gray-700 even:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4">{{ $student->nisn }}</td>
                                        <td class="px-6 py-4">{{ $student->nama_siswa }}</td>
                                        <td class="px-6 py-4">
                                            <select name="status_absensi[{{ $student->id_absensi_siswa }}]" class="border border-gray-300 rounded-md p-2.5 focus:outline-none focus:border-blue-500">
                                                <option value="Alpa" {{ $student->status_absensi == 'Alpa' ? 'selected' : '' }}>Alpa</option>
                                                <option value="Hadir" {{ $student->status_absensi == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                                <option value="Izin" {{ $student->status_absensi == 'Izin' ? 'selected' : '' }}>Izin</option>
                                                <option value="Sakit" {{ $student->status_absensi == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Ubah Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-staffakademik-layout>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    @if(session('success'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    @endif

    @if(session('error'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: '{{ session('error') }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    @endif
</script>
