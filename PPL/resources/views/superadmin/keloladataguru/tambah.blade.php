<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Data Guru') }}
        </h2>
    </x-slot>

    <div class="flex items-center justify-center min-h-screen bg-gray-50 py-8">
        <div class="max-w-6xl w-full p-8 bg-white rounded-lg shadow-md border-2 border-black">
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
                        <a href="{{ route('superadmin.keloladataguru') }}" class="text-gray-400 hover:text-gray-700">
                            <span>Kelola Data Guru</span>
                        </a>
                    </li>
                    <div class="flex justify-center py-1">
                        <svg class="flex w-4 h-4 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
                        </svg>
                    </div>
                    <li class="flex">
                        <a href="#" class="text-gray-400 hover:text-gray-700">
                            <span>Tambah Data Guru</span>
                        </a>
                    </li>
                </ol>
            </nav>  

            <h2 class="text-lg font-semibold text-gray-800">Tambah Data Guru</h2>
            <p class="text-sm text-gray-600 mb-6">Ini adalah halaman untuk menambah data guru</p>

            <form action="{{ route('guru.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Username -->
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username :</label>
                    <input type="text" name="username" id="username" class="w-full border border-black rounded-md p-2.5 focus:outline-none focus:border-blue-500" value="{{ old('username') }}" >
                    @error('username')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password :</label>
                    <input type="password" name="password" id="password" class="w-full border border-black rounded-md p-2.5 focus:outline-none focus:border-blue-500" >
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Nama Guru -->
                <div class="mb-4">
                    <label for="nama_guru" class="block text-sm font-medium text-gray-700 mb-1">Nama :</label>
                    <input type="text" name="nama_guru" id="nama_guru" class="w-full border border-black rounded-md p-2.5 focus:outline-none focus:border-blue-500" value="{{ old('nama_guru') }}" >
                    @error('nama_guru')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- NIP -->
                <div class="mb-4">
                    <label for="nip" class="block text-sm font-medium text-gray-700 mb-1">NIP :</label>
                    <input type="text" name="nip" id="nip" class="w-full border border-black rounded-md p-2.5 focus:outline-none focus:border-blue-500" value="{{ old('nip') }}" >
                    @error('nip')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Alamat -->
                <div class="mb-4">
                    <label for="alamat_guru" class="block text-sm font-medium text-gray-700 mb-1">Alamat :</label>
                    <input type="text" name="alamat_guru" id="alamat_guru" class="w-full border border-black rounded-md p-2.5 focus:outline-none focus:border-blue-500" value="{{ old('alamat_guru') }}" >
                    @error('alamat_guru')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Role Guru -->
                <div class="mb-4">
                    <label for="role_guru" class="block text-sm font-medium text-gray-700 mb-1">Role Guru :</label>
                    <select name="role_guru" id="role_guru" class="w-full border border-black rounded-md p-2.5 focus:outline-none focus:border-blue-500" >
                        <option value="">Pilih Role</option>
                        <option value="guru">Guru</option>
                        <option value="pembina">Pembina</option>
                        <option value="wali_kelas">Wali Kelas</option>
                    </select>
                    @error('role_guru')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Foto Guru Upload -->
                <div class="mb-4">
                    <label for="foto_guru" class="block text-sm font-medium text-gray-700 mb-1">Foto :</label>
                    <div class="flex flex-col items-center justify-center w-full h-32 border-2 border-black rounded-md cursor-pointer bg-gray-50 relative" onclick="document.getElementById('foto_guru').click()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16v4h10v-4M5 12l7-7 7 7M12 5v13" />
                        </svg>
                        <div class="text-center text-sm">
                            <span class="text-blue-500">Click to Upload</span>
                            <span class="text-gray-500">or drag and drop</span>
                            <br>
                            <span class="text-gray-500">(Max. file size: 25 MB)</span>
                        </div>
                        <input type="file" name="foto_guru" id="foto_guru" class="hidden" >
                    </div>
                    @error('foto_guru')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- No. WA -->
                <div class="mb-4">
                    <label for="nomor_wa_guru" class="block text-sm font-medium text-gray-700 mb-1">No. WA :</label>
                    <input type="text" name="nomor_wa_guru" id="nomor_wa_guru" class="w-full border border-black rounded-md p-2.5 focus:outline-none focus:border-blue-500" value="{{ old('nomor_wa_guru') }}" >
                    @error('nomor_wa_guru')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- E-Mail -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email :</label>
                    <input type="email" name="email" id="email" class="w-full border border-black rounded-md p-2.5 focus:outline-none focus:border-blue-500" value="{{ old('email') }}" >
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit -->
                <div class="flex justify-center">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-full mt-4">
                        Tambahkan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
