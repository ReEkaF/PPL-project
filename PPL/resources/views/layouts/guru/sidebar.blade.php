<aside id="sidebar"
    class="fixed top-0 left-0 z-20 flex flex-col flex-shrink-0 hidden w-64 h-full pt-16 font-normal duration-75 lg:flex transition-width"
    aria-label="Sidebar">
    <div class="relative flex flex-col flex-1 min-h-0 pt-0 bg-white border-r border-slate-200">
        <div class="flex flex-col flex-1 pt-5 pb-4 overflow-y-auto">
            <div class="flex-1 px-3 space-y-1 bg-white divide-y divide-slate-100">
                <ul class="pb-2 space-y-1">

                    {{-- Dashboard --}}
                    @php $isDashboardActive = request()->routeIs('guru.dashboard') || request()->is('guru/dashboard'); @endphp
                    <li>
                        <x-sidebar-link href="{{ route('guru.dashboard') }}" :active="$isDashboardActive">
                            <i class="w-5 text-center shrink-0 text-base transition-colors {{ $isDashboardActive ? 'text-brand-800' : 'text-slate-400 group-hover:text-slate-600' }} fa-solid fa-house"></i>
                            <span class="ml-3" sidebar-toggle-item>Dashboard</span>
                        </x-sidebar-link>
                    </li>

                    {{-- Jadwal Mengajar --}}
                    @php $isJadwalActive = request()->is('guru/dashboard/lihat-jadwal*') || request()->routeIs('lihat-jadwal-guru'); @endphp
                    <li>
                        <x-sidebar-link href="{{ route('lihat-jadwal-guru') }}" :active="$isJadwalActive">
                            <i class="w-5 text-center shrink-0 text-base transition-colors {{ $isJadwalActive ? 'text-brand-800' : 'text-slate-400 group-hover:text-slate-600' }} fa-solid fa-calendar-days"></i>
                            <span class="ml-3" sidebar-toggle-item>Jadwal Mengajar</span>
                        </x-sidebar-link>
                    </li>

                    {{-- LMS Guru --}}
                    @php $isLmsActive = request()->is('guru/dashboard/lms*') || request()->routeIs('guru.dashboard.lms*', 'guru.lms.*'); @endphp
                    <li>
                        <x-sidebar-dropdown label="LMS" id="lms" :active="$isLmsActive">
                            <i class="w-5 text-center shrink-0 text-base transition-colors {{ $isLmsActive ? 'text-brand-800' : 'text-slate-400 group-hover:text-slate-600' }} fa-solid fa-graduation-cap"></i>
                        </x-sidebar-dropdown>
                        <x-sidebar-dropdown-list id="lms" :active="$isLmsActive">
                            <li>
                                <x-sidebar-dropdown-list-link href="{{ route('guru.dashboard.lms') }}" :active="request()->routeIs([
                                    'guru.dashboard.lms',
                                    'guru.dashboard.lms.forum',
                                    'guru.dashboard.lms.forum.tugas',
                                    'guru.dashboard.lms.forum.anggota',
                                ])">Beranda LMS</x-sidebar-dropdown-list-link>
                            </li>
                            <li>
                                <x-sidebar-dropdown-list-link href="{{ route('guru.dashboard.lms.materi') }}" :active="request()->is('guru/dashboard/lms/materi*')">Materi</x-sidebar-dropdown-list-link>
                            </li>
                            <li>
                                <x-sidebar-dropdown-list-link href="{{ route('guru.dashboard.lms.tugas.periksa') }}" :active="request()->is('guru/dashboard/lms/tugas*')">Tugas & Nilai</x-sidebar-dropdown-list-link>
                            </li>
                        </x-sidebar-dropdown-list>
                    </li>

                    {{-- Wali Kelas (Khusus Guru yang Menjadi Wali Kelas) --}}
                    @if (auth()->guard('web-guru')->user() && auth()->guard('web-guru')->user()->kelas()->exists())
                        @php $isWaliActive = request()->is('guru/kelas*') || request()->routeIs('guru.daftarSiswaWali', 'guru.wali-kelas.*'); @endphp
                        <li>
                            <x-sidebar-link href="{{ route('guru.daftarSiswaWali') }}" :active="$isWaliActive">
                                <i class="w-5 text-center shrink-0 text-base transition-colors {{ $isWaliActive ? 'text-brand-800' : 'text-slate-400 group-hover:text-slate-600' }} fa-solid fa-user-shield"></i>
                                <span class="ml-3" sidebar-toggle-item>Wali Kelas</span>
                            </x-sidebar-link>
                        </li>
                    @endif

                    {{-- Absensi / Presensi --}}
                    @php $isAbsensiActive = request()->is('guru/absensi*') || request()->routeIs('guru.absensi.*'); @endphp
                    <li>
                        <x-sidebar-link href="{{ route('guru.absensi.index') }}" :active="$isAbsensiActive">
                            <i class="w-5 text-center shrink-0 text-base transition-colors {{ $isAbsensiActive ? 'text-brand-800' : 'text-slate-400 group-hover:text-slate-600' }} fa-solid fa-clipboard-user"></i>
                            <span class="ml-3" sidebar-toggle-item>Presensi Siswa</span>
                        </x-sidebar-link>
                    </li>

                    {{-- Ujian / CBT --}}
                    @php $isUjianActive = request()->is('guru/dashboard/ujian*') || request()->routeIs('ujian.*', 'guru.dashboard.ujian.*', 'guru.ujian.*'); @endphp
                    <li>
                        <x-sidebar-link href="{{ route('ujian.show') }}" :active="$isUjianActive">
                            <i class="w-5 text-center shrink-0 text-base transition-colors {{ $isUjianActive ? 'text-brand-800' : 'text-slate-400 group-hover:text-slate-600' }} fa-solid fa-file-signature"></i>
                            <span class="ml-3" sidebar-toggle-item>Ujian / CBT</span>
                        </x-sidebar-link>
                    </li>

                    {{-- Ekstrakurikuler (Khusus Guru Pembina) --}}
                    @php
                        $userGuru = auth()->guard('web-guru')->user();
                        $isPembina = $userGuru && ($userGuru->role_guru === 'pembina' || $userGuru->ekstrakurikuler()->exists());
                    @endphp
                    @if ($isPembina)
                    @php
                        $isEkstraActive = request()->is('guru/pembina*') || request()->is('*pembina*') || request()->routeIs('pembina.*', 'pembina-ekstra.*');
                    @endphp
                    <li>
                        <x-sidebar-link href="{{ route('pembina.index') }}" :active="$isEkstraActive">
                            <i class="w-5 text-center shrink-0 text-base transition-colors {{ $isEkstraActive ? 'text-brand-800' : 'text-slate-400 group-hover:text-slate-600' }} fa-solid fa-people-group"></i>
                            <span class="ml-3" sidebar-toggle-item>Ekstrakurikuler</span>
                        </x-sidebar-link>
                    </li>
                    @endif

                </ul>
            </div>
        </div>
    </div>
</aside>