<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Masuk - {{ config('app.name', 'SST SMPN 2 Kamal') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/SST-Icon-Black.png') }}" type="image/x-icon">

    <!-- Scripts & Styles via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-slate-800 bg-slate-50 selection:bg-sky-500 selection:text-white">

    <div class="min-h-screen flex flex-col lg:flex-row">
        <!-- Left Column: Institutional Showcase (Desktop Only) -->
        <div class="relative hidden lg:flex lg:w-1/2 xl:w-5/12 flex-col justify-between p-12 bg-slate-900 text-white overflow-hidden">
            <!-- Background Image with Clean Navy Gradient Overlay -->
            <div class="absolute inset-0 bg-cover bg-center z-0" style="background-image: url('{{ asset('images/background-login.webp') }}');"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/95 via-sky-950/85 to-slate-900/70 z-10 backdrop-blur-[1px]"></div>

            <!-- Top Header in Showcase -->
            <div class="relative z-20">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-medium text-sky-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Sistem Sekolah Terintegrasi (SST)
                </div>
            </div>

            <!-- Middle Content: Value Proposition -->
            <div class="relative z-20 space-y-6 my-auto py-8">
                <div>
                    <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                        SMP Negeri 2 Kamal
                    </h2>
                    <p class="mt-3 text-base text-slate-300 leading-relaxed max-w-md">
                        Platform digital satu pintu untuk tata kelola akademik, presensi real-time, perpustakaan, dan pembelajaran terpadu.
                    </p>
                </div>

                <!-- Feature Pillars Checklist -->
                <div class="space-y-3 pt-2">
                    <div class="flex items-center gap-3 text-sm text-slate-200">
                        <div class="w-6 h-6 rounded-md bg-sky-500/20 border border-sky-400/30 flex items-center justify-center text-sky-300 flex-shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span>Akses materi & tugas pembelajaran (LMS & CBT)</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-slate-200">
                        <div class="w-6 h-6 rounded-md bg-sky-500/20 border border-sky-400/30 flex items-center justify-center text-sky-300 flex-shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span>Presensi QR Code terenkripsi & validasi instan</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-slate-200">
                        <div class="w-6 h-6 rounded-md bg-sky-500/20 border border-sky-400/30 flex items-center justify-center text-sky-300 flex-shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span>Katalog sirkulasi perpustakaan & e-rapor siswa</span>
                    </div>
                </div>
            </div>

            <!-- Bottom Footer in Showcase -->
            <div class="relative z-20 pt-6 border-t border-white/10 text-xs text-slate-400 flex items-center justify-between">
                <span>Akreditasi A • Bangkalan, Madura</span>
                <span>&copy; {{ date('Y') }} SMPN 2 Kamal</span>
            </div>
        </div>

        <!-- Right Column: Authentication Form -->
        <div class="w-full lg:w-1/2 xl:w-7/12 flex flex-col justify-between p-6 sm:p-10 lg:p-14 min-h-screen bg-slate-50">
            <!-- Top Navigation (Back to Home) -->
            <div class="flex items-center justify-between">
                <a href="{{ route('beranda.home') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-sky-700 transition-colors group">
                    <svg class="w-4 h-4 text-slate-400 group-hover:-translate-x-0.5 group-hover:text-sky-700 transition-all" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>

            <!-- Form Card Wrapper -->
            <div class="w-full max-w-md mx-auto my-auto py-8">
                <!-- Mobile Logo Header (Visible on small screens) -->
                <div class="mb-6 lg:hidden">
                    <img src="{{ asset('images/SST-Logo.webp') }}" alt="SST Logo" class="h-11 w-auto mb-3">
                </div>

                <!-- Header Title -->
                <div class="space-y-1 mb-6">
                    <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">
                        Selamat Datang
                    </h1>
                    <p class="text-sm text-slate-500">
                        Masuk ke akun Anda untuk mengakses sistem terintegrasi.
                    </p>
                </div>

                <!-- Role Guidance Notice -->
                <div class="p-3.5 mb-6 rounded-xl bg-sky-50/80 border border-sky-200/60 text-xs text-sky-900 flex items-start gap-2.5 leading-relaxed">
                    <svg class="w-4 h-4 text-sky-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        Gunakan <strong class="font-semibold">NISN</strong> untuk Siswa, <strong class="font-semibold">NIP</strong> untuk Guru, atau <strong class="font-semibold">Username</strong> untuk Tenaga Kependidikan & Admin.
                    </div>
                </div>

                <!-- Main Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="redirect" value="{{ request()->query('redirect') }}">

                    <!-- Username / NIP / NISN Input -->
                    <div>
                        <label for="username" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-1.5">
                            Username / NIP / NISN
                        </label>
                        <div class="relative rounded-lg shadow-sm">
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
                                placeholder="Contoh: 19800101... atau 123456..."
                                class="w-full pl-10 pr-3.5 py-2.5 text-sm bg-white border border-slate-300 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-colors @error('username') border-rose-500 ring-rose-200 @enderror"
                            >
                        </div>
                        <x-input-error :messages="$errors->get('username')" class="mt-1.5 text-xs text-rose-600" />
                    </div>

                    <!-- Password Input with Alpine.js Toggle -->
                    <div x-data="{ showPassword: false }">
                        <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-1.5">
                            Kata Sandi
                        </label>
                        <div class="relative rounded-lg shadow-sm">
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
                                placeholder="••••••••"
                                class="w-full pl-10 pr-10 py-2.5 text-sm bg-white border border-slate-300 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-colors @error('password') border-rose-500 ring-rose-200 @enderror"
                            >
                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none"
                                aria-label="Toggle password visibility"
                            >
                                <!-- Eye Open -->
                                <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <!-- Eye Closed -->
                                <svg x-show="showPassword" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-rose-600" />
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button
                            type="submit"
                            class="w-full flex items-center justify-center py-2.5 px-4 rounded-lg bg-sky-700 hover:bg-sky-800 active:bg-sky-900 text-white text-sm font-semibold shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 transition-all duration-150"
                        >
                            <span>Masuk ke Sistem</span>
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </div>
                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs uppercase">
                        <span class="bg-slate-50 px-3 text-slate-400 font-medium">atau lanjutkan dengan</span>
                    </div>
                </div>

                <!-- Google SSO Button -->
                <div>
                    <a
                        href="{{ route('auth.redirect') }}"
                        class="w-full flex items-center justify-center gap-3 py-2.5 px-4 bg-white hover:bg-slate-50 active:bg-slate-100 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 transition-all duration-150"
                    >
                        <svg class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"></path>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"></path>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"></path>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"></path>
                        </svg>
                        <span>Masuk dengan Google</span>
                    </a>
                </div>
            </div>

            <!-- Bottom Support / Copyright -->
            <div class="text-center text-xs text-slate-400 pt-4">
                Lupa sandi atau kendala akun? Hubungi <span class="text-slate-600 font-medium">Administrator Sekolah</span>.
            </div>
        </div>
    </div>

</body>
</html>
