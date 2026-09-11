<x-staffperpustakaan-layout>
    <div class="p-6 max-w-4xl mx-auto">
        <!-- Back navigation & Header -->
        <div class="mb-6">
            <a href="{{ route('staff_perpus.buku.daftarbuku') }}" class="inline-flex items-center gap-2 text-xs font-medium text-slate-500 hover:text-slate-800 transition-colors mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar Buku
            </a>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Tambah Buku Baru</h1>
            <p class="text-sm text-slate-500 mt-1">Lengkapi informasi katalog dan detail fisik buku untuk ditambahkan ke perpustakaan</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-8">
            <form action="{{ route('staff_perpus.buku.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Judul Buku -->
                    <div class="sm:col-span-2">
                        <label for="judul_buku" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Judul Buku <span class="text-rose-500">*</span></label>
                        <input type="text" name="judul_buku" id="judul_buku"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                            value="{{ old('judul_buku') }}" placeholder="Masukkan judul lengkap buku">
                        @error('judul_buku')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Author Buku -->
                    <div>
                        <label for="author_buku" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Penulis / Author <span class="text-rose-500">*</span></label>
                        <input type="text" name="author_buku" id="author_buku"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                            value="{{ old('author_buku') }}" placeholder="Nama penulis">
                        @error('author_buku')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Publisher Buku -->
                    <div>
                        <label for="publisher_buku" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Penerbit</label>
                        <input type="text" name="publisher_buku" id="publisher_buku"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                            value="{{ old('publisher_buku') }}" placeholder="Nama penerbit">
                        @error('publisher_buku')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori Buku -->
                    <div>
                        <label for="id_kategori_buku" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Kategori Buku <span class="text-rose-500">*</span></label>
                        <select name="id_kategori_buku" id="id_kategori_buku"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 bg-white focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors">
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoriBuku as $kategori)
                                <option value="{{ $kategori->id_kategori_buku }}" {{ old('id_kategori_buku') == $kategori->id_kategori_buku ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_kategori_buku')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Buku -->
                    <div>
                        <label for="id_jenis_buku" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Jenis Koleksi <span class="text-rose-500">*</span></label>
                        <select name="id_jenis_buku" id="id_jenis_buku"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 bg-white focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors">
                            <option value="">Pilih Jenis</option>
                            @foreach($jenisBuku as $jenis)
                                <option value="{{ $jenis->id_jenis_buku }}" {{ old('id_jenis_buku') == $jenis->id_jenis_buku ? 'selected' : '' }}>
                                    {{ $jenis->nama_jenis_buku }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_jenis_buku')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tahun Terbit -->
                    <div>
                        <label for="tahun_terbit" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Tahun Terbit</label>
                        <input type="text" name="tahun_terbit" id="tahun_terbit"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors font-mono"
                            value="{{ old('tahun_terbit') }}" placeholder="Contoh: 2024">
                        @error('tahun_terbit')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bahasa Buku -->
                    <div>
                        <label for="bahasa_buku" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Bahasa</label>
                        <input type="text" name="bahasa_buku" id="bahasa_buku"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                            value="{{ old('bahasa_buku') }}" placeholder="Contoh: Indonesia, Inggris">
                        @error('bahasa_buku')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stok Buku -->
                    <div>
                        <label for="stok_buku" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Jumlah Stok <span class="text-rose-500">*</span></label>
                        <input type="number" name="stok_buku" id="stok_buku"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors font-mono"
                            value="{{ old('stok_buku') }}" min="0" placeholder="0">
                        @error('stok_buku')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Rak Buku -->
                    <div>
                        <label for="rak_buku" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Nomor Rak / Lokasi</label>
                        <input type="number" name="rak_buku" id="rak_buku"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors font-mono"
                            value="{{ old('rak_buku') }}" placeholder="Nomor rak">
                        @error('rak_buku')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Harga Buku -->
                    <div>
                        <label for="harga_buku" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Harga Buku (Rp)</label>
                        <input type="number" name="harga_buku" id="harga_buku"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors font-mono"
                            value="{{ old('harga_buku') }}" step="0.01" min="0" placeholder="0">
                        @error('harga_buku')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Foto Buku -->
                    <div>
                        <label for="foto_buku" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Foto Sampul Buku</label>
                        <input type="file" name="foto_buku" id="foto_buku"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3 py-2 file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-[#06466C]/10 file:text-[#06466C] hover:file:bg-[#06466C]/20 cursor-pointer focus:outline-none"
                            accept="image/*">
                        @error('foto_buku')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit & Cancel Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('staff_perpus.buku.daftarbuku') }}"
                        class="px-4 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-lg transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-semibold text-white bg-[#06466C] hover:bg-[#053a5a] rounded-lg shadow-sm transition-colors">
                        Simpan Buku
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-staffperpustakaan-layout>
