<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    
    <!-- Centering the form on the screen -->
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-xs">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="{{ route('superadmin.kelola_staff_perpus.update') }}" method="POST">
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
                
                <div class="flex items-center justify-center">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>