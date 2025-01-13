<x-app-guru-layout>
    <div class="px-3 py-5 mx-4 my-6 bg-white rounded-lg shadow xl:p-6">
        {{-- Breadcrumb --}}
        @php
        $breadcrumbs = [
                ['label' => 'Dashboard', 'route' => route('guru.dashboard')],
                ['label' => 'LMS', 'route' => route('guru.dashboard.lms')],
            ];
        @endphp

        <x-breadcrumb :breadcrumbs="$breadcrumbs" />

        {{-- Main Content --}}
        <div class="px-3 mt-6">
            <h2 class="mb-4 text-3xl font-semibold text-gray-800">Kelas</h2>
            <div class="grid gap-4 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-4">

                <!-- Card 1 -->
                @if ($kelasGuru->count() > 0)
                    @foreach ($kelasGuru as $kelas)
                        <a href="{{ route('guru.dashboard.lms.forum', $kelas->id_kelas_mata_pelajaran) }}" class="block">
                            <div
                                class="flex items-center p-4 border-2 border-gray-300 rounded-2xl  hover:bg-gray-100 transition duration-100">
                                <div class="p-2 mr-2 rounded-full">
                                    <svg width="40" height="40" viewBox="0 0 42 47" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M2.22813 4.97592C0 8.04268 0 12.4174 0 21.1667V25.8334C0 34.5828 0 38.9575 2.22813 42.0242C2.94773 43.0147 3.81873 43.8857 4.80917 44.6053C7.87594 46.8334 12.2506 46.8334 21 46.8334C29.7494 46.8334 34.1241 46.8334 37.1908 44.6053C38.1813 43.8857 39.0523 43.0147 39.7719 42.0242C42 38.9575 42 34.5828 42 25.8334V21.1667C42 12.4174 42 8.04268 39.7719 4.97592C39.0523 3.98548 38.1813 3.11448 37.1908 2.39488C34.1241 0.166748 29.7494 0.166748 21 0.166748C12.2506 0.166748 7.87594 0.166748 4.80917 2.39488C3.81873 3.11448 2.94773 3.98548 2.22813 4.97592ZM11.6667 12.4167C10.7002 12.4167 9.91667 13.2002 9.91667 14.1667C9.91667 15.1332 10.7002 15.9167 11.6667 15.9167H30.3333C31.2998 15.9167 32.0833 15.1332 32.0833 14.1667C32.0833 13.2002 31.2998 12.4167 30.3333 12.4167H11.6667ZM11.6667 21.7501C10.7002 21.7501 9.91667 22.5336 9.91667 23.5001C9.91667 24.4666 10.7002 25.2501 11.6667 25.2501H30.3333C31.2998 25.2501 32.0833 24.4666 32.0833 23.5001C32.0833 22.5336 31.2998 21.7501 30.3333 21.7501H11.6667ZM11.6667 31.0834C10.7002 31.0834 9.91667 31.8669 9.91667 32.8334C9.91667 33.7999 10.7002 34.5834 11.6667 34.5834H18.6667C19.6332 34.5834 20.4167 33.7999 20.4167 32.8334C20.4167 31.8669 19.6332 31.0834 18.6667 31.0834H11.6667Z"
                                            fill="#2D264B" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-lg lg:text-xl font-semibold text-gray-800">
                                        {{ $kelas->mataPelajaran->nama_matpel }} {{ $kelas->kelas->nama_kelas }}
                                    </h4>
                                    </h4>
                                    <p class="text-sm text-gray-500">{{ $kelas->hari->nama_hari }},
                                        {{ $kelas->waktu_mulai }} - {{ $kelas->waktu_selesai }} WIB</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @else
                    <div class="flex items-center justify-center p-4 border-2 border-gray-300 rounded-2xl"></div>
                    <p class="text-lg font-semibold text-gray-800">Siswa belum terdaftar dalam kelas manapun.</p>
                @endif
            </div>
        </div>

    </div>
</x-app-guru-layout>
