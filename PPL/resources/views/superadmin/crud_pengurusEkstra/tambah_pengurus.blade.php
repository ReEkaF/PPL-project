<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Pengurus Ekstrakurikuler') }}
        </h2>
    </x-slot>

    <div class="py-12">
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
                            <a href="{{ route('superadmin.keloladatapengurus') }}" class="text-gray-400 hover:text-gray-700">
                                <span>Kelola Data Pengurus Ekstrakurikuler</span>
                            </a>
                        </li>
                        <div class="flex justify-center py-1">
                            <svg class="flex w-4 h-4 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7" />
                            </svg>
                        </div>
                        <li class="flex">
                            <a href="{{ route('data.pengurus.tambah') }}" class="text-black-500 hover:underline">
                                <span><b>Tambah Pengurus Ekstrakurikuler</b></span>
                            </a>
                        </li>
                    </ol>
                </nav>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold mb-4">Pilih Siswa Untuk Menjadi Pengurus</h3>
                    <div class="relative">
                        <input type="text" id="search-input" placeholder="Search..." 
                               class="border border-gray-300 rounded-md px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 w-64">
                        <svg class="absolute top-2.5 right-3 w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 10-14 0 7 7 0 0014 0z" />
                        </svg>
                    </div>
                </div>
                <table class="min-w-full bg-white border border-gray-200 rounded-lg" id="search-table">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 text-sm leading-normal">
                            <th class="py-3 px-4 text-left">Foto</th>
                            <th class="py-3 px-4 text-left">Nama Siswa</th>
                            <th class="py-3 px-4 text-left">NISN</th>
                            <th class="py-3 px-4 text-left">Alamat</th>
                            <th class="py-3 px-4 text-left">No. WA</th>
                            <th class="py-3 px-4 text-left">E-Mail</th>
                            <th class="py-3 px-4 text-left">Ekstrakurikuler</th>
                            <th class="py-3 px-4 text-left">Role</th>
                            <th class="py-3 px-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light" id="table-body">
                        @foreach ($siswa as $sis)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-4 text-left">
                                    <img src="{{ asset('images/siswa/' . $sis->foto_siswa) }}" alt="Foto" class="w-10 h-10 rounded-full">
                                </td>
                                <td class="py-3 px-4">{{ $sis->nama_siswa }}</td>
                                <td class="py-3 px-4">{{ $sis->nisn }}</td>
                                <td class="py-3 px-4">{{ $sis->alamat }}</td>
                                <td class="py-3 px-4">{{ $sis->nomor_wa_siswa }}</td>
                                <td class="py-3 px-4">{{ $sis->email }}</td>
                                <td class="py-3 px-4">
                                    <form action="{{ route('pengurus.store', $sis->id_siswa) }}" method="POST">
                                        @csrf
                                        <select name="ekstrakurikuler" class="border border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500" required>
                                            @foreach($ekstrakurikuler as $ekstrakurikulerItem)
                                                <option value="{{ $ekstrakurikulerItem->id_ekstrakurikuler }}">{{ $ekstrakurikulerItem->nama_ekstrakurikuler }}</option>
                                            @endforeach
                                        </select>
                                </td>
                                <td class="py-3 px-4">
                                        <select id="role_siswa" name="role_siswa" class="w-full border border-black rounded-md p-2.5 focus:outline-none focus:border-blue-500" required>
                                            <option value="siswa" {{ old('role_siswa', $sis->role_siswa) == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                            <option value="pengurus" {{ old('role_siswa', $sis->role_siswa) == 'pengurus' ? 'selected' : '' }}>Pengurus</option>
                                        </select>
                                </td>
                                <td class="py-3 px-4 flex space-x-2">
                                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Tambah</button>
                                    </form>
                                </td>                                                                                         
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search-input');
            const tableBody = document.getElementById('table-body');
            const rows = tableBody.getElementsByTagName('tr');

            searchInput.addEventListener('input', function () {
                const searchValue = searchInput.value.toLowerCase();
                Array.from(rows).forEach(row => {
                    const cells = row.getElementsByTagName('td');
                    const match = Array.from(cells).some(cell => 
                        cell.textContent.toLowerCase().includes(searchValue)
                    );
                    row.style.display = match ? '' : 'none';
                });
            });
        });
    </script>
</x-admin-layout>
