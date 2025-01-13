<x-app-guru-layout>
    <div class="pt-6">
        <div class="lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-2">
                        {{-- Breadcrumb --}}
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="flex space-x-2">
                            <li class="flex">
                                <a href="{{ route('pembina.dashboard') }}" class="text-gray-400 hover:text-gray-700">
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
                    <div class="flex justify-between items-center space-y-4">
                        <h2 class="text-2xl font-semibold text-gray-800">Penilaian Ekstrakurikuler {{ $nama_ekstra }}</h2>
                    </div>
                <div class="mt-4">
                    <p class="text-lg font-semibold text-gray-700">Pembina: <span class="font-normal">{{ auth()->guard('web-guru')->user()->nama_guru }}</span></p>
                    <p class="text-lg font-semibold text-gray-700">Tahun Ajaran:
                    <select name="tahun_ajaran" id="tahun_ajaran" class="bg-gray-50 border border-gray-300 text-gray-900 font-semibold rounded-lg focus:ring-blue-500 focus:border-blue-500 p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @foreach($tahun_ajaran as $tahun)
                            <option value="{{ $tahun->id_tahun_ajaran }}" {{ $tahun->id_tahun_ajaran == $tahun_ajaran_aktif->id_tahun_ajaran ? 'selected' : '' }}>
                                {{ $tahun->tahun_mulai }}/{{ $tahun->tahun_selesai }} {{ $tahun->semester == 1 ? 'Ganjil' : "Genap" }}
                            </option>
                        @endforeach
                    </select>
                    </p>
                    <script>
                        $(document).ready(function() {
                            $('#tahun_ajaran').change(function() {
                                var selectedTahunAjaran = $(this).val();
                                console.log(selectedTahunAjaran);
                                var newUrl = '/guru/pembina/ekstrakurikuler/penilaian/' + selectedTahunAjaran;
                                window.location.href = newUrl;
                            });
                        });
                    </script>
                    <p class="text-lg font-semibold text-gray-700">Total Anggota: <span class="font-normal">{{ $laporan_anggota ? $laporan_anggota->count() : count($laporan_anggota) }}</span></p>
                </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-6">
        <div class="lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center space-y-4">
                        <h2 class="text-2xl font-semibold text-gray-800">Nama Anggota Ekstrakurikuler</h2>
                    </div>

                    @if (session()->has('success'))
                    <x-alert-notification :color="'green'">
                        {{ session('success') }}
                    </x-alert-notification>
                    @endif

                    <div class="pt-4">
                        <table class="min-w-full divide-y divide-gray-200" id="search-table">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th scope="col" class="px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                    <th scope="col" class="px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NISN</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Isi Laporan</th>
                                    <th scope="col" class="px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penilaian</th>
                                    <th scope="col" class="px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($laporan_anggota as $index => $item)
                                    <tr class="{{ $loop->even ? 'bg-gray-100' : '' }}">
                                        <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration }}</td>
                                        <td class="px-1 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->siswa->nama_siswa }}</td>
                                        <td class="px-1 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->siswa->nisn }}</td>
                                        <td class="px-6 py-4 whitespace-normal text-md text-gray-900">{{ ($item->laporan) ? $item->laporan->isi_laporan : 'Belum Terisi' }}</td>
                                        <td class="px-1 py-4 whitespace-nowrap text-bold text-gray-900">
                                            <select name="penilaian-{{ $loop->iteration }}" class="penilaian-dropdown bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" data-id="{{ $item->id_siswa }}" {{ ($item->laporan) ? '' : 'disabled' }}>
                                                <option value="" disabled {{ $item->penilaian ? '' : 'selected' }}>Pilih Penilaian</option>
                                                <option value="a" {{ ($item->penilaian && $item->penilaian->penilaian == 'A') ? 'selected' : '' }}>A</option>
                                                <option value="b" {{ ($item->penilaian && $item->penilaian->penilaian == 'B') ? 'selected' : '' }}>B</option>
                                                <option value="c" {{ ($item->penilaian && $item->penilaian->penilaian == 'C') ? 'selected' : '' }}>C</option>
                                                <option value="d" {{ ($item->penilaian && $item->penilaian->penilaian == 'D') ? 'selected' : '' }}>D</option>
                                                <option value="e" {{ ($item->penilaian && $item->penilaian->penilaian == 'E') ? 'selected' : '' }}>E</option>
                                            </select>
                                        </td>
                                        <td class="px-1 py-4 whitespace-nowrap text-sm text-gray-500" id="tgl-penilaian-{{ $loop->iteration }}">
                                            {{ ($item->penilaian) ? $item->penilaian->tgl_penilaian : '-' }}
                                            <input type="hidden" value="{{ $item->laporan ? $item->laporan->id_laporan : '' }}" id="id_laporan-{{ $loop->iteration }}">
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-lg font-medium text-gray-900 text-center" colspan="6">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.penilaian-dropdown').each(function(index) {
                $(this).data('iteration', index + 1);
                $(this).on('change', function() {

                    var id_siswa = $(this).data('id');
                    var value = $(this).val();
                    var iteration = $(this).data('iteration');
                    var id_laporan = $('#id_laporan-' + iteration).val();

                    $.ajax({
                        url: '/guru/pembina/ekstrakurikuler/penilaian/' + id_siswa,
                        type: 'POST',
                        data: {
                            penilaian: value,
                            id_siswa: id_siswa,
                            id_laporan: id_laporan,
                        },
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            if (data.success) {
                                $('#tgl-penilaian-' + iteration).text(data.tgl_penilaian);
                            }
                        }
                    });
                });
            });
        });

        if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#search-table", {
                searchable: true,
                paging: false,
                sortable: true
            });
        }

    </script>
</x-app-guru-layout>
