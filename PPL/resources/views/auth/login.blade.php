<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Masuk - {{ config('app.name', 'SST SMPN 2 Kamal') }}</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/beranda/logo.png') }}" type="image/png">

    <!-- Scripts & Styles via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-slate-800 bg-slate-50 selection:bg-brand-500 selection:text-white">

    <div class="min-h-screen flex flex-col lg:flex-row">
        <!-- Left Showcase Panel (Visible on Desktop lg+) -->
        <aside class="relative hidden lg:flex lg:w-1/2 xl:w-5/12 flex-col justify-between p-10 xl:p-14 bg-slate-950 text-white overflow-hidden select-none">
            <!-- Background Photography with Institutional Gradient Overlay -->
            <div class="absolute inset-0 bg-cover bg-center z-0 scale-105 transform transition duration-1000" style="background-image: url('{{ asset('images/background-login.webp') }}');"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/95 via-brand-950/90 to-slate-900/80 z-10 backdrop-blur-[2px]"></div>

            <!-- Top Showcase Header -->
            <div class="relative z-20 flex items-center justify-between">
                <div class="flex items-center gap-3.5">
                    <img src="{{ asset('images/beranda/logo.png') }}" alt="Logo SMPN 2 Kamal" class="h-12 w-auto object-contain bg-white/10 backdrop-blur-md p-1.5 rounded-xl border border-white/20 shadow-sm">
                    <div>
                        <div class="text-base font-bold tracking-tight text-white leading-tight">SMP NEGERI 2 KAMAL</div>
                        <div class="text-xs font-medium text-brand-300 tracking-wider uppercase">Sistem Sekolah Terintegrasi</div>
                    </div>
                </div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-[11px] font-medium text-sky-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Portal v2.0</span>
                </div>
            </div>

            <!-- Middle Value Proposition -->
            <div class="relative z-20 space-y-8 my-auto py-8">
                <div class="space-y-3">
                    <span class="inline-block text-xs font-semibold uppercase tracking-wider text-brand-300">
                        Platform Digital Terpadu
                    </span>
                    <h1 class="text-3xl xl:text-4xl font-extrabold tracking-tight text-white leading-snug">
                        Mendukung Ekosistem Pendidikan yang Modern, Cerdas, dan Berintegritas.
                    </h1>
                    <p class="text-sm xl:text-base text-slate-300 leading-relaxed max-w-lg">
                        Satu pintu masuk untuk seluruh aktivitas akademik: pembelajaran daring, presensi terverifikasi, sirkulasi buku perpustakaan, hingga rekapitulasi penilaian.
                    </p>
                </div>

                <!-- Feature Badges List -->
                <div class="space-y-3.5 max-w-md pt-2">
                    <div class="flex items-start gap-3.5 p-3 rounded-xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-colors">
                        <div class="w-8 h-8 rounded-lg bg-brand-500/20 border border-brand-400/30 flex items-center justify-center text-brand-300 flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div class="text-xs">
                            <strong class="text-white font-semibold block text-sm mb-0.5">LMS & CBT Terpadu</strong>
                            <span class="text-slate-300">Materi ajar digital, pengumpulan tugas daring, dan evaluasi ujian terstruktur.</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3.5 p-3 rounded-xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-colors">
                        <div class="w-8 h-8 rounded-lg bg-brand-500/20 border border-brand-400/30 flex items-center justify-center text-brand-300 flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                            </svg>
                        </div>
                        <div class="text-xs">
                            <strong class="text-white font-semibold block text-sm mb-0.5">Presensi QR Code Otentik</strong>
                            <span class="text-slate-300">Pencatatan kehadiran presisi dengan enkripsi berbasis sesi pembelajaran.</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3.5 p-3 rounded-xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-colors">
                        <div class="w-8 h-8 rounded-lg bg-brand-500/20 border border-brand-400/30 flex items-center justify-center text-brand-300 flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div class="text-xs">
                            <strong class="text-white font-semibold block text-sm mb-0.5">Akses Multi-Peran Aman</strong>
                            <span class="text-slate-300">Hak akses terisolasi untuk Siswa, Guru, Tenaga Kependidikan, & Superadmin.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Showcase Footer -->
            <div class="relative z-20 pt-6 border-t border-white/10 flex items-center justify-between text-xs text-slate-400">
                <span>NPSN: 20528253 • Akreditasi A</span>
                <span>&copy; {{ date('Y') }} SMPN 2 Kamal</span>
            </div>
        </aside>

        <!-- Right Authentication Form Panel -->
        <main class="w-full lg:w-1/2 xl:w-7/12 min-h-screen flex flex-col justify-between py-6 px-4 sm:px-8 md:px-12 lg:px-14 xl:px-20 overflow-y-auto bg-slate-50">
            <!-- Top Navigation Bar -->
            <header class="flex items-center justify-between w-full max-w-lg mx-auto">
                <a href="{{ route('beranda.home') }}" class="inline-flex items-center gap-2 text-xs sm:text-sm font-semibold text-slate-600 hover:text-brand-700 transition-colors group py-2">
                    <svg class="w-4 h-4 text-slate-400 group-hover:-translate-x-1 group-hover:text-brand-700 transition-all duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Kembali ke Beranda</span>
                </a>

                <!-- Mobile Brand Emblem (Only shown on < lg) -->
                <div class="flex items-center gap-2 lg:hidden">
                    <img src="{{ asset('images/beranda/logo.png') }}" alt="Logo" class="h-8 w-auto">
                    <span class="text-xs font-bold text-slate-900">SMPN 2 KAMAL</span>
                </div>
            </header>

            <!-- Authentication Card Container -->
            <div class="w-full max-w-lg mx-auto my-auto py-6 sm:py-10">
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm p-6 sm:p-9 space-y-6">

                    <!-- Header Titles -->
                    <div class="space-y-1.5 text-left">
                        <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">
                            Masuk ke Akun
                        </h2>
                        <p class="text-sm text-slate-500 leading-relaxed">
                            Masukkan kredensial sekolah Anda untuk mengakses modul sistem.
                        </p>
                    </div>

                    <!-- Flash Notification: Status -->
                    @if (session('status'))
                        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200/80 text-emerald-800 text-xs flex items-start gap-3">
                            <svg class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="leading-relaxed">{{ session('status') }}</span>
                        </div>
                    @endif

                    <!-- Flash Notification: Error -->
                    @if (session('error'))
                        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200/80 text-rose-800 text-xs flex items-start gap-3">
                            <svg class="w-5 h-5 text-rose-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="leading-relaxed">{{ session('error') }}</span>
                        </div>
                    @endif

                    <!-- Role Guidance Notice -->
                    <div class="p-3.5 rounded-xl bg-brand-50 border border-brand-200/70 text-brand-900 text-xs flex items-start gap-3 leading-relaxed">
                        <svg class="w-4 h-4 text-brand-700 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <span class="font-semibold text-brand-950">Petunjuk Identitas Akun:</span><br>
                            Gunakan <strong class="font-semibold text-brand-950">NISN</strong> untuk Siswa, <strong class="font-semibold text-brand-950">NIP</strong> untuk Guru, atau <strong class="font-semibold text-brand-950">Username</strong> untuk Tenaga Kependidikan & Administrator.
                        </div>
                    </div>

                    <!-- Main Login Form -->
                    <form method="POST" action="{{ route('login') }}" class="space-y-4" novalidate>
                        @csrf
                        <input type="hidden" name="redirect" value="{{ request()->query('redirect') }}">

                        <!-- Username / NIP / NISN -->
                        <div class="space-y-1.5">
                            <label for="username" class="block text-xs font-semibold uppercase tracking-wider text-slate-700">
                                Username / NIP / NISN
                            </label>
                            <div class="relative rounded-xl shadow-xs">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <input
                                    type="text"
                                    id="username"
                                    name="username"
                                    value="{{ old('username') }}"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    placeholder="Masukkan NISN, NIP, atau username"
                                    class="w-full pl-10 pr-4 py-2.5 sm:py-3 text-sm bg-white border @error('username') border-rose-400 ring-2 ring-rose-100 @else border-slate-300 focus:border-brand-600 focus:ring-4 focus:ring-brand-500/10 @enderror rounded-xl text-slate-900 placeholder-slate-400 transition-all outline-none"
                                >
                            </div>
                            @error('username')
                                <p class="text-xs text-rose-600 flex items-center gap-1.5 mt-1 font-medium">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- Password with Alpine.js Toggle -->
                        <div class="space-y-1.5" x-data="{ showPassword: false }">
                            <div class="flex items-center justify-between">
                                <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-700">
                                    Kata Sandi
                                </label>
                            </div>
                            <div class="relative rounded-xl shadow-xs">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <input
                                    :type="showPassword ? 'text' : 'password'"
                                    id="password"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="Masukkan kata sandi"
                                    class="w-full pl-10 pr-11 py-2.5 sm:py-3 text-sm bg-white border @error('password') border-rose-400 ring-2 ring-rose-100 @else border-slate-300 focus:border-brand-600 focus:ring-4 focus:ring-brand-500/10 @enderror rounded-xl text-slate-900 placeholder-slate-400 transition-all outline-none"
                                >
                                <button
                                    type="button"
                                    @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none focus:text-brand-600 cursor-pointer"
                                    aria-label="Tampilkan atau sembunyikan kata sandi"
                                    tabindex="-1"
                                >
                                    <!-- Eye icon -->
                                    <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <!-- Eye-off icon -->
                                    <svg x-show="showPassword" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-xs text-rose-600 flex items-center gap-1.5 mt-1 font-medium">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button
                                type="submit"
                                class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-brand-600 hover:bg-brand-700 active:bg-brand-800 text-white text-sm font-semibold shadow-sm hover:shadow transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-brand-500/20 cursor-pointer"
                            >
                                <span>Masuk ke Sistem</span>
                                <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </button>
                        </div>
                    </form>

                    <!-- Divider -->
                    <div class="relative py-1">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-slate-200"></div>
                        </div>
                        <div class="relative flex justify-center text-xs uppercase">
                            <span class="bg-white px-3 text-slate-400 font-medium">atau masuk dengan</span>
                        </div>
                    </div>

                    <!-- Google SSO Button -->
                    <div>
                        <a
                            href="{{ route('auth.redirect') }}"
                            class="w-full flex items-center justify-center gap-3 py-2.5 sm:py-3 px-4 bg-white hover:bg-slate-50 active:bg-slate-100 border border-slate-300 hover:border-slate-400 rounded-xl text-sm font-medium text-slate-700 shadow-xs focus:outline-none focus:ring-4 focus:ring-slate-100 transition-all duration-150"
                        >
                            <svg class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"></path>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"></path>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"></path>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"></path>
                            </svg>
                            <span>Akun Google Sekolah</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer Support Info -->
            <footer class="text-center text-xs text-slate-400 py-3">
                Lupa sandi atau kendala akun? Hubungi <span class="text-slate-600 font-semibold">Administrator Sekolah</span>.
            </footer>
        </main>
    </div>

</body>
</html>
