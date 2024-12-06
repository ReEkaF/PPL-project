<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Data Pembina Ekstrakurikuler') }}
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
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
                            </svg>
                        </div>
                        <li class="flex">
                            <a href="{{ route('superadmin.kelola_pembina_ekstrakurikuler') }}" class="text-black-500 hover:underline">
                                <span><b>Kelola Data Pembina Ekstrakurikuler</b></span>
                            </a>
                        </li>
                    </ol>
                </nav>                                   

                <h3 class="text-lg font-semibold mb-4">Kelola Pembina Ekstrakurikuler</h3>

                <div class="mb-4 flex justify-between items-center">
                    <div>
                        <a href="{{ route('kelola_pembina_ekstrakurikuler.create') }}" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Tambah Data</a>
                    </div>
                </div>
                
                <table class="min-w-full bg-white border border-gray-200 rounded-lg" id="search-table">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 text-sm leading-normal">
                            <th class="py-3 px-4 text-left">Foto</th>
                            <th class="py-3 px-4 text-left">Nama Pembina</th>
                            <th class="py-3 px-4 text-left">NIP</th>
                            <th class="py-3 px-4 text-left">Ekstrakurikuler</th>
                            <th class="py-3 px-4 text-left">Alamat</th>
                            <th class="py-3 px-4 text-left">No. WA</th>
                            <th class="py-3 px-4 text-left">E-Mail</th>
                            <th class="py-3 px-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($pembinas as $pembina)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-4 text-left">
                                    <img src="{{ asset('images/guru/' . $pembina->foto_guru) }}" alt="Foto" class="w-10 h-10 rounded-full">
                                </td>
                                <td class="py-3 px-4">{{ $pembina->nama_guru }}</td>
                                <td class="py-3 px-4">{{ $pembina->nip }}</td>
                                <td class="py-3 px-4">
                                    @foreach ($pembina->ekstrakurikuler as $ekstra)
                                        {{ $ekstra->nama_ekstrakurikuler }}<br>
                                    @endforeach
                                </td>
                                <td class="py-3 px-4">{{ $pembina->alamat_guru }}</td>
                                <td class="py-3 px-4">{{ $pembina->nomor_wa_guru }}</td>
                                <td class="py-3 px-4">{{ $pembina->email }}</td>
                                <td class="py-3 px-4 flex space-x-2">
                                    <a href="{{ route('kelola_pembina_ekstrakurikuler.edit', $pembina->id_guru) }}" class="bg-blue-500 text-white px-2 py-1 rounded-md hover:bg-blue-600">Edit</a>
                                    <form action="{{ route('kelola_pembina_ekstrakurikuler.destroy', $pembina->id_guru) }}" method="POST" onsubmit="return confirmDelete(event)" class="inline">
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
                    <div class="flex justify-end">
                        {{ $pembinas->links() }}
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
        document.addEventListener("DOMContentLoaded", function () {
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.opacity = '0';
                    setTimeout(() => successMessage.remove(), 500);
                }, 3000);
            }
        });

        if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#search-table", {
                searchable: true,
                paging: false,
                sortable: false
            });
        }
    </script>
</x-admin-layout>
