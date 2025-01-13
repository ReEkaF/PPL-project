<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil ') }}
        </h2>
    </x-slot>

    <div class="pt-6 pb-6 bg-gray-100 flex justify-center items-center">
        <div class="w-full max-w-6xl bg-white px-12 py-6 rounded-lg shadow-lg relative">
            <!-- Ikon Kembali -->
            <a href="{{ route('superadmin.dashboard') }}" 
               class="absolute top-6 left-6 text-black hover:text-blue-500 flex items-center gap-2 transition-colors duration-200">
                <!-- Ikon Panah Kembali -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span class="text-lg font-semibold">Kembali</span>
            </a>

            <div class="flex gap-6 items-center">
                <!-- Form -->
                <div class="flex flex-col w-full ">
                    <h1 class="text-2xl font-bold text-center text-gray-800 ">Profil Saya</h1>

                    <form method="POST" action="{{ route('superadmin.profile.update') }}" id="updateForm" class="space-y-4 " >
                        @csrf

                        <!-- Username -->
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                            <input type="text" id="username" name="username" value="{{ old('username', $admin->username) }}"
                                   class="mt-1 block w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none @error('username') border-red-500 @enderror"
                                   placeholder="Masukkan username Anda" >
                            @error('username')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="nama_superadmin" class="block text-sm font-medium text-gray-700">Nama</label>
                            <input type="text" id="nama_superadmin" name="nama_superadmin" value="{{ old('nama_superadmin', $admin->nama_superadmin) }}"
                                   class="mt-1 block w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none @error('nama_superadmin') border-red-500 @enderror"
                                   placeholder="Masukkan nama Anda" >
                            @error('nama_superadmin')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $admin->email) }}"
                                   class="mt-1 block w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none @error('email') border-red-500 @enderror"
                                   placeholder="email@contoh.com">
                            @error('email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Nomor Telepon -->
                        <div>
                            <label for="no_hp" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                            <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $admin->no_hp) }}"
                                   class="mt-1 block w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none @error('no_hp') border-red-500 @enderror"
                                   placeholder="Masukkan nomor telepon">
                            @error('no_hp')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>                       
                        <div class="relative">
                            <label for="new_password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                            <div class="relative">
                                <input type="password" id="new_password" name="new_password"
                                       class="mt-1 block w-full px-4 py-2 pr-10 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none @error('new_password') border-red-500 @enderror"
                                       placeholder="Masukkan password baru">
                                <button type="button" 
                                        class="absolute inset-y-0 right-3 flex items-center"
                                        style="top: 50%; transform: translateY(-50%);"
                                        onclick="togglePasswordVisibility('new_password', this)">
                                    <svg xmlns="http://www.w3.org/2000/svg" id="new_password_eye" class="h-6 w-6 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                        <line x1="1" y1="1" x2="23" y2="23"></line>
                                    </svg>
                                </button>
                            </div>
                            @error('new_password')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>                                             
                        <!-- Submit -->
                        <div class="flex justify-center">
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-500 text-white rounded-md transition-colors duration-300 hover:bg-green-500">
                                Perbarui Setting
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function togglePasswordVisibility(inputId, button) {
            const input = document.getElementById(inputId);
            const icon = button.querySelector('svg');

            if (input.type === "password") {
                input.type = "text";
                icon.innerHTML = `
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                `;
                icon.classList.add('text-blue-500'); // Menambahkan warna aktif
            } else {
                input.type = "password";
                icon.innerHTML = `
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                    <line x1="1" y1="1" x2="23" y2="23"></line>
                `;
                icon.classList.remove('text-blue-500'); // Menghapus warna aktif
            }
        }

        // Menampilkan SweetAlert jika ada pesan sukses
        @if(session('success') && !$errors->any())
            Swal.fire({
                title: 'Berhasil!',
                text: 'Profil Anda berhasil diperbarui.',
                icon: 'success',
                showConfirmButton: false, // Menghilangkan tombol OK
                timer: 3000 // Popup otomatis hilang setelah 3 detik
            });
        @endif

    </script>
</x-admin-layout>
