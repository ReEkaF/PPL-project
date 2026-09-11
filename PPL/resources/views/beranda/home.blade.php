<x-guest-layout>
    <!-- Hero / Institutional Identity Section (Option A: Clean Flat Light Theme) -->
    <section class="relative bg-white border-b border-slate-200 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Left: Headline & Information -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-brand-50 border border-brand-200 text-brand-800 text-xs font-semibold">
                        <span>Portal Resmi SMPN 2 Kamal</span>
                    </div>

                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        Mewujudkan Generasi <span class="text-brand-800">Berkarakter</span>, Berprestasi, dan Berdaya Saing
                    </h1>

                    <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-2xl font-normal">
                        SMPN 2 Kamal menyelenggarakan pendidikan terpadu yang memadukan pembentukan akhlak mulia, penguasaan ilmu pengetahuan, serta pengembangan minat bakat secara menyeluruh.
                    </p>

                    <div class="flex flex-wrap items-center gap-3 pt-2">
                        <x-ui.button href="{{ route('beranda.perpustakaan') }}" variant="primary" size="lg">
                            <span>Jelajahi Perpustakaan</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </x-ui.button>
                        <x-ui.button href="{{ route('ekstrakurikuler.index') }}" variant="secondary" size="lg">
                            <span>Daftar Ekstrakurikuler</span>
                        </x-ui.button>
                        <x-ui.button href="{{ route('login') }}" variant="ghost" size="lg">
                            <span>Akses Portal Masuk →</span>
                        </x-ui.button>
                    </div>

                    <div class="pt-4 border-t border-slate-200 text-xs text-slate-500 flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span>Jl. Raya Telang No.3, Telang Indah, Kamal, Bangkalan, Jawa Timur</span>
                    </div>
                </div>

                <!-- Right: School Metrics Grid (Flat Stat Cards) -->
                <div class="lg:col-span-5 grid grid-cols-2 gap-4">
                    <div class="bg-brand-50/50 border border-slate-200 rounded-xl p-5">
                        <div class="text-xs font-medium text-slate-500">Tenaga pengajar</div>
                        <div class="text-3xl font-extrabold text-slate-900 mt-1 tabular-nums">{{ $statistics['total_guru'] ?? '—' }}</div>
                        <p class="text-xs text-slate-500 mt-1">Guru & staf berdedikasi</p>
                    </div>

                    <div class="bg-brand-50/50 border border-slate-200 rounded-xl p-5">
                        <div class="text-xs font-medium text-slate-500">Siswa terdaftar</div>
                        <div class="text-3xl font-extrabold text-slate-900 mt-1 tabular-nums">{{ $statistics['total_siswa'] ?? '—' }}</div>
                        <p class="text-xs text-slate-500 mt-1">Peserta didik aktif</p>
                    </div>

                    <div class="bg-brand-50/50 border border-slate-200 rounded-xl p-5">
                        <div class="text-xs font-medium text-slate-500">Koleksi buku</div>
                        <div class="text-3xl font-extrabold text-slate-900 mt-1 tabular-nums">{{ $statistics['total_buku'] ?? '—' }}</div>
                        <p class="text-xs text-slate-500 mt-1">Judul perpustakaan</p>
                    </div>

                    <div class="bg-brand-50/50 border border-slate-200 rounded-xl p-5">
                        <div class="text-xs font-medium text-slate-500">Ekstrakurikuler</div>
                        <div class="text-3xl font-extrabold text-slate-900 mt-1 tabular-nums">{{ $statistics['total_ekskul'] ?? '—' }}</div>
                        <p class="text-xs text-slate-500 mt-1">Wadah minat & bakat</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Empat Pilar Layanan Sekolah Terintegrasi -->
    <section class="py-16 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mb-10">
                <span class="text-xs font-bold uppercase tracking-wider text-brand-800">Layanan Terpadu</span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1">Fasilitas & Layanan Unggulan Sekolah</h2>
                <p class="text-sm text-slate-600 mt-2">Seluruh ekosistem kegiatan pembelajaran, literasi, minat bakat, dan prestasi dikelola secara terstruktur.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1: Perpustakaan -->
                <div class="bg-white border border-slate-200 rounded-xl overflow-hidden flex flex-col justify-between hover:border-brand-700 transition">
                    <div>
                        <div class="h-44 overflow-hidden relative bg-slate-100">
                            <picture>
                                <source srcset="{{ asset('images/beranda/perpus.webp') }}" type="image/webp">
                                <img src="{{ asset('images/beranda/perpus.jpg') }}" alt="Perpustakaan SMPN 2 Kamal" class="w-full h-full object-cover" loading="lazy">
                            </picture>
                            <div class="absolute top-3 left-3">
                                <x-ui.badge variant="brand">Literasi</x-ui.badge>
                            </div>
                        </div>
                        <div class="p-5 space-y-2">
                            <h3 class="font-bold text-base text-slate-900">Perpustakaan Digital</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Koleksi buku pelajaran, ensiklopedia, referensi ilmiah, serta sistem peminjaman terintegrasi barcode.
                            </p>
                        </div>
                    </div>
                    <div class="p-5 pt-0">
                        <x-ui.button href="{{ route('beranda.perpustakaan') }}" variant="secondary" size="sm" class="w-full justify-between">
                            <span>Katalog Buku</span>
                            <span>→</span>
                        </x-ui.button>
                    </div>
                </div>

                <!-- Card 2: Tenaga Pengajar -->
                <div class="bg-white border border-slate-200 rounded-xl overflow-hidden flex flex-col justify-between hover:border-brand-700 transition">
                    <div>
                        <div class="h-44 overflow-hidden relative bg-slate-100">
                            <img src="{{ asset('images/beranda/tenaga-kerja.jpg') }}" alt="Tenaga Pengajar SMPN 2 Kamal" class="w-full h-full object-cover" loading="lazy">
                            <div class="absolute top-3 left-3">
                                <x-ui.badge variant="brand">Akademik</x-ui.badge>
                            </div>
                        </div>
                        <div class="p-5 space-y-2">
                            <h3 class="font-bold text-base text-slate-900">Tenaga Pendidik</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Dewan guru berkualifikasi, berkompeten di bidang masing-masing, serta membimbing siswa secara profesional.
                            </p>
                        </div>
                    </div>
                    <div class="p-5 pt-0">
                        <x-ui.button href="{{ route('beranda.guru') }}" variant="secondary" size="sm" class="w-full justify-between">
                            <span>Direktori Guru</span>
                            <span>→</span>
                        </x-ui.button>
                    </div>
                </div>

                <!-- Card 3: Ekstrakurikuler -->
                <div class="bg-white border border-slate-200 rounded-xl overflow-hidden flex flex-col justify-between hover:border-brand-700 transition">
                    <div>
                        <div class="h-44 overflow-hidden relative bg-slate-100">
                            <picture>
                                <source srcset="{{ asset('images/beranda/ekstra.webp') }}" type="image/webp">
                                <img src="{{ asset('images/beranda/ekstra.jpg') }}" alt="Ekstrakurikuler SMPN 2 Kamal" class="w-full h-full object-cover" loading="lazy">
                            </picture>
                            <div class="absolute top-3 left-3">
                                <x-ui.badge variant="brand">Pengembangan</x-ui.badge>
                            </div>
                        </div>
                        <div class="p-5 space-y-2">
                            <h3 class="font-bold text-base text-slate-900">Ekstrakurikuler</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Pengembangan minat bakat melalui Pramuka, Paskibra, PMR, Seni Budaya, Olahraga, dan Tahfidz Quran.
                            </p>
                        </div>
                    </div>
                    <div class="p-5 pt-0">
                        <x-ui.button href="{{ route('ekstrakurikuler.index') }}" variant="secondary" size="sm" class="w-full justify-between">
                            <span>Info & Daftar</span>
                            <span>→</span>
                        </x-ui.button>
                    </div>
                </div>

                <!-- Card 4: Prestasi -->
                <div class="bg-white border border-slate-200 rounded-xl overflow-hidden flex flex-col justify-between hover:border-brand-700 transition">
                    <div>
                        <div class="h-44 overflow-hidden relative bg-slate-100">
                            <img src="{{ asset('images/beranda/prestasi.jpg') }}" alt="Prestasi SMPN 2 Kamal" class="w-full h-full object-cover" loading="lazy">
                            <div class="absolute top-3 left-3">
                                <x-ui.badge variant="brand">Pencapaian</x-ui.badge>
                            </div>
                        </div>
                        <div class="p-5 space-y-2">
                            <h3 class="font-bold text-base text-slate-900">Galeri Prestasi</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Rekam jejak torehan medali dan penghargaan para siswa di tingkat kabupaten, provinsi, hingga nasional.
                            </p>
                        </div>
                    </div>
                    <div class="p-5 pt-0">
                        <x-ui.button href="{{ route('beranda.prestasi') }}" variant="secondary" size="sm" class="w-full justify-between">
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
    <section class="py-16 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-brand-800">Katalog Terkini</span>
                    <h2 class="text-2xl font-bold text-slate-900 mt-1">Buku Terbaru di Perpustakaan</h2>
                </div>
                <x-ui.button href="{{ route('beranda.perpustakaan') }}" variant="secondary" size="sm">
                    <span>Lihat Seluruh Koleksi →</span>
                </x-ui.button>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                @foreach($latestBooks as $bukuItem)
                <div class="bg-white border border-slate-200 rounded-xl p-4 flex flex-col justify-between hover:border-brand-700 transition">
                    <div class="space-y-3">
                        <div class="h-48 bg-slate-50 rounded-lg overflow-hidden flex items-center justify-center border border-slate-100">
                            @if($bukuItem->foto_buku)
                                <img src="{{ asset('images/Perpustakaan/foto_buku/' . $bukuItem->foto_buku) }}" alt="{{ $bukuItem->judul_buku }}" class="w-full h-full object-cover" loading="lazy" onerror="this.src='{{ asset('images/image-none.jpg') }}'">
                            @else
                                <img src="{{ asset('images/image-none.jpg') }}" alt="No Image" class="h-20 w-auto opacity-40">
                            @endif
                        </div>
                        <div>
                            <span class="text-[11px] font-semibold text-brand-800">{{ $bukuItem->kategoriBuku->nama_kategori ?? 'Umum' }}</span>
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
    <section class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-xs font-bold uppercase tracking-wider text-brand-800">Profil Institusi</span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1">Mengenal Lebih Dekat SMPN 2 Kamal</h2>
                <p class="text-sm text-slate-600 mt-2">Menghadirkan ekosistem belajar yang ramah, berprestasi, dan berlandaskan budi pekerti luhur.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Visi & Misi -->
                <div class="bg-white border border-slate-200 rounded-xl p-6 flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="w-10 h-10 rounded-lg bg-brand-50 text-brand-800 flex items-center justify-center font-bold text-sm">01</div>
                        <h3 class="text-lg font-bold text-slate-900">Visi & Misi</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Terwujudnya sekolah yang unggul dalam prestasi akademik dan non-akademik, berwawasan lingkungan, serta berpijak pada nilai-nilai keimanan dan ketakwaan.
                        </p>
                    </div>
                </div>

                <!-- Tujuan -->
                <div class="bg-white border border-slate-200 rounded-xl p-6 flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="w-10 h-10 rounded-lg bg-brand-50 text-brand-800 flex items-center justify-center font-bold text-sm">02</div>
                        <h3 class="text-lg font-bold text-slate-900">Tujuan Pendidikan</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Mempersiapkan peserta didik agar menjadi pribadi mandiri, bernalar kritis, kreatif, bergotong royong, dan siap menempuh jenjang pendidikan berikutnya.
                        </p>
                    </div>
                </div>

                <!-- Sejarah & Kiprah -->
                <div class="bg-white border border-slate-200 rounded-xl p-6 flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="w-10 h-10 rounded-lg bg-brand-50 text-brand-800 flex items-center justify-center font-bold text-sm">03</div>
                        <h3 class="text-lg font-bold text-slate-900">Sejarah & Kiprah</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Didirikan pada tahun 2005 di Kecamatan Kamal, Bangkalan. Telah meluluskan ribuan alumni yang berkontribusi nyata bagi pendidikan dan masyarakat.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
