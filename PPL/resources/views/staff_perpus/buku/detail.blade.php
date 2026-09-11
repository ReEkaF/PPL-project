<x-staffperpustakaan-layout>
    <div class="p-6 max-w-5xl mx-auto">
        <!-- Back navigation & Header -->
        <div class="mb-6">
            <a href="{{ route('staff_perpus.buku.daftarbuku') }}" class="inline-flex items-center gap-2 text-xs font-medium text-slate-500 hover:text-slate-800 transition-colors mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar Buku
            </a>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">{{ $buku->judul_buku }}</h1>
                    <p class="text-sm text-slate-500 mt-1">Detail spesifikasi katalog dan ketersediaan fisik buku</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('staff_perpus.buku.edit', $buku->id_buku) }}"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-[#06466C] hover:bg-[#053a5a] rounded-lg shadow-sm transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Buku
                    </a>
                </div>
            </div>
        </div>

        <!-- Detail Card -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 p-6 sm:p-8">
                <!-- Cover Column -->
                <div class="md:col-span-1 flex flex-col items-center">
                    <div class="w-full max-w-[240px] aspect-[3/4] rounded-lg overflow-hidden border border-slate-200 bg-slate-100 shadow-sm">
                        <img src="{{ asset($buku->foto_buku) }}" alt="{{ $buku->judul_buku }}" class="w-full h-full object-cover">
                    </div>
                    <div class="mt-4 w-full max-w-[240px] p-3 rounded-lg bg-slate-50 border border-slate-200 text-center">
                        <div class="text-xs text-slate-500">Stok Tersedia</div>
                        <div class="text-2xl font-bold font-mono text-[#06466C] mt-0.5">{{ $buku->stok_buku }} <span class="text-xs font-sans text-slate-500 font-normal">eksemplar</span></div>
                    </div>
                </div>

                <!-- Info Column -->
                <div class="md:col-span-2 space-y-6">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900 border-b border-slate-100 pb-3">Informasi Katalog</h2>
                        <dl class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                            <div>
                                <dt class="text-xs font-medium text-slate-500">Judul Lengkap</dt>
                                <dd class="mt-1 text-slate-900 font-medium">{{ $buku->judul_buku }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-slate-500">Penulis / Author</dt>
                                <dd class="mt-1 text-slate-900">{{ $buku->author_buku }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-slate-500">Kategori</dt>
                                <dd class="mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-[#06466C]/10 text-[#06466C] border border-[#06466C]/20">
                                        {{ $buku->kategoriBuku->nama_kategori }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-slate-500">Jenis Koleksi</dt>
                                <dd class="mt-1 text-slate-900">{{ $buku->jenisBuku->nama_jenis_buku }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-slate-500">Penerbit</dt>
                                <dd class="mt-1 text-slate-900">{{ $buku->publisher_buku ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-slate-500">Tahun Terbit</dt>
                                <dd class="mt-1 font-mono text-slate-900">{{ $buku->tahun_terbit ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-slate-500">Bahasa</dt>
                                <dd class="mt-1 text-slate-900">{{ $buku->bahasa_buku ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-slate-500">Estimasi Nilai / Harga</dt>
                                <dd class="mt-1 font-mono text-slate-900">
                                    {{ $buku->harga_buku ? 'Rp ' . number_format($buku->harga_buku, 0, ',', '.') : '-' }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-staffperpustakaan-layout>
