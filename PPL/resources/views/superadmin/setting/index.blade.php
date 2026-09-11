<x-admin-layout>
    <div class="p-6 max-w-3xl mx-auto">
        <!-- Breadcrumbs & Header -->
        <div class="mb-6">
            <nav class="flex items-center gap-2 text-xs text-slate-500 mb-2">
                <a href="{{ route('superadmin.dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
                <span>/</span>
                <span class="text-slate-700 font-medium">Pengaturan Profil</span>
            </nav>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Profil & Pengaturan Akun</h1>
            <p class="text-sm text-slate-500 mt-1">Perbarui informasi identitas pribadi dan keamanan kata sandi Anda</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-8">
            <div class="flex items-center gap-4 pb-6 mb-6 border-b border-slate-100">
                <div class="w-14 h-14 rounded-full bg-[#06466C] text-white font-bold flex items-center justify-center text-lg shadow-sm">
                    {{ strtoupper(substr($admin->nama_superadmin ?? $admin->username, 0, 2)) }}
                </div>
                <div>
                    <h2 class="text-base font-semibold text-slate-900">{{ $admin->nama_superadmin }}</h2>
                    <p class="text-xs text-slate-500">Super Administrator Sistem</p>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-[#06466C]/10 text-[#06466C] mt-1">
                        Akses Penuh
                    </span>
                </div>
            </div>

            <form method="POST" action="{{ route('superadmin.profile.update') }}" id="updateForm" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Username <span class="text-rose-500">*</span></label>
                        <input type="text" id="username" name="username" value="{{ old('username', $admin->username) }}"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                            placeholder="Username akun admin" required>
                        @error('username')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama -->
                    <div>
                        <label for="nama_superadmin" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <input type="text" id="nama_superadmin" name="nama_superadmin" value="{{ old('nama_superadmin', $admin->nama_superadmin) }}"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                            placeholder="Nama administrator" required>
                        @error('nama_superadmin')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Alamat Email <span class="text-rose-500">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email', $admin->email) }}"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                            placeholder="admin@sekolah.sch.id" required>
                        @error('email')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nomor Telepon -->
                    <div>
                        <label for="no_hp" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Nomor Telepon / WA</label>
                        <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $admin->no_hp) }}"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 font-mono focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                            placeholder="08xxxxxxxxxx">
                        @error('no_hp')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Baru -->
                    <div class="sm:col-span-2">
                        <label for="new_password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Kata Sandi Baru</label>
                        <div class="relative">
                            <input type="password" id="new_password" name="new_password"
                                class="w-full text-sm rounded-lg border border-slate-300 pl-3.5 pr-10 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                                placeholder="Kosongkan jika tidak ingin mengubah kata sandi">
                            <button type="button"
                                class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-slate-600"
                                onclick="togglePasswordVisibility('new_password', this)">
                                <svg xmlns="http://www.w3.org/2000/svg" id="new_password_eye" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <line x1="1" y1="1" x2="23" y2="23"></line>
                                </svg>
                            </button>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Biarkan kosong bila tidak ingin memperbarui password akun</p>
                        @error('new_password')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit & Actions -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('superadmin.dashboard') }}"
                        class="px-4 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-lg transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-semibold text-white bg-[#06466C] hover:bg-[#053a5a] rounded-lg shadow-sm transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
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
                icon.classList.add('text-[#06466C]');
            } else {
                input.type = "password";
                icon.innerHTML = `
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                    <line x1="1" y1="1" x2="23" y2="23"></line>
                `;
                icon.classList.remove('text-[#06466C]');
            }
        }

        @if(session('success') && !$errors->any())
            Swal.fire({
                title: 'Berhasil!',
                text: 'Profil Anda berhasil diperbarui.',
                icon: 'success',
                confirmButtonColor: '#06466C',
                timer: 3000
            });
        @endif
    </script>
</x-admin-layout>
