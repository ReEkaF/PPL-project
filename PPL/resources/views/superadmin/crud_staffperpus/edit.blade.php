<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    
    <div class="flex items-center justify-center min-h-screen bg-gray-50 py-12">
        <div class="max-w-6xl w-full p-8 bg-white rounded-lg shadow-md border-2 border-black">
            <nav class="text-sm text-gray-500 mb-4">
                <a href="{{ route('superadmin.dashboard') }}" class="text-black-500 hover:underline">Dashboard </a> >
                <a href="{{ route('superadmin.kelola_staff_akademik') }}" class="text-black-500 hover:underline">Kelola Data Staff Perpustakaan</a> >
                <a href="#" class="text-black-500 hover:underline"><b>Edit Data Guru</b></a>
            </nav>
            <h2 class="text-lg font-semibold text-gray-800">Edit Data Staff Perpustakaan</h2>
            <p class="text-sm text-gray-600 mb-6">Ini adalah halaman untuk mengedit Data akun Staff Perpustakaan</p>
            <form  action="{{ route('superadmin.kelola_staff_perpus.update') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                        Username
                    </label>
                    <!-- Hidden field for id_staff_perpustakaan -->
                    <input type="hidden" id="id_staff_perpustakaan" name="id_staff_perpustakaan" value="{{ $staffperpustakaan->id_staff_perpustakaan }}">
                    
                    <!-- Username field -->
                    <input type="text" id="username" name="username" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Username" value="{{ old('username', $staffperpustakaan->username) }}">
                    @error('username')
                        <x-input-error :messages="$message" class="mt-2 text-red-500 text-sm" />
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nama_staff_perpustakaan">
                        Nama
                    </label>
                    <input type="text" id="nama_staff_perpustakaan" name="nama_staff_perpustakaan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Nama" value="{{ old('nama_staff_perpustakaan', $staffperpustakaan->nama_staff_perpustakaan) }}">
                    @error('nama_staff_perpustakaan')
                        <x-input-error :messages="$message" class="mt-2 text-red-500 text-sm" />
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="alamat_staff_perpustakaan">
                        Alamat
                    </label>
                    <input type="text" id="alamat_staff_perpustakaan" name="alamat_staff_perpustakaan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Alamat" value="{{ old('alamat_staff_perpustakaan', $staffperpustakaan->alamat_staff_perpustakaan) }}">
                    @error('alamat_staff_perpustakaan')
                        <x-input-error :messages="$message" class="mt-2 text-red-500 text-sm" />
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="wa_staff_perpustakaan">
                        Whatsapp
                    </label>
                    <input type="text" id="wa_staff_perpustakaan" name="wa_staff_perpustakaan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Whatsapp" value="{{ old('wa_staff_perpustakaan', $staffperpustakaan->wa_staff_perpustakaan) }}">
                    @error('wa_staff_perpustakaan')
                        <x-input-error :messages="$message" class="mt-2 text-red-500 text-sm" />
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Email
                    </label>
                    <input type="text" id="email" name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Whatsapp" value="{{ old('email', $staffperpustakaan->email) }}">
                    @error('email')
                        <x-input-error :messages="$message" class="mt-2 text-red-500 text-sm" />
                    @enderror
                </div>
                
                <div class="flex items-center justify-center">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
