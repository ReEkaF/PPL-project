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
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
                    </svg>
                </div>
                <li class="flex">
                    <a href="{{ route('guru.dashboard') }}" class="text-gray-400 hover:text-gray-700">
                        <span>Ujian</span>
                    </a>
                </li>
                <div class="flex justify-center py-1">
                    <svg class="flex w-4 h-4 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
                    </svg>
                </div>
                <li class="flex">
                    <a href="{{ route('guru.dashboard') }}" class="text-gray-400 hover:text-gray-700">
                        <span>Soal Ujian</span>
                    </a>
                </li>
                <div class="flex justify-center py-1">
                    <svg class="flex w-4 h-4 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
                    </svg>
                </div>
                <li class="flex">
                    <p class="font-semibold text-gray-700">
                        <span>Edit Soal Ujian</span>
                    </p>
                </li>
            </ol>
        </nav>


        {{-- Main Content --}}
        <h2 class="text-xl font-bold text-gray-700">Edit Soal Ujian</h2>
        <form action="{{ route('soal_ujian.update', $soal->id_soal_ujian) }}" method="POST" class="mt-4">
        @csrf
        @method('PUT')

        {{-- Judul Ujian --}}
        <div class="mb-4">
            <label for="judul_ujian" class="block text-sm font-medium text-gray-700">Judul Ujian</label>
            <input type="text" name="judul_ujian" id="judul_ujian" value="{{ old('judul_ujian', $soal->judul_ujian) }}" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200" required>
        </div>

        {{-- Teks Soal --}}
        <div class="mb-4">
            <label for="teks_soal" class="block text-sm font-medium text-gray-700">Teks Soal</label>
            <textarea name="teks_soal" id="teks_soal" rows="4" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200" required>{{ old('teks_soal', $soal->teks_soal) }}</textarea>
        </div>

        {{-- Opsi Jawaban --}}
        {{-- OPSI A --}}
        <div class="mb-4">
            <label for="opsi_a" class="block text-sm font-medium text-gray-700">Opsi A</label>
            <input type="text" name="opsi_a" id="opsi_a" value="{{ old('opsi_a', $jawaban->first()->opsi_a ?? '') }}" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200" required>
        </div>
        {{-- OPSI B --}}
        <div class="mb-4">
            <label for="opsi_b" class="block text-sm font-medium text-gray-700">Opsi B</label>
            <input type="text" name="opsi_b" id="opsi_b" value="{{ old('opsi_b', $jawaban->first()->opsi_b ?? '') }}" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200" required>
        </div>
        {{-- OPSI C --}}
        <div class="mb-4">
            <label for="opsi_c" class="block text-sm font-medium text-gray-700">Opsi C</label>
            <input type="text" name="opsi_c" id="opsi_c" value="{{ old('opsi_c', $jawaban->first()->opsi_c ?? '') }}" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200" required>
        </div>
        {{-- OPSI D --}}
        <div class="mb-4">
            <label for="opsi_d" class="block text-sm font-medium text-gray-700">Opsi D</label>
            <input type="text" name="opsi_d" id="opsi_d" value="{{ old('opsi_d', $jawaban->first()->opsi_d ?? '') }}" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200" required>
        </div>

        {{-- Kunci Jawaban --}}
        <div class="mb-4">
            <label for="kunci_jawaban" class="block text-sm font-medium text-gray-700">Kunci Jawaban</label>
            <select name="kunci_jawaban" id="kunci_jawaban" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200" required>
                <option value="" disabled selected>Pilih Kunci Jawaban</option>
                @if ($jawaban->first())
                    <option value="{{ $jawaban->first()->opsi_a }}" {{ $jawaban->first()->kunci_jawaban == $jawaban->first()->opsi_a ? 'selected' : '' }}>
                        {{ $jawaban->first()->opsi_a }}
                    </option>
                    <option value="{{ $jawaban->first()->opsi_b }}" {{ $jawaban->first()->kunci_jawaban == $jawaban->first()->opsi_b ? 'selected' : '' }}>
                        {{ $jawaban->first()->opsi_b }}
                    </option>
                    <option value="{{ $jawaban->first()->opsi_c }}" {{ $jawaban->first()->kunci_jawaban == $jawaban->first()->opsi_c ? 'selected' : '' }}>
                        {{ $jawaban->first()->opsi_c }}
                    </option>
                    <option value="{{ $jawaban->first()->opsi_d }}" {{ $jawaban->first()->kunci_jawaban == $jawaban->first()->opsi_d ? 'selected' : '' }}>
                        {{ $jawaban->first()->opsi_d }}
                    </option>
                    @else
                    <option value="" disabled selected>Tidak ada opsi tersedia</option>
                    @endif
            </select>
        </div>

        {{-- Tombol Submit --}}
        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-200">
                Simpan Perubahan
            </button>
        </div>
    </form>
    </div>
</x-app-guru-layout>
