<footer class="bg-slate-900 text-slate-300 pt-12 pb-8 border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            <!-- School Info -->
            <div class="md:col-span-2 space-y-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo SMPN 2 Kamal" class="h-12 w-auto brightness-0 invert">
                    <div>
                        <h4 class="text-white font-bold text-base tracking-tight">SMPN 2 KAMAL</h4>
                        <p class="text-xs text-slate-400">Sistem Sekolah Terintegrasi (SST)</p>
                    </div>
                </div>
                <p class="text-sm text-slate-400 max-w-md leading-relaxed">
                    Lembaga pendidikan formal tingkat menengah pertama yang berdedikasi mencetak insan berkarakter mulia, cerdas, berprestasi, dan tanggap terhadap perkembangan teknologi.
                </p>
                <div class="text-xs text-slate-400 flex items-start gap-2">
                    <svg class="w-4 h-4 text-accent-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>Jl. Raya Telang No.3, Telang Indah, Kec. Kamal, Kab. Bangkalan, Jawa Timur 69162</span>
                </div>
            </div>

            <!-- Portal Links -->
            <div class="space-y-3">
                <h5 class="text-sm font-semibold text-white tracking-wider uppercase">Layanan Publik</h5>
                <ul class="space-y-2 text-sm text-slate-400">
                    <li><a href="{{ route('beranda.home') }}" class="hover:text-white transition">Beranda Utama</a></li>
                    <li><a href="{{ route('beranda.perpustakaan') }}" class="hover:text-white transition">Katalog Perpustakaan</a></li>
                    <li><a href="{{ route('beranda.guru') }}" class="hover:text-white transition">Direktori Guru</a></li>
                    <li><a href="{{ route('ekstrakurikuler.index') }}" class="hover:text-white transition">Kegiatan Ekstrakurikuler</a></li>
                    <li><a href="{{ route('beranda.prestasi') }}" class="hover:text-white transition">Galeri Prestasi</a></li>
                </ul>
            </div>

            <!-- System Links -->
            <div class="space-y-3">
                <h5 class="text-sm font-semibold text-white tracking-wider uppercase">Akses Sistem</h5>
                <ul class="space-y-2 text-sm text-slate-400">
                    <li><a href="{{ route('login') }}" class="hover:text-white transition">Portal Masuk Terpadu</a></li>
                    <li><span class="text-slate-500">LMS Guru & Siswa</span></li>
                    <li><span class="text-slate-500">Sistem CBT / Ujian Online</span></li>
                    <li><span class="text-slate-500">Presensi QR & Akademik</span></li>
                </ul>
            </div>
        </div>

        <div class="pt-8 border-t border-slate-800/80 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
            <p>© {{ date('Y') }} SMPN 2 Kamal. Seluruh hak cipta dilindungi undang-undang.</p>
            <p>Sistem Sekolah Terintegrasi (SST)</p>
        </div>
    </div>
</footer>
