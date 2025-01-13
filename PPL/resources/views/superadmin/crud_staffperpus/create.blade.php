<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex items-center justify-center min-h-screen bg-gray-50 py-8">
        <div class="max-w-6xl w-full p-8 bg-white rounded-lg shadow-md border-2 border-black">
            <nav class="text-sm text-gray-500 mb-4">
                <a href="{{ route('superadmin.dashboard') }}" class="text-black-500 hover:underline">Dashboard</a> >
                <a href="{{ route('superadmin.kelola_staff_perpus') }}" class="text-black-500 hover:underline">Kelola Staff Perpustakaan</a> >
                <a href="#" class="text-black-500 hover:underline"><b>Tambah Akun Staff Perpustakaan</b></a>
            </nav>

            <h2 class="text-lg font-semibold text-gray-800">Tambah Akun Staff Perpustakaan</h2>
            <p class="text-sm text-gray-600 mb-6">Ini adalah halaman untuk menambah data Staff Perpustakaan</p>
            <form  action="{{route('superadmin.kelola_staff_perpus.store')}}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="username" class="block text-gray-700">Username</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" class="w-full border border-gray-300 p-2 rounded">
                    @error('username')
                    <x-input-error :messages="$message" class="mt-2 text-red-500 text-sm" />
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Password</label>
                    <input type="password" id="password" name="password" class="w-full border border-gray-300 p-2 rounded">
                    @error('password')
                    <x-input-error :messages="$message" class="mt-2 text-red-500 text-sm" />
                    @enderror
                </div>

                <!-- Nama Field -->
                <div class="mb-4">
                    <label for="nama_staff_perpustakaan" class="block text-gray-700">Nama</label>
                    <input type="text" id="nama_staff_perpustakaan" name="nama_staff_perpustakaan" value="{{ old('nama_staff_perpustakaan') }}" class="w-full border border-gray-300 p-2 rounded">
                    @error('nama_staff_perpustakaan')
                    <x-input-error :messages="$message" class="mt-2 text-red-500 text-sm" />
                    @enderror
                </div>

                <!-- Alamat Field -->
                <div class="mb-4">
                    <label for="alamat_staff_perpustakaan" class="block text-gray-700">Alamat</label>
                    <input type="text" id="alamat_staff_perpustakaan" name="alamat_staff_perpustakaan" value="{{ old('alamat_staff_perpustakaan') }}" class="w-full border border-gray-300 p-2 rounded">
                    @error('alamat_staff_perpustakaan')
                    <x-input-error :messages="$message" class="mt-2 text-red-500 text-sm" />
                    @enderror
                </div>

                <!-- WA (WhatsApp) Field -->
                <div class="mb-4">
                    <label for="wa_staff_perpustakaan" class="block text-gray-700">Nomor WhatsApp</label>
                    <input type="text" id="wa_staff_perpustakaan" name="wa_staff_perpustakaan" value="{{ old('wa_staff_perpustakaan') }}" class="w-full border border-gray-300 p-2 rounded" placeholder="e.g. +62089515896944">
                    @error('wa_staff_perpustakaan')
                    <x-input-error :messages="$message" class="mt-2 text-red-500 text-sm" />
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Nomor WA :</label>
                    <input type="text" id="email" name="email" value="{{ old('email') }}" class="w-full border border-black rounded-md p-2.5 focus:outline-none focus:border-blue-500" placeholder=" @gmail.com">
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Submit</button>
            </form>
        </div>
    </div>
</x-admin-layout>