<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Data Guru') }}
        </h2>
    </x-slot>

    <div class="flex items-center justify-center min-h-screen bg-gray-50 py-8">
        <div class="max-w-6xl w-full p-8 bg-white rounded-lg shadow-md border-2 border-black">
            <nav class="text-sm text-gray-500 mb-4">
                <a href="{{ route('superadmin.dashboard') }}" class="text-black-500 hover:underline">Dashboard</a> >
                <a href="{{ route('superadmin.kelola_staff_akademik') }}" class="text-black-500 hover:underline">Kelola Staff Akademik</a> >
                <a href="#" class="text-black-500 hover:underline"><b>Tambah Akun Staff Akademik</b></a>
            </nav>

            <h2 class="text-lg font-semibold text-gray-800">Tambah Akun Staff Akademik</h2>
            <p class="text-sm text-gray-600 mb-6">Ini adalah halaman untuk menambah data Staff Akademik</p>

            <form action="{{ route('superadmin.kelola_staff_akademik.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Username -->
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username :</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" class="w-full border border-black rounded-md p-2.5 focus:outline-none focus:border-blue-500">
                    @error('username')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password :</label>
                    <input type="password" id="password" name="password" class="w-full border border-black rounded-md p-2.5 focus:outline-none focus:border-blue-500">
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Nama -->
                <div class="mb-4">
                    <label for="nama_staff_akademik" class="block text-sm font-medium text-gray-700 mb-1">Nama :</label>
                    <input type="text" id="nama_staff_akademik" name="nama_staff_akademik" value="{{ old('nama_staff_akademik') }}" class="w-full border border-black rounded-md p-2.5 focus:outline-none focus:border-blue-500">
                    @error('nama_staff_akademik')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Alamat -->
                <div class="mb-4">
                    <label for="alamat_staff_akademik" class="block text-sm font-medium text-gray-700 mb-1">Alamat :</label>
                    <input type="text" id="alamat_staff_akademik" name="alamat_staff_akademik" value="{{ old('alamat_staff_akademik') }}" class="w-full border border-black rounded-md p-2.5 focus:outline-none focus:border-blue-500">
                    @error('alamat_staff_akademik')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Nomor WA -->
                <div class="mb-4">
                    <label for="wa_staff_akademik" class="block text-sm font-medium text-gray-700 mb-1">Nomor WA :</label>
                    <input type="text" id="wa_staff_akademik" name="wa_staff_akademik" value="{{ old('wa_staff_akademik') }}" class="w-full border border-black rounded-md p-2.5 focus:outline-none focus:border-blue-500" placeholder="e.g. +62089515896944">
                    @error('wa_staff_akademik')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Nomor WA :</label>
                    <input type="text" id="email" name="email" value="{{ old('email') }}" class="w-full border border-black rounded-md p-2.5 focus:outline-none focus:border-blue-500" placeholder=" @gmail.com">
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
