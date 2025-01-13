<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Data Guru') }}
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
                            <a href="{{ route('superadmin.keloladataguru') }}" class="text-gray-400 hover:text-gray-700">
                                <span>Kelola Data Guru</span>
                            </a>
                        </li>
                    </ol>
                </nav>

                <h3 class="text-lg font-semibold mb-4">Kelola Data Guru</h3>

                <div class="mb-4 flex justify-between items-center">
                    <div>
                        <a href="{{ route('data.guru.tambah') }}" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Tambah Data</a>
                    </div>
                    <form action="{{ route('superadmin.searchGuru') }}" method="GET" class="flex space-x-2">
                        <input type="text" name="search" placeholder="Cari NIP" value="{{ request('search') }}"
                            class="border border-gray-300 rounded-md px-4 py-2 focus:border-blue-500 focus:outline-none">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Cari</button>
                    </form>
                </div>

                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 text-sm leading-normal">
                            <th class="py-3 px-4 text-left">Foto</th>
                            <th class="py-3 px-4 text-left">Nama Guru</th>
                            <th class="py-3 px-4 text-left">NIP</th>
                            <th class="py-3 px-4 text-left">Alamat</th>
                            <th class="py-3 px-4 text-left">No. WA</th>
                            <th class="py-3 px-4 text-left">E-Mail</th>
                            <th class="py-3 px-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($guruData as $guru)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-4 text-left">
                                <img src="{{ $guru->foto_guru ? asset('images/guru/' . $guru->foto_guru) : 'https://cdn.pixabay.com/photo/2018/11/13/21/43/avatar-3814049_640.png' }}" alt="Foto" class="w-10 h-10 rounded-full">
                            </td>

                            <td class="py-3 px-4">{{ $guru->nama_guru }}</td>
                            <td class="py-3 px-4">{{ $guru->nip }}</td>
                            <td class="py-3 px-4">{{ $guru->alamat_guru }}</td>
                            <td class="py-3 px-4">{{ $guru->nomor_wa_guru }}</td>
                            <td class="py-3 px-4">{{ $guru->email }}</td>
                            <td class="py-3 px-4 flex space-x-2">
                                <a href="{{ route('guru.edit', $guru->id_guru) }}" class="bg-blue-500 text-white px-2 py-1 rounded-md hover:bg-blue-600">Edit</a>
                                <form action="{{ route('guru.destroy', $guru->id_guru) }}" method="POST" onsubmit="return confirmDelete(event)" class="inline">
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
                            Showing <b>{{ $guruData->firstItem() }}</b> to <b>{{ $guruData->lastItem() }}</b> of <b>{{ $guruData->total() }}</b> results
                        </p>
                    </div>
                    <div class="flex justify-end">
                        @if ($guruData->currentPage() > 1)
                        <a href="{{ $guruData->previousPageUrl() }}" class="px-4 py-2 border rounded-l-lg bg-gray-200 hover:bg-gray-300">Previous</a>
                        @endif
                        @if ($guruData->currentPage() > 2)
                        <a href="{{ $guruData->url(1) }}" class="px-4 py-2 border bg-gray-200 hover:bg-gray-300">1</a>
                        @if ($guruData->currentPage() > 3)
                        <span class="px-4 py-2 border bg-gray-200 text-gray-500">...</span>
                        @endif
                        @endif
                        @for ($i = max(1, $guruData->currentPage() - 1); $i <= min($guruData->lastPage(), $guruData->currentPage() + 1); $i++)
                            <a href="{{ $guruData->url($i) }}" class="px-4 py-2 border {{ $i === $guruData->currentPage() ? 'bg-blue-500 text-white font-bold' : 'bg-gray-200 hover:bg-gray-300' }}">
                                {{ $i }}
                            </a>
                            @endfor
                            @if ($guruData->currentPage() < $guruData->lastPage() - 2)
                                <span class="px-4 py-2 border bg-gray-200 text-gray-500">...</span>
                                <a href="{{ $guruData->url($guruData->lastPage()) }}" class="px-4 py-2 border bg-gray-200 hover:bg-gray-300">{{ $guruData->lastPage() }}</a>
                                @endif
                                @if ($guruData->currentPage() < $guruData->lastPage())
                                    <a href="{{ $guruData->nextPageUrl() }}" class="px-4 py-2 border rounded-r-lg bg-gray-200 hover:bg-gray-300">Next</a>
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