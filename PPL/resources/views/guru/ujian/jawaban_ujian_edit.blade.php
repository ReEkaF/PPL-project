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
                        <span>Jawaban Ujian</span>
                    </a>
                </li>
                <div class="flex justify-center py-1">
                    <svg class="flex w-4 h-4 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
                    </svg>
                </div>
                <li class="flex">
                    <p class="font-semibold text-gray-700">
                        <span>Edit Jawaban Ujian</span>
                    </p>
                </li>
            </ol>
        </nav>

        {{-- Main Content --}}
        <div class="p-4 mx-4 my-6 bg-white rounded-lg shadow xl:p-6">
            <h2 class="text-2xl font-bold mb-4">Edit Jawaban Ujian</h2>

        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 p-4 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('jawaban_ujian.update', $jawaban->id_jawaban_ujian) }}" method="POST">
            @csrf
            @method('PUT')
            {{-- {{dd($jawaban)}} --}}

            <div class="mb-4">
                <label for="soal_id" class="block text-sm font-medium text-gray-700">Soal Ujian</label>
                <select name="soal_id" id="soal_id" class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                    @foreach($soalUjian as $soal)
                        <option value="{{ $soal->soal_id }}" {{ $jawaban->soal_id == $soal->soal_id ? 'selected' : '' }}>
                            {{ $soal->teks_soal }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="jawaban_dipilih" class="block text-sm font-medium text-gray-700">Jawaban Dipilih</label>
                <select name="jawaban_dipilih" id="jawaban_dipilih" class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                    @php
                        $opsi = $soalUjian->firstWhere('id_soal_ujian', $jawaban->soal_id);
                    @endphp
                    @if ($opsi)
                    <option value="{{ $opsi->opsi_a }}" {{ $jawaban->jawaban_dipilih == $opsi->opsi_a ? 'selected' : '' }}>
                        {{ $opsi->opsi_a }}
                    </option>
                    <option value="{{ $opsi->opsi_b }}" {{ $jawaban->jawaban_dipilih == $opsi->opsi_b ? 'selected' : '' }}>
                        {{ $opsi->opsi_b }}
                    </option>
                    <option value="{{ $opsi->opsi_c }}" {{ $jawaban->jawaban_dipilih == $opsi->opsi_c ? 'selected' : '' }}>
                        {{ $opsi->opsi_c }}
                    </option>
                    <option value="{{ $opsi->opsi_d }}" {{ $jawaban->jawaban_dipilih == $opsi->opsi_d ? 'selected' : '' }}>
                        {{ $opsi->opsi_d }}
                    </option>
                    @else
                    <option value="" disabled selected>Tidak ada opsi tersedia</option>
                    @endif
                </select>
            </div>


            {{-- <div class="mb-4">
                <label for="jawaban_dipilih" class="block text-sm font-medium text-gray-700">Jawaban Dipilih</label>
                <input type="text" name="jawaban_dipilih" id="jawaban_dipilih" value="{{ $jawaban->jawaban_dipilih }}" class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm">
            </div> --}}

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
            <a href="{{ route('guru.dashboard.ujian.jawaban_ujian') }}" class="ml-4 text-gray-500 hover:underline">Batal</a>
        </form>
        </div>
    </div>
</x-app-guru-layout>
