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
                <li class="flex">
                    <a href="{{ route('ujian.show') }}" class="text-gray-400 hover:text-gray-700">
                        <span>Beranda Ujian</span>
                    </a>
                </li>
                <div class="flex justify-center py-1">
                    <svg class="flex w-4 h-4 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
                    </svg>
                </div>
                <li class="flex">
                    <p class="font-semibold text-gray-700">
                        <span>Tambah Soal</span>
                    </p>
                </li>
            </ol>
        </nav>

        {{-- main content --}}
        <!-- Import Soal Ujian dari Excel -->
        <div class="mb-6">
            <form action="{{ route('soal_ujian.import', ['ujian_id' => $ujian_id]) }}" method="POST" enctype="multipart/form-data" id="importExcelForm">
                @csrf
                <input type="hidden" name="ujian_id" value="{{ $ujian_id }}">
                <label class="block mb-2 text-sm font-medium text-gray-700" for="file_input">Import Soal Ujian dari Excel</label>
                <input name="file" type="file" class="file-input block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" id="file_input" required>
                <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Upload</button>
            </form>
        </div>
    </div>
</x-app-guru-layout>
