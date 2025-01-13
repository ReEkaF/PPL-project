<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Pengurus') }}
        </h2>
    </x-slot>

    <div class="flex items-center justify-center min-h-screen bg-gray-50 py-8">
        <div class="max-w-6xl w-full p-8 bg-white rounded-lg shadow-md border-2 border-black">
            <!-- Breadcrumb -->
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
                        <a href="{{ route('superadmin.keloladatapengurus') }}" class="text-gray-400 hover:text-gray-700">
                            <span>Kelola Data Pengurus</span>
                        </a>
                    </li>
                    <div class="flex justify-center py-1">
                        <svg class="flex w-4 h-4 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
                        </svg>
                    </div>
                    <li class="flex">
                            <span><b>Edit Data Pengurus</b></span>
                        </a>
                    </li>
                </ol>
            </nav>
            <!-- Form Edit Pengurus -->
            <h2 class="text-lg font-semibold text-gray-800">Edit Data Pengurus</h2>
            <p class="text-sm text-gray-600 mb-6">Ini adalah halaman untuk mengedit data pengurus</p>

            <form action="{{ route('data.pengurus.update', $pengurus->id_siswa) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Nama Pengurus -->
                <div class="mb-4">
                    <label for="nama_siswa" class="block text-sm font-medium text-gray-700 mb-1">Nama :</label>
                    <input type="text" name="nama_siswa" id="nama_siswa" value="{{ old('nama_siswa', $pengurus->nama_siswa) }}" class="w-full border border-black rounded-md p-2.5 focus:outline-none focus:border-blue-500" required>
                </div>

                <!-- Role -->
                <div class="mb-4">
                    <label for="role_siswa" class="block text-sm font-medium text-gray-700 mb-1">Role :</label>
                    <select id="role_siswa" name="role_siswa" class="w-full border border-black rounded-md p-2.5 focus:outline-none focus:border-blue-500" required>
                        <option value="siswa" {{ old('role_siswa', $pengurus->role_siswa) == 'siswa' ? 'selected' : '' }}>Siswa</option>
                        <option value="pengurus" {{ old('role_siswa', $pengurus->role_siswa) == 'pengurus' ? 'selected' : '' }}>Pengurus</option>
                    </select>
                </div>

                <!-- Ekstrakurikuler -->
                <div class="mb-4">
                    <label for="ekstrakurikuler" class="block text-sm font-medium text-gray-700 mb-1">Ekstrakurikuler :</label>
                    <select name="ekstrakurikuler" class="w-full border border-black rounded-md p-2.5 focus:outline-none focus:border-blue-500" required>
                        @foreach($ekstrakurikuler as $ekstrakurikulerItem)
                            <option value="{{ $ekstrakurikulerItem->id_ekstrakurikuler }}" {{ $pengurus->id_ekstrakurikuler == $ekstrakurikulerItem->id_ekstrakurikuler ? 'selected' : '' }}>
                                {{ $ekstrakurikulerItem->nama_ekstrakurikuler }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-full mt-4">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
