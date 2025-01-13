<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Data Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if(session('success'))
        <div id="success-message" class="bg-green-500 text-white text-center py-2 px-4 rounded-md shadow-md mb-6">
            {{ session('success') }}
        </div>
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <nav class="text-sm text-gray-500 mb-4">
                    <ol class="flex px-0 space-x-1">
                        <li class="flex">
                            <a href="{{ route('superadmin.dashboard') }}" class="text-gray-400 hover:text-gray-700">
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <div class="flex justify-center py-1">
                            <svg class="flex w-4 h-4 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7" />
                            </svg>
                        </div>
                        <li class="flex">
                            <a href="{{ route('superadmin.keloladatasiswa') }}" class="text-gray-400 hover:text-gray-700">
                                <span>Kelola Data Siswa</span>
                            </a>
                        </li>
                    </ol>
                </nav>
                <h3 class="text-lg font-semibold mb-4">Kelola Data Siswa</h3>
                <div class="mb-4 flex justify-between items-center">
                    <div>
                        <a href="{{ route('data.siswa.tambah') }}" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Tambah Data</a>
                    </div>
                    <form action="{{ route('superadmin.searchSiswa') }}" method="GET" class="flex space-x-2">
                        <input type="text" name="search" placeholder="Cari NISN" value="{{ request('search') }}"
                            class="border border-gray-300 rounded-md px-4 py-2 focus:border-blue-500 focus:outline-none">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Cari</button>
                    </form>
                </div>

                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 text-sm leading-normal">
                            <th class="py-3 px-4 text-left">Foto</th>
                            <th class="py-3 px-4 text-left">Nama Siswa</th>
                            <th class="py-3 px-4 text-left">Jenis Kelamin</th>
                            <th class="py-3 px-4 text-left">NISN</th>
                            {{-- <th class="py-3 px-4 text-left">Kelas</th> --}}
                            <th class="py-3 px-4 text-left">Alamat</th>
                            <th class="py-3 px-4 text-left">Telephone</th>
                            <th class="py-3 px-4 text-left">E-Mail</th>
                            <th class="py-3 px-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($siswaData as $siswa)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-4 text-left">
                                <img src="{{ $siswa->foto_siswa ? asset('images/siswa/' . $siswa->foto_siswa) : 'https://cdn.pixabay.com/photo/2018/11/13/21/43/avatar-3814049_640.png' }}" alt="Foto" class="w-10 h-10 rounded-full">
                            </td>



                            <td class="py-3 px-4">{{ $siswa->nama_siswa }}</td>
                            <td class="py-3 px-4">{{ $siswa->jenis_kelamin_siswa }}</td>
                            <td class="py-3 px-4">{{ $siswa->nisn }}</td>
                            {{-- <td class="py-3 px-4">
                                    @foreach ($siswa->kelas as $kelas)
                                        {{ $kelas->nama_kelas }}@if (!$loop->last), @endif
                            @endforeach
                            </td> --}}
                            <td class="py-3 px-4">{{ $siswa->alamat_siswa }}</td>
                            <td class="py-3 px-4">{{ $siswa->nomor_wa_siswa }}</td>
                            <td class="py-3 px-4">{{ $siswa->email }}</td>
                            <td class="py-3 px-4 flex space-x-2">
                                <a href="{{ route('siswa.edit', ['id_siswa' => $siswa->id_siswa]) }}" class="bg-blue-500 text-white px-2 py-1 rounded-md hover:bg-blue-600">Edit</a>
                                <form action="{{ route('siswa.destroy', $siswa->id_siswa) }}" method="POST" onsubmit="return confirmDelete(event)" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded-md hover:bg-red-600">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4 flex justify-between items-center">
                    <div>
                        <p class="text-gray-600">
                            Showing <b>{{ $siswaData->firstItem() }}</b> to <b>{{ $siswaData->lastItem() }}</b> of <b>{{ $siswaData->total() }}</b> results
                        </p>
                    </div>
                    <div class="flex justify-end">
                        @if ($siswaData->currentPage() > 1)
                        <a href="{{ $siswaData->previousPageUrl() }}" class="px-4 py-2 border rounded-l-lg bg-gray-200 hover:bg-gray-300">Previous</a>
                        @endif
                        @if ($siswaData->currentPage() > 2)
                        <a href="{{ $siswaData->url(1) }}" class="px-4 py-2 border bg-gray-200 hover:bg-gray-300">1</a>
                        @if ($siswaData->currentPage() > 3)
                        <span class="px-4 py-2 border bg-gray-200 text-gray-500">...</span>
                        @endif
                        @endif
                        @for ($i = max(1, $siswaData->currentPage() - 1); $i <= min($siswaData->lastPage(), $siswaData->currentPage() + 1); $i++)
                            <a href="{{ $siswaData->url($i) }}" class="px-4 py-2 border {{ $i === $siswaData->currentPage() ? 'bg-blue-500 text-white font-bold' : 'bg-gray-200 hover:bg-gray-300' }}">
                                {{ $i }}
                            </a>
                            @endfor
                            @if ($siswaData->currentPage() < $siswaData->lastPage() - 2)
                                <span class="px-4 py-2 border bg-gray-200 text-gray-500">...</span>
                                <a href="{{ $siswaData->url($siswaData->lastPage()) }}" class="px-4 py-2 border bg-gray-200 hover:bg-gray-300">{{ $siswaData->lastPage() }}</a>
                                @endif
                                @if ($siswaData->currentPage() < $siswaData->lastPage())
                                    <a href="{{ $siswaData->nextPageUrl() }}" class="px-4 py-2 border rounded-r-lg bg-gray-200 hover:bg-gray-300">Next</a>
                                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function confirmDelete(event) {
            event.preventDefault();
            const confirmation = confirm("Apakah Anda yakin ingin menghapus data ini?");
            if (confirmation) {
                event.target.submit();
            }
        }

        // Hide success message smoothly
        document.addEventListener("DOMContentLoaded", function() {
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.opacity = '0';
                    setTimeout(() => successMessage.remove(), 500);
                }, 3000);
            }
        });
    </script>
</x-admin-layout>