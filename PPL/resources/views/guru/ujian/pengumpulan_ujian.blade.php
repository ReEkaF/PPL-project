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
                        <span>Pengumpulan Ujian</span>
                    </p>
                </li>
            </ol>
        </nav>

        {{-- Main Content --}}

        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="py-3 px-6">No.</th>
                        <th class="py-3 px-6">Nama Siswa</th>
                        <th class="py-3 px-6">Judul Ujian</th>
                        <th class="py-3 px-6">Tanggal Pengumpulan</th>
                        <th class="py-3 px-6">Nilai</th>
                        <th class="py-3 px-6">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengumpulanUjian as $item)
                    {{-- {{ dd($item) }} --}}
                    <tr class="bg-white border-b">
                        <td class="py-4 px-6">{{ $loop->iteration }}</td>
                        <td class="py-4 px-6">{{ $item->siswa->nama_siswa ?? 'Tidak Ada Data' }}</td>
                        <td class="py-4 px-6">{{ $item->ujian->judul ?? 'Tidak Ada Data' }}</td>
                        <td class="py-4 px-6">{{ $item->tanggal_pengumpulan }}</td>
                        <td class="py-4 px-6">{{ $item->nilai ?? 'Belum Dinilai' }}</td>
                        <td class="py-4 px-6">
                            {{-- <a href="{{ route('guru.dashboard.pengumpulan_ujian.edit', $item->id_pengumpulan_ujian) }}" class="text-blue-600 hover:underline">Edit</a> | --}}
                            <form action="{{ route('guru.dashboard.pengumpulan_ujian.destroy', $item->id_pengumpulan_ujian) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @if($pengumpulanUjian->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-700">Tidak ada data pengumpulan ujian.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</x-app-guru-layout>
