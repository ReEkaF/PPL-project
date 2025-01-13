<x-app-guru-layout>
    <div class="px-3 py-5 mx-4 my-6 bg-white rounded-lg shadow xl:p-6">

        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'route' => route('guru.dashboard')],
                ['label' => 'LMS', 'route' => route('guru.dashboard.lms')],
                ['label' => 'Periksa Tugas'],
            ];
        @endphp
        <x-breadcrumb :breadcrumbs="$breadcrumbs" />

        <div class="px-4 mt-6">
            <!-- Form Filter Kelas -->
            <div class="max-w-3xl mx-auto mb-6">
                <form action="{{ route('guru.dashboard.lms.tugas.periksa') }}" method="GET"
                    class="flex items-center space-x-4">
                    <select name="kelas_id" onchange="this.form.submit()"
                        class="form-select w-full rounded-md border-black shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">>
                        <option value="">Semua Kelas</option>
                        @foreach ($kelasList as $kelas)
                            <option value="{{ $kelas->id_kelas }}" {{ $kelas->id_kelas == $kelasId ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="space-y-4 max-w-3xl mx-auto">
                @forelse ($tugas as $t)
                    <a href="{{ route('guru.dashboard.lms.tugas.siswa', $t['tugas']->id_tugas) }}" class="block">
                        <div class="rounded-lg shadow-sm border border-black">
                            <div class="flex items-center justify-between  p-4 cursor-pointer">
                                <div class="flex items-center ">
                                    <svg width="20" height="28" viewBox="0 0 28 36" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M1.05254 6.87192C0.583496 8.31548 0.583496 10.0992 0.583496 13.6667V27.8258C0.583496 31.5003 0.583496 33.3375 1.23891 34.3092C2.0396 35.4962 3.43508 36.138 4.8574 35.9734C6.02166 35.8387 7.41659 34.6431 10.2064 32.2518C11.4345 31.1991 12.0486 30.6728 12.7231 30.4345C13.5494 30.1425 14.4509 30.1425 15.2773 30.4345C15.9517 30.6728 16.5658 31.1991 17.7938 32.2517C20.5837 34.643 21.9787 35.8387 23.1429 35.9734C24.5652 36.138 25.9607 35.4962 26.7614 34.3092C27.4168 33.3375 27.4168 31.5003 27.4168 27.8258V13.6667C27.4168 10.0992 27.4168 8.31548 26.9478 6.87192C25.9998 3.95439 23.7124 1.667 20.7949 0.719042C19.3513 0.25 17.5676 0.25 14.0002 0.25C10.4327 0.25 8.64898 0.25 7.20542 0.719042C4.28789 1.667 2.0005 3.95439 1.05254 6.87192ZM8.25016 10.3125C7.45625 10.3125 6.81266 10.9561 6.81266 11.75C6.81266 12.5439 7.45625 13.1875 8.25016 13.1875H19.7502C20.5441 13.1875 21.1877 12.5439 21.1877 11.75C21.1877 10.9561 20.5441 10.3125 19.7502 10.3125H8.25016Z"
                                            fill="#2D264B" />
                                    </svg>
                                    <div class="ml-3">
                                        <p class="text-sm font-semibold">{{ $t['tugas']->judul }}</p>
                                        <p class="text-xs font-normal text-gray-700">Kelas
                                            {{ $t['namaKelas'] }} | Tenggat:
                                            {{ $t['deadline']->translatedFormat('l, d F Y') }}</p>
                                    </div>
                                </div>
                                <div class="flex gap-x-4 items-center">
                                    <div>
                                        <div>{{ $t['siswaMenyerahkan'] }} </div>
                                        <div class="text-xs text-gray-500">Diserahkan</div>
                                    </div>
                                    <div>
                                        <div>{{$t['siswaBelumMenyerahkan']}}</div>
                                        <div class="text-xs text-gray-500">Ditugaskan</div>
                                    </div>
                                    <div>
                                        <div>{{ $t['dinilai'] }}</div>
                                        <div class="text-xs text-gray-500">Dinilai</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-6 text-gray-500">
                        Tidak ada tugas
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</x-app-guru-layout>
