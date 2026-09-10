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
                        <span>Jawaban Ujian</span>
                    </p>
                </li>
            </ol>
        </nav>

        {{-- Main Content --}}
        <div class="container mx-auto mt-10">
            <h2 class="text-2xl font-bold mb-4">Daftar Jawaban Ujian</h2>

            {{-- Cek jika tidak ada data --}}
                <!-- Table for CRUD -->
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="py-3 px-6">No.</th>
                                <th class="py-3 px-6">Soal</th>
                                <th class="py-3 px-6">Jawaban Dipilih</th>
                                <th class="py-3 px-6">Tanggal</th>
                                <th class="py-3 px-6">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($jawabanUjian->isEmpty())
                                <tr>
                                    <td colspan="7" class="px-4 py-2 border-b text-center text-sm text-gray-700">
                                        Belum ada jawaban ujian yang dikumpulkan
                                    </td>
                                </tr>
                            @else
                                @foreach($jawabanUjian as $jawaban)
                                <tr class="bg-white border-b">
                                    <td class="py-4 px-6">{{ $loop->iteration }}</td>
                                    <td class="py-4 px-6">{{ $jawaban->soalUjian->teks_soal ?? 'Tidak ada' }}</td>
                                    <td class="py-4 px-6">{{ $jawaban->jawaban_dipilih }}</td>
                                    <td class="py-4 px-6">{{ $jawaban->created_at->format('d M Y') }}</td>
                                    <td class="py-4 px-6">
                                        <a href="{{ route('jawaban_ujian.edit', ['id' => $jawaban->id_jawaban_ujian]) }}" class="text-blue-600 hover:underline">Edit</a> |
                                        <form action="{{ route('jawaban_ujian.destroy', $jawaban->id_jawaban_ujian) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Yakin ingin menghapus?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
</x-app-guru-layout>
