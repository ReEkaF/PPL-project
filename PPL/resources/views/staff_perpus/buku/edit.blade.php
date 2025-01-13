<x-staffperpustakaan-layout>
    <div class="container mx-auto max-w-lg p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Edit Buku</h1>
        <div>
            <a href="{{ route('staff_perpus.buku.daftarbuku') }}" class="text-blue-500 hover:text-blue-700 flex items-center mt-12">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
        </div>
        <form action="{{ route('staff_perpus.buku.update', $buku->id_buku) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')
            
            <!-- Foto Buku -->
            <div>
                <div class="mb-6">
                    <img src="{{ asset($buku->foto_buku) }}"  alt="Gambar Buku" class="w-32 h-32 mx-auto rounded shadow-md">
                </div>
                {{-- @if($buku->foto_buku)
                    <img src="{{ asset($buku->foto_buku) }}"  alt="Gambar Buku" class="mt-3 mx-auto w-24 h-36 rounded-md shadow">
                @endif --}}
                <label class="block text-gray-700 font-semibold mb-2">Foto Buku</label>
                <input type="file" name="foto_buku" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200">
                @error('foto_buku')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Judul Buku -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Judul Buku</label>
                <input type="text" name="judul_buku" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200" value="{{ old('judul_buku', $buku->judul_buku) }}" >
                @error('judul_buku')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Author Buku -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Author</label>
                <input type="text" name="author_buku" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200" value="{{ old('author_buku', $buku->author_buku) }}" >
                @error('author_buku')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Publisher Buku -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Publisher</label>
                <input type="text" name="publisher_buku" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200" value="{{ old('publisher_buku', $buku->publisher_buku) }}" >
                @error('publisher_buku')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tahun Terbit -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Tahun Terbit</label>
                <input type="text" name="tahun_terbit" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" >
                @error('tahun_terbit')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Bahasa Buku -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Bahasa</label>
                <input type="text" name="bahasa_buku" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200" value="{{ old('bahasa_buku', $buku->bahasa_buku) }}" >
                @error('bahasa_buku')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Stok Buku -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Stok Buku</label>
                <input type="number" name="stok_buku" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200" value="{{ old('stok_buku', $buku->stok_buku) }}"  min="0">
                @error('stok_buku')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Rak Buku -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Rak Buku</label>
                <input type="number" name="rak_buku" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200" value="{{ old('rak_buku', $buku->rak_buku) }}" >
                @error('rak_buku')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Kategori Buku -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Kategori Buku</label>
                <select name="id_kategori_buku" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200" >
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoriBuku as $kategori)
                        <option value="{{ $kategori->id_kategori_buku }}" {{ old('id_kategori_buku', $buku->id_kategori_buku) == $kategori->id_kategori_buku ? 'selected' : '' }}>
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
                <label class="block text-gray-700 font-semibold mb-2">Jenis Buku</label>
                <select name="id_jenis_buku" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200" >
                    <option value="">Pilih Jenis</option>
                    @foreach($jenisBuku as $jenis)
                        <option value="{{ $jenis->id_jenis_buku }}" {{ old('id_jenis_buku', $buku->id_jenis_buku) == $jenis->id_jenis_buku ? 'selected' : '' }}>
                            {{ $jenis->nama_jenis_buku }}
                        </option>
                    @endforeach
                </select>
                @error('id_jenis_buku')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Harga Buku -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Harga Buku</label>
                <input type="number" name="harga_buku" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200" value="{{ old('harga_buku', $buku->harga_buku) }}" min="0" step="0.01">
                @error('harga_buku')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tombol Submit -->
            <div class="text-left">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-600 transition duration-300">Update Buku</button>
            </div>
        </form>
    </div>
</x-staffperpustakaan-layout>
