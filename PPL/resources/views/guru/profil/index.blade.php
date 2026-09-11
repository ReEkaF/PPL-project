<x-app-guru-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <nav class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                    <a href="{{ route('guru.dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
                    <span>/</span>
                    <span class="text-slate-700 font-medium">Profil Guru</span>
                </nav>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Profil & Pengaturan Akun</h1>
                <p class="text-sm text-slate-500 mt-0.5">Kelola identitas pendidik, kontak, dan keamanan kata sandi Anda</p>
            </div>
            <div>
                <a href="{{ route('guru.dashboard') }}" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-semibold shadow-xs transition-colors">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Kembali</span>
                </a>
            </div>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-8">
            <div class="flex flex-col md:flex-row gap-8 items-start">
                <!-- Foto Profil Sidebar -->
                <div class="flex flex-col items-center w-full md:w-64 shrink-0 pb-6 md:pb-0 md:border-r md:border-slate-100 md:pr-8 text-center">
                    <div class="relative group cursor-pointer" id="avatarWrapper">
                        <img id="profileImage"
                            src="{{ $guru->foto_guru ? asset('images/guru/' . $guru->foto_guru) : 'https://ui-avatars.com/api/?name='.urlencode($guru->nama_guru ?? 'Guru').'&background=06466C&color=ffffff&size=256' }}"
                            alt="Foto Profil"
                            class="w-36 h-36 rounded-full object-cover border-2 border-slate-200 shadow-sm">
                        <div class="absolute inset-0 rounded-full bg-slate-900/40 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-xs font-semibold transition-opacity">
                            Lihat Foto
                        </div>
                    </div>
                    <h2 class="text-base font-bold text-slate-900 mt-4">{{ $guru->nama_guru ?? 'Nama Guru' }}</h2>
                    <p class="text-xs font-mono text-slate-500 mt-0.5">NIP: {{ $guru->nip ?? '-' }}</p>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-[#06466C]/10 text-[#06466C] mt-2.5">
                        {{ ucfirst($guru->role_guru ?? 'Tenaga Pengajar') }}
                    </span>
                </div>

                <!-- Form Kredensial & Biodata -->
                <div class="flex-1 w-full">
                    <h3 class="text-base font-bold text-slate-900 mb-1">Informasi Kredensial</h3>
                    <p class="text-xs text-slate-500 mb-5">Perbarui username, email, nomor kontak, atau ubah kata sandi akun pendidik Anda</p>

                    <form method="POST" action="{{ route('profil.update') }}" id="updateForm" class="space-y-5" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <!-- Username -->
                            <div>
                                <label for="username" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Username</label>
                                <input type="text" id="username" name="username" value="{{ old('username', $guru->username) }}"
                                    class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                                    placeholder="Username akun">
                                @error('username')
                                    <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Alamat Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $guru->email) }}"
                                    class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                                    placeholder="email@sekolah.sch.id">
                                @error('email')
                                    <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nomor Telepon -->
                            <div class="sm:col-span-2">
                                <label for="nomor_wa_guru" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Nomor WhatsApp / Telepon</label>
                                <input type="text" id="nomor_wa_guru" name="nomor_wa_guru" value="{{ old('nomor_wa_guru', $guru->nomor_wa_guru) }}"
                                    class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 font-mono focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                                    placeholder="08xxxxxxxxxx">
                                @error('nomor_wa_guru')
                                    <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Update Divider -->
                        <div class="pt-4 border-t border-slate-100">
                            <h4 class="text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Ubah Kata Sandi (Opsional)</h4>
                            <p class="text-xs text-slate-400 mb-4">Kosongkan jika Anda tidak ingin memperbarui password</p>

                            <div class="space-y-4">
                                <!-- Password Lama -->
                                <div>
                                    <label for="current_password" class="block text-xs font-medium text-slate-600 mb-1.5">Kata Sandi Saat Ini</label>
                                    <div class="relative">
                                        <input type="password" id="current_password" name="current_password"
                                            class="w-full text-sm rounded-lg border border-slate-300 pl-3.5 pr-10 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                                            placeholder="Masukkan kata sandi lama">
                                        <button type="button"
                                            class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-slate-600"
                                            onclick="togglePasswordVisibility('current_password', this)">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                                <line x1="1" y1="1" x2="23" y2="23"></line>
                                            </svg>
                                        </button>
                                    </div>
                                    @error('current_password')
                                        <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <!-- Password Baru -->
                                    <div>
                                        <label for="new_password" class="block text-xs font-medium text-slate-600 mb-1.5">Kata Sandi Baru</label>
                                        <div class="relative">
                                            <input type="password" id="new_password" name="new_password"
                                                class="w-full text-sm rounded-lg border border-slate-300 pl-3.5 pr-10 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                                                placeholder="Minimal 6 karakter">
                                            <button type="button"
                                                class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-slate-600"
                                                onclick="togglePasswordVisibility('new_password', this)">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                    <line x1="1" y1="1" x2="23" y2="23"></line>
                                                </svg>
                                            </button>
                                        </div>
                                        @error('new_password')
                                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Konfirmasi Password Baru -->
                                    <div>
                                        <label for="new_password_confirmation" class="block text-xs font-medium text-slate-600 mb-1.5">Ulangi Kata Sandi Baru</label>
                                        <div class="relative">
                                            <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                                class="w-full text-sm rounded-lg border border-slate-300 pl-3.5 pr-10 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                                                placeholder="Ulangi kata sandi baru">
                                            <button type="button"
                                                class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-slate-600"
                                                onclick="togglePasswordVisibility('new_password_confirmation', this)">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                    <line x1="1" y1="1" x2="23" y2="23"></line>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                            <button type="submit"
                                class="px-5 py-2.5 text-sm font-semibold text-white bg-[#06466C] hover:bg-[#053a5a] rounded-lg shadow-sm transition-colors">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pop-up Foto -->
    <div id="imageModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs hidden items-center justify-center z-50 p-4">
        <div class="relative max-w-lg w-full bg-white rounded-2xl p-4 shadow-xl">
            <button id="closeModal" class="absolute top-3 right-3 text-slate-400 hover:text-slate-600 text-lg leading-none">
                ✕
            </button>
            <img id="modalImage" src="" alt="Foto Besar" class="w-full max-h-[75vh] object-contain rounded-xl">
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

        document.addEventListener('DOMContentLoaded', function () {
            const profileImage = document.getElementById('profileImage');
            const imageModal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            const closeModal = document.getElementById('closeModal');

            profileImage.addEventListener('click', () => {
                modalImage.src = profileImage.src;
                imageModal.classList.remove('hidden');
                imageModal.classList.add('flex');
            });

            closeModal.addEventListener('click', () => {
                imageModal.classList.add('hidden');
                imageModal.classList.remove('flex');
            });

            imageModal.addEventListener('click', (e) => {
                if (e.target === imageModal) {
                    imageModal.classList.add('hidden');
                    imageModal.classList.remove('flex');
                }
            });
        });
    </script>
</x-app-guru-layout>
