<x-guest-layout>
    <!-- Header Banner -->
    <section class="relative bg-slate-900 text-white py-16 lg:py-20 border-b border-slate-800">
        <div class="absolute inset-0 opacity-20 bg-cover bg-center" style="background-image: url('{{ asset('images/beranda/perpus.webp') }}');"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-900/90 to-slate-900/70"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl space-y-4">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-brand-900/80 border border-brand-700/60 text-brand-200 text-xs font-semibold">
                    Katalog Terbuka
                </span>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Perpustakaan SMPN 2 Kamal</h1>
                <p class="text-sm sm:text-base text-slate-300 leading-relaxed">
                    Menyediakan ribuan sumber referensi cetak dan digital untuk memfasilitasi riset mandiri, tugas akademik, serta menumbuhkan budaya gemar membaca bagi seluruh civitas akademika.
                </p>
                <div class="pt-2 flex flex-wrap items-center gap-3">
                    <x-ui.button href="{{ route('login') }}" variant="accent" size="md">
                        <span>Masuk untuk Meminjam Buku</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </x-ui.button>
                </div>
            </div>
        </div>
    </section>

    <!-- Informasi Perpustakaan & Fasilitas -->
    <section class="py-14 bg-white border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                <!-- Visual Galeri -->
                <div class="lg:col-span-6 grid grid-cols-2 gap-4">
                    <div class="space-y-4">
                        <img src="{{ asset('images/beranda/perpustakaan/perpus-dalam1.jpg') }}" alt="Ruang Baca" class="rounded-xl object-cover h-48 w-full shadow-sm border border-slate-200" loading="lazy">
                        <img src="{{ asset('images/beranda/perpustakaan/perpus-dalam2.jpg') }}" alt="Rak Buku" class="rounded-xl object-cover h-36 w-full shadow-sm border border-slate-200" loading="lazy">
                    </div>
                    <div class="pt-6">
                        <img src="{{ asset('images/beranda/perpustakaan/perpus-dalam3.jpg') }}" alt="Fasilitas Belajar" class="rounded-xl object-cover h-72 w-full shadow-sm border border-slate-200" loading="lazy">
                    </div>
                </div>

                <!-- Text & Rules -->
                <div class="lg:col-span-6 space-y-6">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-brand-700">Fasilitas Literasi</span>
                        <h2 class="text-2xl font-bold text-slate-900 mt-1">Ruang Baca Nyaman & Terbuka</h2>
                        <p class="text-sm text-slate-600 mt-3 leading-relaxed">
                            Terletak di area strategis lingkungan sekolah, perpustakaan dilengkapi dengan ruang baca ber-AC, area diskusi kelompok, sistem katalog terkomputerisasi, serta ribuan judul buku teks pelajaran, fiksi bermutu, dan ensiklopedia sains.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                        <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-lg">
                            <h4 class="font-semibold text-xs text-slate-900 uppercase tracking-wider">Jam Operasional</h4>
                            <p class="text-sm text-slate-700 mt-1 font-medium">Senin – Jumat</p>
                            <p class="text-xs text-slate-500">07.00 – 14.30 WIB</p>
                        </div>
                        <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-lg">
                            <h4 class="font-semibold text-xs text-slate-900 uppercase tracking-wider">Sistem Peminjaman</h4>
                            <p class="text-sm text-slate-700 mt-1 font-medium">Barcode NISN / NIP</p>
                            <p class="text-xs text-slate-500">Maksimal 3 buku / minggu</p>
                        </div>
                    </div>

                    <div class="p-4 border-l-4 border-accent-500 bg-amber-50/60 rounded-r-lg">
                        <blockquote class="text-xs sm:text-sm text-slate-700 italic">
                            "Membaca adalah jendela dunia, di mana kita bisa melihat lebih luas tanpa harus melangkahkan kaki."
                        </blockquote>
                        <span class="text-xs font-semibold text-slate-500 block mt-1">— René Descartes</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Daftar Buku Terbaru -->
    <section class="py-14 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mb-10">
                <span class="text-xs font-bold uppercase tracking-wider text-brand-700">Koleksi Terkini</span>
                <h2 class="text-2xl font-bold text-slate-900 mt-1">Daftar Buku Terbaru</h2>
                <p class="text-sm text-slate-600 mt-1">Buku-buku yang baru ditambahkan ke katalog perpustakaan.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($buku as $item)
                    @php
                        $coverPath = asset('images/image-none.jpg');
                        if (!empty($item->foto_buku)) {
                            if (str_starts_with($item->foto_buku, 'http')) {
                                $coverPath = $item->foto_buku;
                            } elseif (file_exists(public_path('images/Perpustakaan/foto_buku/' . $item->foto_buku))) {
                                $coverPath = asset('images/Perpustakaan/foto_buku/' . $item->foto_buku);
                            }
                        }
                    @endphp
                    <div class="bg-white border border-slate-200/80 rounded-xl overflow-hidden flex flex-col justify-between hover:shadow-md transition">
                        <div class="p-4 space-y-3">
                            <div class="h-56 bg-slate-100 rounded-lg overflow-hidden flex items-center justify-center border border-slate-100">
                                <img src="{{ $coverPath }}" alt="{{ $item->judul_buku }}" class="w-full h-full object-cover" loading="lazy" onerror="this.src='{{ asset('images/image-none.jpg') }}'">
                            </div>
                            <div>
                                <x-ui.badge variant="brand" size="sm">{{ $item->kategoriBuku->nama_kategori ?? 'Umum' }}</x-ui.badge>
                                <h3 class="font-bold text-sm text-slate-900 line-clamp-2 mt-2" title="{{ $item->judul_buku }}">{{ $item->judul_buku }}</h3>
                                <p class="text-xs text-slate-500 mt-1">Penulis: {{ $item->author_buku ?? 'Tidak diketahui' }}</p>
                                <p class="text-xs text-slate-400">{{ $item->publisher_buku ?? '' }} ({{ $item->tahun_terbit ?? '' }})</p>
                            </div>
                        </div>

                        <div class="px-4 py-3 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between text-xs">
                            <span class="text-slate-600">Stok: <strong>{{ $item->stok_buku ?? 0 }}</strong></span>
                            <a href="{{ route('login') }}" class="text-brand-700 hover:text-brand-900 font-semibold">Pinjam →</a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 bg-white rounded-xl border border-slate-200">
                        <p class="text-sm text-slate-500">Belum ada data buku yang tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</x-guest-layout>
