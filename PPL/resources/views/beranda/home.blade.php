<x-guest-layout>
    <!-- Hero / Institutional Identity Section -->
    <section class="relative bg-slate-900 text-white overflow-hidden border-b border-slate-800">
        <!-- Subtle Institutional Backdrop -->
        <div class="absolute inset-0 opacity-20 bg-cover bg-center" style="background-image: url('{{ asset('images/beranda/sekolah2.jpg') }}');"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-900/95 to-slate-900/80"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Left: Headline & Information -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md bg-brand-900/80 border border-brand-700/60 text-brand-200 text-xs font-semibold tracking-wide">
                        <span class="w-2 h-2 rounded-full bg-accent-500 animate-pulse"></span>
                        Portal Resmi & Sistem Terintegrasi
                    </div>

                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight">
                        Mewujudkan Generasi <span class="text-accent-500">Berkarakter</span>, Berprestasi, dan Berdaya Saing
                    </h1>

                    <p class="text-base sm:text-lg text-slate-300 leading-relaxed max-w-2xl font-normal">
                        SMPN 2 Kamal berkomitmen menyelenggarakan pendidikan berkualitas terpadu yang memadukan pembentukan akhlak mulia, penguasaan ilmu pengetahuan, serta pengembangan minat bakat siswa secara menyeluruh.
                    </p>

                    <div class="flex flex-wrap items-center gap-3 pt-2">
                        <x-ui.button href="{{ route('beranda.perpustakaanPublik') }}" variant="accent" size="lg">
                            <span>Jelajahi Perpustakaan</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </x-ui.button>
                        <x-ui.button href="{{ route('ekstrakurikuler.dashboardEkstra') }}" variant="secondary" size="lg">
                            <span>Daftar Ekstrakurikuler</span>
                        </x-ui.button>
                        <x-ui.button href="{{ route('login') }}" variant="ghost" size="lg" class="text-slate-300 hover:text-white hover:bg-slate-800">
                            <span>Akses Portal Masuk →</span>
                        </x-ui.button>
                    </div>

                    <div class="pt-4 border-t border-slate-800/80 text-xs text-slate-400 flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span>Jl. Raya Telang No.3, Telang Indah, Kamal, Bangkalan, Jawa Timur</span>
                    </div>
                </div>

                <!-- Right: School Metrics Grid -->
                <div class="lg:col-span-5 grid grid-cols-2 gap-4">
                    <div class="bg-slate-800/70 border border-slate-700/80 rounded-xl p-5 backdrop-blur-sm">
                        <div class="text-brand-400 text-xs font-semibold uppercase tracking-wider">Tenaga Pengajar</div>
                        <div class="text-3xl font-extrabold text-white mt-1">{{ $statistics['total_guru'] ?? '—' }}</div>
                        <p class="text-xs text-slate-400 mt-1">Guru & staf berdedikasi</p>
                    </div>

                    <div class="bg-slate-800/70 border border-slate-700/80 rounded-xl p-5 backdrop-blur-sm">
                        <div class="text-brand-400 text-xs font-semibold uppercase tracking-wider">Siswa Terdaftar</div>
                        <div class="text-3xl font-extrabold text-white mt-1">{{ $statistics['total_siswa'] ?? '—' }}</div>
                        <p class="text-xs text-slate-400 mt-1">Peserta didik aktif</p>
                    </div>

                    <div class="bg-slate-800/70 border border-slate-700/80 rounded-xl p-5 backdrop-blur-sm">
                        <div class="text-brand-400 text-xs font-semibold uppercase tracking-wider">Koleksi Buku</div>
                        <div class="text-3xl font-extrabold text-white mt-1">{{ $statistics['total_buku'] ?? '—' }}</div>
                        <p class="text-xs text-slate-400 mt-1">Judul buku perpustakaan</p>
                    </div>

                    <div class="bg-slate-800/70 border border-slate-700/80 rounded-xl p-5 backdrop-blur-sm">
                        <div class="text-brand-400 text-xs font-semibold uppercase tracking-wider">Ekstrakurikuler</div>
                        <div class="text-3xl font-extrabold text-white mt-1">{{ $statistics['total_ekskul'] ?? '—' }}</div>
                        <p class="text-xs text-slate-400 mt-1">Wadah minat & bakat</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Empat Pilar Layanan Sekolah Terintegrasi -->
    <section class="py-16 bg-white border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mb-12">
                <span class="text-xs font-bold uppercase tracking-wider text-brand-700">Pusat Layanan Terpadu</span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1">Fasilitas & Layanan Unggulan Sekolah</h2>
                <p class="text-sm text-slate-600 mt-2">Seluruh ekosistem kegiatan pembelajaran, literasi, bakat, dan prestasi dikelola secara transparan dan terstruktur.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1: Perpustakaan -->
                <div class="bg-slate-50 border border-slate-200/80 rounded-xl overflow-hidden flex flex-col hover:border-brand-300 transition group shadow-sm">
                    <div class="h-44 overflow-hidden relative bg-slate-200">
                        <picture>
                            <source srcset="{{ asset('images/beranda/perpus.webp') }}" type="image/webp">
                            <img src="{{ asset('images/beranda/perpus.jpg') }}" alt="Perpustakaan SMPN 2 Kamal" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                        </picture>
                        <div class="absolute top-3 left-3">
                            <x-ui.badge variant="brand">Literasi</x-ui.badge>
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                        <div>
                            <h3 class="font-bold text-base text-slate-900 group-hover:text-brand-800 transition-colors">Perpustakaan Digital</h3>
                            <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                                Koleksi buku pelajaran, ensiklopedia, referensi ilmiah, serta sistem peminjaman terintegrasi barcode.
                            </p>
                        </div>
                        <x-ui.button href="{{ route('beranda.perpustakaanPublik') }}" variant="outline" size="sm" class="w-full justify-between">
                            <span>Katalog Buku</span>
                            <span>→</span>
                        </x-ui.button>
                    </div>
                </div>

                <!-- Card 2: Tenaga Pengajar -->
                <div class="bg-slate-50 border border-slate-200/80 rounded-xl overflow-hidden flex flex-col hover:border-brand-300 transition group shadow-sm">
                    <div class="h-44 overflow-hidden relative bg-slate-200">
                        <img src="{{ asset('images/beranda/tenaga-kerja.jpg') }}" alt="Tenaga Pengajar SMPN 2 Kamal" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                        <div class="absolute top-3 left-3">
                            <x-ui.badge variant="success">Akademik</x-ui.badge>
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                        <div>
                            <h3 class="font-bold text-base text-slate-900 group-hover:text-brand-800 transition-colors">Tenaga Pendidik</h3>
                            <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                                Dewan guru berkualifikasi, berkompeten di bidang masing-masing, serta membimbing siswa dengan pendekatan humanis.
                            </p>
                        </div>
                        <x-ui.button href="{{ route('beranda.tenagaPengajarPublik') }}" variant="outline" size="sm" class="w-full justify-between">
                            <span>Direktori Guru</span>
                            <span>→</span>
                        </x-ui.button>
                    </div>
                </div>

                <!-- Card 3: Ekstrakurikuler -->
                <div class="bg-slate-50 border border-slate-200/80 rounded-xl overflow-hidden flex flex-col hover:border-brand-300 transition group shadow-sm">
                    <div class="h-44 overflow-hidden relative bg-slate-200">
                        <picture>
                            <source srcset="{{ asset('images/beranda/ekstra.webp') }}" type="image/webp">
                            <img src="{{ asset('images/beranda/ekstra.jpg') }}" alt="Ekstrakurikuler SMPN 2 Kamal" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                        </picture>
                        <div class="absolute top-3 left-3">
                            <x-ui.badge variant="warning">Minat Bakat</x-ui.badge>
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                        <div>
                            <h3 class="font-bold text-base text-slate-900 group-hover:text-brand-800 transition-colors">Ekstrakurikuler</h3>
                            <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                                Pengembangan bakat melalui Pramuka, Paskibra, PMR, Seni Budaya, Olahraga, dan Tahfidz Quran.
                            </p>
                        </div>
                        <x-ui.button href="{{ route('ekstrakurikuler.dashboardEkstra') }}" variant="outline" size="sm" class="w-full justify-between">
                            <span>Info & Daftar</span>
                            <span>→</span>
                        </x-ui.button>
                    </div>
                </div>

                <!-- Card 4: Prestasi -->
                <div class="bg-slate-50 border border-slate-200/80 rounded-xl overflow-hidden flex flex-col hover:border-brand-300 transition group shadow-sm">
                    <div class="h-44 overflow-hidden relative bg-slate-200">
                        <img src="{{ asset('images/beranda/prestasi.jpg') }}" alt="Prestasi SMPN 2 Kamal" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                        <div class="absolute top-3 left-3">
                            <x-ui.badge variant="info">Kejuaraan</x-ui.badge>
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                        <div>
                            <h3 class="font-bold text-base text-slate-900 group-hover:text-brand-800 transition-colors">Galeri Prestasi</h3>
                            <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                                Jejak torehan medali dan penghargaan para siswa di tingkat kabupaten, provinsi, hingga nasional.
                            </p>
                        </div>
                        <x-ui.button href="{{ route('beranda.prestasiPublik') }}" variant="outline" size="sm" class="w-full justify-between">
                            <span>Lihat Prestasi</span>
                            <span>→</span>
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Koleksi Buku Terbaru di Perpustakaan (Jika Ada) -->
    @if(isset($latestBooks) && $latestBooks->count() > 0)
    <section class="py-16 bg-slate-100/60 border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-brand-700">Katalog Terkini</span>
                    <h2 class="text-2xl font-bold text-slate-900 mt-1">Buku Terbaru di Perpustakaan</h2>
                </div>
                <x-ui.button href="{{ route('beranda.perpustakaanPublik') }}" variant="secondary" size="sm">
                    <span>Lihat Seluruh Koleksi →</span>
                </x-ui.button>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                @foreach($latestBooks as $bukuItem)
                <div class="bg-white border border-slate-200/90 rounded-xl p-4 flex flex-col justify-between hover:shadow-md transition">
                    <div class="space-y-3">
                        <div class="h-48 bg-slate-100 rounded-lg overflow-hidden flex items-center justify-center border border-slate-100">
                            @if($bukuItem->foto_buku)
                                <img src="{{ asset('images/Perpustakaan/foto_buku/' . $bukuItem->foto_buku) }}" alt="{{ $bukuItem->judul_buku }}" class="w-full h-full object-cover" loading="lazy" onerror="this.src='{{ asset('images/image-none.jpg') }}'">
                            @else
                                <img src="{{ asset('images/image-none.jpg') }}" alt="No Image" class="h-20 w-auto opacity-40">
                            @endif
                        </div>
                        <div>
                            <span class="text-[11px] font-semibold text-brand-700">{{ $bukuItem->kategoriBuku->nama_kategori ?? 'Umum' }}</span>
                            <h4 class="font-bold text-sm text-slate-900 line-clamp-2 mt-0.5" title="{{ $bukuItem->judul_buku }}">{{ $bukuItem->judul_buku }}</h4>
                            <p class="text-xs text-slate-500 mt-1">Karya: {{ $bukuItem->author_buku ?? 'Tidak diketahui' }}</p>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-500">Stok: <strong class="text-slate-800">{{ $bukuItem->stok_buku ?? 0 }}</strong></span>
                        <span class="text-slate-500">Rak: <strong class="text-slate-800">{{ $bukuItem->rak_buku ?? '-' }}</strong></span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Profil Institusi: Visi, Misi & Sejarah -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-xs font-bold uppercase tracking-wider text-brand-700">Profil Institusi</span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1">Mengenal Lebih Dekat SMPN 2 Kamal</h2>
                <p class="text-sm text-slate-600 mt-2">Dedikasi kami dalam menghadirkan ekosistem belajar yang ramah anak, berprestasi, dan berlandaskan budi pekerti luhur.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Visi & Misi -->
                <div class="bg-slate-50 border border-slate-200/80 rounded-xl p-6 flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="w-10 h-10 rounded-lg bg-brand-100 text-brand-800 flex items-center justify-center font-bold">01</div>
                        <h3 class="text-lg font-bold text-slate-900">Visi & Misi</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Terwujudnya sekolah yang unggul dalam prestasi akademik dan non-akademik, berwawasan lingkungan, serta berpijak pada nilai-nilai keimanan dan ketakwaan.
                        </p>
                    </div>
                </div>

                <!-- Tujuan -->
                <div class="bg-slate-50 border border-slate-200/80 rounded-xl p-6 flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="w-10 h-10 rounded-lg bg-brand-100 text-brand-800 flex items-center justify-center font-bold">02</div>
                        <h3 class="text-lg font-bold text-slate-900">Tujuan Pendidikan</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Mempersiapkan peserta didik agar menjadi pribadi mandiri, bernalar kritis, kreatif, bergotong royong, dan siap menempuh jenjang pendidikan berikutnya dengan penuh percaya diri.
                        </p>
                    </div>
                </div>

                <!-- Sejarah & Kiprah -->
                <div class="bg-slate-50 border border-slate-200/80 rounded-xl p-6 flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="w-10 h-10 rounded-lg bg-brand-100 text-brand-800 flex items-center justify-center font-bold">03</div>
                        <h3 class="text-lg font-bold text-slate-900">Sejarah & Kiprah</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Didirikan pada tahun 2005 di Kecamatan Kamal, Bangkalan. Telah meluluskan ribuan alumni yang tersebar di berbagai institusi pendidikan unggulan dan berkontribusi nyata bagi masyarakat.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
