<aside id="sidebar"
class="fixed top-0 left-0 z-20 flex flex-col flex-shrink-0 hidden w-64 h-full pt-16 font-normal duration-75 lg:flex transition-width"
aria-label="Sidebar">
<div
    class="relative flex flex-col flex-1 min-h-0 pt-0 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="flex flex-col flex-1 pt-5 pb-4 overflow-y-auto">
        <div class="flex-1 px-3 space-y-1 bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
            {{-- Sidebar Header --}}
            <ul class="pb-2 space-y-2">
                <li>
                    <form action="#" method="GET" class="lg:hidden">
                        <label for="mobile-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input type="text" name="email" id="mobile-search"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Search">
                        </div>
                    </form>
                </li>

                {{-- Overview --}}
                <li>
                    <x-sidebar-link href="{{ route('staff_akademik.dashboard') }}" :active="request()->is('staff_akademik/dashboard')">
                        <x-sidebar-icon>
                                <path d="M13.5 2c-.178 0-.356.013-.492.022l-.074.005a1 1 0 0 0-.934.998V11a1 1 0 0 0 1 1h7.975a1 1 0 0 0 .998-.934l.005-.074A7.04 7.04 0 0 0 22 10.5 8.5 8.5 0 0 0 13.5 2Z"/>
                                <path d="M11 6.025a1 1 0 0 0-1.065-.998 8.5 8.5 0 1 0 9.038 9.039A1 1 0 0 0 17.975 13H11V6.025Z"/>
                        </x-sidebar-icon>
                        <span class="ml-3" sidebar-toggle-item>Overview</span>
                    </x-sidebar-link>
                </li>

                {{-- Data Master --}}
                <li>
                    <x-sidebar-dropdown label="Master Data" id="master" :active="request()->is('staff_akademik/kelas') || request()->is('staff_akademik/guru-mata-pelajaran') || request()->is('staff_akademik/mata-pelajaran') || request()->is('staff_akademik/jadwal')">
                        <x-sidebar-icon>
                            <path fill-rule="evenodd" d="M4 4a1 1 0 0 1 1-1h14a1 1 0 1 1 0 2v14a1 1 0 1 1 0 2H5a1 1 0 1 1 0-2V5a1 1 0 0 1-1-1Zm5 2a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H9Zm5 0a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1h-1Zm-5 4a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1H9Zm5 0a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1h-1Zm-3 4a2 2 0 0 0-2 2v3h2v-3h2v3h2v-3a2 2 0 0 0-2-2h-2Z" clip-rule="evenodd"/>
                        </x-sidebar-icon>
                    </x-sidebar-dropdown>
                    <x-sidebar-dropdown-list id="master" :active="request()->is('staff_akademik/kelas') || request()->is('staff_akademik/guru-mata-pelajaran') || request()->is('staff_akademik/mata-pelajaran') || request()->is('staff_akademik/jadwal')">
                        <li>
                            <x-sidebar-dropdown-list-link href="{{route('staff_akademik.kelas.index')}}" :active="request()->is('staff_akademik/kelas')">Data Kelas</x-sidebar-dropdown-list-link>
                        </li>
                        <li>
                            <x-sidebar-dropdown-list-link href="{{route('daftarkelas')}}" :active="request()->is('staff-akademik/master/kelas')">Atur Siswa & Wali Kelas</x-sidebar-dropdown-list-link>
                        </li>
                        <li>
                            <x-sidebar-dropdown-list-link href="{{route('daftarkelas')}}" :active="request()->is('staff-akademik/master/kelas')">Atur Siswa & Wali Kelas</x-sidebar-dropdown-list-link>
                        </li>
                        <li>
                            <x-sidebar-dropdown-list-link href="{{route('staff_akademik.guru_mata_pelajaran.index')}}" :active="request()->is('staff_akademik/guru-mata-pelajaran')">Data Guru</x-sidebar-dropdown-list-link>
                        </li>
                        <li>
                            <x-sidebar-dropdown-list-link href="{{route('staff_akademik.mata-pelajaran.index')}}" :active="request()->is('staff_akademik/mata-pelajaran')">Data Mata Pelajaran</x-sidebar-dropdown-list-link>
                        </li>
                        <li>
                            <x-sidebar-dropdown-list-link href="{{route('staff_akademik.jadwal')}}" :active="request()->is('staff_akademik/jadwal')">Data Jadwal</x-sidebar-dropdown-list-link>
                        </li>
                    </x-sidebar-dropdown-list>
                </li>

                {{-- Prestasi --}}
                <li>
                    <x-sidebar-dropdown label="Data Prestasi" id="prestasi" :active="request()->is('staff_akademik/prestasi/*')">
                        <x-sidebar-icon>
                            <path fill-rule="evenodd" d="M4 4a1 1 0 0 1 1-1h14a1 1 0 1 1 0 2v14a1 1 0 1 1 0 2H5a1 1 0 1 1 0-2V5a1 1 0 0 1-1-1Zm5 2a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H9Zm5 0a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1h-1Zm-5 4a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1H9Zm5 0a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1h-1Zm-3 4a2 2 0 0 0-2 2v3h2v-3h2v3h2v-3a2 2 0 0 0-2-2h-2Z" clip-rule="evenodd"/>
                        </x-sidebar-icon>
                    </x-sidebar-dropdown>
                    <x-sidebar-dropdown-list id="prestasi" :active="request()->is('staff_akademik/prestasi*')">
                        <li>
                            <x-sidebar-dropdown-list-link href="{{route('prestasi.index')}}" :active="request()->is('staff_akademik/prestasi')">Data Prestasi</x-sidebar-dropdown-list-link>
                        </li>
                        <li>
                            <x-sidebar-dropdown-list-link href="{{route('prestasi.pengajuan')}}" :active="request()->is('staff_akademik/prestasi/pengajuan')">Pengajuan Prestasi</x-sidebar-dropdown-list-link>
                        </li>
                    </x-sidebar-dropdown-list>
                </li>

                {{-- Jadwal Kelas& Guru --}}
                <li>
                    <x-sidebar-dropdown label="Jadwal Kelas & Guru" id="jadwal" :active="request()->is('staff_akademik/jadwal-kelas') || request()->is('staff_akademik/jadwal-guru')">
                        <x-sidebar-icon>
                               <path fill-rule="evenodd" d="M5 5a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1 2 2 0 0 1 2 2v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a2 2 0 0 1 2-2ZM3 19v-7a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm6.01-6a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm-10 4a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Z" clip-rule="evenodd"/>
                        </x-sidebar-icon>
                    </x-sidebar-dropdown>
                    <x-sidebar-dropdown-list id="jadwal" :active="request()->is('staff_akademik/jadwal-kelas') || request()->is('staff_akademik/jadwal-guru')">
                        <li>
                            <x-sidebar-dropdown-list-link href="{{route('lihat.jadwal.kelas')}}" :active="request()->is('staff_akademik/jadwal-kelas')">Jadwal Kelas</x-sidebar-dropdown-list-link>
                        </li>
                        <li>
                            <x-sidebar-dropdown-list-link href="{{route('lihat.jadwal.guru')}}" :active="request()->is('staff_akademik/jadwal-guru')">Jadwal Guru</x-sidebar-dropdown-list-link>
                        </li>

                    </x-sidebar-dropdown-list>
                </li>

                <li>
                    <x-sidebar-link href="{{ route('akademik.absensi.index') }}" :active="request()->is('staff_akademik/dashboard')">
                        <x-sidebar-icon>
                            <path fill-rule="evenodd" d="M8 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1h2a2 2 0 0 1 2 2v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h2Zm6 1h-4v2H9a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2h-1V4Zm-6 8a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1 3a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z" clip-rule="evenodd"/>
                        </x-sidebar-icon>
                        <span class="ml-3" sidebar-toggle-item>Absensi</span>
                    </x-sidebar-link>
                </li>
            </ul>

        </div>
    </div>
</div>
</aside>
