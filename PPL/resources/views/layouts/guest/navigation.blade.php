<header x-data="{ mobileMenuOpen: false }" class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200/80 transition">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Brand Identity -->
            <a href="{{ route('beranda.home') }}" class="flex items-center gap-3 group focus:outline-none">
                <img src="{{ asset('images/logo.png') }}" alt="Logo SMPN 2 Kamal" class="h-12 w-auto object-contain transition-transform group-hover:scale-105">
                <div class="flex flex-col">
                    <span class="text-base font-bold tracking-tight text-slate-900 group-hover:text-brand-800 transition-colors">SMPN 2 KAMAL</span>
                    <span class="text-[11px] font-medium text-slate-500 tracking-wider uppercase">Sistem Sekolah Terintegrasi</span>
                </div>
            </a>

            <!-- Desktop Nav Links -->
            <nav class="hidden md:flex items-center gap-1 lg:gap-2">
                <a href="{{ route('beranda.home') }}"
                   class="px-3.5 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('beranda.home') ? 'text-brand-800 bg-brand-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                    Beranda
                </a>
                <a href="{{ route('beranda.perpustakaan') }}"
                   class="px-3.5 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('beranda.perpustakaan*') ? 'text-brand-800 bg-brand-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                    Perpustakaan
                </a>
                <a href="{{ route('beranda.guru') }}"
                   class="px-3.5 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('beranda.guru*') || request()->routeIs('beranda.tenagaPengajarPublik*') ? 'text-brand-800 bg-brand-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                    Tenaga Pengajar
                </a>
                <a href="{{ route('ekstrakurikuler.index') }}"
                   class="px-3.5 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('ekstrakurikuler.*') ? 'text-brand-800 bg-brand-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                    Ekstrakurikuler
                </a>
                <a href="{{ route('beranda.prestasi') }}"
                   class="px-3.5 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('beranda.prestasi*') ? 'text-brand-800 bg-brand-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                    Prestasi
                </a>
            </nav>

            <!-- User Status / Login Action -->
            <div class="hidden md:flex items-center gap-3">
                @php
                    $isLoggedIn = auth()->guard('web')->check()
                        || auth()->guard('web-siswa')->check()
                        || auth()->guard('web-guru')->check()
                        || auth()->guard('web-staffakademik')->check()
                        || auth()->guard('web-staffperpus')->check()
                        || auth()->guard('web-superadmin')->check();

                    $dashboardRoute = route('login');
                    $displayName = 'Pengguna';

                    if (auth()->guard('web-siswa')->check()) {
                        $dashboardRoute = route('siswa.dashboard');
                        $displayName = auth()->guard('web-siswa')->user()->nama_siswa ?? 'Siswa';
                    } elseif (auth()->guard('web-guru')->check()) {
                        $dashboardRoute = route('guru.dashboard');
                        $displayName = auth()->guard('web-guru')->user()->nama_guru ?? 'Guru';
                    } elseif (auth()->guard('web-staffakademik')->check()) {
                        $dashboardRoute = route('staff_akademik.dashboard');
                        $displayName = auth()->guard('web-staffakademik')->user()->nama_staff_akademik ?? 'Staff';
                    } elseif (auth()->guard('web-staffperpus')->check()) {
                        $dashboardRoute = route('staff_perpus.dashboard');
                        $displayName = auth()->guard('web-staffperpus')->user()->nama_staff_perpustakaan ?? 'Pustakawan';
                    } elseif (auth()->guard('web-superadmin')->check()) {
                        $dashboardRoute = route('superadmin.dashboard');
                        $displayName = auth()->guard('web-superadmin')->user()->nama_superadmin ?? 'Superadmin';
                    }
                @endphp

                @if($isLoggedIn)
                    <div class="flex items-center gap-2">
                        <x-ui.button href="{{ $dashboardRoute }}" variant="primary" size="sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span>Dashboard ({{ Str::limit($displayName, 12) }})</span>
                        </x-ui.button>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <x-ui.button type="submit" variant="ghost" size="sm" title="Keluar">
                                <svg class="w-4 h-4 text-slate-500 hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            </x-ui.button>
                        </form>
                    </div>
                @else
                    <x-ui.button href="{{ route('login') }}" variant="primary" size="sm">
                        <span>Masuk Sistem</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                    </x-ui.button>
                @endif
            </div>

            <!-- Mobile Menu Toggle Button -->
            <div class="flex md:hidden items-center">
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                        type="button"
                        class="p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-brand-700"
                        aria-label="Toggle Menu">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer Menu -->
        <div x-show="mobileMenuOpen"
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden py-4 border-t border-slate-200/80 space-y-1">
            <a href="{{ route('beranda.home') }}"
               class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('beranda.home') ? 'bg-brand-50 text-brand-800' : 'text-slate-700 hover:bg-slate-100' }}">
                Beranda
            </a>
            <a href="{{ route('beranda.perpustakaan') }}"
               class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('beranda.perpustakaan*') ? 'bg-brand-50 text-brand-800' : 'text-slate-700 hover:bg-slate-100' }}">
                Perpustakaan
            </a>
            <a href="{{ route('beranda.guru') }}"
               class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('beranda.guru*') || request()->routeIs('beranda.tenagaPengajarPublik*') ? 'bg-brand-50 text-brand-800' : 'text-slate-700 hover:bg-slate-100' }}">
                Tenaga Pengajar
            </a>
            <a href="{{ route('ekstrakurikuler.index') }}"
               class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('ekstrakurikuler.*') ? 'bg-brand-50 text-brand-800' : 'text-slate-700 hover:bg-slate-100' }}">
                Ekstrakurikuler
            </a>
            <a href="{{ route('beranda.prestasi') }}"
               class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('beranda.prestasi*') ? 'bg-brand-50 text-brand-800' : 'text-slate-700 hover:bg-slate-100' }}">
                Prestasi
            </a>

            <div class="pt-4 border-t border-slate-200">
                @if($isLoggedIn)
                    <a href="{{ $dashboardRoute }}" class="block w-full text-center px-4 py-2.5 bg-brand-800 text-white font-medium rounded-lg shadow-sm">
                        Ke Dashboard ({{ $displayName }})
                    </a>
                @else
                    <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2.5 bg-brand-800 text-white font-medium rounded-lg shadow-sm">
                        Masuk Sistem
                    </a>
                @endif
            </div>
        </div>
    </div>
</header>
