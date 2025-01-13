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
                    <a href="{{ route('ujian.show') }}" class="text-gray-400 hover:text-gray-700">
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
                        <span>Beranda Ujian</span>
                    </p>
                </li>
            </ol>
        </nav>

        {{-- Main Content --}}
        <div class="container mx-auto mt-10">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Table Ujian</h2>

            {{-- Tabel Daftar Ujian --}}
            <table class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold text-gray-700">No</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold text-gray-700">Judul Ujian</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold text-gray-700">Deskripsi</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold text-gray-700">Topik</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold text-gray-700">Kelas Mata Pelajaran</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold text-gray-700">Tanggal Dibuat</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($ujian->isEmpty())
                        <tr>
                            <td colspan="7" class="px-4 py-2 border-b text-center text-sm text-gray-700">
                                Belum ada ujian yang dibuat
                            </td>
                        </tr>
                    @else
                        @foreach ($ujian as $index => $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $item->judul }}</td>
                                <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $item->deskripsi ?? 'N/A' }}</td>
                                <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $item->topik->judul_topik ?? 'N/A' }}</td>
                                <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $item->kelasMataPelajaran->kelas->nama_kelas ?? 'N/A' }} - {{ $item->kelasMataPelajaran->mataPelajaran->nama_matpel ?? 'N/A' }}</td>
                                <td class="px-4 py-2 border-b text-sm text-gray-700">{{ \Carbon\Carbon::parse($item->tanggal_dibuat)->format('d M Y') }}</td>
                                <td class="px-4 py-2 border-b text-sm text-gray-700">
                                    <a href="{{ route('guru.ujian.add.soal', $item->id_ujian) }}" class="text-green-500 hover:text-green-700 ml-4">Tambah Soal</a>
                                    <a href="{{ route('guru.ujian.soal_ujian', $item->id_ujian) }}" class="text-purple-500 hover:text-purple-700 ml-4">Lihat Soal</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $ujian->links() }} <!-- Menampilkan pagination -->
            </div>

            {{-- Tombol Tambah Ujian --}}
            <div class="mt-4 text-right">
                <a href="{{ route('guru.dashboard.ujian.create_ujian') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Tambah Ujian</a>
            </div>
        </div>
    </div>
</x-app-guru-layout>
