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
                <a href="{{ route('superadmin.kelola_staff_akademik') }}" class="text-black-500 hover:underline">Kelola Data Staff Akademik</a> >
                <a href="#" class="text-black-500 hover:underline"><b>Edit Data Staff Perpus</b></a>
            </nav>
            <h2 class="text-lg font-semibold text-gray-800">Edit Data Staff Akademik</h2>
            <p class="text-sm text-gray-600 mb-6">Ini adalah halaman untuk mengedit Data akun Staff Akademik</p>
            <!-- Centering the form on the screen -->
            <form  action="{{ route('superadmin.kelola_staff_akademik.update') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                        Username
                    </label>
                    <!-- Hidden field for id_staff_akademik -->
                    <input type="hidden" id="id_staff_akademik" name="id_staff_akademik" value="{{ $staffakademik->id_staff_akademik }}">

                    <!-- Username field -->
                    <input type="text" id="username" name="username" class="w-full border border-black rounded-md p-2.5 focus:outline-none focus:border-blue-500" placeholder="Username" value="{{ old('username', $staffakademik->username) }}">
                    @error('username')
                    <x-input-error :messages="$message" class="mt-2 text-red-500 text-sm" />
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nama_staff_akademik">
                        Nama
                    </label>
                    <input type="text" id="nama_staff_akademik" name="nama_staff_akademik" class="w-full border border-black rounded-md p-2.5 focus:outline-none focus:border-blue-500" placeholder="Nama" value="{{ old('nama_staff_akademik', $staffakademik->nama_staff_akademik) }}">
                    @error('nama_staff_akademik')
                    <x-input-error :messages="$message" class="mt-2 text-red-500 text-sm" />
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="alamat_staff_akademik">
                        Alamat
                    </label>
                    <input type="text" id="alamat_staff_akademik" name="alamat_staff_akademik" class="w-full border border-black rounded-md p-2.5 focus:outline-none focus:border-blue-500" placeholder="Alamat" value="{{ old('alamat_staff_akademik', $staffakademik->alamat_staff_akademik) }}">
                    @error('alamat_staff_akademik')
                    <x-input-error :messages="$message" class="mt-2 text-red-500 text-sm" />
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="wa_staff_akademik">
                        Whatsapp
                    </label>
                    <input type="text" id="wa_staff_akademik" name="wa_staff_akademik" class="w-full border border-black rounded-md p-2.5 focus:outline-none focus:border-blue-500" placeholder="+6289515896944" value="{{ old('wa_staff_akademik', $staffakademik->wa_staff_akademik) }}">
                    @error('wa_staff_akademik')
                    <x-input-error :messages="$message" class="mt-2 text-red-500 text-sm" />
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Email
                    </label>
                    <input type="text" id="email" name="email" class="w-full border border-black rounded-md p-2.5 focus:outline-none focus:border-blue-500" placeholder="@gamil" value="{{ old('email', $staffakademik->email) }}">
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