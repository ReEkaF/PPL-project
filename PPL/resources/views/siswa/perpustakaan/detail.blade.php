<x-siswa-layout>
    <div class="max-w-6xl mx-auto space-y-6">

        {{-- Header with Back Button --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard.perpustakaan') }}"
                class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-900 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <div class="flex items-center gap-2 mb-0.5">
                    <span class="text-xs font-semibold bg-brand-100 text-brand-700 px-2.5 py-0.5 rounded-full">
                        {{ $kategori->nama_kategori ?? 'Koleksi Perpustakaan' }}
                    </span>
                    <span class="text-xs text-slate-400">Detail Buku</span>
                </div>
                <h1 class="text-xl font-bold text-slate-900">{{ $buku->judul_buku }}</h1>
            </div>
        </div>

        {{-- Main 2-Column Content --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            {{-- Left Column: Cover & Quick Status --}}
            <div class="lg:col-span-1 space-y-4">
                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm text-center">
                    <div class="aspect-[3/4] w-full max-w-[220px] mx-auto bg-slate-100 rounded-lg overflow-hidden shadow-md mb-4">
                        @if ($buku->foto_buku)
                            <img src="{{ asset($buku->foto_buku) }}" alt="{{ $buku->judul_buku }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 p-4 bg-slate-50">
                                <svg class="w-16 h-16 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                <span class="text-xs font-medium text-slate-400">Sampul Buku</span>
                            </div>
                        @endif
                    </div>

                    {{-- Stock indicator --}}
                    <div class="space-y-2">
                        @if ($buku->stok_buku > 0)
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-xs font-semibold">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                Stok Tersedia: {{ $buku->stok_buku }} Eksemplar
                            </div>
                        @else
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-50 text-rose-700 border border-rose-200 rounded-full text-xs font-semibold">
                                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                Stok Buku Sedang Habis
                            </div>
                        @endif

                        <p class="text-xs text-slate-500">
                            Lokasi Penyimpanan: <span class="font-semibold text-slate-700">Rak {{ $buku->rak_buku ?? '-' }}</span>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Right Column: Specs & Guidance --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Book Specs --}}
                <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm space-y-5">
                    <h2 class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Informasi Spesifikasi Buku</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-3.5 bg-slate-50 border border-slate-100 rounded-xl">
                            <p class="text-xs text-slate-400 font-medium">Judul Lengkap</p>
                            <p class="text-sm font-semibold text-slate-900 mt-0.5">{{ $buku->judul_buku }}</p>
                        </div>

                        <div class="p-3.5 bg-slate-50 border border-slate-100 rounded-xl">
                            <p class="text-xs text-slate-400 font-medium">Penulis / Pengarang</p>
                            <p class="text-sm font-semibold text-slate-900 mt-0.5">{{ $buku->author_buku ?? '-' }}</p>
                        </div>

                        <div class="p-3.5 bg-slate-50 border border-slate-100 rounded-xl">
                            <p class="text-xs text-slate-400 font-medium">Penerbit</p>
                            <p class="text-sm font-semibold text-slate-900 mt-0.5">{{ $buku->publisher_buku ?? '-' }}</p>
                        </div>

                        <div class="p-3.5 bg-slate-50 border border-slate-100 rounded-xl">
                            <p class="text-xs text-slate-400 font-medium">Tahun Terbit</p>
                            <p class="text-sm font-semibold text-slate-900 mt-0.5">{{ $buku->tahun_terbit ?? '-' }}</p>
                        </div>

                        <div class="p-3.5 bg-slate-50 border border-slate-100 rounded-xl">
                            <p class="text-xs text-slate-400 font-medium">Kategori</p>
                            <p class="text-sm font-semibold text-slate-900 mt-0.5">{{ $kategori->nama_kategori ?? '-' }}</p>
                        </div>

                        <div class="p-3.5 bg-slate-50 border border-slate-100 rounded-xl">
                            <p class="text-xs text-slate-400 font-medium">Bahasa</p>
                            <p class="text-sm font-semibold text-slate-900 mt-0.5">{{ $buku->bahasa_buku ?? '-' }}</p>
                        </div>

                        <div class="p-3.5 bg-slate-50 border border-slate-100 rounded-xl">
                            <p class="text-xs text-slate-400 font-medium">Lokasi Rak</p>
                            <p class="text-sm font-semibold text-slate-900 mt-0.5">Rak {{ $buku->rak_buku ?? '-' }}</p>
                        </div>

                        <div class="p-3.5 bg-slate-50 border border-slate-100 rounded-xl">
                            <p class="text-xs text-slate-400 font-medium">Jumlah Stok</p>
                            <p class="text-sm font-semibold text-slate-900 mt-0.5">{{ $buku->stok_buku }} Buku</p>
                        </div>
                    </div>
                </div>

                {{-- Borrowing Info Notice --}}
                <div class="bg-brand-50 border border-brand-200 rounded-xl p-5 flex items-start gap-3.5">
                    <div class="w-9 h-9 rounded-lg bg-brand-100 text-brand-700 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-brand-900">Petunjuk Peminjaman Buku</h4>
                        <p class="text-xs text-brand-700 mt-1 leading-relaxed">
                            Peminjaman buku dilakukan secara langsung di meja sirkulasi perpustakaan sekolah. Silakan tunjukkan Kartu Tanda Siswa atau sebutkan NISN kamu kepada staf perpustakaan untuk mencatat transaksi peminjaman.
                        </p>
                    </div>
                </div>

            </div>

        </div>

    </div>
</x-siswa-layout>
