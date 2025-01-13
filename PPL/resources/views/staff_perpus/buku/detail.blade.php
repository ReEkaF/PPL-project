<x-staffperpustakaan-layout>
    
    <div class="container mx-auto p-6 bg-white rounded shadow-lg">
        <h1 class="text-3xl font-semibold mb-6 text-center">Detail Buku</h1>

        {{-- <div class="mb-6">
            <img src="{{ asset($buku->foto_buku) }}"  alt="Gambar Buku" class="w-32 h-32 mx-auto rounded shadow-md">
        </div> --}}
        <div>
            <a href="{{ route('staff_perpus.buku.daftarbuku') }}" class="text-blue-500 hover:text-blue-700 flex items-center mt-12">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
        </div>

        <div class="mt-6 max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6 flex">
            <!-- Gambar Buku -->
            <div class="w-500">
                <img src="{{ asset($buku->foto_buku) }}" alt="{{ $buku->judul_buku }}" class="w-full h-[250px] rounded-md object-cover mb-4">
            </div>
            <div class="w-2/3 ml-6">
                <h2 class="text-2xl font-bold"><p><strong>Judul Buku:</strong> {{ $buku->judul_buku }}</p></h2>
                {{-- <p><strong>Judul Buku:</strong> {{ $buku->judul_buku }}</p> --}}
                <p><strong>Author:</strong> {{ $buku->author_buku }}</p>
                <p><strong>Kategori:</strong> {{ $buku->kategoriBuku->nama_kategori }}</p>
                <p><strong>Jenis:</strong> {{ $buku->jenisBuku->nama_jenis_buku }}</p>
                <p><strong>Stok:</strong> {{ $buku->stok_buku }}</p>
                <p><strong>Tahun Terbit:</strong> {{ $buku->tahun_terbit }}</p>
                <p><strong>Bahasa:</strong> {{ $buku->bahasa_buku }}</p>
                <p><strong>Publisher:</strong> {{ $buku->publisher_buku }}</p>
                <p><strong>Harga:</strong> {{ $buku->harga_buku }}</p>
            </div>
        
            {{-- <div class="mt-6 text-center">
                <a href="{{ route('staff_perpus.buku.daftarbuku') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Kembali</a>
            </div> --}}
        </div>
</x-staffperpustakaan-layout>
