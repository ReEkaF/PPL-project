<x-staffperpustakaan-layout>
    <div class="container mx-auto p-6 bg-white rounded shadow-lg">
        <h1 class="text-3xl font-semibold mb-6 text-center">Daftar Buku</h1>
        
        <!-- Form Pencarian dan Tombol Tambah Buku -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center justify-between mb-6">
                <form action="{{ route('staff_perpus.buku.daftarbuku') }}" method="GET" class="flex w-full gap-4">
                    @csrf
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Cari Judul Buku" 
                        class="border border-gray-300 rounded-lg px-4 py-2 w-300" 
                        value="{{ old('search', request('search')) }}"
                    />
                    <select 
                        name="kategori_buku" 
                        class="border border-gray-300 rounded-lg px-4 py-2 w-200"
                        onchange="this.form.submit()"
                    >
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoriBuku as $cat)
                            <option value="{{ $cat->id_kategori_buku }}" 
                                {{ old('kategori_buku', request('kategori_buku')) == $cat->id_kategori_buku ? 'selected' : '' }}>
                                {{ $cat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
            <!-- Tombol Tambah Buku -->
            <a href="{{ route('staff_perpus.buku.create') }}" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-800">Tambah Buku</a>
        </div>
        
        <!-- Tabel Buku -->
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 text-sm text-left">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="border-b px-4 py-2 text-gray-600">Gambar</th>
                        <th class="border-b px-4 py-2 text-gray-600">Nama Buku</th>
                        <th class="border-b px-4 py-2 text-gray-600">Author</th>
                        <th class="border-b px-4 py-2 text-gray-600">Kategori</th>
                        <th class="border-b px-4 py-2 text-gray-600">Jenis</th>
                        <th class="border-b px-4 py-2 text-gray-600">Stok</th>
                        <th class="border-b px-4 py-2 text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($buku as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="border-b px-4 py-2">
                            <img src="{{ asset($item->foto_buku) }}" alt="Gambar Buku" class="w-16 h-16 rounded shadow-md">
                        </td>
                        <td class="border-b px-4 py-2">{{ $item->judul_buku }}</td>
                        <td class="border-b px-4 py-2">{{ $item->author_buku }}</td>
                        <td class="border-b px-4 py-2">{{ $item->kategoriBuku->nama_kategori }}</td>
                        <td class="border-b px-4 py-2">{{ $item->jenisBuku->nama_jenis_buku }}</td>
                        <td class="border-b px-4 py-2">{{ $item->stok_buku }}</td>
                        <td class="border-b px-4 py-2 space-x-2">
                            <!-- Link Detail -->
                            <a href="{{ route('staff_perpus.buku.detail', $item->id_buku) }}" class="text-green-500 hover:underline">Detail</a>
                            <!-- Link Edit -->
                            <a href="{{ route('staff_perpus.buku.edit', $item->id_buku) }}" class="text-blue-500 hover:underline">Edit</a>
                            <!-- Form Delete -->
                            <form action="{{ route('staff_perpus.buku.destroy', $item->id_buku) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="mt-6">
            {{ $buku->links() }}
        </div>

        @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


    </div>
</x-staffperpustakaan-layout>
