<x-staffakademik-layout>
    <div class="col-span-full xl:col-auto">
        <div class="p-4 mb-4 bg-white border border-gray-200 rounded shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">

            @php
                $breadcrumbs = [
                    ['label' => 'Dashboard', 'route' => route('staff_akademik.dashboard')],
                    ['label' => 'Absensi', 'route' => route('akademik.absensi.index')],
                    ['label' => 'Kelas', 'route' => route('akademik.absensi.details', $detail->id_kelas_mata_pelajaran)],
                ];
            @endphp

            <div class="flex justify-between items-center pt-4">
                <x-breadcrumb :breadcrumbs="$breadcrumbs" />
            </div>

            <div class="mt-4">
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 my-2">Daftar Absensi Kelas {{ $detail->kelas->nama_kelas }}</h2>

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

                <form action="{{ route('akademik.absensi.generate', $detail->id_kelas_mata_pelajaran) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="first_week_date" class="inline-block text-sm font-medium text-gray-700 mb-1">Tanggal Pertemuan Pertama:</label>
                            @if ($errors->has('first_week_date'))
                                <span class="text-red-500 text-sm">{{ $errors->first('first_week_date') }}</span>
                            @endif
                            <input type="date" id="first_week_date" name="first_week_date" class="w-full border border-gray-300 rounded-md p-2.5 focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label for="total_meetings" class="inline-block text-sm font-medium text-gray-700 mb-1">Total Pertemuan:</label>
                            @if ($errors->has('total_meetings'))
                                <span class="text-red-500 text-sm">{{ $errors->first('total_meetings') }}</span>
                            @endif
                            <input type="number" id="total_meetings" name="total_meetings" class="w-full border border-gray-300 rounded-md p-2.5 focus:outline-none focus:border-blue-500" placeholder="Masukkan Total Pertemuan">
                        </div>
                    </div>
                    @if ($detail->pertemuan->isEmpty())
                        <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Generate Data Absensi</button>
                    @endif
                </form>

                @if (!$detail->pertemuan->isEmpty())
                    <form id="reset-form" action="{{ route('akademik.absensi.reset', $detail->id_kelas_mata_pelajaran) }}" method="POST" class="mb-4">
                        @csrf
                        @method('DELETE')
                        <button type="button" id="reset-button" class="w-full bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Reset Pertemuan</button>
                    </form>
                @endif

                <div class="relative overflow-x-auto shadow sm:rounded-lg mt-6 mb-8">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Pertemuan Ke-</th>
                                <th scope="col" class="px-6 py-3">Tanggal Pertemuan</th>
                                <th scope="col" class="px-6 py-3">QR Code</th>
                                <th scope="col" class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($detail->pertemuan as $pertemuan)
                                <tr class="odd:bg-white border-t-2 dark:bg-gray-800 dark:border-gray-700 even:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-16 py-4 font-semibold text-gray-500">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 font-semibold text-gray-500">{{ \Carbon\Carbon::parse($pertemuan->tanggal_pertemuan)->translatedFormat('d F Y') }}</td>
                                    <td class="py-4 px-2">
                                        <a href="#" data-modal-target="qrModal-{{ $loop->iteration }}" data-modal-toggle="qrModal-{{ $loop->iteration }}">
                                            <img src="{{ asset('storage/' . $pertemuan->qr_code) }}"
                                                 alt="QR Code for Pertemuan {{ $loop->iteration }}"
                                                 class="w-32 h-32">
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('akademik.absensi.pertemuan.details', ['id' => $detail->id_kelas_mata_pelajaran, 'pertemuan' => $pertemuan->id_pertemuan]) }}" class="text-blue-500 flex gap-2 mb-2">
                                            <button class="flex items-center gap-1 bg-blue-100 text-primary-800 text-xs font-medium py-0.5 px-2 rounded-md border border-blue-300 hover:text-blue-700 focus:ring-2 focus:outline-none focus:ring-blue-300" data-modal-target="showRpsModal-01J620BBWTCSE859ZVBZPEX46C" data-modal-toggle="showRpsModal-01J620BBWTCSE859ZVBZPEX46C">
                                                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"></path>
                                                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                                                </svg>
                                                Detail
                                            </button>
                                        </a>
                                        <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Hadir: {{ $pertemuan->absensisiswa->where('status_absensi', 'Hadir')->count() }}</span>
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">Izin: {{ $pertemuan->absensisiswa->where('status_absensi', 'Izin')->count() }}</span>
                                        <span class="bg-purple-100 text-purple-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-purple-900 dark:text-purple-300">Sakit: {{ $pertemuan->absensisiswa->where('status_absensi', 'Sakit')->count() }}</span>
                                        <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">Alpa: {{ $pertemuan->absensisiswa->where('status_absensi', 'Alpa')->count() }}</span>
                                    </td>
                                </tr>

                                <div id="qrModal-{{ $loop->iteration }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
                                    <div class="relative w-full h-full max-w-2xl md:h-auto">
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="qrModal-{{ $loop->iteration }}">
                                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                            <div class="p-6 text-center">
                                                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Absensi Pertemuan Ke-{{ $loop->iteration }}</h3>
                                                <img src="{{ asset('storage/' . $pertemuan->qr_code) }}"
                                                     alt="QR Code for Pertemuan {{ $loop->iteration }}"
                                                     class="mx-auto" style="width: 600px; height: 600px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak Ada Data Absensi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-staffakademik-layout>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('reset-button').addEventListener('click', function() {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Anda tidak akan bisa mengembalikan data absensi yang sudah direset!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Reset',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('reset-form').submit();
            }
        });
    });

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
