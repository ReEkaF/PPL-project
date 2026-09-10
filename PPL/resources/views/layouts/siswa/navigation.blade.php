{{-- Siswa Navigation --}}
<nav class="fixed z-30 w-full bg-white/95 backdrop-blur-md border-b border-slate-200/80">
    <div class="px-4 lg:px-6">
        <div class="flex items-center justify-between h-16">
            {{-- Nav Left --}}
            <div class="flex items-center gap-3">
                {{-- Toggle Sidebar Mobile --}}
                <button id="toggleSidebarMobile" aria-expanded="true" aria-controls="sidebar"
                    class="p-2 text-slate-500 rounded-lg cursor-pointer lg:hidden hover:text-slate-900 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-slate-200 transition">
                    <svg id="toggleSidebarMobileHamburger" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg id="toggleSidebarMobileClose" class="hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                {{-- Logo --}}
                <a href="{{ route('beranda.home') }}" class="flex items-center gap-2.5 group focus:outline-none">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo SMPN 2 Kamal" class="h-9 w-auto object-contain transition-transform group-hover:scale-105">
                    <div class="hidden sm:flex flex-col">
                        <span class="text-sm font-bold tracking-tight text-slate-900 group-hover:text-brand-800 transition-colors">SMPN 2 KAMAL</span>
                        <span class="text-[10px] font-medium text-slate-400 tracking-wider uppercase">Portal Siswa</span>
                    </div>
                </a>
            </div>

            {{-- Nav Right --}}
            <div class="flex items-center gap-3">
                {{-- User Info --}}
                <div class="hidden lg:flex flex-col items-end">
                    <span class="text-sm font-semibold text-slate-700">{{auth()->guard('web-siswa')->user()->nama_siswa}}</span>
                    <span class="text-xs text-slate-400">Siswa</span>
                </div>

                {{-- Profile Menu --}}
                <div class="relative flex items-center" x-data="{ open: false }">
                    <button @click="open = !open" type="button"
                        class="flex overflow-hidden w-9 h-9 rounded-full border-2 border-slate-200 hover:border-brand-400 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2 transition"
                        aria-expanded="false">
                        <img class="w-full h-full object-cover"
                            src="{{ auth()->guard('web-siswa')->user()->foto_siswa
                                     ? asset('images/siswa/' . auth()->guard('web-siswa')->user()->foto_siswa)
                                     : 'https://cdn.pixabay.com/photo/2018/11/13/21/43/avatar-3814049_640.png' }}"
                            alt="Foto siswa">
                    </button>

                    <div x-show="open" @click.away="open = false" x-cloak
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 top-12 w-56 bg-white border border-slate-200 rounded-xl shadow-lg z-50 overflow-hidden">
                        <div class="px-4 py-3 border-b border-slate-100">
                            <p class="text-sm font-semibold text-slate-800">{{auth()->guard('web-siswa')->user()->nama_siswa}}</p>
                            <p class="text-xs text-slate-500 truncate">{{auth()->guard('web-siswa')->user()->email}}</p>
                        </div>
                        <ul class="py-1">
                            <li>
                                <a href="{{ route('siswaprofil.update') }}"
                                    class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Profil Saya
                                </a>
                            </li>
                            <li class="border-t border-slate-100 mt-1 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center gap-2 w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
