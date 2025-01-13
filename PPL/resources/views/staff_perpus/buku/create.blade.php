<x-staffperpustakaan-layout>
    <div class="container mx-auto max-w-lg p-6 bg-white shadow-md rounded-lg">
        <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">Tambah Buku</h2>
        <div>
            <a href="{{ route('staff_perpus.buku.daftarbuku') }}" class="text-blue-500 hover:text-blue-700 flex items-center mt-12">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
        </div>
        <form action="{{ route('staff_perpus.buku.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
    
            <!-- Judul Buku -->
            <div>
                <label for="judul_buku" class="block text-gray-700 font-semibold mb-1">Judul Buku</label>
                <input type="text" name="judul_buku" id="judul_buku" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" value="{{ old('judul_buku') }}">
                @error('judul_buku')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            
            <!-- Author Buku -->
            <div>
                <label for="author_buku" class="block text-gray-700 font-semibold mb-1">Author Buku</label>
                <input type="text" name="author_buku" id="author_buku" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" value="{{ old('author_buku') }}">
                @error('author_buku')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
    
            <!-- Publisher Buku -->
            <div>
                <label for="publisher_buku" class="block text-gray-700 font-semibold mb-1">Publisher Buku</label>
                <input type="text" name="publisher_buku" id="publisher_buku" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" value="{{ old('publisher_buku') }}">
                @error('publisher_buku')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Kategori Buku -->
            <div>
                <label for="id_kategori_buku" class="block text-gray-700 font-semibold mb-1">Kategori Buku</label>
                <select name="id_kategori_buku" id="id_kategori_buku" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoriBuku as $kategori)
                    <option value="{{ $kategori->id_kategori_buku }}" {{ old('id_kategori_buku') == $kategori->id_kategori_buku ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                    @endforeach
                </select>
                @error('id_kategori_buku')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
    
            <!-- Jenis Buku -->
            <div>
                <label for="id_jenis_buku" class="block text-gray-700 font-semibold mb-1">Jenis Buku</label>
                <select name="id_jenis_buku" id="id_jenis_buku" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                    <option value="">Pilih Jenis</option>
                    @foreach($jenisBuku as $jenis)
                        <option value="{{ $jenis->id_jenis_buku }}" {{ old('id_jenis_buku') == $jenis->id_jenis_buku ? 'selected' : '' }}>
                            {{ $jenis->nama_jenis_buku }}
                        </option>
                        @endforeach
                    </select>
                    @error('id_jenis_buku')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Tahun Terbit -->
                <div>
                    <label for="tahun_terbit" class="block text-gray-700 font-semibold mb-1">Tahun Terbit</label>
                <input type="text" name="tahun_terbit" id="tahun_terbit" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" value="{{ old('tahun_terbit') }}">
                @error('tahun_terbit')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Bahasa Buku -->
            <div>
                <label for="bahasa_buku" class="block text-gray-700 font-semibold mb-1">Bahasa Buku</label>
                <input type="text" name="bahasa_buku" id="bahasa_buku" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" value="{{ old('bahasa_buku') }}">
                @error('bahasa_buku')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Stok Buku -->
            <div>
                <label for="stok_buku" class="block text-gray-700 font-semibold mb-1">Stok Buku</label>
                <input type="number" name="stok_buku" id="stok_buku" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" value="{{ old('stok_buku') }}">
                @error('stok_buku')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Rak Buku -->
            <div>
                <label for="rak_buku" class="block text-gray-700 font-semibold mb-1">Rak Buku</label>
                <input type="number" name="rak_buku" id="rak_buku" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" value="{{ old('rak_buku') }}">
                @error('rak_buku')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Harga Buku -->
            <div>
                <label for="harga_buku" class="block text-gray-700 font-semibold mb-1">Harga Buku</label>
                <input type="number" name="harga_buku" id="harga_buku" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" value="{{ old('harga_buku') }}" step="0.01" min="0">
                @error('harga_buku')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Foto Buku -->
            <div>
                <label for="foto_buku" class="block text-gray-700 font-semibold mb-1">Foto Buku</label>
                <input type="file" name="foto_buku" id="foto_buku" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" accept="image/*">
                @error('foto_buku')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
    
            <!-- Submit Button -->
            <div class="text-left">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-600 transition duration-300">Tambah Buku</button>
            </div>
        </form>
    </div>
</x-staffperpustakaan-layout>
