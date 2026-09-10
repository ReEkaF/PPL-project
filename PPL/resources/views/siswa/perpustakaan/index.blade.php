<x-siswa-layout>
    <div class="max-w-6xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-900">Katalog Perpustakaan</h1>
                <p class="text-sm text-slate-500 mt-0.5">Jelajahi koleksi buku perpustakaan sekolah dan cari buku yang ingin kamu pinjam.</p>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="flex gap-1 bg-slate-100 p-1 rounded-xl w-fit">
            <a href="{{ route('siswa.perpustakaan.index') }}"
                class="px-4 py-2 text-sm font-medium rounded-lg transition-colors bg-white text-slate-900 shadow-sm">
                Katalog Buku
            </a>
            <a href="{{ route('siswa.perpustakaan.riwayat') }}"
                class="px-4 py-2 text-sm font-medium rounded-lg transition-colors text-slate-500 hover:text-slate-700">
                Riwayat Peminjaman
            </a>
            <a href="{{ route('siswa.perpustakaan.rules') }}"
                class="px-4 py-2 text-sm font-medium rounded-lg transition-colors text-slate-500 hover:text-slate-700">
                Aturan Perpustakaan
            </a>
        </div>

        {{-- Search and Filter Bar --}}
        <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
            <form action="{{ route('dashboard.perpustakaan') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" placeholder="Cari judul buku atau pengarang..."
                        class="w-full pl-10 pr-4 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400 placeholder-slate-400"
                        value="{{ request('search') }}" />
                </div>

                <div class="sm:w-60">
                    <select name="kategori_buku" onchange="this.form.submit()"
                        class="w-full px-3 py-2 text-sm border border-slate-200 bg-white rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400 text-slate-700">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id_kategori_buku }}"
                                {{ request('kategori_buku') == $cat->id_kategori_buku ? 'selected' : '' }}>
                                {{ $cat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                        class="px-4 py-2 bg-brand-800 text-white text-sm font-medium rounded-lg hover:bg-brand-900 transition-colors shadow-sm flex items-center justify-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <span>Cari</span>
                    </button>
                    @if (request('search') || request('kategori_buku'))
                        <a href="{{ route('dashboard.perpustakaan') }}"
                            class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-medium rounded-lg transition-colors flex items-center justify-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Book Grid --}}
        @if ($pages->isEmpty())
            <div class="bg-white border border-slate-200 rounded-xl p-12 text-center">
                <div class="w-14 h-14 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-slate-800">Buku Tidak Ditemukan</h3>
                <p class="text-sm text-slate-500 mt-1">Tidak ada koleksi buku yang cocok dengan pencarian atau kategori yang kamu pilih.</p>
                @if (request('search') || request('kategori_buku'))
                    <a href="{{ route('dashboard.perpustakaan') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition">
                        Reset Filter
                    </a>
                @endif
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 sm:gap-5">
                @foreach ($pages as $buku)
                    <div class="group bg-white border border-slate-200 rounded-xl overflow-hidden hover:shadow-md hover:border-slate-300 transition-all duration-200 flex flex-col">
                        {{-- Book Cover --}}
                        <div class="relative aspect-[3/4] bg-slate-100 overflow-hidden">
                            @if ($buku->foto_buku)
                                <img src="{{ asset($buku->foto_buku) }}" alt="{{ $buku->judul_buku }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 p-4 bg-slate-50">
                                    <svg class="w-12 h-12 text-slate-300 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    <span class="text-[11px] font-medium text-slate-400">Sampul Buku</span>
                                </div>
                            @endif

                            {{-- Floating Category --}}
                            @if ($buku->kategoriBuku)
                                <span class="absolute top-2.5 left-2.5 bg-white/90 backdrop-blur text-[11px] font-semibold text-brand-800 px-2 py-0.5 rounded shadow-sm border border-slate-200/50">
                                    {{ $buku->kategoriBuku->nama_kategori }}
                                </span>
                            @endif

                            {{-- Floating Stock Badge --}}
                            @if ($buku->stok_buku > 0)
                                <span class="absolute top-2.5 right-2.5 bg-emerald-600/90 backdrop-blur text-[10px] font-semibold text-white px-2 py-0.5 rounded shadow-sm">
                                    Stok: {{ $buku->stok_buku }}
                                </span>
                            @else
                                <span class="absolute top-2.5 right-2.5 bg-rose-600/90 backdrop-blur text-[10px] font-semibold text-white px-2 py-0.5 rounded shadow-sm">
                                    Habis
                                </span>
                            @endif
                        </div>

                        {{-- Book Info --}}
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="font-bold text-slate-900 group-hover:text-brand-800 transition-colors text-sm line-clamp-2 leading-snug" title="{{ $buku->judul_buku }}">
                                    {{ $buku->judul_buku }}
                                </h3>
                                @if ($buku->author_buku)
                                    <p class="text-xs text-slate-500 mt-1 truncate">
                                        <span class="text-slate-400">Oleh:</span> {{ $buku->author_buku }}
                                    </p>
                                @endif
                                @if ($buku->rak_buku)
                                    <p class="text-xs text-slate-400 mt-0.5">
                                        Rak: {{ $buku->rak_buku }}
                                    </p>
                                @endif
                            </div>

                            <a href="{{ route('siswa.perpustakaan.detail', $buku->id_buku) }}"
                                class="mt-3 w-full py-1.5 px-3 bg-brand-50 hover:bg-brand-100 text-brand-700 text-xs font-semibold rounded-lg text-center transition-colors block">
                                Detail Buku
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if ($pages->hasPages())
                <div class="pt-2">
                    {{ $pages->links() }}
                </div>
            @endif
        @endif

    </div>
</x-siswa-layout>
