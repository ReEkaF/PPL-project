<x-app-guru-layout>
    <div class="p-2 mx-4 my-6 bg-white rounded-lg shadow xl:p-6">
        {{-- Breadcrumb --}}
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="flex px-3 space-x-2">
                <li class="flex">
                    <a href="{{ route('guru.dashboard') }}" class="text-gray-400 hover:text-gray-700">
                        <span>Dashboard</span>
                    </a>
                </li>
                <div class="flex justify-center py-1">
                    <svg class="flex w-4 h-4 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7" />
                    </svg>
                </div>
                <li class="flex">
                    <a href="{{ route('guru.dashboard') }}" class="text-gray-400 hover:text-gray-700">
                        <span>Ujian</span>
                    </a>
                </li>
                <div class="flex justify-center py-1">
                    <svg class="flex w-4 h-4 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7" />
                    </svg>
                </div>
                <li class="flex">
                    <p class="font-semibold text-gray-700">
                        <span>Soal Ujian</span>
                    </p>
                </li>
            </ol>
        </nav>


        {{-- Main Content --}}
        <div class="container mx-auto mt-10">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Form Tambah Ujian</h2>
            <form action="{{ route('ujian.stored') }}" method="POST" class="mt-4">
                @csrf
                <!-- Judul Ujian -->
                <div class="mb-4">
                    <label for="judul" class="block text-sm font-medium text-gray-700">Judul Ujian</label>
                    <input type="text" name="judul" id="judul" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <!-- Deskripsi Ujian -->
                <div class="mb-4">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Ujian</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>

                <!-- Pilih Topik -->
                <div class="mb-4">
                    <label for="topik_id" class="block text-sm font-medium text-gray-700">Topik</label>
                    <select name="topik_id" id="topik_id" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="" disabled selected>Pilih Topik</option>
                        @foreach ($topik as $item)
                        <option value="{{ $item->id_topik }}">{{ $item->judul_topik }}</option>
                        @endforeach
                    </select>
                    {{-- {{ dd($item) }} --}}
                </div>

                {{--Jenis Ujian--}}
                <div class="mb-4">
                    <label for="jenis_ujian" class="block text-sm font-medium text-gray-700">Jenis Ujian</label>
                    <select name="jenis_ujian" id="jenis_ujian" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="UTS">UTS</option>
                        <option value="UAS">UAS</option>
                    </select>
                    {{-- {{ dd($item) }} --}}
                </div>

                <!-- Pilih Kelas Mata Pelajaran -->
                <div class="mb-4">
                    <label for="kelas_mata_pelajaran_id" class="block text-sm font-medium text-gray-700">Kelas Mata Pelajaran</label>
                    <select name="kelas_mata_pelajaran_id" id="kelas_mata_pelajaran_id" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="" disabled selected>Pilih Kelas Mata Pelajaran</option>
                        @foreach ($kelasMataPelajaran as $item)
                        <option value="{{ $item->id_kelas_mata_pelajaran }}">{{ $item->kelas->nama_kelas }} - {{ $item->mataPelajaran->nama_matpel }}</option>
                        @endforeach
                    </select>
                    {{-- {{ dd($item) }} --}}
                </div>

                <!-- Tanggal Dibuat -->
                <div class="mb-4">
                    <label for="tanggal_dibuat" class="block text-sm font-medium text-gray-700">Tanggal Dibuat</label>
                    <input type="date" name="tanggal_dibuat" id="tanggal_dibuat" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <!-- Submit Button -->
                <div class="text-right">
                    <button id="submitUjian" type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-guru-layout>