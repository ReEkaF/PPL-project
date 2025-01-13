<x-staffperpustakaan-layout>
    <div class="container mx-auto max-w-lg p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Tambah Transaksi Peminjaman Buku</h1>
        <a href="{{ route('staff_perpus.transaksi.daftartransaksi') }}"  class="text-blue-500 hover:text-blue-700 flex items-center mt-12">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali
        </a>
        @if ($errors->has('message'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $errors->first('message') }}</li>
                @endforeach
            </ul>
            </div>
        @endif

        {{-- @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}

        <form action="{{ route('staff_perpus.transaksi.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Pilih Jenis Peminjam (Guru/Siswa) -->
            <div>
                <label for="jenis_peminjam" class="block text-gray-700 font-semibold mb-1">Jenis Peminjam</label>
                <select name="jenis_peminjam" id="jenis_peminjam" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" >
                    <option value="">Pilih Jenis Peminjam</option>
                    <option value="siswa">Siswa</option>
                    <option value="guru">Guru</option>
                </select>
                @error('jenis_peminjam')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
            </div>

            <!-- Input NISN/NIP -->
            <div>
                <label for="nisn_nip" class="block text-gray-700 font-semibold mb-1">NISN/NIP</label>
                <input type="text" name="nisn_nip" id="nisn_nip" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" >
                @error('nisn_nip')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
            </div>

            <!-- Pilih Buku -->
            <div>
                <label for="id_buku" class="block text-gray-700 font-semibold mb-1">Buku yang Ingin Dipinjam</label>
                <select name="id_buku" id="id_buku" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" >
                    <option value="">Pilih Buku</option>
                    @foreach($buku as $b)
                        <option value="{{ $b->id_buku }}">{{ $b->judul_buku }}</option>
                    @endforeach
                </select>
                @error('id_buku')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
            </div>

            <!-- Jumlah Buku yang Dipinjam -->
            {{-- <div>
                <label for="jumlah" class="block text-gray-700 font-semibold mb-1">Jumlah Buku yang Dipinjam</label>
                <input type="number" name="jumlah" id="jumlah" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                @error('jumlah')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
            </div> --}}

            <!-- Submit Button -->
            <div class="text-left">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-600 transition duration-300">Simpan Transaksi</button>
            </div>
        </form>
    </div>
</x-staffperpustakaan-layout>
