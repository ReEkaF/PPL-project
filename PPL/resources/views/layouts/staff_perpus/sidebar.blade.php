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
                                <svg class="w-[14px] h-[14px] text-gray-500 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M13.5 2c-.178 0-.356.013-.492.022l-.074.005a1 1 0 0 0-.934.998V11a1 1 0 0 0 1 1h7.975a1 1 0 0 0 .998-.934l.005-.074A7.04 7.04 0 0 0 22 10.5 8.5 8.5 0 0 0 13.5 2Z" />
                                    <path
                                        d="M11 6.025a1 1 0 0 0-1.065-.998 8.5 8.5 0 1 0 9.038 9.039A1 1 0 0 0 17.975 13H11V6.025Z" />
                                </svg>
                            </x-sidebar-icon>
                            <span class="ml-3" sidebar-toggle-item>Overview</span>
                        </x-sidebar-link>
                    </li>
                    <li>
                        <x-sidebar-link href="{{ route('staff_perpus.transaksi.daftartransaksi') }}" :active="request()->is('staff_perpus/transaksi')">
                            <x-sidebar-icon>
                                <svg class="w-[14px] h-[14px] text-gray-500 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5H9Zm2 0V2h7a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9h5a2 2 0 0 0 2-2Zm-1 9a1 1 0 1 0-2 0v2a1 1 0 1 0 2 0v-2Zm2-5a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0v-6a1 1 0 0 1 1-1Zm4 4a1 1 0 1 0-2 0v3a1 1 0 1 0 2 0v-3Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </x-sidebar-icon>
                            <span class="ml-3" sidebar-toggle-item>Transaksi</span>
                        </x-sidebar-link>
                    </li>
                    <li>
                        <x-sidebar-link href="{{ route('staff_perpus.buku.daftarbuku') }}" :active="request()->is('staff_perpus/buku')">
                            <x-sidebar-icon>
                                <svg class="w-[14px] h-[14px] text-gray-500 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M20 14h-2.722L11 20.278a5.511 5.511 0 0 1-.9.722H20a1 1 0 0 0 1-1v-5a1 1 0 0 0-1-1ZM9 3H4a1 1 0 0 0-1 1v13.5a3.5 3.5 0 1 0 7 0V4a1 1 0 0 0-1-1ZM6.5 18.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2ZM19.132 7.9 15.6 4.368a1 1 0 0 0-1.414 0L12 6.55v9.9l7.132-7.132a1 1 0 0 0 0-1.418Z" />
                                </svg>
                            </x-sidebar-icon>
                            <span class="ml-3" sidebar-toggle-item>Kelola Buku</span>
                        </x-sidebar-link>
                    </li>
                    <li>
                        <x-sidebar-link href="{{ route('staff_perpus.managecategories') }}" :active="request()->is('staff_perpus/mngcategory')">
                            <x-sidebar-icon>
                                <svg class="w-[14px] h-[14px] text-gray-500 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M20 10H4v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8ZM9 13v-1h6v1a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1Z"
                                        clip-rule="evenodd" />
                                    <path d="M2 6a2 2 0 0 1 2-2h16a2 2 0 1 1 0 4H4a2 2 0 0 1-2-2Z" />
                                </svg>
                            </x-sidebar-icon>
                            <span class="ml-3" sidebar-toggle-item>Kelola Kategori Buku</span>
                        </x-sidebar-link>
                    </li>
                    <li>
                        <x-sidebar-link href="{{ route('staff_perpus.riwayat_transaksi.riwayattransaksi') }}" :active="request()->is('staff_perpus/manageCategory')">
                            <x-sidebar-icon>
                                <svg class="w-[14px] h-[14px] text-gray-500 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M20 10H4v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8ZM9 13v-1h6v1a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1Z"
                                        clip-rule="evenodd" />
                                    <path d="M2 6a2 2 0 0 1 2-2h16a2 2 0 1 1 0 4H4a2 2 0 0 1-2-2Z" />
                                </svg>
                            </x-sidebar-icon>
                            <span class="ml-3" sidebar-toggle-item>Riwayat Transaksi</span>
                        </x-sidebar-link>
                    </li>
                    <li>
                        <x-sidebar-dropdown label="Laporan" id="perpustakaan" :active="request()->is('dashboard/perpustakaan/laporan*')">
                            <x-sidebar-icon>
                                <path fill-rule="evenodd"
                                    d="M6 2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 1 0 0-2h-2v-2h2a1 1 0 0 0 1-1V4a2 2 0 0 0-2-2h-8v16h5v2H7a1 1 0 1 1 0-2h1V2H6Z"
                                    clip-rule="evenodd" />
                            </x-sidebar-icon>
                        </x-sidebar-dropdown>
                        <x-sidebar-dropdown-list id="perpustakaan" :active="request()->is('dashboard/perpustakaan*')">
                    <li>
                        <x-sidebar-dropdown-list-link href="{{ route('staff_perpus.laporan.laporanbukumasuk') }}"  :active="request()->is('dashboard/perpustakaan/laporan/bukumasuk')">Laporan Buku
                            Masuk</x-sidebar-dropdown-list-link>
                    </li>
                    <li>
                        <x-sidebar-dropdown-list-link href="{{ route('staff_perpus.laporan.laporanbukuhilang') }}" :active="request()->is('dashboard/perpustakaan/laporan/bukuhilang')">Laporan Buku
                            Hilang</x-sidebar-dropdown-list-link>
                    </li>
                    <li>
                        <x-sidebar-dropdown-list-link href="{{ route('staff_perpus.laporan.laporantransaksi') }}" :active="request()->is('dashboard/perpustakaan/laporan/transaksi')">Laporan
                            Transaksi</x-sidebar-dropdown-list-link>
                    </li>
                    <!-- <li>
                            <x-sidebar-dropdown-list-link href="{{ route('staff_perpus.buku.daftarbuku') }}"
                                :active="request()->is('dashboard/perpustakaan/buku')">Daftar Buku</x-sidebar-dropdown-list-link>
                        </li> -->
                    <!-- <li>
                            <x-sidebar-dropdown-list-link href="/dashboard"
                                :active="request()->is('dashboard/perpustakaan/beranda')">Beranda</x-sidebar-dropdown-list-link>
                        </li> -->
                    <!-- <li>
                            <x-sidebar-dropdown-list-link href="{{ route('staff_perpus.transaksi.daftartransaksi') }}"  :active="request()->is('dashboard/perpustakaan/transaksi')">Transaksi</x-sidebar-dropdown-list-link>
                        </li> -->
                    <!-- <li>
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
                        </li> -->
                    </x-sidebar-dropdown-list>
                    </li>
                </ul>

                {{-- Sidebar Footer --}}
                <!-- <div class="pt-5">
                    <x-sidebar-link href="{{ route('beranda.home') }}">
                        <x-sidebar-icon>
                            <svg class="w-[14px] h-[14px] text-gray-500 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </x-sidebar-icon>
                        <span class="ml-3" sidebar-toggle-item>Kembali ke Beranda</span>
                    </x-sidebar-link>
                    <x-sidebar-link href="{{ route('staff_perpus.profile') }}" :active="request()->is('staff_perpus/profile')">
                        <x-sidebar-icon>
                            <svg class="w-[14px] h-[14px] text-gray-500 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M4 4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H4Zm10 5a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm0 3a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm0 3a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm-8-5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm1.942 4a3 3 0 0 0-2.847 2.051l-.044.133-.004.012c-.042.126-.055.167-.042.195.006.013.02.023.038.039.032.025.08.064.146.155A1 1 0 0 0 6 17h6a1 1 0 0 0 .811-.415.713.713 0 0 1 .146-.155c.019-.016.031-.026.038-.04.014-.027 0-.068-.042-.194l-.004-.012-.044-.133A3 3 0 0 0 10.059 14H7.942Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </x-sidebar-icon>
                        <span class="ml-3" sidebar-toggle-item>My Profile</span>
                    </x-sidebar-link>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        @method('POST')
                        <x-sidebar-link href="javascript:void(0)" onclick="this.closest('form').submit();">
                            <x-sidebar-icon>
                                <svg class="w-[14px] h-[14px] text-gray-500 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14 19V5h4a1 1 0 0 1 1 1v11h1a1 1 0 0 1 0 2h-6Z" />
                                    <path fill-rule="evenodd"
                                        d="M12 4.571a1 1 0 0 0-1.275-.961l-5 1.428A1 1 0 0 0 5 6v11H4a1 1 0 0 0 0 2h1.86l4.865 1.39A1 1 0 0 0 12 19.43V4.57ZM10 11a1 1 0 0 1 1 1v.5a1 1 0 0 1-2 0V12a1 1 0 0 1 1-1Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </x-sidebar-icon>
                            <span class="ml-3" sidebar-toggle-item>Log Out</span>
                        </x-sidebar-link>
                    </form>
                </div> -->
            </div>
        </div>
    </div>
</aside>
