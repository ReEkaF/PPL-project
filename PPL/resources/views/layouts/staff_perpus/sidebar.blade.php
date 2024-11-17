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
                        <form action="#" method="GET" class="lg:hidden hidden">
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
                        <x-sidebar-link href="{{ route('staff_perpus.dashboard') }}" :active="request()->is('staff_perpus/dashboard')">
                            <x-sidebar-icon>
                                <path
                                    d="M13.5 2c-.178 0-.356.013-.492.022l-.074.005a1 1 0 0 0-.934.998V11a1 1 0 0 0 1 1h7.975a1 1 0 0 0 .998-.934l.005-.074A7.04 7.04 0 0 0 22 10.5 8.5 8.5 0 0 0 13.5 2Z" />
                                <path
                                    d="M11 6.025a1 1 0 0 0-1.065-.998 8.5 8.5 0 1 0 9.038 9.039A1 1 0 0 0 17.975 13H11V6.025Z" />
                            </x-sidebar-icon>
                            <span class="ml-3" sidebar-toggle-item>Overview</span>
                        </x-sidebar-link>
                    </li>
                    <li>
                        <x-sidebar-link href="{{ route('staff_perpus.managecategories') }}" :active="request()->is('staff_perpus/manageCategory')">
                            <x-sidebar-icon>
                                <path fill-rule="evenodd"
                                    d="M20 10H4v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8ZM9 13v-1h6v1a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1Z"
                                    clip-rule="evenodd" />
                                <path d="M2 6a2 2 0 0 1 2-2h16a2 2 0 1 1 0 4H4a2 2 0 0 1-2-2Z" />
                            </x-sidebar-icon>
                            <span class="ml-3" sidebar-toggle-item>Kelola Kategori Buku</span>
                        </x-sidebar-link>
                    </li>

                    {{-- LMS --}}
                    {{-- <li>
                        <x-sidebar-dropdown label="LMS" id="lms" :active="request()->is('siswa/dashboard/lms*')">
                            <x-sidebar-icon>
                                <path fill-rule="evenodd"
                                    d="M4 4a1 1 0 0 1 1-1h14a1 1 0 1 1 0 2v14a1 1 0 1 1 0 2H5a1 1 0 1 1 0-2V5a1 1 0 0 1-1-1Zm5 2a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H9Zm5 0a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1h-1Zm-5 4a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1H9Zm5 0a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1h-1Zm-3 4a2 2 0 0 0-2 2v3h2v-3h2v3h2v-3a2 2 0 0 0-2-2h-2Z"
                                    clip-rule="evenodd" />
                            </x-sidebar-icon>
                        </x-sidebar-dropdown>
                        <x-sidebar-dropdown-list id="lms" :active="request()->is('siswa/dashboard/lms*')">
                    <li>
                        <x-sidebar-dropdown-list-link href="{{ route('siswa.dashboard.lms') }}"
                            :active="request()->is('siswa/dashboard/lms')">Beranda</x-sidebar-dropdown-list-link>
                    </li>
                    <li>
                        <x-sidebar-dropdown-list-link href="{{ route('siswa.dashboard.lms.materi') }}"
                            :active="request()->is('siswa/dashboard/lms/materi')">Materi</x-sidebar-dropdown-list-link>
                    </li>
                    <li>
                        <x-sidebar-dropdown-list-link href="{{ route('siswa.dashboard.lms.tugas') }}"
                            :active="request()->is('siswa/dashboard/lms/tugas')">Tugas</x-sidebar-dropdown-list-link>
                    </li>
                    </x-sidebar-dropdown-list>
                    </li> --}}

                    {{-- Perpustakaan --}}
                    <li>
                        <x-sidebar-dropdown label="Perpustakaan" id="perpustakaan" :active="request()->is('dashboard/perpustakaan*')">
                            <x-sidebar-icon>
                                <path fill-rule="evenodd"
                                    d="M6 2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 1 0 0-2h-2v-2h2a1 1 0 0 0 1-1V4a2 2 0 0 0-2-2h-8v16h5v2H7a1 1 0 1 1 0-2h1V2H6Z"
                                    clip-rule="evenodd" />+
                            </x-sidebar-icon>
                        </x-sidebar-dropdown>
                        <x-sidebar-dropdown-list id="perpustakaan" :active="request()->is('dashboard/perpustakaan*')">
                    <li>
                        <x-sidebar-dropdown-list-link href="/dashboard"
                            :active="request()->is('dashboard/perpustakaan/beranda')">Beranda</x-sidebar-dropdown-list-link>
                    </li>
                    <li>
                        <x-sidebar-dropdown-list-link href="{{ route('staff_perpus.buku.daftarbuku') }}"
                            :active="request()->is('dashboard/perpustakaan/buku')">Daftar Buku</x-sidebar-dropdown-list-link>
                    </li>
                    <li>
                        <x-sidebar-dropdown-list-link href="dashboard/lms" :active="request()->is('dashboard/perpustakaan/daftarkategori')">Daftar
                            Kategori</x-sidebar-dropdown-list-link>
                    </li>
                    <li>
                        <x-sidebar-dropdown-list-link href="{{ route('staff_perpus.transaksi.daftartransaksi') }}"  :active="request()->is('dashboard/perpustakaan/transaksi')">Transaksi</x-sidebar-dropdown-list-link>
                    </li>
                    {{-- <li>
                        <x-sidebar-dropdown label="Laporan" id="laporan" :active="request()->is('dashboard/perpustakaan/laporan*')">
                        </x-sidebar-dropdown>
                        <x-sidebar-dropdown-list id="laporan" :active="request()->is('dashboard/perpustakaan/laporan*')">
                    <li>
                        <x-sidebar-dropdown-list-link href="dashboard/lms" :active="request()->is('dashboard/perpustakaan/laporan/bukumasuk')">Laporan Buku
                            Masuk</x-sidebar-dropdown-list-link>
                    </li>
                    <li>
                        <x-sidebar-dropdown-list-link href="dashboard/lms" :active="request()->is('dashboard/perpustakaan/laporan/bukuhilang')">Laporan Buku
                            Hilang</x-sidebar-dropdown-list-link>
                    </li>
                    <li>
                        <x-sidebar-dropdown-list-link href="dashboard/lms" :active="request()->is('dashboard/perpustakaan/laporan/transaksi')">Laporan
                            Transaksi</x-sidebar-dropdown-list-link>
                    </li>
                    </x-sidebar-dropdown-list>
                    </li>
                    </x-sidebar-dropdown-list>
                    </li>

                    {{-- Ekstrakurikuler --}}

                    {{-- 
                    <li>
                        <x-sidebar-dropdown label="Ekstrakurikuler" id="ekstrakurikuler" :active="request()->is('dashboard/ekstrakurikuler*')">
                            <x-sidebar-icon>
                                <path fill-rule="evenodd"
                                    d="M17.316 4.052a.99.99 0 0 0-.9.14c-.262.19-.416.495-.416.82v8.566a4.573 4.573 0 0 0-2-.464c-1.99 0-4 1.342-4 3.443 0 2.1 2.01 3.443 4 3.443 1.99 0 4-1.342 4-3.443V6.801c.538.5 1 1.219 1 2.262 0 .56.448 1.013 1 1.013s1-.453 1-1.013c0-1.905-.956-3.18-1.86-3.942a6.391 6.391 0 0 0-1.636-.998 4 4 0 0 0-.166-.063l-.013-.005-.005-.002h-.002l-.002-.001ZM4 5.012c-.552 0-1 .454-1 1.013 0 .56.448 1.013 1 1.013h9c.552 0 1-.453 1-1.013 0-.559-.448-1.012-1-1.012H4Zm0 4.051c-.552 0-1 .454-1 1.013 0 .56.448 1.013 1 1.013h9c.552 0 1-.454 1-1.013 0-.56-.448-1.013-1-1.013H4Zm0 4.05c-.552 0-1 .454-1 1.014 0 .559.448 1.012 1 1.012h4c.552 0 1-.453 1-1.012 0-.56-.448-1.013-1-1.013H4Z"
                                    clip-rule="evenodd" />+
                            </x-sidebar-icon>
                        </x-sidebar-dropdown>
                        <x-sidebar-dropdown-list id="ekstrakurikuler" :active="request()->is('dashboard/ekstrakurikuler*')">
                    <li>
                        <x-sidebar-dropdown-list-link href="dashboard/lms"
                            :active="request()->is('dashboard/ekstrakurikuler/beranda')">Beranda</x-sidebar-dropdown-list-link>
                    </li>
                    <li>
                        <x-sidebar-dropdown-list-link href="dashboard/ekstrakurikuler/anggota"
                            :active="request()->is('dashboard/ekstrakurikuler/anggota')">Anggota</x-sidebar-dropdown-list-link>
                    </li>
                    </x-sidebar-dropdown-list>
                    </li> --}}



                    {{-- Ujian --}}
                    {{-- <li>
                        <x-sidebar-link href="#">
                            <x-sidebar-icon>
                                <path fill-rule="evenodd"
                                    d="M5.617 2.076a1 1 0 0 1 1.09.217L8 3.586l1.293-1.293a1 1 0 0 1 1.414 0L12 3.586l1.293-1.293a1 1 0 0 1 1.414 0L16 3.586l1.293-1.293A1 1 0 0 1 19 3v18a1 1 0 0 1-1.707.707L16 20.414l-1.293 1.293a1 1 0 0 1-1.414 0L12 20.414l-1.293 1.293a1 1 0 0 1-1.414 0L8 20.414l-1.293 1.293A1 1 0 0 1 5 21V3a1 1 0 0 1 .617-.924ZM9 7a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2H9Zm0 4a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Zm0 4a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z"
                                    clip-rule="evenodd" />+
                                </path>
                            </x-sidebar-icon>
                            <span class="ml-3" sidebar-toggle-item>Ujian</span>
                        </x-sidebar-link>
                    </li> --}}
                </ul>

                {{-- Sidebar Footer --}}
                <div class="pt-2 space-y-2">
                    <x-sidebar-link href="#">
                        <x-sidebar-icon>
                            <path fill-rule="evenodd"
                                d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z"
                                clip-rule="evenodd" />
                        </x-sidebar-icon>
                        <span class="ml-3" sidebar-toggle-item>Kembali ke Beranda</span>
                    </x-sidebar-link>
                    <x-sidebar-link href="#">
                        <x-sidebar-icon>
                            <path d="M14 19V5h4a1 1 0 0 1 1 1v11h1a1 1 0 0 1 0 2h-6Z" />
                            <path fill-rule="evenodd"
                                d="M12 4.571a1 1 0 0 0-1.275-.961l-5 1.428A1 1 0 0 0 5 6v11H4a1 1 0 0 0 0 2h1.86l4.865 1.39A1 1 0 0 0 12 19.43V4.57ZM10 11a1 1 0 0 1 1 1v.5a1 1 0 0 1-2 0V12a1 1 0 0 1 1-1Z"
                                clip-rule="evenodd" />
                        </x-sidebar-icon>
                        <span class="ml-3" sidebar-toggle-item>Log Out</span>

                    </x-sidebar-link>
                    {{-- <x-sidebar-link href="#">
                        <x-sidebar-icon>
                            <path fill-rule="evenodd"
                                d="M3 6a2 2 0 0 1 2-2h5.532a2 2 0 0 1 1.536.72l1.9 2.28H3V6Zm0 3v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V9H3Z"
                                clip-rule="evenodd" />
                        </x-sidebar-icon>
                        <span class="ml-3" sidebar-toggle-item>Raport</span>
                    </x-sidebar-link> --}}
                </div>
            </div>
        </div>
    </div>
</aside>
