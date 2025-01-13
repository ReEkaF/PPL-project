<x-app-guru-layout>
    <div class="px-3 py-5 mx-4 my-6 bg-white rounded-lg shadow xl:p-6">
        {{-- Breadcrumb --}}
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'route' => route('guru.dashboard')],
                ['label' => 'LMS', 'route' => route('guru.dashboard.lms')],
                ['label' => $mataPelajaran->nama_matpel . ' ' . $kelas->nama_kelas],
            ];
        @endphp

        <x-breadcrumb :breadcrumbs="$breadcrumbs" />


        {{-- Main Content --}}
        <div class="px-3">
            {{-- Tabs --}}
            <div class="flex gap-2 mb-4 mt-6 overflow-x-auto whitespace-nowrap">
                <x-nav-button-lms route="guru.dashboard.lms.forum" :id="$id" label="Forum" />
                <x-nav-button-lms route="guru.dashboard.lms.forum.tugas" :id="$id" label="Tugas" />
                <x-nav-button-lms route="guru.dashboard.lms.forum.anggota" :id="$id" label="Anggota" />
            </div>

            {{-- Main Content with Sidebar and Material/Tugas --}}
            <div class="flex flex-col md:flex-row gap-4">
                {{-- Left Sidebar --}}
                <div class="flex flex-col gap-4 w-full basis-1/2">
                    {{-- Instructor Info --}}
                    <div class="p-4 bg-gray-100 rounded-lg  border border-black">
                        <div class="flex items-center gap-2">
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $guru->nama_guru }}</h3>
                                <p class="text-sm text-gray-500">{{ $hari->nama_hari }}, {{ $waktu_mulai }} -
                                    {{ $waktu_selesai }} WIB</p>
                            </div>
                        </div>
                    </div>

                    {{-- Upcoming Assignments --}}
                    <div class="p-4 rounded-lg border border-black">
                        <h4 class="font-semibold text-gray-800 mb-2">Mendatang</h4>
                        <ul class="text-sm text-gray-600 space-y-3">
                            @forelse ($tugasMendatang as $tugas)
                                <li>
                                    <p class="text-gray-600">Tenggat:
                                        {{ Carbon\Carbon::parse($tugas->deadline)->translatedFormat('l, d F Y') }}</p>
                                    <a href="{{ route('guru.dashboard.lms.detail.tugas', $tugas->id_tugas) }}"
                                        class="text-blue-500 underline">
                                        {{ $tugas->judul }}
                                    </a>
                                </li>
                            @empty
                                <p class="text-gray-500">Tidak ada tugas mendatang</p>
                            @endforelse
                        </ul>

                    </div>

                </div>

                {{-- Right Sidebar/Main Content --}}
                <div class="flex flex-col gap-4 w-full">
                    {{-- List of Materi & Tugas --}}
                    <div class="space-y-4">
                        {{-- Sample Item --}}
                        @if ($materiTugas && $materiTugas->count() > 0)
                            @foreach ($materiTugas as $item)
                                @php
                                    $route =
                                        $item->type === 'materi'
                                            ? route('guru.dashboard.lms.materi.detail', $item->id)
                                            : route('guru.dashboard.lms.detail.tugas', $item->id);
                                    $titlePrefix = $item->type === 'materi' ? 'Materi Baru: ' : 'Tugas Baru: ';
                                @endphp
                                <a href="{{ $route }}" class="block">
                                    <div
                                        class="flex items-center p-4 bg-white border border-black rounded-lg shadow hover:bg-gray-100 transition duration-200">
                                        <div class="mr-2 p-2 rounded-full">
                                            @if ($item->type == 'materi')
                                                <svg width="36" height="39" viewBox="0 0 36 39" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M2.58025 4.28389C0.75 6.80302 0.75 10.3965 0.75 17.5835V21.4168C0.75 28.6038 0.75 32.1973 2.58025 34.7164C3.17135 35.53 3.88682 36.2455 4.70039 36.8366C7.21952 38.6668 10.813 38.6668 18 38.6668C25.187 38.6668 28.7805 38.6668 31.2996 36.8366C32.1132 36.2455 32.8287 35.53 33.4197 34.7164C35.25 32.1973 35.25 28.6038 35.25 21.4168V17.5835C35.25 10.3965 35.25 6.80302 33.4197 4.28389C32.8287 3.47031 32.1132 2.75485 31.2996 2.16375C28.7805 0.333496 25.187 0.333496 18 0.333496C10.813 0.333496 7.21952 0.333496 4.70039 2.16375C3.88682 2.75485 3.17135 3.47031 2.58025 4.28389ZM10.3333 10.396C9.53942 10.396 8.89583 11.0396 8.89583 11.8335C8.89583 12.6274 9.53942 13.271 10.3333 13.271H25.6667C26.4606 13.271 27.1042 12.6274 27.1042 11.8335C27.1042 11.0396 26.4606 10.396 25.6667 10.396H10.3333ZM10.3333 18.0627C9.53942 18.0627 8.89583 18.7063 8.89583 19.5002C8.89583 20.2941 9.53942 20.9377 10.3333 20.9377H25.6667C26.4606 20.9377 27.1042 20.2941 27.1042 19.5002C27.1042 18.7063 26.4606 18.0627 25.6667 18.0627H10.3333ZM10.3333 25.7293C9.53942 25.7293 8.89583 26.3729 8.89583 27.1668C8.89583 27.9607 9.53942 28.6043 10.3333 28.6043H25.6667C26.4606 28.6043 27.1042 27.9607 27.1042 27.1668C27.1042 26.3729 26.4606 25.7293 25.6667 25.7293H10.3333Z"
                                                        fill="#2D264B" />
                                                </svg>
                                            @else
                                                <svg width="28" height="36" viewBox="0 0 28 36" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M1.05254 6.87192C0.583496 8.31548 0.583496 10.0992 0.583496 13.6667V27.8258C0.583496 31.5003 0.583496 33.3375 1.23891 34.3092C2.0396 35.4962 3.43508 36.138 4.8574 35.9734C6.02166 35.8387 7.41659 34.6431 10.2064 32.2518C11.4345 31.1991 12.0486 30.6728 12.7231 30.4345C13.5494 30.1425 14.4509 30.1425 15.2773 30.4345C15.9517 30.6728 16.5658 31.1991 17.7938 32.2517C20.5837 34.643 21.9787 35.8387 23.1429 35.9734C24.5652 36.138 25.9607 35.4962 26.7614 34.3092C27.4168 33.3375 27.4168 31.5003 27.4168 27.8258V13.6667C27.4168 10.0992 27.4168 8.31548 26.9478 6.87192C25.9998 3.95439 23.7124 1.667 20.7949 0.719042C19.3513 0.25 17.5676 0.25 14.0002 0.25C10.4327 0.25 8.64898 0.25 7.20542 0.719042C4.28789 1.667 2.0005 3.95439 1.05254 6.87192ZM8.25016 10.3125C7.45625 10.3125 6.81266 10.9561 6.81266 11.75C6.81266 12.5439 7.45625 13.1875 8.25016 13.1875H19.7502C20.5441 13.1875 21.1877 12.5439 21.1877 11.75C21.1877 10.9561 20.5441 10.3125 19.7502 10.3125H8.25016Z"
                                                        fill="#2D264B" />
                                                </svg>
                                            @endif

                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-800">
                                                @if ($item->type === 'materi')
                                                    Materi Baru: {{ $item->judul }}
                                                @else
                                                    Tugas Baru: {{ $item->judul }}
                                                @endif
                                            </h4>
                                            <div class="flex items-center gap-2">
                                                <p class="text-sm text-gray-500 ">
                                                    {{ Carbon\Carbon::parse($item->date)->format('d F Y') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <p class="text-gray-500 font-semibold text-center">Tidak ada materi atau tugas baru.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-guru-layout>
