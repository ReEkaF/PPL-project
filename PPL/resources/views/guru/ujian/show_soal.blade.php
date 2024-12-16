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
                    <p class="font-semibold text-gray-700">
                        <span>Soal Ujian</span>
                    </p>
                </li>
            </ol>
        </nav>

        {{-- MAIN CONTENT --}}
        <div class="container mx-auto mt-10">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Table Ujian</h2>
            <table class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold text-gray-700">No</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold text-gray-700">Judul Ujian</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold text-gray-700">Teks Soal</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold text-gray-700">Opsi A</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold text-gray-700">Opsi B</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold text-gray-700">Opsi C</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold text-gray-700">Opsi D</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold text-gray-700">Kunci Jawaban</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($soalUjian as $index => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $item->judul_ujian }}</td>
                            <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $item->teks_soal }}</td>
                            <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $item->opsi_a }}</td>
                            <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $item->opsi_b }}</td>
                            <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $item->opsi_c }}</td>
                            <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $item->opsi_d }}</td>
                            <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $item->kunci_jawaban }}</td>
                            <td class="px-4 py-2 border-b text-sm text-gray-700">
                                <a href="{{ route('soal_ujian.edit', $item->id_soal_ujian) }}" class="text-blue-500 hover:text-blue-700">Edit</a>
                                <a href="{{ route('soal_ujian.destroy', $item->id_soal_ujian) }}" class="text-red-500 hover:text-red-700 ml-4" onclick="return confirm('Apakah Anda yakin ingin menghapus soal ini?')">Hapus</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-guru-layout>
