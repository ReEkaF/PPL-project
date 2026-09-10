<aside id="sidebar"
    class="fixed top-0 left-0 z-20 flex flex-col flex-shrink-0 hidden w-64 h-full pt-16 font-normal duration-75 lg:flex transition-width"
    aria-label="Sidebar">
    <div
        class="relative flex flex-col flex-1 min-h-0 pt-0 bg-white border-r border-slate-200">
        <div class="flex flex-col flex-1 pt-5 pb-4 overflow-y-auto">
            <div class="flex-1 px-3 space-y-1 bg-white divide-y divide-slate-100">
                {{-- Sidebar Header --}}
                <ul class="pb-2 space-y-1">

                    {{-- Dashboard --}}
                    @php $isDashboardActive = request()->routeIs('siswa.dashboard') || request()->is('siswa/dashboard'); @endphp
                    <li>
                        <x-sidebar-link href="{{ route('siswa.dashboard') }}" :active="$isDashboardActive">
                            <i class="w-5 text-center shrink-0 text-base transition-colors {{ $isDashboardActive ? 'text-brand-800' : 'text-slate-400 group-hover:text-slate-600' }} fa-solid fa-house"></i>
                            <span class="ml-3" sidebar-toggle-item>Dashboard</span>
                        </x-sidebar-link>
                    </li>

                    {{-- Jadwal --}}
                    @php $isJadwalActive = request()->is('siswa/dashboard/jadwal-pelajaran*') || request()->is('siswa/dashboard/lihat-jadwal*') || request()->is('siswa/jadwal*') || request()->routeIs('lihat-jadwal-siswa', 'siswa.jadwal.*'); @endphp
                    <li>
                        <x-sidebar-link href="{{ route('lihat-jadwal-siswa') }}" :active="$isJadwalActive">
                            <i class="w-5 text-center shrink-0 text-base transition-colors {{ $isJadwalActive ? 'text-brand-800' : 'text-slate-400 group-hover:text-slate-600' }} fa-solid fa-calendar-days"></i>
                            <span class="ml-3" sidebar-toggle-item>Jadwal</span>
                        </x-sidebar-link>
                    </li>

                    {{-- LMS --}}
                    @php $isLmsActive = request()->is('siswa/dashboard/lms*') || request()->routeIs('siswa.lms.*', 'siswa.dashboard.lms*'); @endphp
                    <li>
                        <x-sidebar-dropdown label="LMS" id="lms" :active="$isLmsActive">
                            <i class="w-5 text-center shrink-0 text-base transition-colors {{ $isLmsActive ? 'text-brand-800' : 'text-slate-400 group-hover:text-slate-600' }} fa-solid fa-graduation-cap"></i>
                        </x-sidebar-dropdown>
                        <x-sidebar-dropdown-list id="lms" :active="$isLmsActive">
                            <li>
                                <x-sidebar-dropdown-list-link href="{{ route('siswa.dashboard.lms') }}"
                                    :active="request()->is('siswa/dashboard/lms') || request()->is('siswa/dashboard/lms-siswa') || request()->is('siswa/dashboard/lms/forum*') || request()->is('siswa/dashboard/lms/diskusi-forum*') || request()->routeIs([
                                        'siswa.dashboard.lms',
                                        'siswa.lms.dashboard',
                                        'siswa.dashboard.lms.forum',
                                        'siswa.lms.forum',
                                        'siswa.dashboard.lms.forum.tugas',
                                        'siswa.lms.forum.tugas',
                                        'siswa.dashboard.lms.forum.anggota',
                                        'siswa.lms.forum.anggota',
                                    ])">Beranda</x-sidebar-dropdown-list-link>
                            </li>
                            <li>
                                <x-sidebar-dropdown-list-link href="{{ route('siswa.dashboard.lms.materi') }}"
                                    :active="request()->is('siswa/dashboard/lms/materi*') || request()->is('siswa/dashboard/lms/daftar-materi*') || request()->routeIs('siswa.lms.materi.*', 'siswa.dashboard.lms.materi', 'siswa.dashboard.lms.detail.materi')">Materi</x-sidebar-dropdown-list-link>
                            </li>
                            <li>
                                <x-sidebar-dropdown-list-link href="{{ route('siswa.dashboard.lms.tracking.tugas.ditugaskan') }}"
                                    :active="request()->is('siswa/dashboard/lms/tugas*') || request()->is('siswa/dashboard/lms/daftar-tugas*') || request()->routeIs([
                                        'siswa.dashboard.lms.tracking.tugas.*',
                                        'siswa.lms.tugas.tracking.*',
                                        'siswa.dashboard.lms.tugas*',
                                        'siswa.lms.tugas.*',
                                        'siswa.dashboard.lms.detail.tugas'
                                    ])">Tugas</x-sidebar-dropdown-list-link>
                            </li>
                        </x-sidebar-dropdown-list>
                    </li>

                    {{-- Perpustakaan --}}
                    @php $isPerpusActive = request()->is('siswa/dashboard/perpustakaan*') || request()->is('siswa/dashboard/layanan-perpustakaan*') || request()->routeIs('siswa.perpustakaan.*', 'dashboard.perpustakaan*'); @endphp
                    <li>
                        <x-sidebar-dropdown label="Perpustakaan" id="perpustakaan" :active="$isPerpusActive">
                            <i class="w-5 text-center shrink-0 text-base transition-colors {{ $isPerpusActive ? 'text-brand-800' : 'text-slate-400 group-hover:text-slate-600' }} fa-solid fa-book-open"></i>
                        </x-sidebar-dropdown>
                        <x-sidebar-dropdown-list id="perpustakaan" :active="$isPerpusActive">
                            <li>
                                <x-sidebar-dropdown-list-link href="{{ route('siswa.perpustakaan.index') }}"
                                    :active="request()->is('siswa/dashboard/perpustakaan') || request()->is('siswa/dashboard/layanan-perpustakaan') || request()->is('siswa/dashboard/perpustakaan/detail*') || request()->is('siswa/dashboard/perpustakaan/buku*') || request()->routeIs('siswa.perpustakaan.index', 'dashboard.perpustakaan', 'siswa.perpustakaan.detail', 'siswa.dashboard.perpustakaan.detail')">Beranda</x-sidebar-dropdown-list-link>
                            </li>
                            <li>
                                <x-sidebar-dropdown-list-link href="{{ route('siswa.perpustakaan.riwayat') }}"
                                    :active="request()->is('siswa/dashboard/perpustakaan/riwayat*') || request()->routeIs('siswa.perpustakaan.riwayat')">Transaksi</x-sidebar-dropdown-list-link>
                            </li>
                            <li>
                                <x-sidebar-dropdown-list-link href="{{ route('siswa.perpustakaan.rules') }}"
                                    :active="request()->is('siswa/dashboard/perpustakaan/rules*') || request()->routeIs('siswa.perpustakaan.rules')">Aturan</x-sidebar-dropdown-list-link>
                            </li>
                        </x-sidebar-dropdown-list>
                    </li>

                    {{-- Ekstrakurikuler --}}
                    @php 
                        $isEkstraActive = request()->is('siswa/ekstrakurikuler*') 
                            || request()->is('siswa/pengurus*') 
                            || request()->routeIs('siswa.ekstrakurikuler.*', 'pengurus-ekstra.*', 'pengurus_ekstra.*'); 
                        $isPengurus = auth()->guard('web-siswa')->user()->role_siswa == 'pengurus';
                    @endphp
                    <li>
                        <x-sidebar-dropdown label="Ekstrakurikuler" id="ekstrakurikuler" :active="$isEkstraActive">
                            <i class="w-5 text-center shrink-0 text-base transition-colors {{ $isEkstraActive ? 'text-brand-800' : 'text-slate-400 group-hover:text-slate-600' }} fa-solid fa-users"></i>
                        </x-sidebar-dropdown>
                        <x-sidebar-dropdown-list id="ekstrakurikuler" :active="$isEkstraActive">
                            {{-- Menu untuk Seluruh Siswa --}}
                            <li>
                                <x-sidebar-dropdown-list-link href="{{ route('siswa.ekstrakurikuler.index') }}"
                                    :active="request()->routeIs('siswa.ekstrakurikuler.index', 'siswa.ekstrakurikuler.detail')">Informasi Ekskul</x-sidebar-dropdown-list-link>
                            </li>
                            <li>
                                <x-sidebar-dropdown-list-link href="{{ route('siswa.ekstrakurikuler.saya') }}"
                                    :active="request()->routeIs('siswa.ekstrakurikuler.saya')">Ekskul Saya</x-sidebar-dropdown-list-link>
                            </li>
                            <li>
                                <x-sidebar-dropdown-list-link href="{{ route('siswa.ekstrakurikuler.pendaftaran') }}"
                                    :active="request()->routeIs('siswa.ekstrakurikuler.pendaftaran*')">Pendaftaran</x-sidebar-dropdown-list-link>
                            </li>

                            {{-- Menu Tambahan Khusus Pengurus Ekstrakurikuler --}}
                            @if ($isPengurus)
                            <li class="pt-2 pb-1 px-3">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Panel Pengurus</span>
                            </li>
                            <li>
                                <x-sidebar-dropdown-list-link href="{{ route('pengurus_ekstra.dashboard') }}"
                                    :active="request()->is('siswa/ekstrakurikuler/dashboard*') || request()->is('siswa/pengurus/dashboard*') || request()->routeIs('pengurus_ekstra.dashboard', 'pengurus-ekstra.dashboard')">Kelola Informasi</x-sidebar-dropdown-list-link>
                            </li>
                            <li>
                                <x-sidebar-dropdown-list-link href="{{ route('pengurus_ekstra.anggota') }}"
                                    :active="request()->is('siswa/ekstrakurikuler/anggota*') || request()->is('siswa/pengurus/anggota*') || request()->routeIs('pengurus_ekstra.anggota', 'pengurus-ekstra.anggota.*')">Anggota</x-sidebar-dropdown-list-link>
                            </li>
                            <li>
                                <x-sidebar-dropdown-list-link href="{{ route('pengurus_ekstra.penilaian') }}" :active="request()->is('siswa/ekstrakurikuler/penilaian*') || request()->is('siswa/pengurus/penilaian*') || request()->routeIs('pengurus_ekstra.penilaian', 'pengurus-ekstra.penilaian.*')">Laporan Penilaian</x-sidebar-dropdown-list-link>
                            </li>
                            <li>
                                <x-sidebar-dropdown-list-link href="{{ route('pengurus_ekstra.perlengkapan') }}"
                                    :active="request()->is('siswa/ekstrakurikuler/perlengkapan*') || request()->is('siswa/pengurus/perlengkapan*') || request()->routeIs('pengurus_ekstra.perlengkapan', 'pengurus-ekstra.perlengkapan.*')">Perlengkapan</x-sidebar-dropdown-list-link>
                            </li>
                            @endif
                        </x-sidebar-dropdown-list>
                    </li>

                    {{-- Ujian --}}
                    @php $isUjianActive = request()->is('siswa/dashboard/ujian*') || request()->is('siswa/dashboard/daftar-ujian*') || request()->is('siswa/ujian*') || request()->routeIs('siswa.ujian.*', 'siswa.dashboard.ujian'); @endphp
                    <li>
                        <x-sidebar-link href="{{ route('siswa.ujian.index') }}" :active="$isUjianActive">
                            <i class="w-5 text-center shrink-0 text-base transition-colors {{ $isUjianActive ? 'text-brand-800' : 'text-slate-400 group-hover:text-slate-600' }} fa-solid fa-file-pen"></i>
                            <span class="ml-3" sidebar-toggle-item>Ujian</span>
                        </x-sidebar-link>
                    </li>
                </ul>

                {{-- Sidebar Footer --}}
                <div class="pt-2 space-y-2">
                    @php $isNotifActive = request()->is('siswa/notifikasi*') || request()->routeIs('siswa.notifikasi*'); @endphp
                    <x-sidebar-link href="{{ route('siswa.notifikasi') }}" :active="$isNotifActive">
                        <i class="w-5 text-center shrink-0 text-base transition-colors {{ $isNotifActive ? 'text-brand-800' : 'text-slate-400 group-hover:text-slate-600' }} fa-solid fa-bell"></i>
                        <span class="ml-3" sidebar-toggle-item>Notifikasi</span>
                        <span class="inline-flex items-center justify-center px-2 py-1 ml-3 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
                            {{ session('notifikasi_count', 0) }}
                        </span>
                    </x-sidebar-link>

                    @php $isAbsensiActive = request()->is('siswa/absensi*') || request()->routeIs('siswa.absensi.*'); @endphp
                    <x-sidebar-link href="{{ route('siswa.absensi.index') }}" :active="$isAbsensiActive">
                        <i class="w-5 text-center shrink-0 text-base transition-colors {{ $isAbsensiActive ? 'text-brand-800' : 'text-slate-400 group-hover:text-slate-600' }} fa-solid fa-calendar-check"></i>
                        <span class="ml-3" sidebar-toggle-item>Absensi</span>
                    </x-sidebar-link>
                </div>
            </div>
        </div>
    </div>
</aside>
